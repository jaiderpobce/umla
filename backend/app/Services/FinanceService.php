<?php

namespace App\Services;

use App\Mail\PaymentReceiptMail;
use App\Models\FinanceCharge;
use App\Models\FinancePayment;
use App\Models\FinancePeriod;
use App\Models\FinanceReceipt;
use App\Models\FinanceStatusLog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FinanceService
{
    public function getCareers(): array
    {
        return DB::table('calificaciones_old')
            ->whereNotNull('Nivel')
            ->where('Nivel', '!=', '')
            ->distinct()
            ->pluck('Nivel')
            ->values()
            ->all();
    }

    public function generateChargesByCareer(array $data, int $createdByUserId): array
    {
        $career = $data['career'];
        $concept = $data['concept'];
        $amount = (float) $data['amount'];
        $dueDate = $data['due_date'];
        $periodId = $data['finance_period_id'] ?? null;
        $description = $data['description'] ?? null;

        if (!$periodId) {
            $period = FinancePeriod::query()->where('status', 'active')->first()
                ?? FinancePeriod::query()->latest('id')->first();

            if (!$period) {
                $currentYear = (int) date('Y');
                $currentMonth = (int) date('m');
                $monthNames = [
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ];
                $monthName = $monthNames[$currentMonth] ?? 'Actual';

                $period = FinancePeriod::create([
                    'name' => "$monthName $currentYear",
                    'slug' => sprintf('%04d-%02d', $currentYear, $currentMonth),
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'starts_at' => date('Y-m-01'),
                    'ends_at' => date('Y-m-t'),
                    'due_at' => date('Y-m-10'),
                    'status' => 'active',
                    'notes' => 'Período generado automáticamente por el sistema.',
                    'created_by_user_id' => $createdByUserId,
                ]);
            }

            $periodId = $period->id;
        }

        // Buscar IDs de estudiantes de esa carrera desde calificaciones_old o role_user
        $studentUserIds = DB::table('calificaciones_old')
            ->where('Nivel', $career)
            ->whereNotNull('id_estudiante')
            ->distinct()
            ->pluck('id_estudiante')
            ->map(fn($id) => (int) $id)
            ->filter()
            ->values()
            ->all();

        if (empty($studentUserIds)) {
            // Fallback: Si no hay estudiantes asignados en calificaciones_old, asignar a todos los usuarios con rol 'estudiante'
            $studentUserIds = DB::table('role_user')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('roles.slug', 'estudiante')
                ->pluck('role_user.user_id')
                ->map(fn($id) => (int) $id)
                ->all();
        }

        $createdCount = 0;
        DB::transaction(function () use ($studentUserIds, $periodId, $concept, $amount, $dueDate, $description, $createdByUserId, &$createdCount) {
            foreach ($studentUserIds as $userId) {
                $chargeCode = 'CHG-' . date('Ym') . '-' . $userId . '-' . Str::upper(Str::random(6));

                FinanceCharge::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'finance_period_id' => $periodId,
                        'concept' => $concept,
                    ],
                    [
                        'charge_code' => $chargeCode,
                        'description' => $description,
                        'currency' => 'MXN',
                        'amount_total' => $amount,
                        'amount_paid' => 0.00,
                        'balance_due' => $amount,
                        'status' => 'pendiente',
                        'billed_at' => now()->toDateString(),
                        'due_at' => $dueDate,
                        'created_by_user_id' => $createdByUserId,
                        'updated_by_user_id' => $createdByUserId,
                    ]
                );
                $createdCount++;
            }
        });

        return [
            'success' => true,
            'count' => $createdCount,
            'message' => "Se emitieron $createdCount cargos pendientes para la carrera '$career'.",
        ];
    }

    public function getAdminCharges(array $filters = []): array
    {
        // 1. Query para Cobranza Global (Charges)
        $query = FinanceCharge::with(['user', 'period', 'payments.receipt']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('concept', 'like', "%{$search}%")
                  ->orWhere('charge_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['career'])) {
            $career = $filters['career'];
            $query->whereHas('user', function ($uq) use ($career) {
                $uq->whereIn('id', function ($subq) use ($career) {
                    $subq->select('id_estudiante')
                         ->from('calificaciones_old')
                         ->where('Nivel', $career);
                });
            });
        }

        $charges = $query->orderBy('id', 'desc')->paginate(
            $filters['per_page'] ?? 20, 
            ['*'], 
            'charges_page', 
            $filters['charges_page'] ?? 1
        );

        // 2. Query para Pagos Pendientes (Pending Payments)
        $pendingQuery = FinancePayment::with(['user', 'charge.period'])
            ->where('status', 'reportado');
            
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('bank_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['career'])) {
            $career = $filters['career'];
            $pendingQuery->whereHas('user', function ($uq) use ($career) {
                $uq->whereIn('id', function ($subq) use ($career) {
                    $subq->select('id_estudiante')
                         ->from('calificaciones_old')
                         ->where('Nivel', $career);
                });
            });
        }

        $pendingPayments = $pendingQuery->orderBy('id', 'desc')->paginate(
            $filters['per_page'] ?? 20, 
            ['*'], 
            'pending_page', 
            $filters['pending_page'] ?? 1
        );

        $periods = FinancePeriod::orderBy('id', 'desc')->get();

        return [
            'charges' => $charges,
            'pending_payments' => $pendingPayments,
            'periods' => $periods,
            'careers' => $this->getCareers(),
        ];
    }

    public function getStudentData(int $studentUserId, array $filters = []): array
    {
        $chargesQuery = FinanceCharge::with(['period', 'payments.receipt'])
            ->where('user_id', $studentUserId);

        if (!empty($filters['status'])) {
            $chargesQuery->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $chargesQuery->where(function ($q) use ($search) {
                $q->where('concept', 'like', "%{$search}%")
                  ->orWhere('charge_code', 'like', "%{$search}%");
            });
        }

        $charges = $chargesQuery->orderBy('id', 'desc')->paginate(
            $filters['per_page'] ?? 15,
            ['*'],
            'charges_page',
            $filters['charges_page'] ?? 1
        );

        $receiptsQuery = FinanceReceipt::where('student_user_id', $studentUserId);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $receiptsQuery->where(function ($q) use ($search) {
                $q->where('concept', 'like', "%{$search}%")
                  ->orWhere('folio', 'like', "%{$search}%");
            });
        }

        $receipts = $receiptsQuery->orderBy('id', 'desc')->paginate(
            $filters['per_page'] ?? 15,
            ['*'],
            'receipts_page',
            $filters['receipts_page'] ?? 1
        );

        return [
            'charges' => $charges,
            'receipts' => $receipts,
        ];
    }

    public function reportPayment(int $studentUserId, array $data, ?UploadedFile $file): FinancePayment
    {
        $charge = FinanceCharge::findOrFail($data['finance_charge_id']);

        $voucherPath = null;
        $originalName = null;

        if ($file) {
            $originalName = $file->getClientOriginalName();
            $voucherPath = $file->store('vouchers', 'public');
        }

        return DB::transaction(function () use ($charge, $studentUserId, $data, $voucherPath, $originalName) {
            $payment = FinancePayment::create([
                'finance_charge_id' => $charge->id,
                'user_id' => $studentUserId,
                'reported_by_user_id' => $studentUserId,
                'amount' => (float) $data['amount'],
                'payment_date' => $data['payment_date'] ?? now()->toDateString(),
                'reported_at' => now(),
                'status' => 'reportado',
                'payment_method' => $data['payment_method'] ?? 'transferencia',
                'reference' => $data['reference'] ?? null,
                'bank_name' => $data['bank_name'] ?? null,
                'voucher_path' => $voucherPath,
                'voucher_original_name' => $originalName,
            ]);

            $charge->update(['status' => 'en_revision']);

            FinanceStatusLog::create([
                'entity_type' => 'finance_payment',
                'entity_id' => $payment->id,
                'status_from' => null,
                'status_to' => 'reportado',
                'acted_by_user_id' => $studentUserId,
                'notes' => 'Comprobante de pago cargado por estudiante.',
                'acted_at' => now(),
            ]);

            return $payment;
        });
    }

    public function approvePayment(int $paymentId, int $adminUserId, ?string $notes = null): FinancePayment
    {
        return DB::transaction(function () use ($paymentId, $adminUserId, $notes) {
            $payment = FinancePayment::with(['charge.period', 'user'])->findOrFail($paymentId);
            $charge = $payment->charge;

            $payment->update([
                'status' => 'aprobado',
                'approved_by_user_id' => $adminUserId,
                'reviewed_at' => now(),
                'review_notes' => $notes,
            ]);

            $newAmountPaid = $charge->amount_paid + $payment->amount;
            $newBalance = max(0, $charge->amount_total - $newAmountPaid);
            $newStatus = ($newBalance <= 0) ? 'pagado' : 'en_revision';

            $charge->update([
                'amount_paid' => $newAmountPaid,
                'balance_due' => $newBalance,
                'status' => $newStatus,
                'updated_by_user_id' => $adminUserId,
            ]);

            // Generar Recibo Oficial de Pago
            $folio = 'REC-' . date('Ymd') . '-' . str_pad((string) $payment->id, 6, '0', STR_PAD_LEFT);
            $studentEmail = $payment->user ? $payment->user->email : null;

            $receipt = FinanceReceipt::create([
                'finance_payment_id' => $payment->id,
                'finance_charge_id' => $charge->id,
                'student_user_id' => $payment->user_id,
                'approved_by_user_id' => $adminUserId,
                'folio' => $folio,
                'period_label' => $charge->period ? $charge->period->name : 'Período Actual',
                'concept' => $charge->concept,
                'amount' => $payment->amount,
                'payment_date' => $payment->payment_date ? $payment->payment_date->toDateString() : now()->toDateString(),
                'payment_method' => $payment->payment_method,
                'reference' => $payment->reference,
                'sent_to_email' => $studentEmail,
                'generated_at' => now(),
                'sent_at' => now(),
            ]);

            FinanceStatusLog::create([
                'entity_type' => 'finance_payment',
                'entity_id' => $payment->id,
                'status_from' => 'reportado',
                'status_to' => 'aprobado',
                'acted_by_user_id' => $adminUserId,
                'notes' => $notes ?? 'Pago aprobado por administración.',
                'acted_at' => now(),
            ]);

            // Intentar envío de correo al alumno
            if ($studentEmail) {
                try {
                    Mail::to($studentEmail)->send(new PaymentReceiptMail($receipt));
                } catch (\Throwable $e) {
                    // Log fail silently so HTTP request succeeds
                }
            }

            return $payment;
        });
    }

    public function rejectPayment(int $paymentId, int $adminUserId, ?string $notes = null): FinancePayment
    {
        return DB::transaction(function () use ($paymentId, $adminUserId, $notes) {
            $payment = FinancePayment::with('charge')->findOrFail($paymentId);
            $charge = $payment->charge;

            $payment->update([
                'status' => 'rechazado',
                'approved_by_user_id' => $adminUserId,
                'reviewed_at' => now(),
                'review_notes' => $notes,
            ]);

            $charge->update([
                'status' => 'pendiente',
                'updated_by_user_id' => $adminUserId,
            ]);

            FinanceStatusLog::create([
                'entity_type' => 'finance_payment',
                'entity_id' => $payment->id,
                'status_from' => 'reportado',
                'status_to' => 'rechazado',
                'acted_by_user_id' => $adminUserId,
                'notes' => $notes ?? 'Comprobante rechazado por administración.',
                'acted_at' => now(),
            ]);

            return $payment;
        });
    }
}
