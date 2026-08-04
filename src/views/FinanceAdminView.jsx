import { useEffect, useState } from 'react';
import { FinanceModel } from '../models/FinanceModel.js';

const financeModel = new FinanceModel();

export function FinanceAdminView() {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [successMsg, setSuccessMsg] = useState('');

  const [charges, setCharges] = useState([]);
  const [pendingPayments, setPendingPayments] = useState([]);
  const [careers, setCareers] = useState([]);
  const [periods, setPeriods] = useState([]);

  const [activeTab, setActiveTab] = useState('pending'); // 'pending' | 'charges'
  const [search, setSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('');
  const [careerFilter, setCareerFilter] = useState('');

  // Pagination
  const [chargesPage, setChargesPage] = useState(1);
  const [pendingPage, setPendingPage] = useState(1);
  const [chargesMeta, setChargesMeta] = useState({});
  const [pendingMeta, setPendingMeta] = useState({});

  // Modales
  const [showGenerateModal, setShowGenerateModal] = useState(false);
  const [selectedPayment, setSelectedPayment] = useState(null);
  const [actionType, setActionType] = useState(''); // 'approve' | 'reject'
  const [actionNotes, setActionNotes] = useState('');
  const [processingAction, setProcessingAction] = useState(false);

  // Visor de documentos
  const [viewerUrl, setViewerUrl] = useState('');
  const [showViewerModal, setShowViewerModal] = useState(false);

  // Formulario Emisión de Causado
  const [formData, setFormData] = useState({
    career: '',
    concept: '',
    amount: '',
    due_date: '',
    description: '',
    finance_period_id: '',
  });
  const [generating, setGenerating] = useState(false);

  useEffect(() => {
    loadData();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [statusFilter, careerFilter, chargesPage, pendingPage]);

  async function loadData() {
    try {
      setLoading(true);
      setError('');
      const res = await financeModel.getAdminData({
        search,
        status: statusFilter,
        career: careerFilter,
        charges_page: chargesPage,
        pending_page: pendingPage,
        per_page: 15
      });

      if (res?.status === 'success' && res.data) {
        setCharges(res.data.charges?.data || []);
        setChargesMeta({
          current_page: res.data.charges?.current_page || 1,
          last_page: res.data.charges?.last_page || 1,
          total: res.data.charges?.total || 0,
        });

        setPendingPayments(res.data.pending_payments?.data || []);
        setPendingMeta({
          current_page: res.data.pending_payments?.current_page || 1,
          last_page: res.data.pending_payments?.last_page || 1,
          total: res.data.pending_payments?.total || 0,
        });

        setCareers(res.data.careers || []);
        setPeriods(res.data.periods || []);
        if (res.data.careers?.length > 0 && !formData.career) {
          setFormData((prev) => ({ ...prev, career: res.data.careers[0] }));
        }
      }
    } catch (err) {
      setError(err.message || 'Error al cargar los datos de finanzas');
    } finally {
      setLoading(false);
    }
  }

  async function handleGenerateSubmit(e) {
    e.preventDefault();
    if (!formData.career || !formData.concept || !formData.amount || !formData.due_date) {
      setError('Por favor completa todos los campos requeridos.');
      return;
    }

    try {
      setGenerating(true);
      setError('');
      const res = await financeModel.generateChargesByCareer(formData);
      if (res?.status === 'success') {
        setSuccessMsg(res.message || 'Causado emitido correctamente.');
        setShowGenerateModal(false);
        setFormData({
          career: careers[0] || '',
          concept: '',
          amount: '',
          due_date: '',
          description: '',
          finance_period_id: '',
        });
        loadData();
      }
    } catch (err) {
      setError(err.message || 'Error al emitir el causado por carrera');
    } finally {
      setGenerating(false);
    }
  }

  async function handleConfirmAction() {
    if (!selectedPayment || !actionType) return;
    try {
      setProcessingAction(true);
      setError('');

      let res;
      if (actionType === 'approve') {
        res = await financeModel.approvePayment(selectedPayment.id, actionNotes);
      } else {
        res = await financeModel.rejectPayment(selectedPayment.id, actionNotes);
      }

      if (res?.status === 'success') {
        setSuccessMsg(res.message);
        setSelectedPayment(null);
        setActionNotes('');
        setActionType('');
        loadData();
      }
    } catch (err) {
      setError(err.message || 'Error al procesar la acción sobre el pago');
    } finally {
      setProcessingAction(false);
    }
  }

  function getStatusBadge(status) {
    switch (status) {
      case 'pagado':
      case 'aprobado':
        return <span className="badge badge-success">Pagado</span>;
      case 'en_revision':
      case 'reportado':
        return <span className="badge badge-warning">En Revisión</span>;
      case 'rechazado':
        return <span className="badge badge-danger">Rechazado</span>;
      default:
        return <span className="badge badge-secondary">Pendiente</span>;
    }
  }

  function openDocumentViewer(path) {
    setViewerUrl(`/umla-api/storage/${path}`);
    setShowViewerModal(true);
  }

  function renderPagination(meta, setPage) {
    if (!meta || meta.last_page <= 1) return null;
    return (
      <div className="pagination-controls" style={{ marginTop: '16px', display: 'flex', gap: '8px', justifyContent: 'flex-end', alignItems: 'center' }}>
        <button 
          className="btn btn-sm btn-secondary" 
          disabled={meta.current_page === 1}
          onClick={() => setPage(meta.current_page - 1)}
        >
          &laquo; Anterior
        </button>
        <span style={{ fontSize: '0.9rem' }}>
          Página <strong>{meta.current_page}</strong> de {meta.last_page} (Total: {meta.total})
        </span>
        <button 
          className="btn btn-sm btn-secondary" 
          disabled={meta.current_page === meta.last_page}
          onClick={() => setPage(meta.current_page + 1)}
        >
          Siguiente &raquo;
        </button>
      </div>
    );
  }

  return (
    <div className="finance-container">
      <div className="finance-header">
        <div>
          <h2>Gestión de Cobranza y Finanzas</h2>
          <p className="subtitle">Emisión de causados por carrera y validación de comprobantes de pago</p>
        </div>
        <button
          type="button"
          className="btn btn-primary"
          onClick={() => setShowGenerateModal(true)}
        >
          + Emitir Causado por Carrera
        </button>
      </div>

      {error ? <div className="alert alert-error">{error}</div> : null}
      {successMsg ? <div className="alert alert-success">{successMsg}</div> : null}

      {/* Filters (Global for both tabs) */}
      <div className="table-filters" style={{ marginBottom: '16px', padding: '16px', background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' }}>
        <input
          type="text"
          placeholder="Buscar por alumno, folio o referencia..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          onKeyDown={(e) => e.key === 'Enter' && loadData()}
          className="search-input"
          style={{ minWidth: '250px' }}
        />
        <select
          value={careerFilter}
          onChange={(e) => setCareerFilter(e.target.value)}
          className="select-input"
          style={{ minWidth: '220px' }}
        >
          <option value="">Todas las Carreras</option>
          {careers.map((c, i) => (
            <option key={i} value={c}>{c}</option>
          ))}
        </select>
        {activeTab === 'charges' && (
          <select
            value={statusFilter}
            onChange={(e) => setStatusFilter(e.target.value)}
            className="select-input"
          >
            <option value="">Todos los estatus</option>
            <option value="pendiente">Pendientes</option>
            <option value="en_revision">En Revisión</option>
            <option value="pagado">Pagados</option>
          </select>
        )}
        <button className="btn btn-primary" onClick={loadData}>Buscar</button>
      </div>

      {/* Tabs */}
      <div className="finance-tabs">
        <button
          type="button"
          className={`tab-item ${activeTab === 'pending' ? 'active' : ''}`}
          onClick={() => setActiveTab('pending')}
        >
          Pagos por Validar ({pendingMeta.total || 0})
        </button>
        <button
          type="button"
          className={`tab-item ${activeTab === 'charges' ? 'active' : ''}`}
          onClick={() => setActiveTab('charges')}
        >
          Cobranza Global ({chargesMeta.total || 0})
        </button>
      </div>

      {loading ? (
        <div className="loading-state">Cargando información de cobranza...</div>
      ) : activeTab === 'pending' ? (
        <div className="charges-table-container">
          <table className="custom-table">
            <thead>
              <tr>
                <th>Estudiante</th>
                <th>Concepto / Monto</th>
                <th>Fecha Pago</th>
                <th>Método / Banco</th>
                <th>Referencia</th>
                <th>Comprobante</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {pendingPayments.length === 0 ? (
                <tr>
                  <td colSpan="7" style={{ textAlign: 'center', padding: '24px' }}>
                    No hay comprobantes pendientes de revisión en este momento.
                  </td>
                </tr>
              ) : (
                pendingPayments.map((payment) => (
                  <tr key={payment.id}>
                    <td>
                      <strong>{payment.user?.name || 'Estudiante'}</strong>
                      <div className="user-email" style={{ fontSize: '0.85em', color: '#666' }}>{payment.user?.email}</div>
                    </td>
                    <td>
                      <div>{payment.charge?.concept || 'Mensualidad'}</div>
                      <strong style={{ color: '#198754' }}>${Number(payment.amount).toFixed(2)} MXN</strong>
                    </td>
                    <td>{payment.payment_date || 'N/A'}</td>
                    <td>
                      <div>{payment.payment_method?.toUpperCase() || 'N/A'}</div>
                      <div style={{ fontSize: '0.85em', color: '#666' }}>{payment.bank_name || '-'}</div>
                    </td>
                    <td><code>{payment.reference || 'Sin ref'}</code></td>
                    <td>
                      {payment.voucher_path ? (
                        <button
                          type="button"
                          className="btn btn-sm btn-outline"
                          onClick={() => openDocumentViewer(payment.voucher_path)}
                        >
                          👁️ Ver Archivo
                        </button>
                      ) : (
                        <span style={{ color: '#dc3545', fontSize: '0.85em' }}>Sin Adjunto</span>
                      )}
                    </td>
                    <td>
                      <div style={{ display: 'flex', gap: '4px', flexWrap: 'wrap' }}>
                        <button
                          type="button"
                          className="btn btn-sm btn-success"
                          onClick={() => {
                            setSelectedPayment(payment);
                            setActionType('approve');
                          }}
                        >
                          ✓ Aprobar
                        </button>
                        <button
                          type="button"
                          className="btn btn-sm btn-danger"
                          onClick={() => {
                            setSelectedPayment(payment);
                            setActionType('reject');
                          }}
                        >
                          ✕ Rechazar
                        </button>
                      </div>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
          {renderPagination(pendingMeta, setPendingPage)}
        </div>
      ) : (
        <div className="charges-table-container">
          <table className="custom-table">
            <thead>
              <tr>
                <th>Código</th>
                <th>Estudiante</th>
                <th>Concepto</th>
                <th>Monto Total</th>
                <th>Pagado</th>
                <th>Saldo</th>
                <th>Vencimiento</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              {charges.length === 0 ? (
                <tr>
                  <td colSpan="8" style={{ textAlign: 'center', padding: '24px' }}>
                    No se encontraron registros de cobro.
                  </td>
                </tr>
              ) : (
                charges.map((charge) => (
                  <tr key={charge.id}>
                    <td><code>{charge.charge_code}</code></td>
                    <td>
                      <strong>{charge.user?.name || 'Alumno'}</strong>
                      <div className="user-email">{charge.user?.email}</div>
                    </td>
                    <td>{charge.concept}</td>
                    <td>${Number(charge.amount_total).toFixed(2)}</td>
                    <td style={{ color: '#198754', fontWeight: 'bold' }}>
                      ${Number(charge.amount_paid).toFixed(2)}
                    </td>
                    <td style={{ color: charge.balance_due > 0 ? '#dc3545' : '#6c757d' }}>
                      ${Number(charge.balance_due).toFixed(2)}
                    </td>
                    <td>{charge.due_at || 'S/V'}</td>
                    <td>{getStatusBadge(charge.status)}</td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
          {renderPagination(chargesMeta, setChargesPage)}
        </div>
      )}

      {/* Modal: Visor de Documentos (Comprobantes) */}
      {showViewerModal && viewerUrl && (
        <div className="modal-backdrop" style={{ zIndex: 9999 }}>
          <div className="modal-content" style={{ maxWidth: '800px', width: '90%' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '16px' }}>
              <h3>Visor de Comprobante</h3>
              <button 
                className="btn btn-sm btn-secondary" 
                onClick={() => setShowViewerModal(false)}
              >
                ✕ Cerrar
              </button>
            </div>
            <div style={{ width: '100%', height: '600px', backgroundColor: '#f0f2f5', display: 'flex', justifyContent: 'center', alignItems: 'center', borderRadius: '4px', overflow: 'hidden' }}>
              {viewerUrl.toLowerCase().endsWith('.pdf') ? (
                <iframe 
                  src={viewerUrl} 
                  width="100%" 
                  height="100%" 
                  style={{ border: 'none' }}
                  title="Visor PDF"
                />
              ) : (
                <img 
                  src={viewerUrl} 
                  alt="Comprobante de Pago" 
                  style={{ maxWidth: '100%', maxHeight: '100%', objectFit: 'contain' }} 
                />
              )}
            </div>
            <div className="modal-actions" style={{ marginTop: '16px' }}>
              <a href={viewerUrl} target="_blank" rel="noreferrer" className="btn btn-primary">
                Abrir en nueva pestaña
              </a>
            </div>
          </div>
        </div>
      )}

      {/* Modal: Emitir Causado por Carrera */}
      {showGenerateModal ? (
        <div className="modal-backdrop">
          <div className="modal-content">
            <h3>Emitir Causado por Carrera</h3>
            <p className="modal-sub">Se creará un cobro pendiente a cada alumno registrado en la carrera seleccionada.</p>

            <form onSubmit={handleGenerateSubmit}>
              <div className="form-group">
                <label>Carrera u Oferta Educativa *</label>
                <select
                  value={formData.career}
                  onChange={(e) => setFormData({ ...formData, career: e.target.value })}
                  required
                >
                  <option value="">-- Seleccionar Carrera --</option>
                  {careers.map((c, i) => (
                    <option key={i} value={c}>{c}</option>
                  ))}
                  {careers.length === 0 ? (
                    <option value="LICENCIATURA EN ADMINISTRACION">LICENCIATURA EN ADMINISTRACION</option>
                  ) : null}
                </select>
              </div>

              <div className="form-group">
                <label>Concepto del Cobro *</label>
                <input
                  type="text"
                  placeholder="Ej. Mensualidad Agosto 2026"
                  value={formData.concept}
                  onChange={(e) => setFormData({ ...formData, concept: e.target.value })}
                  required
                />
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label>Monto ($ MXN) *</label>
                  <input
                    type="number"
                    step="0.01"
                    placeholder="1850.00"
                    value={formData.amount}
                    onChange={(e) => setFormData({ ...formData, amount: e.target.value })}
                    required
                  />
                </div>

                <div className="form-group">
                  <label>Fecha Límite de Pago *</label>
                  <input
                    type="date"
                    value={formData.due_date}
                    onChange={(e) => setFormData({ ...formData, due_date: e.target.value })}
                    required
                  />
                </div>
              </div>

              <div className="form-group">
                <label>Descripción / Observaciones</label>
                <textarea
                  rows="2"
                  placeholder="Indicaciones para el estudiante..."
                  value={formData.description}
                  onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                />
              </div>

              <div className="modal-actions">
                <button
                  type="button"
                  className="btn btn-secondary"
                  onClick={() => setShowGenerateModal(false)}
                  disabled={generating}
                >
                  Cancelar
                </button>
                <button type="submit" className="btn btn-primary" disabled={generating}>
                  {generating ? 'Generando Causado...' : 'Generar Cobro Masivo'}
                </button>
              </div>
            </form>
          </div>
        </div>
      ) : null}

      {/* Modal: Aprobar / Rechazar Pago */}
      {selectedPayment ? (
        <div className="modal-backdrop" style={{ zIndex: 10000 }}>
          <div className="modal-content">
            <h3>{actionType === 'approve' ? 'Aprobar Pago de Estudiante' : 'Rechazar Pago de Estudiante'}</h3>
            <p className="modal-sub">
              Estudiante: <strong>{selectedPayment.user?.name}</strong> | Monto: <strong>${Number(selectedPayment.amount).toFixed(2)} MXN</strong>
            </p>

            {actionType === 'approve' ? (
              <p style={{ color: '#198754', fontSize: '0.9rem' }}>
                ✓ Al aprobar, el estatus cambiará a <strong>PAGADO</strong>, se generará el Folio oficial de recibo y se enviará por correo electrónico al estudiante.
              </p>
            ) : (
              <p style={{ color: '#dc3545', fontSize: '0.9rem' }}>
                ✕ Al rechazar, el cobro volverá a estatus <strong>PENDIENTE</strong> para que el estudiante cargue un nuevo comprobante corregido.
              </p>
            )}

            <div className="form-group" style={{ marginTop: '16px' }}>
              <label>Notas u Observaciones {actionType === 'reject' ? '*' : '(Opcional)'}</label>
              <textarea
                rows="3"
                placeholder={actionType === 'reject' ? 'Motivo del rechazo (ej. Referencia ilegible)...' : 'Notas internas...'}
                value={actionNotes}
                onChange={(e) => setActionNotes(e.target.value)}
                required={actionType === 'reject'}
              />
            </div>

            <div className="modal-actions">
              <button
                type="button"
                className="btn btn-secondary"
                onClick={() => setSelectedPayment(null)}
                disabled={processingAction}
              >
                Cancelar
              </button>
              <button
                type="button"
                className={`btn ${actionType === 'approve' ? 'btn-success' : 'btn-danger'}`}
                onClick={handleConfirmAction}
                disabled={processingAction}
              >
                {processingAction ? 'Procesando...' : actionType === 'approve' ? 'Confirmar y Enviar Recibo' : 'Confirmar Rechazo'}
              </button>
            </div>
          </div>
        </div>
      ) : null}
    </div>
  );
}
