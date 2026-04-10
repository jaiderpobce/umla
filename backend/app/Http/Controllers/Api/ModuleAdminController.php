<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppModule;
use App\Models\ModuleView;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModuleAdminController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'modules' => AppModule::query()->with(['views' => function ($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get()->map(function (AppModule $module) {
                return $this->rbacService->serializeModule($module);
            })->values(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:modules,slug'],
            'icon' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $module = AppModule::create($payload);

        return response()->json([
            'message' => 'Módulo creado.',
            'module' => $this->rbacService->serializeModule($module),
        ]);
    }

    public function update(Request $request, AppModule $module): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('modules', 'slug')->ignore($module->id)],
            'icon' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $module->update($payload);

        return response()->json([
            'message' => 'Módulo actualizado.',
            'module' => $this->rbacService->serializeModule($module->fresh()),
        ]);
    }

    public function destroy(AppModule $module): JsonResponse
    {
        $module->delete();

        return response()->json([
            'message' => 'Módulo eliminado.',
        ]);
    }

    public function storeView(Request $request, AppModule $module): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('module_views', 'slug')->where(function ($query) use ($module) {
                return $query->where('module_id', $module->id);
            })],
            'route' => ['required', 'string', 'max:255'],
            'component' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $module->views()->create($payload);

        return response()->json([
            'message' => 'Vista creada.',
            'module' => $this->rbacService->serializeModule($module->fresh()),
        ]);
    }

    public function updateView(Request $request, ModuleView $moduleView): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('module_views', 'slug')->ignore($moduleView->id)->where(function ($query) use ($moduleView) {
                return $query->where('module_id', $moduleView->module_id);
            })],
            'route' => ['required', 'string', 'max:255'],
            'component' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $moduleView->update($payload);

        return response()->json([
            'message' => 'Vista actualizada.',
            'module' => $this->rbacService->serializeModule($moduleView->module->fresh()),
        ]);
    }

    public function destroyView(ModuleView $moduleView): JsonResponse
    {
        $module = $moduleView->module;
        $moduleView->delete();

        return response()->json([
            'message' => 'Vista eliminada.',
            'module' => $this->rbacService->serializeModule($module->fresh()),
        ]);
    }
}
