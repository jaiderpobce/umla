<?php

namespace App\Services;

use App\Models\AcademicPeriod;
use App\Models\AcademicProgram;
use App\Models\ActiveStudent;
use App\Models\PeriodoAlumno;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActiveStudentService
{
    public function getStudentsData(array $filters = []): array
    {
        $query = ActiveStudent::with(['program', 'periods', 'user']);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('curp', 'like', "%{$search}%")
                  ->orWhere('matricula', 'like', "%{$search}%")
                  ->orWhere('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['program_id'])) {
            $query->where('programa_id', $filters['program_id']);
        }

        if (!empty($filters['period_id'])) {
            $periodId = (int) $filters['period_id'];
            $query->whereHas('periods', function ($pq) use ($periodId) {
                $pq->where('periodos_academicos.id', $periodId);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $students = $query->orderBy('id', 'desc')->paginate(
            $filters['per_page'] ?? 20,
            ['*'],
            'page',
            $filters['page'] ?? 1
        );

        $programs = AcademicProgram::orderBy('nombre', 'asc')->get();
        $periods = AcademicPeriod::orderBy('id', 'desc')->get();

        return [
            'students' => $students,
            'programs' => $programs,
            'periods' => $periods,
        ];
    }

    public function resolvePeriodDates(string $periodName): array
    {
        $upper = Str::upper(trim($periodName));
        preg_match('/\b(20\d{2})\b/', $upper, $matches);
        $year = isset($matches[1]) ? (int) $matches[1] : (int) date('Y');

        $fechaIni = "$year-01-01";
        $fechaFin = "$year-12-31";

        if (Str::contains($upper, ['ENERO - ABRIL', 'ENE - ABR', 'ENERO-ABRIL'])) {
            $fechaIni = "$year-01-01";
            $fechaFin = "$year-04-30";
        } elseif (Str::contains($upper, ['MAYO - AGOSTO', 'MAY - AGO', 'MAYO-AGOSTO'])) {
            $fechaIni = "$year-05-01";
            $fechaFin = "$year-08-31";
        } elseif (Str::contains($upper, ['SEPTIEMBRE - DICIEMBRE', 'SEP - DIC', 'SEPTIEMBRE-DICIEMBRE'])) {
            $fechaIni = "$year-09-01";
            $fechaFin = "$year-12-31";
        } elseif (Str::contains($upper, ['ENERO - JUNIO', 'ENE - JUN', 'ENERO-JUNIO'])) {
            $fechaIni = "$year-01-01";
            $fechaFin = "$year-06-30";
        } elseif (Str::contains($upper, ['JULIO - DICIEMBRE', 'JUL - DIC', 'JULIO-DICIEMBRE'])) {
            $fechaIni = "$year-07-01";
            $fechaFin = "$year-12-31";
        }

        return [
            'fecha_ini' => $fechaIni,
            'fecha_fin' => $fechaFin,
        ];
    }

    public function previewCsv(UploadedFile $file, User $user): array
    {
        $content = file_get_contents($file->getRealPath());
        
        // Convertir codificación a UTF-8 si es necesario
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1, Windows-1252');
        }

        // Eliminar BOM si existe
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        $lines = explode("\n", str_replace("\r", "", $content));
        if (empty($lines)) {
            throw new \InvalidArgumentException('El archivo CSV está vacío.');
        }

        $headerLine = array_shift($lines);
        $delimiter = strpos($headerLine, ';') !== false ? ';' : ',';
        $headers = array_map('trim', str_getcsv($headerLine, $delimiter));

        // Normalizar nombres de columnas
        $colMap = [];
        foreach ($headers as $index => $header) {
            $clean = Str::upper(trim($header));
            if (Str::contains($clean, ['CORREO', 'COORREO', 'EMAIL'])) {
                $colMap['email'] = $index;
            } elseif (Str::contains($clean, ['MATRICULA', 'MATRÍCULA'])) {
                $colMap['matricula'] = $index;
            } elseif (Str::contains($clean, ['NOMBRE', 'ALUMNO'])) {
                $colMap['nombre'] = $index;
            } elseif (Str::contains($clean, ['NIVEL', 'CARRERA'])) {
                $colMap['nivel'] = $index;
            } elseif (Str::contains($clean, ['PROGRAMA', 'ID PROGRAMA', 'CLAVE'])) {
                $colMap['id_programa'] = $index;
            } elseif (Str::contains($clean, ['CURP'])) {
                $colMap['curp'] = $index;
            } elseif (Str::contains($clean, ['TETRA', 'PERIODO', 'INICIO'])) {
                $colMap['periodo'] = $index;
            }
        }

        if (!isset($colMap['curp'])) {
            throw new \InvalidArgumentException('El archivo CSV debe contener la columna CURP.');
        }

        $validRows = [];
        $invalidRows = [];
        $existingCurps = ActiveStudent::pluck('id', 'curp')->all();

        $toInsertCount = 0;
        $toUpdateCount = 0;

        foreach ($lines as $lineNo => $line) {
            if (trim($line) === '') {
                continue;
            }

            $row = str_getcsv($line, $delimiter);
            $curp = isset($colMap['curp'], $row[$colMap['curp']]) ? Str::upper(trim($row[$colMap['curp']])) : '';
            $email = isset($colMap['email'], $row[$colMap['email']]) ? trim($row[$colMap['email']]) : '';
            $matricula = isset($colMap['matricula'], $row[$colMap['matricula']]) ? trim($row[$colMap['matricula']]) : '';
            $nombre = isset($colMap['nombre'], $row[$colMap['nombre']]) ? trim($row[$colMap['nombre']]) : '';
            $nivel = isset($colMap['nivel'], $row[$colMap['nivel']]) ? trim($row[$colMap['nivel']]) : '';
            $idPrograma = isset($colMap['id_programa'], $row[$colMap['id_programa']]) ? Str::upper(trim($row[$colMap['id_programa']])) : '';
            $periodo = isset($colMap['periodo'], $row[$colMap['periodo']]) ? trim($row[$colMap['periodo']]) : '';

            $rowNumber = $lineNo + 2;

            if (empty($curp)) {
                $invalidRows[] = [
                    'row' => $rowNumber,
                    'curp' => $curp,
                    'nombre' => $nombre,
                    'reason' => 'CURP ausente o vacía.',
                ];
                continue;
            }

            if (strlen($curp) < 10) {
                $invalidRows[] = [
                    'row' => $rowNumber,
                    'curp' => $curp,
                    'nombre' => $nombre,
                    'reason' => 'CURP con longitud inválida.',
                ];
                continue;
            }

            $isUpdate = isset($existingCurps[$curp]);
            if ($isUpdate) {
                $toUpdateCount++;
            } else {
                $toInsertCount++;
            }

            $validRows[] = [
                'row' => $rowNumber,
                'curp' => $curp,
                'email' => $email,
                'matricula' => $matricula,
                'nombre' => $nombre,
                'nivel' => $nivel,
                'id_programa' => $idPrograma ?: 'GEN',
                'periodo' => $periodo ?: 'PERIODO INICIAL',
                'is_update' => $isUpdate,
            ];
        }

        $token = (string) Str::uuid();
        $payload = [
            'valid_rows' => $validRows,
            'invalid_rows' => $invalidRows,
            'summary' => [
                'total_rows' => count($validRows) + count($invalidRows),
                'valid_count' => count($validRows),
                'invalid_count' => count($invalidRows),
                'to_insert_count' => $toInsertCount,
                'to_update_count' => $toUpdateCount,
            ],
            'created_at' => now()->timestamp,
        ];

        Storage::disk('local')->put("active_students_imports/{$token}.json", json_encode($payload));

        return [
            'status' => 'success',
            'token' => $token,
            'summary' => $payload['summary'],
            'preview_valid' => array_slice($validRows, 0, 10),
            'preview_invalid' => array_slice($invalidRows, 0, 10),
        ];
    }

    public function confirmImport(string $token, User $user): array
    {
        $filePath = "active_students_imports/{$token}.json";
        if (!Storage::disk('local')->exists($filePath)) {
            throw new \InvalidArgumentException('El token de importación ha expirado o no es válido.');
        }

        $payload = json_decode(Storage::disk('local')->get($filePath), true);
        $validRows = $payload['valid_rows'] ?? [];

        $insertedCount = 0;
        $updatedCount = 0;
        $periodLinkCount = 0;

        DB::transaction(function () use ($validRows, &$insertedCount, &$updatedCount, &$periodLinkCount) {
            foreach ($validRows as $item) {
                $curp = $item['curp'];
                $code = $item['id_programa'];
                $nivel = $item['nivel'];
                $periodName = $item['periodo'];

                // 1. Programa Académico
                $program = AcademicProgram::firstOrCreate(
                    ['codigo' => $code],
                    [
                        'nombre' => $nivel ?: "Programa $code",
                        'nivel' => $nivel,
                        'is_active' => true,
                    ]
                );

                if ($nivel && $program->nombre !== $nivel) {
                    $program->update(['nombre' => $nivel, 'nivel' => $nivel]);
                }

                // 2. Período Académico
                $slug = Str::slug($periodName);
                $dates = $this->resolvePeriodDates($periodName);

                $period = AcademicPeriod::firstOrCreate(
                    ['nombre' => $periodName],
                    [
                        'slug' => $slug ?: Str::slug(Str::random(10)),
                        'fecha_ini' => $dates['fecha_ini'],
                        'fecha_fin' => $dates['fecha_fin'],
                        'is_active' => true,
                    ]
                );

                // 3. UPSERT Alumno Activo por CURP
                $student = ActiveStudent::where('curp', $curp)->first();

                if ($student) {
                    $student->update([
                        'matricula' => !empty($item['matricula']) ? $item['matricula'] : $student->matricula,
                        'nombre_completo' => !empty($item['nombre']) ? $item['nombre'] : $student->nombre_completo,
                        'email' => !empty($item['email']) ? $item['email'] : $student->email,
                        'programa_id' => $program->id,
                        'status' => 'activo',
                    ]);
                    $updatedCount++;
                } else {
                    $student = ActiveStudent::create([
                        'curp' => $curp,
                        'matricula' => $item['matricula'],
                        'nombre_completo' => $item['nombre'],
                        'email' => $item['email'],
                        'programa_id' => $program->id,
                        'status' => 'activo',
                    ]);
                    $insertedCount++;
                }

                // 4. Vinculación en periodo_alumnos
                PeriodoAlumno::updateOrCreate(
                    [
                        'id_alumno' => $student->id,
                        'id_periodo' => $period->id,
                    ],
                    [
                        'status' => 'cursando',
                    ]
                );
                $periodLinkCount++;
            }
        });

        // Limpiar archivo temporal
        Storage::disk('local')->delete($filePath);

        return [
            'status' => 'success',
            'message' => "Proceso finalizado: $insertedCount alumnos creados, $updatedCount alumnos actualizados, $periodLinkCount registros vinculados a sus períodos.",
            'inserted' => $insertedCount,
            'updated' => $updatedCount,
            'period_links' => $periodLinkCount,
        ];
    }

    public function invalidCsvForToken(string $token): array
    {
        $filePath = "active_students_imports/{$token}.json";
        if (!Storage::disk('local')->exists($filePath)) {
            throw new \InvalidArgumentException('El reporte de errores ha expirado.');
        }

        $payload = json_decode(Storage::disk('local')->get($filePath), true);
        $invalidRows = $payload['invalid_rows'] ?? [];

        $tmpPath = sys_get_temp_dir() . "/invalid_students_{$token}.csv";
        $handle = fopen($tmpPath, 'w');

        // BOM para Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, ['Fila', 'CURP', 'Nombre', 'Motivo de Inconsistencia']);

        foreach ($invalidRows as $row) {
            fputcsv($handle, [
                $row['row'],
                $row['curp'],
                $row['nombre'],
                $row['reason'],
            ]);
        }

        fclose($handle);

        return [
            'path' => $tmpPath,
            'download_name' => "alumnos_invalidos_{$token}.csv",
        ];
    }
}
