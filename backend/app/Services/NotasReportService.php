<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class NotasReportService
{
    public function options(User $user, ?string $career = null, ?string $matricula = null): array
    {
        $query = $this->scopedQuery($user)->whereNotNull('Nivel')->where('Nivel', '!=', '');

        if ($career !== null && $career !== '') {
            $query->where('Nivel', $career);
            if ($matricula !== null && $matricula !== '') {
                $query->where('Matricula', 'like', '%' . $matricula . '%');
            }
            $students = $query
                ->select('Matricula', 'Nombre', 'APaterno', 'AMaterno', 'Email')
                ->distinct()->orderBy('Matricula')->get()->map(function ($student) {
                    return [
                        'matricula' => $student->Matricula,
                        'nombre' => trim(implode(' ', array_filter([$student->Nombre, $student->APaterno, $student->AMaterno]))),
                        'email' => $student->Email,
                    ];
                })->values()->all();

            return ['careers' => [$career], 'students' => $students];
        }

        return [
            'careers' => $query->select('Nivel')->distinct()->orderBy('Nivel')->pluck('Nivel')->values()->all(),
            'students' => [],
        ];
    }

    public function detail(User $user, string $career, string $matricula): array
    {
        $rows = $this->scopedQuery($user)->where('Nivel', $career)->where('Matricula', $matricula)
            ->orderByRaw("CAST(REPLACE(Tetramestre, 'T', '') AS UNSIGNED)")->orderBy('Asignatura')->get();

        if ($rows->isEmpty()) {
            abort(404, 'No se encontraron notas para el alumno seleccionado.');
        }

        $first = $rows->first();
        $grades = $rows->map(function ($row) {
            $value = str_replace(',', '.', trim((string) $row->CalificacionFinal));
            return is_numeric($value) ? (float) $value : null;
        })->filter(function ($value) { return $value !== null; });

        return [
            'title' => 'Detalle de notas',
            'student' => [
                'matricula' => $first->Matricula,
                'name' => trim(implode(' ', array_filter([$first->Nombre, $first->APaterno, $first->AMaterno]))),
                'email' => $first->Email,
                'career' => $first->Nivel,
            ],
            'summary' => [
                'subjects' => $rows->count(),
                'average' => $grades->isEmpty() ? null : round($grades->avg(), 2),
                'approved' => $grades->filter(function ($grade) { return $grade >= 6; })->count(),
                'failed' => $grades->filter(function ($grade) { return $grade < 6; })->count(),
            ],
            'rows' => $rows->map(function ($row) {
                return ['period' => $row->Periodo, 'tetramester' => $row->Tetramestre, 'subject' => $row->Asignatura, 'grade' => $row->CalificacionFinal, 'teacher' => $row->Catedratico];
            })->values()->all(),
        ];
    }

    public function pdf(User $user, string $career, string $matricula): string
    {
        $report = $this->detail($user, $career, $matricula);
        $tempDir = sys_get_temp_dir() . '/sistedu-mpdf';
        if (!is_dir($tempDir)) { mkdir($tempDir, 0775, true); }
        $mpdf = new Mpdf(['tempDir' => $tempDir, 'format' => 'A4', 'margin_top' => 30, 'margin_right' => 12, 'margin_bottom' => 14, 'margin_left' => 12]);
        $mpdf->SetTitle('Detalle de notas - ' . $report['student']['matricula']);
        $qrPayload = 'Sistedu|Notas|Alumno:' . $report['student']['name'] . '|Matricula:' . $report['student']['matricula'] . '|Carrera:' . $report['student']['career'];
        $mpdf->SetHTMLHeader('<div style="text-align:right"><barcode code="' . htmlspecialchars($qrPayload, ENT_QUOTES, 'UTF-8') . '" type="QR" size="0.9" error="L" /></div>');
        $mpdf->SetHTMLFooter('<div style="text-align:center;font-size:8px;color:#718087">Detalle de notas · Página {PAGENO} de {nbpg}</div>');
        $html = preg_replace('/<div class="qr">.*?<\/div><\/div><h1>/s', '<h1>', $this->html($report));
        $html = str_replace('.summary{width:100%;', '.summary{display:none!important;width:100%;', $html);
        $mpdf->WriteHTML($html ?: $this->html($report));
        return $mpdf->Output('', 'S');
    }

    protected function scopedQuery(User $user)
    {
        $query = DB::table('calificaciones_old');
        $roleSlugs = $user->roles()->pluck('slug');
        if (!$roleSlugs->contains('super-admin') && !$roleSlugs->contains('operador') && $roleSlugs->contains('estudiante')) {
            $query->where(function ($scope) use ($user) { $scope->where('id_estudiante', $user->id)->orWhere('Email', $user->email); });
        }
        return $query;
    }

    protected function html(array $report): string
    {
        $escape = function ($value): string { return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8'); };
        $student = $report['student']; $summary = $report['summary']; $qrPayload = '';
        $rows = '';
        foreach ($report['rows'] as $row) {
            $rows .= '<tr><td>' . $escape($row['tetramester']) . '</td><td>' . $escape($row['period']) . '</td><td>' . $escape($row['subject']) . '</td><td class="grade">' . $escape($row['grade']) . '</td><td>' . $escape($row['teacher']) . '</td></tr>';
        }
        return '<html><head><style>body{font-family:dejavusans;color:#27313a;font-size:10px}.brand{border-bottom:3px solid #d96c3f;padding-bottom:10px;margin-bottom:16px}h1{font-size:20px;margin:0;color:#263844}.qr{float:right;text-align:center;margin-left:18px}.qr-label{font-size:7px;color:#718087;margin-top:3px}h2{font-size:13px;margin:18px 0 7px;color:#d96c3f}.meta{width:100%;border-collapse:collapse}.meta td{padding:4px 0}.label{font-weight:bold;color:#68757d}.summary{width:100%;border-collapse:collapse;margin:12px 0}.summary td{background:#f2f5f4;padding:8px;text-align:center;border-right:2px solid white}.summary strong{display:block;font-size:15px;color:#263844}.notes{width:100%;border-collapse:collapse}.notes thead{display:table-header-group}.notes tr{page-break-inside:avoid}.notes th{background:#263844;color:white;text-align:left;padding:7px}.notes td{border-bottom:1px solid #d8e0df;padding:6px;vertical-align:top}.grade{text-align:center;font-weight:bold}</style></head><body><div class="brand"><div class="qr"><barcode code="' . $escape($qrPayload) . '" type="QR" size="1.1" error="M" /><div class="qr-label">Datos del alumno</div></div><h1>Detalle de notas</h1><div>Histórico académico individual</div></div><table class="meta"><tr><td class="label">Alumno</td><td>' . $escape($student['name']) . '</td><td class="label">Matrícula</td><td>' . $escape($student['matricula']) . '</td></tr><tr><td class="label">Carrera</td><td colspan="3">' . $escape($student['career']) . '</td></tr><tr><td class="label">Correo</td><td colspan="3">' . $escape($student['email']) . '</td></tr></table><table class="summary"><tr><td><strong>' . $escape($summary['subjects']) . '</strong>Materias</td><td><strong>' . $escape($summary['average'] ?? 'N/D') . '</strong>Promedio</td><td><strong>' . $escape($summary['approved']) . '</strong>Aprobadas</td><td><strong>' . $escape($summary['failed']) . '</strong>Reprobadas</td></tr></table><h2>Histórico académico</h2><table class="notes"><thead><tr><th>Tetramestre</th><th>Periodo</th><th>Asignatura</th><th>Calificación</th><th>Catedrático</th></tr></thead><tbody>' . $rows . '</tbody></table></body></html>';
    }
}
