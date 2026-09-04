<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ActiveStudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ActiveStudentController extends Controller
{
    protected ActiveStudentService $activeStudentService;

    public function __construct(ActiveStudentService $activeStudentService)
    {
        $this->activeStudentService = $activeStudentService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'program_id', 'period_id', 'status', 'per_page', 'page']);
        $data = $this->activeStudentService->getStudentsData($filters);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function preview(Request $request): JsonResponse
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx|max:20480',
        ]);

        $file = $request->file('csv_file');
        $result = $this->activeStudentService->previewCsv($file, $request->user());

        return response()->json($result);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $result = $this->activeStudentService->confirmImport($validated['token'], $request->user());

        return response()->json($result);
    }

    public function downloadInvalidCsv(Request $request, string $token): BinaryFileResponse
    {
        $file = $this->activeStudentService->invalidCsvForToken($token);

        return response()->download($file['path'], $file['download_name'], [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
