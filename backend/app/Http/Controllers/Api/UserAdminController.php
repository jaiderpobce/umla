<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'users' => User::query()->with('roles:id,name,slug')->orderBy('name')->get()->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_ids' => $user->roles->pluck('id')->values(),
                ];
            })->values(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role_ids' => ['array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::create($payload);
        $user->roles()->sync($payload['role_ids'] ?? []);

        // Si el usuario creado tiene el rol 'estudiante', forzar cambio de contraseña en primer login.
        if ($user->roles()->where('slug', 'estudiante')->exists()) {
            $user->update(['must_change_password' => true]);
        }

        return response()->json([
            'message' => 'Usuario creado.',
            'user' => $user->load('roles:id,name,slug'),
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role_ids' => ['array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        if (empty($payload['password'])) {
            unset($payload['password']);
        }

        $user->update($payload);
        $user->roles()->sync($payload['role_ids'] ?? []);

        // Si tras la actualización el usuario tiene rol 'estudiante', forzar cambio de contraseña.
        if ($user->roles()->where('slug', 'estudiante')->exists()) {
            $user->update(['must_change_password' => true]);
        }

        return response()->json([
            'message' => 'Usuario actualizado.',
            'user' => $user->load('roles:id,name,slug'),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if ((int) $request->user()->id === (int) $user->id) {
            return response()->json([
                'message' => 'No puedes eliminar tu propio usuario activo.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado.',
        ]);
    }

    public function resetStudentPasswords(Request $request): JsonResponse
    {
        $hashed = bcrypt('passwd');

        $count = User::whereHas('roles', function ($query) {
            $query->where('slug', 'estudiante');
        })->update([
            'password' => $hashed,
            'must_change_password' => true,
        ]);

        return response()->json([
            'message' => "Se han reseteado las contraseñas de {$count} estudiantes.",
        ]);
    }
}
