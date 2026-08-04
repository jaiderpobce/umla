<?php

namespace App\Mail;

use App\Models\FinanceReceipt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public FinanceReceipt $receipt;

    public function __construct(FinanceReceipt $receipt)
    {
        $this->receipt = $receipt;
    }

    public function build()
    {
        return $this->subject('Recibo de Pago Confirmado - UMLA (Folio: ' . $this->receipt->folio . ')')
                    ->html($this->buildHtmlContent());
    }

    protected function buildHtmlContent(): string
    {
        return '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e0e0e0; border-radius: 12px; background-color: #ffffff;">
            <h2 style="color: #0d6efd; margin-top: 0;">¡Pago Confirmado Exitosamente!</h2>
            <p>Estimado(a) estudiante,</p>
            <p>Hemos recibido y validado tu comprobante de pago. A continuación te presentamos el resumen de tu recibo oficial:</p>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background-color: #f8f9fa;">
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Folio:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($this->receipt->folio) . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Concepto:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($this->receipt->concept) . '</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Período:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($this->receipt->period_label) . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Monto Pagado:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; color: #198754; font-size: 1.1em; font-weight: bold;">$' . number_format($this->receipt->amount, 2) . ' MXN</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Método de Pago:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars(ucfirst($this->receipt->payment_method ?? 'N/A')) . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Referencia Bancaria:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($this->receipt->reference ?? 'Sin referencia') . '</td>
                </tr>
            </table>

            <p style="color: #6c757d; font-size: 0.9em; margin-top: 30px;">
                Este correo sirve como comprobante de pago emitido por la Universidad José Martí de Latinoamérica. Puedes consultar tu histórico de recibos en tu portal de estudiante.
            </p>
        </div>
        ';
    }
}
