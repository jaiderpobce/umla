<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CalificacionesImportService;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CalificacionesImportController extends Controller
{
    protected $rbacService;

    protected $importService;

    public function __construct(RbacService $rbacService, CalificacionesImportService $importService)
    {
        $this->rbacService = $rbacService;
        $this->importService = $importService;
    }

    public function summary(Request $request): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'calificaciones', 'importacion');

        if (!$payload) {
            return response()->json([
                'message' => 'No tienes acceso a este módulo.',
            ], 403);
        }

        return response()->json($this->importService->summary());
    }

    public function preview(Request $request): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'calificaciones', 'importacion');

        if (!$payload || !in_array('create', $payload['view']['permissions'], true)) {
            return response()->json([
                'message' => 'No tienes permisos para cargar archivos en este módulo.',
            ], 403);
        }

        $validated = $request->validate([
            'zip_file' => ['required', 'file', 'mimes:zip', 'max:51200'],
        ]);

        $result = $this->importService->previewFromZip($validated['zip_file'], $request->user());

        return response()->json($result);
    }

    public function downloadInvalidCsv(Request $request, string $token): BinaryFileResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'calificaciones', 'importacion');

        if (!$payload || !in_array('create', $payload['view']['permissions'], true)) {
            abort(403, 'No tienes permisos para descargar el reporte de inválidos.');
        }

        $file = $this->importService->invalidCsvForToken($token, $request->user());

        return response()->download($file['path'], $file['download_name'], [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'calificaciones', 'importacion');

        if (!$payload || !in_array('create', $payload['view']['permissions'], true)) {
            return response()->json([
                'message' => 'No tienes permisos para cargar archivos en este módulo.',
            ], 403);
        }

        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $result = $this->importService->confirmImport($validated['token'], $request->user());

        return response()->json($result);
    }
}