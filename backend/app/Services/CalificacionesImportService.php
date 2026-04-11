<?php

namespace App\Services;

use App\Models\CalificacionesImportHistory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class CalificacionesImportService
{
    protected const EXPECTED_COLUMN_COUNT = 11;

    protected const BATCH_SIZE = 500;

    protected const MAX_INVALID_PREVIEW = 25;

    protected const HISTORY_LIMIT = 12;

    protected $studentRoleId;

    protected const EXPECTED_HEADERS = [
        'EMAIL DEL ALUMNO',
        'MATRÍCULA',
        'NOMBRE(S) DEL ALUMNO(A)',
        'APELLIDO PATERNO',
        'APELLIDO MATERNO',
        'PERÍODO',
        'TETRAMESTRE',
        'NIVEL',
        'ASIGNATURA',
        'CAL FINAL',
        'Nombre(s) y Apellido(s) del Maestro y/o Catedrático',
    ];

    public function summary(): array
    {
        return [
            'table_total' => DB::table('calificaciones_old')->count(),
            'last_import_at' => DB::table('calificaciones_old')->max('marcatemporal'),
            'history' => CalificacionesImportHistory::query()
                ->with('user:id,name,email')
                ->orderByDesc('processed_at')
                ->orderByDesc('id')
                ->limit(self::HISTORY_LIMIT)
                ->get()
                ->map(function (CalificacionesImportHistory $history) {
                    return [
                        'id' => $history->id,
                        'original_file_name' => $history->original_file_name,
                        'csv_file_name' => $history->csv_file_name,
                        'status' => $history->status,
                        'total_rows' => $history->total_rows,
                        'valid_rows' => $history->valid_rows,
                        'invalid_rows' => $history->invalid_rows,
                        'imported_rows' => $history->imported_rows,
                        'processed_at' => optional($history->processed_at)->format('Y-m-d H:i:s'),
                        'user' => $history->user ? [
                            'id' => $history->user->id,
                            'name' => $history->user->name,
                            'email' => $history->user->email,
                        ] : null,
                    ];
                })
                ->values(),
        ];
    }

    public function previewFromZip(UploadedFile $zipFile, User $user): array
    {
        $originalFileName = $zipFile->getClientOriginalName();
        $token = (string) Str::uuid();
        $storedZipPath = $zipFile->storeAs('calificaciones-imports/staging', $token . '.zip');
        $invalidCsvPath = $this->invalidCsvPath($token);

        try {
            $inspection = $this->inspectZip(Storage::path($storedZipPath), Storage::path($invalidCsvPath));

            if (!$inspection['header_valid']) {
                Storage::delete([$storedZipPath, $invalidCsvPath]);

                return [
                    'message' => 'El encabezado del CSV no coincide con el formato esperado.',
                    'preview' => [
                        'token' => null,
                        'original_file_name' => $originalFileName,
                        'csv_file_name' => $inspection['csv_file_name'],
                        'delimiter' => $inspection['delimiter'],
                        'header_valid' => false,
                        'expected_headers' => self::EXPECTED_HEADERS,
                        'received_headers' => $inspection['headers'],
                        'total_rows' => $inspection['total_rows'],
                        'valid_rows' => 0,
                        'invalid_rows' => 0,
                        'invalid_reason_summary' => [],
                        'invalid_rows_preview' => [],
                        'invalid_csv_download_url' => null,
                    ],
                ];
            }

            Storage::put($this->metadataPath($token), json_encode([
                'token' => $token,
                'user_id' => $user->id,
                'original_file_name' => $originalFileName,
                'stored_zip_path' => $storedZipPath,
                'invalid_csv_path' => $invalidCsvPath,
                'csv_file_name' => $inspection['csv_file_name'],
                'created_at' => now()->format('Y-m-d H:i:s'),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return [
                'message' => 'Validación completada. Revisa la vista previa antes de confirmar la importación.',
                'preview' => [
                    'token' => $token,
                    'original_file_name' => $originalFileName,
                    'csv_file_name' => $inspection['csv_file_name'],
                    'delimiter' => $inspection['delimiter'],
                    'header_valid' => true,
                    'expected_headers' => self::EXPECTED_HEADERS,
                    'received_headers' => $inspection['headers'],
                    'total_rows' => $inspection['total_rows'],
                    'valid_rows' => $inspection['valid_rows'],
                    'invalid_rows' => $inspection['invalid_rows'],
                    'invalid_reason_summary' => $inspection['invalid_reason_summary'],
                    'invalid_rows_preview' => $inspection['invalid_rows_preview'],
                    'invalid_csv_download_url' => $inspection['invalid_rows'] > 0 ? '/umla-api/api/calificaciones/importacion/preview/' . $token . '/invalid-csv' : null,
                ],
            ];
        } catch (\Throwable $exception) {
            Storage::delete([$storedZipPath, $invalidCsvPath]);
            throw $exception;
        }
    }

    public function confirmImport(string $token, User $user): array
    {
        $metadata = $this->loadMetadata($token);

        if ((int) $metadata['user_id'] !== (int) $user->id) {
            throw new RuntimeException('La vista previa pertenece a otro usuario. Vuelve a validar el archivo.');
        }

        $inspection = $this->inspectZip(Storage::path($metadata['stored_zip_path']));

        if (!$inspection['header_valid']) {
            $this->cleanupToken($token, $metadata);
            throw new RuntimeException('El encabezado del CSV ya no es válido para importar.');
        }

        $now = now()->format('Y-m-d H:i:s');
        $importedRows = 0;
        $batch = [];

        foreach ($inspection['valid_payloads'] as $payload) {
            $payload['marcatemporal'] = $now;
            $payload['id_estudiante'] = $this->resolveStudentUserId($payload);
            $batch[] = $payload;
            $importedRows++;

            if (count($batch) >= self::BATCH_SIZE) {
                $this->flushBatch($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->flushBatch($batch);
        }

        CalificacionesImportHistory::create([
            'user_id' => $user->id,
            'original_file_name' => $metadata['original_file_name'],
            'csv_file_name' => $inspection['csv_file_name'],
            'status' => 'completed',
            'total_rows' => $inspection['total_rows'],
            'valid_rows' => $inspection['valid_rows'],
            'invalid_rows' => $inspection['invalid_rows'],
            'imported_rows' => $importedRows,
            'invalid_rows_preview' => $inspection['invalid_rows_preview'],
            'processed_at' => now(),
        ]);

        $this->cleanupToken($token, $metadata);

        return [
            'message' => 'Importación confirmada y registrada en el historial.',
            'summary' => [
                'csv_file' => $inspection['csv_file_name'],
                'processed_rows' => $importedRows,
                'skipped_rows' => $inspection['invalid_rows'],
                'table_total' => DB::table('calificaciones_old')->count(),
                'last_import_at' => $now,
                'executed_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
            'errors' => array_map(function (array $item) {
                return 'Fila ' . $item['line'] . ': ' . $item['reason'];
            }, $inspection['invalid_rows_preview']),
        ];
    }

    public function invalidCsvForToken(string $token, User $user): array
    {
        $metadata = $this->loadMetadata($token);

        if ((int) $metadata['user_id'] !== (int) $user->id) {
            throw new RuntimeException('El archivo de inválidos pertenece a otra vista previa.');
        }

        if (empty($metadata['invalid_csv_path']) || !Storage::exists($metadata['invalid_csv_path'])) {
            throw new RuntimeException('No existe un CSV de inválidos para esta vista previa.');
        }

        return [
            'path' => Storage::path($metadata['invalid_csv_path']),
            'download_name' => 'invalidos_' . $token . '.csv',
        ];
    }

    protected function inspectZip(string $zipPath, ?string $invalidCsvFullPath = null): array
    {
        $zip = new ZipArchive();
        $openResult = $zip->open($zipPath);

        if ($openResult !== true) {
            throw new RuntimeException('No fue posible abrir el archivo ZIP.');
        }

        $csvEntryName = $this->findCsvEntryName($zip);

        if (!$csvEntryName) {
            $zip->close();
            throw new RuntimeException('El ZIP no contiene un archivo CSV válido.');
        }

        $stream = $zip->getStream($csvEntryName);

        if (!$stream) {
            $zip->close();
            throw new RuntimeException('No fue posible leer el CSV dentro del ZIP.');
        }

        $lineNumber = 0;
        $delimiter = null;
        $headers = [];
        $headerValid = false;
        $totalRows = 0;
        $validRows = 0;
        $invalidRows = 0;
        $invalidReasonSummary = [];
        $invalidPreview = [];
        $validPayloads = [];
        $invalidCsvHandle = null;

        if ($invalidCsvFullPath) {
            File::ensureDirectoryExists(dirname($invalidCsvFullPath));
            $invalidCsvHandle = fopen($invalidCsvFullPath, 'w');
            fputcsv($invalidCsvHandle, array_merge(['LINEA', 'MOTIVO'], self::EXPECTED_HEADERS), ';');
        }

        try {
            while (($line = fgets($stream)) !== false) {
                if (trim($line) === '') {
                    continue;
                }

                $lineNumber++;

                if ($lineNumber === 1) {
                    $delimiter = $this->detectDelimiter($line);
                    $headers = $this->parseHeader($line, $delimiter);
                    $headerValid = $headers === self::EXPECTED_HEADERS;
                    continue;
                }

                $totalRows++;
                $row = str_getcsv($line, $delimiter ?? ';');

                if ($this->rowIsEmpty($row)) {
                    continue;
                }

                if (!$headerValid) {
                    continue;
                }

                $validation = $this->validateAndNormalizeRow($row);

                if (!$validation['valid']) {
                    $invalidRows++;
                    $invalidReasonSummary[$validation['reason']] = ($invalidReasonSummary[$validation['reason']] ?? 0) + 1;
                    if (count($invalidPreview) < self::MAX_INVALID_PREVIEW) {
                        $invalidPreview[] = [
                            'line' => $lineNumber,
                            'reason' => $validation['reason'],
                            'row' => array_slice($row, 0, self::EXPECTED_COLUMN_COUNT),
                        ];
                    }
                    if ($invalidCsvHandle) {
                        fputcsv($invalidCsvHandle, array_merge([$lineNumber, $validation['reason']], array_slice($row, 0, self::EXPECTED_COLUMN_COUNT)), ';');
                    }
                    continue;
                }

                $validRows++;
                $validPayloads[] = $validation['payload'];
            }
        } finally {
            if ($invalidCsvHandle) {
                fclose($invalidCsvHandle);
            }
            fclose($stream);
            $zip->close();
        }

        $invalidReasonSummary = collect($invalidReasonSummary)
            ->map(function ($count, $reason) {
                return [
                    'reason' => $reason,
                    'count' => $count,
                    'label' => $count . ' filas inválidas por ' . $reason,
                ];
            })
            ->values()
            ->all();

        return [
            'csv_file_name' => $csvEntryName,
            'delimiter' => $delimiter,
            'headers' => $headers,
            'header_valid' => $headerValid,
            'total_rows' => $totalRows,
            'valid_rows' => $validRows,
            'invalid_rows' => $invalidRows,
            'invalid_reason_summary' => $invalidReasonSummary,
            'invalid_rows_preview' => $invalidPreview,
            'valid_payloads' => $validPayloads,
        ];
    }

    protected function parseHeader(string $line, string $delimiter): array
    {
        $headers = str_getcsv($line, $delimiter);

        return array_map(function ($header, $index) {
            $header = trim((string) $header);
            if ($index === 0) {
                $header = preg_replace('/^\xEF\xBB\xBF/', '', $header);
            }
            return $header;
        }, $headers, array_keys($headers));
    }

    protected function validateAndNormalizeRow(array $row): array
    {
        if (count($row) < self::EXPECTED_COLUMN_COUNT) {
            return [
                'valid' => false,
                'reason' => 'columnas insuficientes',
            ];
        }

        $email = $this->cleanEmail($row[0] ?? '');
        $matricula = $this->cleanText($row[1] ?? '');
        $nombre = $this->cleanText($row[2] ?? '');
        $apaterno = $this->cleanText($row[3] ?? '');
        $amaterno = $this->cleanText($row[4] ?? '');
        $periodo = $this->cleanText($row[5] ?? '');
        $tetramestre = $this->cleanText($row[6] ?? '');
        $nivel = $this->cleanText($row[7] ?? '');
        $asignatura = $this->cleanText($row[8] ?? '');
        $calificacionFinal = trim((string) ($row[9] ?? ''));
        $catedratico = $this->cleanText($row[10] ?? '');

        if ($matricula === '') {
            return ['valid' => false, 'reason' => 'matrícula vacía'];
        }

        if ($asignatura === '') {
            return ['valid' => false, 'reason' => 'asignatura vacía'];
        }

        if ($nombre === '') {
            return ['valid' => false, 'reason' => 'nombre vacío'];
        }

        if ($calificacionFinal === '' || $calificacionFinal === '-') {
            $calificacionFinal = '0.0';
        }

        if ($email === '') {
            return ['valid' => false, 'reason' => 'correo vacío o inválido'];
        }

        return [
            'valid' => true,
            'payload' => [
                'marcatemporal' => now()->format('Y-m-d H:i:s'),
                'Email' => $email,
                'Matricula' => $matricula,
                'Nombre' => $nombre,
                'APaterno' => $apaterno,
                'AMaterno' => $amaterno,
                'Periodo' => $periodo,
                'Tetramestre' => $tetramestre,
                'Nivel' => $nivel,
                'Asignatura' => $asignatura,
                'CalificacionFinal' => $calificacionFinal,
                'Catedratico' => $catedratico,
                'id_estudiante' => null,
            ],
        ];
    }

    protected function loadMetadata(string $token): array
    {
        $path = $this->metadataPath($token);

        if (!Storage::exists($path)) {
            throw new RuntimeException('La vista previa ya expiró o no existe. Vuelve a validar el ZIP.');
        }

        $metadata = json_decode(Storage::get($path), true);

        if (!is_array($metadata) || empty($metadata['stored_zip_path'])) {
            throw new RuntimeException('La vista previa no contiene metadatos válidos.');
        }

        if (!Storage::exists($metadata['stored_zip_path'])) {
            throw new RuntimeException('El archivo temporal de la vista previa ya no existe.');
        }

        return $metadata;
    }

    protected function cleanupToken(string $token, array $metadata): void
    {
        Storage::delete(array_filter([
            $metadata['stored_zip_path'] ?? null,
            $metadata['invalid_csv_path'] ?? null,
            $this->metadataPath($token),
        ]));
    }

    protected function metadataPath(string $token): string
    {
        return 'calificaciones-imports/staging/' . $token . '.json';
    }

    protected function invalidCsvPath(string $token): string
    {
        return 'calificaciones-imports/staging/' . $token . '-invalid.csv';
    }

    protected function findCsvEntryName(ZipArchive $zip): ?string
    {
        for ($index = 0; $index < $zip->numFiles; $index++) {
            $entryName = $zip->getNameIndex($index);
            if (!$entryName) {
                continue;
            }

            if (substr($entryName, -1) === '/') {
                continue;
            }

            if (strtolower(pathinfo($entryName, PATHINFO_EXTENSION)) === 'csv') {
                return $entryName;
            }
        }

        return null;
    }

    protected function detectDelimiter(string $firstLine): string
    {
        return substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
    }

    protected function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    protected function cleanEmail(string $value): string
    {
        $value = trim($value);
        $sanitized = preg_replace('/[^a-zA-Z0-9@._\-+]/', '', $value);
        return $sanitized ?: '';
    }

    protected function cleanText(string $value): string
    {
        $value = trim(str_replace('"', '', $value));
        $sanitized = preg_replace('/[^\p{L}\p{N}\s.@\-_]/u', '', $value);
        return $sanitized ? preg_replace('/\s+/u', ' ', $sanitized) : '';
    }

    protected function flushBatch(array $batch): void
    {
        $columns = ['marcatemporal', 'Email', 'Matricula', 'Nombre', 'APaterno', 'AMaterno', 'Periodo', 'Tetramestre', 'Nivel', 'Asignatura', 'CalificacionFinal', 'Catedratico', 'id_estudiante'];
        $placeholders = [];
        $bindings = [];

        foreach ($batch as $row) {
            $placeholders[] = '(' . implode(', ', array_fill(0, count($columns), '?')) . ')';
            foreach ($columns as $column) {
                $bindings[] = $row[$column] ?? null;
            }
        }

        $sql = 'INSERT INTO calificaciones_old (' . implode(', ', $columns) . ') VALUES ' . implode(', ', $placeholders) . '
            ON DUPLICATE KEY UPDATE
            marcatemporal = VALUES(marcatemporal),
            Email = VALUES(Email),
            Nombre = VALUES(Nombre),
            APaterno = VALUES(APaterno),
            AMaterno = VALUES(AMaterno),
            Periodo = VALUES(Periodo),
            Tetramestre = VALUES(Tetramestre),
            Nivel = VALUES(Nivel),
            Catedratico = VALUES(Catedratico),
            id_estudiante = VALUES(id_estudiante),
            CalificacionFinal = CASE
                WHEN CAST(REPLACE(VALUES(CalificacionFinal), ",", ".") AS DECIMAL(10,2)) > CAST(REPLACE(COALESCE(CalificacionFinal, "0"), ",", ".") AS DECIMAL(10,2))
                    THEN VALUES(CalificacionFinal)
                ELSE CalificacionFinal
            END';

        DB::statement($sql, $bindings);
    }

    protected function resolveStudentUserId(array $payload): int
    {
        $user = User::query()->where('email', $payload['Email'])->first();

        if (!$user) {
            $fullName = $this->composeStudentName($payload);

            $user = User::create([
                'name' => $fullName,
                'email' => $payload['Email'],
                'password' => $payload['Matricula'],
            ]);
        }

        $user->roles()->syncWithoutDetaching([$this->studentRoleId()]);

        return (int) $user->id;
    }

    protected function composeStudentName(array $payload): string
    {
        $fullName = trim(implode(' ', array_filter([
            $payload['Nombre'] ?? null,
            $payload['APaterno'] ?? null,
            $payload['AMaterno'] ?? null,
        ])));

        return $fullName !== '' ? $fullName : $payload['Matricula'];
    }

    protected function studentRoleId(): int
    {
        if ($this->studentRoleId) {
            return $this->studentRoleId;
        }

        $role = Role::query()->firstOrCreate(
            ['slug' => 'estudiante'],
            [
                'name' => 'Estudiante',
                'description' => 'Cuenta creada automáticamente para alumnos importados',
            ]
        );

        $this->studentRoleId = (int) $role->id;

        return $this->studentRoleId;
    }
}