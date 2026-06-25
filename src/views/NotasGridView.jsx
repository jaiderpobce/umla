import { ChevronLeft, ChevronRight, Eraser, Mail, PencilLine, Save, Search, Trash2, UserRound, BookOpenText } from 'lucide-react';
import { useEffect, useState } from 'react';

function emptyForm() {
  return {
    id: null,
    Email: '',
    Matricula: '',
    Nombre: '',
    APaterno: '',
    AMaterno: '',
    Periodo: '',
    Tetramestre: '',
    Nivel: '',
    Asignatura: '',
    CalificacionFinal: '',
    Catedratico: '',
  };
}

function buildPageItems(currentPage, lastPage) {
  if (!lastPage || lastPage <= 1) {
    return [];
  }

  const pages = new Set([1, lastPage, currentPage - 1, currentPage, currentPage + 1]);
  const sortedPages = Array.from(pages)
    .filter((page) => page >= 1 && page <= lastPage)
    .sort((left, right) => left - right);

  return sortedPages.reduce((items, page, index) => {
    const previousPage = sortedPages[index - 1];

    if (index > 0 && page - previousPage > 1) {
      items.push({ type: 'ellipsis', value: `ellipsis-${previousPage}-${page}` });
    }

    items.push({ type: 'page', value: page });
    return items;
  }, []);
}

function Pagination({ meta, onChange }) {
  if (!meta?.last_page || meta.last_page <= 1) {
    return null;
  }

  const pageItems = buildPageItems(meta.current_page, meta.last_page);

  return (
    <div className="pagination-bar">
      <button className="inline-button icon-button" type="button" disabled={meta.current_page <= 1} onClick={() => onChange(meta.current_page - 1)}>
        <ChevronLeft size={16} />
        <span>Anterior</span>
      </button>
      <div className="pagination-meta">
        <span className="pagination-status">Página {meta.current_page} de {meta.last_page}</span>
        <span className="pagination-total">Mostrando {meta.from || 0}-{meta.to || 0} de {meta.total || 0}</span>
      </div>
      <div className="pagination-pages" aria-label="Paginación de notas">
        {pageItems.map((item) => item.type === 'ellipsis' ? (
          <span key={item.value} className="pagination-ellipsis">...</span>
        ) : (
          <button
            key={item.value}
            className={`pagination-page ${item.value === meta.current_page ? 'is-active' : ''}`}
            type="button"
            onClick={() => onChange(item.value)}
            disabled={item.value === meta.current_page}
          >
            {item.value}
          </button>
        ))}
      </div>
      <button className="inline-button icon-button" type="button" disabled={meta.current_page >= meta.last_page} onClick={() => onChange(meta.current_page + 1)}>
        <span>Siguiente</span>
        <ChevronRight size={16} />
      </button>
    </div>
  );
}

export function NotasGridView({ dataController, permissions }) {
  const [rows, setRows] = useState([]);
  const [meta, setMeta] = useState({ current_page: 1, last_page: 1, total: 0 });
  const [search, setSearch] = useState('');
  const [appliedSearch, setAppliedSearch] = useState('');
  const [perPage, setPerPage] = useState(15);
  const [loading, setLoading] = useState(true);
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const [editing, setEditing] = useState(emptyForm());

  useEffect(() => {
    if (message || error) {
      const timer = setTimeout(() => {
        setMessage('');
        setError('');
      }, 5000);
      return () => clearTimeout(timer);
    }
  }, [message, error]);

  const canEdit = permissions.includes('edit');
  const canDelete = permissions.includes('delete');

  async function loadNotas(page = 1, currentSearch = appliedSearch, currentPerPage = perPage) {
    setLoading(true);
    setError('');
    try {
      const response = await dataController.getNotas({ search: currentSearch, page, perPage: currentPerPage });
      setRows(response.data || []);
      setMeta(response.meta || { current_page: 1, last_page: 1, total: 0 });
    } catch (loadError) {
      setError(loadError.message);
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    loadNotas(1, '', perPage);
  }, []);

  async function submitSearch(event) {
    event.preventDefault();
    setAppliedSearch(search);
    await loadNotas(1, search, perPage);
  }

  async function handlePerPageChange(event) {
    const nextPerPage = Number(event.target.value) || 15;
    setPerPage(nextPerPage);
    await loadNotas(1, appliedSearch, nextPerPage);
  }

  async function submitEdit(event) {
    event.preventDefault();
    setMessage('');
    setError('');
    try {
      await dataController.updateNota(editing.id, editing);
      setMessage('Nota actualizada.');
      setEditing(emptyForm());
      await loadNotas(meta.current_page, appliedSearch, perPage);
    } catch (submitError) {
      setError(submitError.message);
    }
  }

  async function handleDelete(notaId) {
    setMessage('');
    setError('');
    try {
      await dataController.deleteNota(notaId);
      setMessage('Nota eliminada.');
      await loadNotas(meta.current_page, appliedSearch, perPage);
    } catch (deleteError) {
      setError(deleteError.message);
    }
  }

  function closeEditModal() {
    setEditing(emptyForm());
  }

  return (
    <section className="notas-panel">
      <article className="info-card notas-card">
        <div className="notas-toolbar-head">
          <div>
            <p className="eyebrow">Consulta Operativa</p>
            <h3>Grid de notas</h3>
          </div>
          <div className="notas-summary-pill">
            <span>{meta.total || 0} registros</span>
          </div>
        </div>

        <form className="notas-toolbar" onSubmit={submitSearch}>
          <div className="notas-search-group">
            <label className="notas-search-shell">
              <Search size={18} className="notas-search-icon" />
              <input
                className="notas-search"
                value={search}
                onChange={(event) => setSearch(event.target.value)}
                placeholder="Buscar por matrícula, nombre, correo, asignatura..."
              />
            </label>
            <button className="submit-button icon-button" type="submit">
              <Search size={16} />
              <span>Filtrar</span>
            </button>
          </div>
          <label className="notas-page-size-field">
            <span>Filas por página</span>
            <select className="notas-page-size-select" value={perPage} onChange={handlePerPageChange}>
              <option value="15">15</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </label>
        </form>

        {message ? <p className="admin-message is-success">{message}</p> : null}
        {error ? <p className="admin-message is-error">{error}</p> : null}

        {loading ? <p className="empty-inline">Cargando notas...</p> : (
          <>
            <div className="table-shell notas-table-shell">
              <table className="sistedu-grid notas-table">
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Alumno</th>
                    <th>Tetramestre</th>
                    <th>Asignatura</th>
                    <th>Calificación</th>
                    <th>Catedrático</th>
                    {(canEdit || canDelete) ? <th>Acciones</th> : null}
                  </tr>
                </thead>
                <tbody>
                  {rows.map((row) => (
                    <tr key={row.id}>
                      <td>
                        <div className="notas-cell-stack">
                          <strong>{row.Matricula}</strong>
                          <span>ID {row.id}</span>
                        </div>
                      </td>
                      <td>
                        <div className="notas-cell-stack">
                          <strong>{[row.Nombre, row.APaterno, row.AMaterno].filter(Boolean).join(' ')}</strong>
                          <span>{row.Email}</span>
                        </div>
                      </td>
                      <td>
                        <div className="notas-meta-chip">
                          <span>{row.Tetramestre || 'N/D'}</span>
                        </div>
                      </td>
                      <td>
                        <div className="notas-subject-chip">
                          <BookOpenText size={15} />
                          <span>{row.Asignatura}</span>
                        </div>
                      </td>
                      <td>
                        <span className={`grade-badge ${Number(row.CalificacionFinal) >= 90 ? 'is-high' : Number(row.CalificacionFinal) < 70 ? 'is-low' : ''}`}>
                          {row.CalificacionFinal}
                        </span>
                      </td>
                      <td>{row.Catedratico}</td>
                      {(canEdit || canDelete) ? (
                        <td className="row-actions">
                          {canEdit ? (
                            <button className="inline-button icon-button" type="button" onClick={() => setEditing({ ...row })}>
                              <PencilLine size={15} />
                              <span>Editar</span>
                            </button>
                          ) : null}
                          {canDelete ? (
                            <button className="inline-button danger icon-button" type="button" onClick={() => handleDelete(row.id)}>
                              <Trash2 size={15} />
                              <span>Eliminar</span>
                            </button>
                          ) : null}
                        </td>
                      ) : null}
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            <Pagination meta={meta} onChange={(page) => loadNotas(page, appliedSearch, perPage)} />
          </>
        )}
      </article>

      {canEdit && editing.id ? (
        <div className="modal-backdrop" onClick={closeEditModal}>
          <article className="modal-card notas-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Edición rápida</p>
                <h3>Editar nota</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closeEditModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>

            <form className="admin-form notas-edit-form" onSubmit={submitEdit}>
              <label>Correo<div className="input-with-icon"><Mail size={16} /><input value={editing.Email} onChange={(event) => setEditing((current) => ({ ...current, Email: event.target.value }))} /></div></label>
              <label>Matrícula<div className="input-with-icon"><UserRound size={16} /><input value={editing.Matricula} onChange={(event) => setEditing((current) => ({ ...current, Matricula: event.target.value }))} /></div></label>
              <label>Nombre<div className="input-with-icon"><UserRound size={16} /><input value={editing.Nombre} onChange={(event) => setEditing((current) => ({ ...current, Nombre: event.target.value }))} /></div></label>
              <label>Apellido paterno<input value={editing.APaterno || ''} onChange={(event) => setEditing((current) => ({ ...current, APaterno: event.target.value }))} /></label>
              <label>Apellido materno<input value={editing.AMaterno || ''} onChange={(event) => setEditing((current) => ({ ...current, AMaterno: event.target.value }))} /></label>
              <label>Periodo<input value={editing.Periodo || ''} onChange={(event) => setEditing((current) => ({ ...current, Periodo: event.target.value }))} /></label>
              <label>Tetramestre<input value={editing.Tetramestre || ''} onChange={(event) => setEditing((current) => ({ ...current, Tetramestre: event.target.value }))} /></label>
              <label>Nivel<input value={editing.Nivel || ''} onChange={(event) => setEditing((current) => ({ ...current, Nivel: event.target.value }))} /></label>
              <label>Asignatura<div className="input-with-icon"><BookOpenText size={16} /><input value={editing.Asignatura} onChange={(event) => setEditing((current) => ({ ...current, Asignatura: event.target.value }))} /></div></label>
              <label>Calificación<input value={editing.CalificacionFinal || ''} onChange={(event) => setEditing((current) => ({ ...current, CalificacionFinal: event.target.value }))} /></label>
              <label>Catedrático<input value={editing.Catedratico || ''} onChange={(event) => setEditing((current) => ({ ...current, Catedratico: event.target.value }))} /></label>
              <div className="form-actions">
                <button className="submit-button icon-button" type="submit"><Save size={16} /><span>Guardar cambios</span></button>
                <button className="inline-button icon-button" type="button" onClick={closeEditModal}><Eraser size={15} /><span>Cancelar</span></button>
              </div>
            </form>
          </article>
        </div>
      ) : null}
    </section>
  );
}