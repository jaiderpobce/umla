import { ChevronLeft, ChevronRight, Search } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

// Normaliza texto para permitir comparaciones tolerantes en busquedas simples.
function normalizeText(value) {
  return String(value || '')
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .trim();
}

// Construye una ventana corta de paginas para evitar paginadores demasiado largos.
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

// Renderiza la barra de paginacion reutilizable para cualquier modulo administrativo.
function AdminGridPagination({ meta, onChange }) {
  if (!meta?.lastPage || meta.lastPage <= 1) {
    return null;
  }

  const pageItems = buildPageItems(meta.currentPage, meta.lastPage);

  return (
    <div className="pagination-bar">
      <button className="inline-button icon-button" type="button" disabled={meta.currentPage <= 1} onClick={() => onChange(meta.currentPage - 1)}>
        <ChevronLeft size={16} />
        <span>Anterior</span>
      </button>
      <div className="pagination-meta">
        <span className="pagination-status">Pagina {meta.currentPage} de {meta.lastPage}</span>
        <span className="pagination-total">Mostrando {meta.from}-{meta.to} de {meta.total}</span>
      </div>
      <div className="pagination-pages" aria-label="Paginacion del grid administrativo">
        {pageItems.map((item) => item.type === 'ellipsis' ? (
          <span key={item.value} className="pagination-ellipsis">...</span>
        ) : (
          <button
            key={item.value}
            className={`pagination-page ${item.value === meta.currentPage ? 'is-active' : ''}`}
            type="button"
            onClick={() => onChange(item.value)}
            disabled={item.value === meta.currentPage}
          >
            {item.value}
          </button>
        ))}
      </div>
      <button className="inline-button icon-button" type="button" disabled={meta.currentPage >= meta.lastPage} onClick={() => onChange(meta.currentPage + 1)}>
        <span>Siguiente</span>
        <ChevronRight size={16} />
      </button>
    </div>
  );
}

// Resuelve el valor textual de un campo configurable para busqueda o filtros.
function readFieldValue(row, field) {
  if (typeof field === 'function') {
    return field(row);
  }

  return row?.[field];
}

// Componente estandar de grid administrativo con seleccion, filtros y busqueda.
export function AdminDataGrid({
  title,
  copy,
  rows,
  columns,
  searchableFields = [],
  filters = [],
  pageSize = 10,
  getRowId = (row) => row.id,
  selectedRowId = null,
  onSelectionChange,
  renderActions,
  searchPlaceholder = 'Buscar en la tabla...',
  emptyMessage = 'No hay registros para mostrar.',
  tableClassName = '',
  shellClassName = '',
  colorScheme = {},
}) {
  const [searchTerm, setSearchTerm] = useState('');
  const [filterValues, setFilterValues] = useState(() => filters.reduce((accumulator, filter) => ({ ...accumulator, [filter.key]: filter.initialValue || '' }), {}));
  const [currentPage, setCurrentPage] = useState(1);

  const filteredRows = useMemo(() => {
    const normalizedSearch = normalizeText(searchTerm);

    return rows.filter((row) => {
      const passesSearch = !normalizedSearch || searchableFields.some((field) => normalizeText(readFieldValue(row, field)).includes(normalizedSearch));
      if (!passesSearch) {
        return false;
      }

      return filters.every((filter) => {
        const currentValue = filterValues[filter.key];
        if (!currentValue) {
          return true;
        }

        if (typeof filter.matches === 'function') {
          return filter.matches(row, currentValue);
        }

        return normalizeText(readFieldValue(row, filter.field || filter.key)) === normalizeText(currentValue);
      });
    });
  }, [rows, searchableFields, filters, filterValues, searchTerm]);

  const lastPage = Math.max(1, Math.ceil(filteredRows.length / pageSize));
  const visibleRows = useMemo(() => {
    const startIndex = (currentPage - 1) * pageSize;
    return filteredRows.slice(startIndex, startIndex + pageSize);
  }, [filteredRows, currentPage, pageSize]);
  const selectedRow = useMemo(() => filteredRows.find((row) => getRowId(row) === selectedRowId) || rows.find((row) => getRowId(row) === selectedRowId) || null, [filteredRows, rows, getRowId, selectedRowId]);
  const paginationMeta = {
    currentPage,
    lastPage,
    total: filteredRows.length,
    from: filteredRows.length === 0 ? 0 : ((currentPage - 1) * pageSize) + 1,
    to: Math.min(currentPage * pageSize, filteredRows.length),
  };
  const gridColorStyle = {
    '--admin-grid-row-odd-bg': colorScheme.rowOddBg,
    '--admin-grid-row-even-bg': colorScheme.rowEvenBg,
    '--admin-grid-row-hover-bg': colorScheme.rowHoverBg,
    '--admin-grid-row-selected-bg': colorScheme.rowSelectedBg,
  };

  useEffect(() => {
    setCurrentPage(1);
  }, [searchTerm, filterValues, pageSize]);

  useEffect(() => {
    if (currentPage > lastPage) {
      setCurrentPage(lastPage);
    }
  }, [currentPage, lastPage]);

  // Limpia la seleccion cuando el registro ya no existe en la coleccion actual.
  useEffect(() => {
    if (selectedRowId == null) {
      return;
    }

    const rowStillExists = rows.some((row) => getRowId(row) === selectedRowId);
    if (!rowStillExists && typeof onSelectionChange === 'function') {
      onSelectionChange(null);
    }
  }, [rows, getRowId, selectedRowId, onSelectionChange]);

  // Cambia el valor de un filtro declarativo sin acoplar el grid a un modulo concreto.
  function updateFilter(filterKey, value) {
    setFilterValues((current) => ({ ...current, [filterKey]: value }));
  }

  // Propaga la fila seleccionada para que el modulo resuelva sus acciones y modales.
  function handleRowClick(row) {
    if (typeof onSelectionChange === 'function') {
      onSelectionChange(row);
    }
  }

  return (
    <article className="info-card admin-card admin-data-grid-card" style={gridColorStyle}>
      <div className="admin-section-header">
        <h3>{title}</h3>
        <p>{copy}</p>
      </div>

      <div className="admin-data-grid-toolbar">
        <div className="admin-data-grid-filters">
          <label className="admin-data-grid-search-shell">
            <Search size={18} className="admin-data-grid-search-icon" />
            <input
              className="admin-data-grid-search"
              type="search"
              value={searchTerm}
              onChange={(event) => setSearchTerm(event.target.value)}
              placeholder={searchPlaceholder}
            />
          </label>

          {filters.map((filter) => (
            <label key={filter.key} className="admin-data-grid-filter-field">
              <span>{filter.label}</span>
              <select value={filterValues[filter.key] || ''} onChange={(event) => updateFilter(filter.key, event.target.value)}>
                {(filter.options || []).map((option) => (
                  <option key={option.value} value={option.value}>{option.label}</option>
                ))}
              </select>
            </label>
          ))}
        </div>

        <div className="admin-data-grid-actions">
          {typeof renderActions === 'function' ? renderActions({ selectedRow, totalRows: rows.length, filteredRows: filteredRows.length, searchTerm, filterValues }) : null}
        </div>
      </div>

      <div className={`table-shell ${shellClassName}`.trim()}>
        <table className={`data-table ${tableClassName}`.trim()}>
          <thead>
            <tr>
              {columns.map((column) => (
                <th key={column.key || column.label}>{column.label}</th>
              ))}
            </tr>
          </thead>
          <tbody>
            {visibleRows.length > 0 ? visibleRows.map((row) => {
              const rowId = getRowId(row);
              return (
                <tr key={rowId} className={selectedRowId === rowId ? 'row-selected' : ''} onClick={() => handleRowClick(row)}>
                  {columns.map((column) => (
                    <td key={`${rowId}-${column.key || column.label}`}>
                      {typeof column.render === 'function' ? column.render(row) : readFieldValue(row, column.key)}
                    </td>
                  ))}
                </tr>
              );
            }) : (
              <tr>
                <td className="admin-data-grid-empty" colSpan={columns.length}>{emptyMessage}</td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      <AdminGridPagination meta={paginationMeta} onChange={setCurrentPage} />
    </article>
  );
}