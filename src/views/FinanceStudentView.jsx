import { useEffect, useState } from 'react';
import { FinanceModel } from '../models/FinanceModel.js';

const financeModel = new FinanceModel();

export function FinanceStudentView() {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [successMsg, setSuccessMsg] = useState('');

  const [charges, setCharges] = useState([]);
  const [receipts, setReceipts] = useState([]);

  // Modales
  const [selectedCharge, setSelectedCharge] = useState(null);
  const [selectedReceipt, setSelectedReceipt] = useState(null);
  const [uploading, setUploading] = useState(false);

  // Formulario de Pago
  const [paymentData, setPaymentData] = useState({
    amount: '',
    payment_date: new Date().toISOString().split('T')[0],
    payment_method: 'transferencia',
    reference: '',
    bank_name: '',
  });
  const [file, setFile] = useState(null);

  useEffect(() => {
    loadData();
  }, []);

  async function loadData() {
    try {
      setLoading(true);
      setError('');
      const res = await financeModel.getStudentData();
      if (res?.status === 'success' && res.data) {
        setCharges(res.data.charges || []);
        setReceipts(res.data.receipts || []);
      }
    } catch (err) {
      setError(err.message || 'Error al cargar tu estado de cuenta');
    } finally {
      setLoading(false);
    }
  }

  function handleOpenUploadModal(charge) {
    setSelectedCharge(charge);
    setPaymentData({
      amount: charge.balance_due || charge.amount_total,
      payment_date: new Date().toISOString().split('T')[0],
      payment_method: 'transferencia',
      reference: '',
      bank_name: '',
    });
    setFile(null);
    setError('');
  }

  async function handleReportSubmit(e) {
    e.preventDefault();
    if (!selectedCharge || !file) {
      setError('Por favor adjunta el archivo comprobante (PDF o Imagen).');
      return;
    }

    try {
      setUploading(true);
      setError('');

      const formData = new FormData();
      formData.append('finance_charge_id', selectedCharge.id);
      formData.append('amount', paymentData.amount);
      formData.append('payment_date', paymentData.payment_date);
      formData.append('payment_method', paymentData.payment_method);
      formData.append('reference', paymentData.reference);
      formData.append('bank_name', paymentData.bank_name);
      formData.append('voucher', file);

      const res = await financeModel.reportPayment(formData);
      if (res?.status === 'success') {
        setSuccessMsg('¡Comprobante enviado exitosamente! Tu pago está en proceso de validación por administración.');
        setSelectedCharge(null);
        loadData();
      }
    } catch (err) {
      setError(err.message || 'Error al enviar el comprobante de pago');
    } finally {
      setUploading(false);
    }
  }

  function getStatusBadge(status) {
    switch (status) {
      case 'pagado':
        return <span className="badge badge-success">✓ PAGADO</span>;
      case 'en_revision':
        return <span className="badge badge-warning">⏳ EN REVISIÓN</span>;
      case 'rechazado':
        return <span className="badge badge-danger">✕ RECHAZADO</span>;
      default:
        return <span className="badge badge-secondary">PENDIENTE DE PAGO</span>;
    }
  }

  return (
    <div className="finance-container">
      <div className="finance-header">
        <div>
          <h2>Estado de Cuenta y Mis Pagos</h2>
          <p className="subtitle">Consulta de saldos mensuales, reporte de comprobantes y recibos de pago</p>
        </div>
      </div>

      {error ? <div className="alert alert-error">{error}</div> : null}
      {successMsg ? <div className="alert alert-success">{successMsg}</div> : null}

      {loading ? (
        <div className="loading-state">Cargando tus datos financieros...</div>
      ) : (
        <div className="student-finance-grid">
          {/* Columna Izquierda: Mis Cargos / Adeudos */}
          <div className="finance-section">
            <h3>Mis Conceptos de Cobro</h3>

            {charges.length === 0 ? (
              <div className="empty-state">No tienes cargos registrados en este momento.</div>
            ) : (
              charges.map((charge) => {
                const latestPayment = charge.payments?.[0];
                return (
                  <div key={charge.id} className="student-charge-card">
                    <div className="charge-card-header">
                      <div>
                        <h4>{charge.concept}</h4>
                        <span className="charge-code">Código: {charge.charge_code}</span>
                      </div>
                      {getStatusBadge(charge.status)}
                    </div>

                    <div className="charge-card-details">
                      <p><strong>Monto Total:</strong> ${Number(charge.amount_total).toFixed(2)} MXN</p>
                      <p><strong>Saldo Pendiente:</strong> ${Number(charge.balance_due).toFixed(2)} MXN</p>
                      <p><strong>Fecha Límite:</strong> {charge.due_at || 'Sin fecha'}</p>

                      {latestPayment?.review_notes && charge.status === 'pendiente' ? (
                        <div className="rejection-box">
                          <strong>Motivo de rechazo anterior:</strong> {latestPayment.review_notes}
                        </div>
                      ) : null}
                    </div>

                    <div className="charge-card-actions">
                      {charge.status === 'pendiente' ? (
                        <button
                          type="button"
                          className="btn btn-primary"
                          onClick={() => handleOpenUploadModal(charge)}
                        >
                          ⬆ Adjuntar Comprobante de Pago
                        </button>
                      ) : charge.status === 'en_revision' ? (
                        <span className="info-text">
                          Comprobante enviado el {latestPayment?.payment_date}. Esperando validación del administrador.
                        </span>
                      ) : (
                        <span className="success-text">Pago validado y completado.</span>
                      )}
                    </div>
                  </div>
                );
              })
            )}
          </div>

          {/* Columna Derecha: Recibos Oficiales Emitidos */}
          <div className="finance-section">
            <h3>Mis Recibos Oficiales</h3>

            {receipts.length === 0 ? (
              <div className="empty-state">Aún no cuentas con recibos oficiales emitidos.</div>
            ) : (
              receipts.map((receipt) => (
                <div key={receipt.id} className="receipt-card">
                  <div className="receipt-card-header">
                    <div>
                      <strong>Folio: {receipt.folio}</strong>
                      <div className="receipt-date">Emitido: {receipt.generated_at ? new Date(receipt.generated_at).toLocaleDateString() : 'Hoy'}</div>
                    </div>
                    <span className="receipt-amount">${Number(receipt.amount).toFixed(2)} MXN</span>
                  </div>

                  <p className="receipt-concept">{receipt.concept} ({receipt.period_label})</p>

                  <button
                    type="button"
                    className="btn btn-sm btn-outline"
                    onClick={() => setSelectedReceipt(receipt)}
                  >
                    🔍 Ver Recibo de Pago
                  </button>
                </div>
              ))
            )}
          </div>
        </div>
      )}

      {/* Modal: Adjuntar Comprobante de Pago */}
      {selectedCharge ? (
        <div className="modal-backdrop">
          <div className="modal-content">
            <h3>Adjuntar Comprobante de Pago</h3>
            <p className="modal-sub">
              Concepto: <strong>{selectedCharge.concept}</strong> | Saldo: <strong>${Number(selectedCharge.balance_due).toFixed(2)} MXN</strong>
            </p>

            <form onSubmit={handleReportSubmit}>
              <div className="form-row">
                <div className="form-group">
                  <label>Monto a Reportar ($) *</label>
                  <input
                    type="number"
                    step="0.01"
                    value={paymentData.amount}
                    onChange={(e) => setPaymentData({ ...paymentData, amount: e.target.value })}
                    required
                  />
                </div>

                <div className="form-group">
                  <label>Fecha de Pago *</label>
                  <input
                    type="date"
                    value={paymentData.payment_date}
                    onChange={(e) => setPaymentData({ ...paymentData, payment_date: e.target.value })}
                    required
                  />
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>Método de Pago *</label>
                  <select
                    value={paymentData.payment_method}
                    onChange={(e) => setPaymentData({ ...paymentData, payment_method: e.target.value })}
                  >
                    <option value="transferencia">Transferencia Electrónica (SPEI)</option>
                    <option value="deposito">Depósito en Ventanilla / OXXO</option>
                    <option value="tarjeta">Tarjeta de Crédito / Débito</option>
                  </select>
                </div>

                <div className="form-group">
                  <label>Banco Emisor / Receptor</label>
                  <input
                    type="text"
                    placeholder="Ej. BBVA, Banamex, Santander"
                    value={paymentData.bank_name}
                    onChange={(e) => setPaymentData({ ...paymentData, bank_name: e.target.value })}
                  />
                </div>
              </div>

              <div className="form-group">
                <label>Número de Referencia Bancaria</label>
                <input
                  type="text"
                  placeholder="Ej. 123456789"
                  value={paymentData.reference}
                  onChange={(e) => setPaymentData({ ...paymentData, reference: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label>Archivo Comprobante (PDF o Imagen) *</label>
                <input
                  type="file"
                  accept="image/jpeg,image/png,application/pdf"
                  onChange={(e) => setFile(e.target.files[0])}
                  required
                />
              </div>

              <div className="modal-actions">
                <button
                  type="button"
                  className="btn btn-secondary"
                  onClick={() => setSelectedCharge(null)}
                  disabled={uploading}
                >
                  Cancelar
                </button>
                <button type="submit" className="btn btn-primary" disabled={uploading}>
                  {uploading ? 'Enviando Comprobante...' : 'Enviar Comprobante'}
                </button>
              </div>
            </form>
          </div>
        </div>
      ) : null}

      {/* Modal: Visualizador de Recibo Oficial */}
      {selectedReceipt ? (
        <div className="modal-backdrop">
          <div className="modal-content receipt-modal-content">
            <div className="receipt-print-area">
              <div className="receipt-modal-header">
                <h2>UNIVERSIDAD JOSÉ MARTÍ DE LATINOAMÉRICA</h2>
                <h3>RECIBO OFICIAL DE PAGO</h3>
                <span className="receipt-folio">FOLIO: {selectedReceipt.folio}</span>
              </div>

              <table className="receipt-modal-table">
                <tbody>
                  <tr>
                    <td><strong>Período:</strong> {selectedReceipt.period_label}</td>
                    <td><strong>Fecha Emisión:</strong> {selectedReceipt.generated_at ? new Date(selectedReceipt.generated_at).toLocaleDateString() : 'N/A'}</td>
                  </tr>
                  <tr>
                    <td><strong>Concepto:</strong> {selectedReceipt.concept}</td>
                    <td><strong>Monto Pagado:</strong> <span style={{ color: '#198754', fontWeight: 'bold' }}>${Number(selectedReceipt.amount).toFixed(2)} MXN</span></td>
                  </tr>
                  <tr>
                    <td><strong>Método:</strong> {selectedReceipt.payment_method?.toUpperCase()}</td>
                    <td><strong>Referencia:</strong> {selectedReceipt.reference || 'Sin ref'}</td>
                  </tr>
                </tbody>
              </table>

              <div className="receipt-modal-footer">
                <p>Estatus: <strong style={{ color: '#198754' }}>VALIDADO Y PAGADO</strong></p>
                <p className="small">Este recibo ha sido enviado al correo electrónico institucional del estudiante.</p>
              </div>
            </div>

            <div className="modal-actions" style={{ marginTop: '20px' }}>
              <button
                type="button"
                className="btn btn-secondary"
                onClick={() => setSelectedReceipt(null)}
              >
                Cerrar
              </button>
              <button
                type="button"
                className="btn btn-primary"
                onClick={() => window.print()}
              >
                🖨 Imprimir Recibo
              </button>
            </div>
          </div>
        </div>
      ) : null}
    </div>
  );
}
