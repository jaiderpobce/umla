<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleViewPermission;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleAdminController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'roles' => Role::query()->orderBy('name')->get()->map(function (Role $role) {
                return $this->rbacService->serializeRole($role);
            })->values(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role = Role::create($payload);

        return response()->json([
            'message' => 'Rol creado.',
            'role' => $this->rbacService->serializeRole($role),
        ]);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('roles', 'slug')->ignore($role->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update($payload);

        return response()->json([
            'message' => 'Rol actualizado.',
            'role' => $this->rbacService->serializeRole($role),
        ]);
    }

    public function destroy(Role $role): JsonResponse
    {
        if ($role->users()->exists()) {
            return response()->json([
                'message' => 'No puedes eliminar un rol asignado a usuarios.',
            ], 422);
        }

        $role->delete();

        return response()->json([
            'message' => 'Rol eliminado.',
        ]);
    }

    public function syncAccess(Request $request, Role $role): JsonResponse
    {
        $payload = $request->validate([
            'module_ids' => ['array'],
            'module_ids.*' => ['integer', 'exists:modules,id'],
            'view_permissions' => ['array'],
        ]);

        DB::transaction(function () use ($payload, $role) {
            $role->modules()->sync($payload['module_ids'] ?? []);
            RoleViewPermission::query()->where('role_id', $role->id)->delete();

            foreach (($payload['view_permissions'] ?? []) as $viewId => $permissionIds) {
                foreach ((array) $permissionIds as $permissionId) {
                    RoleViewPermission::create([
                        'role_id' => $role->id,
                        'module_view_id' => (int) $viewId,
                        'permission_id' => (int) $permissionId,
                    ]);
                }
            }
        });

        return response()->json([
            'message' => 'Acceso del rol actualizado.',
            'role' => $this->rbacService->serializeRole($role->fresh()),
        ]);
    }
}
