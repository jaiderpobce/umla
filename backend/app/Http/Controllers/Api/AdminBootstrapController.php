<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;

class AdminBootstrapController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->rbacService->adminSnapshot());
    }
}
