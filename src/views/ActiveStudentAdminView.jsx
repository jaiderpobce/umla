import { useEffect, useState } from 'react';
import { ActiveStudentModel } from '../models/ActiveStudentModel.js';

const activeStudentModel = new ActiveStudentModel();

export function ActiveStudentAdminView() {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [successMsg, setSuccessMsg] = useState('');

  // Datasets
  const [students, setStudents] = useState([]);
  const [programs, setPrograms] = useState([]);
  const [periods, setPeriods] = useState([]);

  // Filters & Tabs
  const [activeTab, setActiveTab] = useState('students'); // 'students' | 'programs' | 'periods'
  const [search, setSearch] = useState('');
  const [programFilter, setProgramFilter] = useState('');
  const [periodFilter, setPeriodFilter] = useState('');
  const [statusFilter, setStatusFilter] = useState('');
  const [page, setPage] = useState(1);
  const [paginationMeta, setPaginationMeta] = useState({});

  // Modales
  const [showImportModal, setShowImportModal] = useState(false);
  const [csvFile, setCsvFile] = useState(null);
  const [previewing, setPreviewing] = useState(false);
  const [confirming, setConfirming] = useState(false);
  const [previewData, setPreviewData] = useState(null);

  useEffect(() => {
    loadData();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [programFilter, periodFilter, statusFilter, page]);

  async function loadData() {
    try {
      setLoading(true);
      setError('');
      const res = await activeStudentModel.getStudents({
        search,
        program_id: programFilter,
        period_id: periodFilter,
        status: statusFilter,
        page,
        per_page: 15,
      });

      if (res?.status === 'success' && res.data) {
        setStudents(res.data.students?.data || []);
        setPaginationMeta({
          current_page: res.data.students?.current_page || 1,
          last_page: res.data.students?.last_page || 1,
          total: res.data.students?.total || 0,
        });
        setPrograms(res.data.programs || []);
        setPeriods(res.data.periods || []);
      }
    } catch (err) {
      setError(err.message || 'Error al cargar el listado de alumnos activos');
    } finally {
      setLoading(false);
    }
  }

  async function handlePreviewSubmit(e) {
    e.preventDefault();
    if (!csvFile) {
      setError('Por favor selecciona un archivo CSV.');
      return;
    }

    try {
      setPreviewing(true);
      setError('');
      const res = await activeStudentModel.previewCsv(csvFile);
      if (res?.status === 'success') {
        setPreviewData(res);
      }
    } catch (err) {
      setError(err.message || 'Error al previsualizar el archivo CSV');
    } finally {
      setPreviewing(false);
    }
  }

  async function handleConfirmImport() {
    if (!previewData?.token) return;

    try {
      setConfirming(true);
      setError('');
      const res = await activeStudentModel.confirmImport(previewData.token);
      if (res?.status === 'success') {
        setSuccessMsg(res.message);
        setShowImportModal(false);
        setCsvFile(null);
        setPreviewData(null);
        loadData();
      }
    } catch (err) {
      setError(err.message || 'Error al procesar la importación masiva');
    } finally {
      setConfirming(false);
    }
  }

  function handleDownloadInvalidReport() {
    if (!previewData?.token) return;
    window.open(`/umla-api/api/alumnos-activos/invalid-csv/${previewData.token}`, '_blank');
  }

  function getStatusBadge(status) {
    switch (status) {
      case 'activo':
      case 'cursando':
      case 'inscrito':
        return <span className="badge badge-success">Activo</span>;
      case 'inactivo':
        return <span className="badge badge-secondary">Inactivo</span>;
      case 'baja':
        return <span className="badge badge-danger">Baja</span>;
      case 'egresado':
      case 'concluido':
        return <span className="badge badge-primary">Egresado</span>;
      default:
        return <span className="badge badge-secondary">{status}</span>;
    }
  }

  function renderPagination() {
    if (!paginationMeta || paginationMeta.last_page <= 1) return null;
    return (
      <div className="pagination-controls" style={{ marginTop: '16px', display: 'flex', gap: '8px', justifyContent: 'flex-end', alignItems: 'center' }}>
        <button
          className="btn btn-sm btn-secondary"
          disabled={paginationMeta.current_page === 1}
          onClick={() => setPage(paginationMeta.current_page - 1)}
        >
          &laquo; Anterior
        </button>
        <span style={{ fontSize: '0.9rem' }}>
          Página <strong>{paginationMeta.current_page}</strong> de {paginationMeta.last_page} (Total: {paginationMeta.total})
        </span>
        <button
          className="btn btn-sm btn-secondary"
          disabled={paginationMeta.current_page === paginationMeta.last_page}
          onClick={() => setPage(paginationMeta.current_page + 1)}
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
          <h2>Gestión de Alumnos Activos y Expedientes</h2>
          <p className="subtitle">Catálogo de programas, períodos aperturados y carga masiva por CURP</p>
        </div>
        <button
          type="button"
          className="btn btn-primary"
          onClick={() => {
            setShowImportModal(true);
            setPreviewData(null);
            setCsvFile(null);
            setError('');
          }}
        >
          ⬆ Cargar Alumnos Activos (CSV)
        </button>
      </div>

      {error ? <div className="alert alert-error">{error}</div> : null}
      {successMsg ? <div className="alert alert-success">{successMsg}</div> : null}

      {/* Filters */}
      <div className="table-filters" style={{ marginBottom: '16px', padding: '16px', background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.1)', display: 'flex', gap: '12px', flexWrap: 'wrap' }}>
        <input
          type="text"
          placeholder="Buscar por CURP, nombre, matrícula o correo..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          onKeyDown={(e) => e.key === 'Enter' && loadData()}
          className="search-input"
          style={{ minWidth: '280px', flex: 1 }}
        />

        <select
          value={programFilter}
          onChange={(e) => setProgramFilter(e.target.value)}
          className="select-input"
          style={{ minWidth: '200px' }}
        >
          <option value="">Todos los Programas</option>
          {programs.map((p) => (
            <option key={p.id} value={p.id}>
              {p.codigo} - {p.nombre}
            </option>
          ))}
        </select>

        <select
          value={periodFilter}
          onChange={(e) => setPeriodFilter(e.target.value)}
          className="select-input"
          style={{ minWidth: '200px' }}
        >
          <option value="">Todos los Períodos</option>
          {periods.map((per) => (
            <option key={per.id} value={per.id}>
              {per.nombre}
            </option>
          ))}
        </select>

        <select
          value={statusFilter}
          onChange={(e) => setStatusFilter(e.target.value)}
          className="select-input"
        >
          <option value="">Todos los estatus</option>
          <option value="activo">Activo</option>
          <option value="inactivo">Inactivo</option>
          <option value="baja">Baja</option>
          <option value="egresado">Egresado</option>
        </select>

        <button className="btn btn-primary" onClick={loadData}>Buscar</button>
      </div>

      {/* Tabs */}
      <div className="finance-tabs">
        <button
          type="button"
          className={`tab-item ${activeTab === 'students' ? 'active' : ''}`}
          onClick={() => setActiveTab('students')}
        >
          Alumnos Activos ({paginationMeta.total || 0})
        </button>
        <button
          type="button"
          className={`tab-item ${activeTab === 'programs' ? 'active' : ''}`}
          onClick={() => setActiveTab('programs')}
        >
          Programas Académicos ({programs.length})
        </button>
        <button
          type="button"
          className={`tab-item ${activeTab === 'periods' ? 'active' : ''}`}
          onClick={() => setActiveTab('periods')}
        >
          Períodos Aperturados ({periods.length})
        </button>
      </div>

      {loading ? (
        <div className="loading-state">Cargando información de alumnos activos...</div>
      ) : activeTab === 'students' ? (
        <div className="charges-table-container">
          <table className="custom-table">
            <thead>
              <tr>
                <th>CURP</th>
                <th>Matrícula</th>
                <th>Alumno</th>
                <th>Programa / Oferta</th>
                <th>Período(s) Inscrito(s)</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              {students.length === 0 ? (
                <tr>
                  <td colSpan="6" style={{ textAlign: 'center', padding: '24px' }}>
                    No se encontraron registros de alumnos activos.
                  </td>
                </tr>
              ) : (
                students.map((student) => (
                  <tr key={student.id}>
                    <td><code>{student.curp}</code></td>
                    <td><strong>{student.matricula || '-'}</strong></td>
                    <td>
                      <strong>{student.nombre_completo}</strong>
                      <div className="user-email" style={{ fontSize: '0.85em', color: '#666' }}>
                        {student.email || 'Sin correo registrado'}
                      </div>
                    </td>
                    <td>
                      <div><strong>{student.program?.codigo}</strong> - {student.program?.nombre}</div>
                      <div style={{ fontSize: '0.85em', color: '#888' }}>{student.program?.nivel}</div>
                    </td>
                    <td>
                      {student.periods && student.periods.length > 0 ? (
                        student.periods.map((p, idx) => (
                          <span key={idx} className="badge badge-info" style={{ marginRight: '4px', marginBottom: '4px', display: 'inline-block' }}>
                            {p.nombre}
                          </span>
                        ))
                      ) : (
                        <span style={{ fontSize: '0.85em', color: '#888' }}>Sin período asignado</span>
                      )}
                    </td>
                    <td>{getStatusBadge(student.status)}</td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
          {renderPagination()}
        </div>
      ) : activeTab === 'programs' ? (
        <div className="charges-table-container">
          <table className="custom-table">
            <thead>
              <tr>
                <th>Código</th>
                <th>Nombre del Programa</th>
                <th>Nivel Académico</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              {programs.length === 0 ? (
                <tr>
                  <td colSpan="4" style={{ textAlign: 'center', padding: '24px' }}>
                    No hay programas académicos registrados.
                  </td>
                </tr>
              ) : (
                programs.map((program) => (
                  <tr key={program.id}>
                    <td><code>{program.codigo}</code></td>
                    <td><strong>{program.nombre}</strong></td>
                    <td>{program.nivel || 'N/A'}</td>
                    <td>
                      {program.is_active ? (
                        <span className="badge badge-success">Activo</span>
                      ) : (
                        <span className="badge badge-secondary">Inactivo</span>
                      )}
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      ) : (
        <div className="charges-table-container">
          <table className="custom-table">
            <thead>
              <tr>
                <th>Nombre del Período</th>
                <th>Slug</th>
                <th>Fecha Inicio (fecha_ini)</th>
                <th>Fecha Fin (fecha_fin)</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              {periods.length === 0 ? (
                <tr>
                  <td colSpan="5" style={{ textAlign: 'center', padding: '24px' }}>
                    No hay períodos aperturados registrados.
                  </td>
                </tr>
              ) : (
                periods.map((period) => (
                  <tr key={period.id}>
                    <td><strong>{period.nombre}</strong></td>
                    <td><code>{period.slug}</code></td>
                    <td>{period.fecha_ini || 'Sin fecha'}</td>
                    <td>{period.fecha_fin || 'Sin fecha'}</td>
                    <td>
                      {period.is_active ? (
                        <span className="badge badge-success">Activo</span>
                      ) : (
                        <span className="badge badge-secondary">Inactivo</span>
                      )}
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      )}

      {/* Modal: Carga e Importación Masiva por CSV */}
      {showImportModal ? (
        <div className="modal-backdrop">
          <div className="modal-content" style={{ maxWidth: '750px', width: '90%' }}>
            <h3>Carga Masiva de Alumnos Activos (CSV)</h3>
            <p className="modal-sub">
              El sistema utilizará la <strong>CURP</strong> para identificar a cada estudiante. Los alumnos existentes se actualizarán y los nuevos se registrarán automáticamente.
            </p>

            {!previewData ? (
              <form onSubmit={handlePreviewSubmit}>
                <div className="form-group" style={{ margin: '20px 0' }}>
                  <label style={{ fontWeight: 'bold', marginBottom: '8px', display: 'block' }}>
                    Seleccionar Archivo CSV *
                  </label>
                  <input
                    type="file"
                    accept=".csv,.txt,.xlsx"
                    onChange={(e) => setCsvFile(e.target.files[0])}
                    required
                  />
                  <small style={{ color: '#666', display: 'block', marginTop: '6px' }}>
                    El archivo debe incluir encabezados: <code>Coorreo institucional, Matricula, NOMBRE, NIVEL, ID PROGRAMA, CURP, INICIO DE TETRA</code>
                  </small>
                </div>

                <div className="modal-actions">
                  <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={() => setShowImportModal(false)}
                    disabled={previewing}
                  >
                    Cancelar
                  </button>
                  <button type="submit" className="btn btn-primary" disabled={previewing}>
                    {previewing ? 'Analizando Archivo CSV...' : '🔍 Previsualizar Datos'}
                  </button>
                </div>
              </form>
            ) : (
              <div>
                {/* Resumen de Previsualización */}
                <div className="metrics-grid" style={{ marginBottom: '16px' }}>
                  <article className="metric-card">
                    <p>Total Filas</p>
                    <strong>{previewData.summary?.total_rows}</strong>
                  </article>
                  <article className="metric-card" style={{ borderColor: '#198754' }}>
                    <p>Filas Válidas</p>
                    <strong style={{ color: '#198754' }}>{previewData.summary?.valid_count}</strong>
                  </article>
                  <article className="metric-card" style={{ borderColor: '#0d6efd' }}>
                    <p>Nuevos a Insertar</p>
                    <strong style={{ color: '#0d6efd' }}>+{previewData.summary?.to_insert_count}</strong>
                  </article>
                  <article className="metric-card" style={{ borderColor: '#ffc107' }}>
                    <p>Existentes a Actualizar</p>
                    <strong style={{ color: '#d97706' }}>↺ {previewData.summary?.to_update_count}</strong>
                  </article>
                </div>

                {previewData.summary?.invalid_count > 0 ? (
                  <div className="alert alert-warning" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <span>
                      ⚠️ Se detectaron <strong>{previewData.summary?.invalid_count}</strong> filas con inconsistencias o CURP inválida.
                    </span>
                    <button
                      type="button"
                      className="btn btn-sm btn-outline"
                      onClick={handleDownloadInvalidReport}
                    >
                      📥 Descargar Reporte de Errores (.csv)
                    </button>
                  </div>
                ) : null}

                <h4>Vista Previa de Alumnos Aceptados</h4>
                <div style={{ maxHeight: '220px', overflowY: 'auto', marginBottom: '16px', border: '1px solid #ddd', borderRadius: '4px' }}>
                  <table className="custom-table" style={{ fontSize: '0.85rem' }}>
                    <thead>
                      <tr>
                        <th>CURP</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Período</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      {previewData.preview_valid?.map((item, idx) => (
                        <tr key={idx}>
                          <td><code>{item.curp}</code></td>
                          <td>{item.nombre}</td>
                          <td>{item.id_programa}</td>
                          <td>{item.periodo}</td>
                          <td>
                            {item.is_update ? (
                              <span style={{ color: '#d97706', fontWeight: 'bold' }}>Actualizar</span>
                            ) : (
                              <span style={{ color: '#198754', fontWeight: 'bold' }}>Nuevo</span>
                            )}
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>

                <div className="modal-actions">
                  <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={() => setPreviewData(null)}
                    disabled={confirming}
                  >
                    &laquo; Volver a Seleccionar
                  </button>
                  <button
                    type="button"
                    className="btn btn-success"
                    onClick={handleConfirmImport}
                    disabled={confirming || previewData.summary?.valid_count === 0}
                  >
                    {confirming ? 'Procesando Importación...' : '✓ Confirmar e Importar Alumnos'}
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>
      ) : null}
    </div>
  );
}
