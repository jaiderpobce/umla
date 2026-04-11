import { useEffect, useState } from 'react';

function SummaryStat({ label, value, caption }) {
  return (
    <article className="import-stat-card">
      <p>{label}</p>
      <strong>{value}</strong>
      {caption ? <span>{caption}</span> : null}
    </article>
  );
}

function MessageBlock({ message, tone = 'neutral' }) {
  if (!message) {
    return null;
  }

  return <p className={`import-feedback is-${tone}`}>{message}</p>;
}

function HeadersPanel({ preview }) {
  if (!preview) {
    return null;
  }

  return (
    <div className="import-result-card">
      <h4>Validación de encabezados</h4>
      <div className="header-validation-grid">
        <div>
          <p className="header-list-title">Esperados</p>
          <ul>
            {preview.expected_headers.map((header) => (
              <li key={header}>{header}</li>
            ))}
          </ul>
        </div>
        <div>
          <p className="header-list-title">Recibidos</p>
          <ul>
            {preview.received_headers.map((header, index) => (
              <li key={`${header}-${index}`}>{header}</li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
}

function InvalidSummary({ items, downloadUrl }) {
  if (!items?.length) {
    return <p className="empty-inline">No hay motivos de rechazo en esta vista previa.</p>;
  }

  return (
    <div className="import-result-card">
      <h4>Resumen de inválidas</h4>
      <ul className="invalid-summary-list">
        {items.map((item) => (
          <li key={item.reason}>{item.label}</li>
        ))}
      </ul>
      {downloadUrl ? (
        <a className="download-link-button" href={downloadUrl}>
          Descargar CSV de inválidas
        </a>
      ) : null}
    </div>
  );
}

function HistoryTable({ items }) {
  if (!items?.length) {
    return <p className="empty-inline">Aún no hay importaciones registradas.</p>;
  }

  return (
    <div className="table-shell">
      <table className="data-table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Archivo</th>
            <th>CSV</th>
            <th>Importadas</th>
            <th>Inválidas</th>
          </tr>
        </thead>
        <tbody>
          {items.map((item) => (
            <tr key={item.id}>
              <td>{item.processed_at || 'Sin fecha'}</td>
              <td>{item.user?.name || 'Sin usuario'}</td>
              <td>{item.original_file_name}</td>
              <td>{item.csv_file_name || 'N/D'}</td>
              <td>{item.imported_rows}</td>
              <td>{item.invalid_rows}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

function InvalidRowsPreview({ items }) {
  if (!items?.length) {
    return <p className="empty-inline">No se detectaron filas inválidas en la vista previa.</p>;
  }

  return (
    <div className="table-shell">
      <table className="data-table">
        <thead>
          <tr>
            <th>Fila</th>
            <th>Motivo</th>
            <th>Contenido</th>
          </tr>
        </thead>
        <tbody>
          {items.map((item) => (
            <tr key={`${item.line}-${item.reason}`}>
              <td>{item.line}</td>
              <td>{item.reason}</td>
              <td>{item.row.join(' | ')}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export function CalificacionesImportView({ dataController, permissions }) {
  const [summary, setSummary] = useState({ table_total: 0, last_import_at: null, history: [] });
  const [selectedFile, setSelectedFile] = useState(null);
  const [preview, setPreview] = useState(null);
  const [loading, setLoading] = useState(true);
  const [previewing, setPreviewing] = useState(false);
  const [confirming, setConfirming] = useState(false);
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const [result, setResult] = useState(null);

  const canUpload = permissions.includes('create');

  useEffect(() => {
    let isMounted = true;

    async function loadSummary() {
      setLoading(true);
      setError('');

      try {
        const payload = await dataController.getCalificacionesImportSummary();
        if (isMounted) {
          setSummary(payload);
        }
      } catch (loadError) {
        if (isMounted) {
          setError(loadError.message);
        }
      } finally {
        if (isMounted) {
          setLoading(false);
        }
      }
    }

    loadSummary();

    return () => {
      isMounted = false;
    };
  }, [dataController]);

  async function refreshSummary() {
    const payload = await dataController.getCalificacionesImportSummary();
    setSummary(payload);
  }

  async function handlePreview(event) {
    event.preventDefault();

    if (!selectedFile) {
      setError('Selecciona un archivo ZIP antes de validar.');
      return;
    }

    setPreviewing(true);
    setMessage('');
    setError('');
    setResult(null);

    try {
      const response = await dataController.previewCalificacionesZip(selectedFile);
      setPreview(response.preview || null);
      setMessage(response.message || 'Vista previa generada.');
    } catch (previewError) {
      setPreview(null);
      setError(previewError.message);
    } finally {
      setPreviewing(false);
    }
  }

  async function handleConfirm() {
    if (!preview?.token) {
      setError('Primero debes validar un ZIP con encabezado correcto.');
      return;
    }

    setConfirming(true);
    setMessage('');
    setError('');

    try {
      const response = await dataController.confirmCalificacionesImport(preview.token);
      setResult(response || null);
      setMessage(response.message || 'Importación confirmada.');
      setPreview(null);
      setSelectedFile(null);
      await refreshSummary();
    } catch (confirmError) {
      setError(confirmError.message);
    } finally {
      setConfirming(false);
    }
  }

  return (
    <div className="import-layout">
      <div className="import-grid">
        <article className="info-card import-card import-card-form">
          <div className="admin-section-header">
            <h3>Validar archivo ZIP</h3>
            <p>Primero se valida el encabezado exacto y se genera una vista previa de filas inválidas. Solo después se confirma la importación.</p>
          </div>

          <form className="admin-form" onSubmit={handlePreview}>
            <label>
              Archivo ZIP
              <input
                type="file"
                accept=".zip,application/zip"
                onChange={(event) => {
                  setSelectedFile(event.target.files?.[0] || null);
                  setPreview(null);
                  setResult(null);
                }}
                disabled={!canUpload || previewing || confirming}
              />
            </label>

            <div className="import-hints">
              <span>Encabezado exacto esperado según el layout oficial del CSV.</span>
              <span>Delimitador principal detectado: punto y coma.</span>
              <span>La importación definitiva ocurre solo al pulsar Confirmar importación.</span>
            </div>

            <div className="form-actions">
              <button className="submit-button" type="submit" disabled={!canUpload || previewing || confirming}>
                {previewing ? 'Validando...' : 'Validar ZIP'}
              </button>
              <button className="inline-button" type="button" disabled={!preview?.token || previewing || confirming} onClick={handleConfirm}>
                {confirming ? 'Confirmando...' : 'Confirmar importación'}
              </button>
            </div>
          </form>

          {!canUpload ? <MessageBlock tone="warning" message="Tu rol puede visualizar el módulo, pero no cargar archivos." /> : null}
          <MessageBlock tone="success" message={message} />
          <MessageBlock tone="error" message={error} />
        </article>

        <article className="info-card import-card">
          <div className="admin-section-header">
            <h3>Estado de la tabla</h3>
            <p>{loading ? 'Cargando resumen...' : 'Resumen actual y últimas importaciones.'}</p>
          </div>

          <div className="import-stats-grid">
            <SummaryStat label="Registros actuales" value={summary.table_total || 0} caption="total en tabla" />
            <SummaryStat label="Última carga" value={summary.last_import_at || 'Sin registro'} caption="marca temporal" />
          </div>

          {result?.summary ? (
            <div className="import-result-card">
              <h4>Última confirmación</h4>
              <ul>
                <li>CSV detectado: {result.summary.csv_file}</li>
                <li>Filas importadas: {result.summary.processed_rows}</li>
                <li>Filas omitidas: {result.summary.skipped_rows}</li>
                <li>Total en tabla: {result.summary.table_total}</li>
                <li>Ejecutado por: {result.summary.executed_by?.name} ({result.summary.executed_by?.email})</li>
              </ul>
            </div>
          ) : null}
        </article>
      </div>

      {preview ? (
        <section className="content-panel">
          <article className="info-card import-card">
            <div className="admin-section-header">
              <h3>Vista previa</h3>
              <p>Archivo: {preview.original_file_name} {preview.csv_file_name ? `| CSV: ${preview.csv_file_name}` : ''}</p>
            </div>

            <div className="import-stats-grid">
              <SummaryStat label="Encabezado" value={preview.header_valid ? 'Válido' : 'Inválido'} caption="comparación exacta" />
              <SummaryStat label="Filas válidas" value={preview.valid_rows || 0} caption="listas para importar" />
              <SummaryStat label="Filas inválidas" value={preview.invalid_rows || 0} caption="revisar antes de confirmar" />
              <SummaryStat label="Total analizado" value={preview.total_rows || 0} caption="sin contar encabezado" />
            </div>

            <HeadersPanel preview={preview} />
            <InvalidSummary items={preview.invalid_reason_summary} downloadUrl={preview.invalid_csv_download_url} />
          </article>

          <article className="info-card import-card">
            <div className="admin-section-header">
              <h3>Filas inválidas</h3>
              <p>Se muestran hasta 25 filas con error antes de confirmar.</p>
            </div>
            <InvalidRowsPreview items={preview.invalid_rows_preview} />
          </article>
        </section>
      ) : null}

      <section className="content-panel">
        <article className="info-card import-card">
          <div className="admin-section-header">
            <h3>Historial de importaciones</h3>
            <p>Fecha, usuario y archivo procesado de las últimas cargas confirmadas.</p>
          </div>
          <HistoryTable items={summary.history} />
        </article>
      </section>
    </div>
  );
}