<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function navigation(Request $request): JsonResponse
    {
        return response()->json([
            'navigation' => $this->rbacService->navigationFor($request->user()),
        ]);
    }

    public function show(Request $request, string $moduleSlug, string $viewSlug): JsonResponse
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), $moduleSlug, $viewSlug);

        if (!$payload) {
            return response()->json([
                'message' => 'Vista no autorizada o inexistente.',
            ], 404);
        }

        return response()->json($payload);
    }
}
