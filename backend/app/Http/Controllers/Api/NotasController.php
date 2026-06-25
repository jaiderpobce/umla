<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NotasController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function index(Request $request): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'notas', 'grid');

        if (!$payload || !in_array('view', $payload['view']['permissions'], true)) {
            return response()->json(['message' => 'No tienes acceso al módulo de notas.'], 403);
        }

        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $search = trim((string) $request->query('search', ''));
        $matricula = trim((string) $request->query('matricula', ''));

        $query = DB::table('calificaciones_old')->orderByDesc('id');

        if ($this->isStudentOnly($request->user())) {
            $query->where(function ($scope) use ($request) {
                $scope->where('id_estudiante', $request->user()->id)
                    ->orWhere('Email', $request->user()->email);
            });
        }

        if ($matricula !== '') {
            $query->where('Matricula', $matricula);
        }

        if ($search !== '') {
            $query->where(function ($scope) use ($search) {
                $like = '%' . $search . '%';
                $scope->where('Matricula', 'like', $like)
                    ->orWhere('Nombre', 'like', $like)
                    ->orWhere('APaterno', 'like', $like)
                    ->orWhere('AMaterno', 'like', $like)
                    ->orWhere('Email', 'like', $like)
                    ->orWhere('Asignatura', 'like', $like)
                    ->orWhere('Periodo', 'like', $like)
                    ->orWhere('Nivel', 'like', $like)
                    ->orWhere('Catedratico', 'like', $like);
            });
        }

        $result = $query->paginate($perPage);

        $matriculas = [];
        if ($this->isStudentOnly($request->user())) {
            $matriculas = DB::table('calificaciones_old')
                ->where(function ($scope) use ($request) {
                    $scope->where('id_estudiante', $request->user()->id)
                        ->orWhere('Email', $request->user()->email);
                })
                ->whereNotNull('Matricula')
                ->where('Matricula', '!=', '')
                ->distinct()
                ->pluck('Matricula')
                ->all();
        }

        return response()->json([
            'data' => collect($result->items())->map(function ($item) {
                return $this->serializeNota($item);
            })->values(),
            'meta' => [
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
                'from' => $result->firstItem(),
                'to' => $result->lastItem(),
            ],
            'matriculas' => $matriculas,
        ]);
    }

    public function update(Request $request, int $notaId): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'notas', 'grid');

        if (!$payload || !in_array('edit', $payload['view']['permissions'], true)) {
            return response()->json(['message' => 'No tienes permisos para editar notas.'], 403);
        }

        $nota = DB::table('calificaciones_old')->where('id', $notaId)->first();

        if (!$nota) {
            return response()->json(['message' => 'La nota solicitada no existe.'], 404);
        }

        $validated = $request->validate([
            'Email' => ['required', 'email', 'max:200'],
            'Matricula' => ['required', 'string', 'max:250'],
            'Nombre' => ['required', 'string', 'max:250'],
            'APaterno' => ['nullable', 'string', 'max:250'],
            'AMaterno' => ['nullable', 'string', 'max:250'],
            'Periodo' => ['nullable', 'string', 'max:255'],
            'Tetramestre' => ['nullable', 'string', 'max:255'],
            'Nivel' => ['nullable', 'string', 'max:255'],
            'Asignatura' => ['required', 'string', 'max:255'],
            'CalificacionFinal' => ['nullable', 'string', 'max:10'],
            'Catedratico' => ['nullable', 'string', 'max:255'],
        ]);

        $duplicate = DB::table('calificaciones_old')
            ->where('Matricula', $validated['Matricula'])
            ->where('Asignatura', $validated['Asignatura'])
            ->where('id', '!=', $notaId)
            ->exists();

        if ($duplicate) {
            return response()->json(['message' => 'Ya existe otra nota con esa matrícula y asignatura.'], 422);
        }

        $studentUser = User::query()->where('email', $validated['Email'])->first();

        DB::table('calificaciones_old')->where('id', $notaId)->update([
            'marcatemporal' => now()->format('Y-m-d H:i:s'),
            'Email' => $validated['Email'],
            'Matricula' => $validated['Matricula'],
            'Nombre' => $validated['Nombre'],
            'APaterno' => $validated['APaterno'] ?? '',
            'AMaterno' => $validated['AMaterno'] ?? '',
            'Periodo' => $validated['Periodo'] ?? '',
            'Tetramestre' => $validated['Tetramestre'] ?? '',
            'Nivel' => $validated['Nivel'] ?? '',
            'Asignatura' => $validated['Asignatura'],
            'CalificacionFinal' => $validated['CalificacionFinal'] === '' || $validated['CalificacionFinal'] === null ? '0.0' : $validated['CalificacionFinal'],
            'Catedratico' => $validated['Catedratico'] ?? '',
            'id_estudiante' => $studentUser ? $studentUser->id : null,
        ]);

        $updated = DB::table('calificaciones_old')->where('id', $notaId)->first();

        return response()->json([
            'message' => 'Nota actualizada.',
            'nota' => $this->serializeNota($updated),
        ]);
    }

    public function destroy(Request $request, int $notaId): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'notas', 'grid');

        if (!$payload || !in_array('delete', $payload['view']['permissions'], true)) {
            return response()->json(['message' => 'No tienes permisos para eliminar notas.'], 403);
        }

        $deleted = DB::table('calificaciones_old')->where('id', $notaId)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'La nota solicitada no existe.'], 404);
        }

        return response()->json(['message' => 'Nota eliminada.']);
    }

    protected function isStudentOnly(User $user): bool
    {
        $roleSlugs = $user->roles()->pluck('slug');

        if ($roleSlugs->contains('super-admin') || $roleSlugs->contains('operador')) {
            return false;
        }

        return $roleSlugs->contains('estudiante');
    }

    protected function serializeNota($item): array
    {
        return [
            'id' => (int) $item->id,
            'marcatemporal' => $item->marcatemporal,
            'Email' => $item->Email,
            'Matricula' => $item->Matricula,
            'Nombre' => $item->Nombre,
            'APaterno' => $item->APaterno,
            'AMaterno' => $item->AMaterno,
            'Periodo' => $item->Periodo,
            'Tetramestre' => $item->Tetramestre,
            'Nivel' => $item->Nivel,
            'Asignatura' => $item->Asignatura,
            'CalificacionFinal' => $item->CalificacionFinal,
            'Catedratico' => $item->Catedratico,
            'id_estudiante' => $item->id_estudiante ? (int) $item->id_estudiante : null,
        ];
    }
}