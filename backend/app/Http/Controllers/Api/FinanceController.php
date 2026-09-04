<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected FinanceService $financeService;

    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    public function adminIndex(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'search', 'per_page', 'career', 'charges_page', 'pending_page']);
        $data = $this->financeService->getAdminCharges($filters);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function generateByCareer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'career' => 'required|string',
            'concept' => 'required|string|max:160',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'finance_period_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $result = $this->financeService->generateChargesByCareer($validated, $request->user()->id);

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'count' => $result['count'],
        ]);
    }

    public function studentIndex(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'search', 'per_page', 'charges_page', 'receipts_page']);
        $data = $this->financeService->getStudentData($request->user()->id, $filters);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function reportPayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'finance_charge_id' => 'required|integer|exists:finance_charges,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:60',
            'reference' => 'nullable|string|max:120',
            'bank_name' => 'nullable|string|max:120',
            'voucher' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
        ]);

        $file = $request->file('voucher');
        $payment = $this->financeService->reportPayment(
            $request->user()->id,
            $validated,
            $file
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Comprobante de pago reportado exitosamente.',
            'payment' => $payment,
        ]);
    }

    public function approvePayment(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $payment = $this->financeService->approvePayment(
            $id,
            $request->user()->id,
            $validated['notes'] ?? null
        );

        return response()->json([
            'status' => 'success',
            'message' => 'El pago ha sido aprobado y el recibo fue emitido y enviado al correo del estudiante.',
            'payment' => $payment,
        ]);
    }

    public function rejectPayment(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $payment = $this->financeService->rejectPayment(
            $id,
            $request->user()->id,
            $validated['notes'] ?? null
        );

        return response()->json([
            'status' => 'success',
            'message' => 'El pago ha sido rechazado.',
            'payment' => $payment,
        ]);
    }
}
