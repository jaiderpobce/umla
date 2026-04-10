import { AdminCrudView } from './AdminCrudView.jsx';

function PermissionChip({ permission }) {
  return <span className="permission-chip">{permission}</span>;
}

export function ModuleView({ state, metrics, dataController }) {
  if (state.loading) {
    return <section className="empty-state">Cargando módulo...</section>;
  }

  if (state.error) {
    return <section className="empty-state">{state.error}</section>;
  }

  if (!state.payload) {
    return <section className="empty-state">No hay información disponible.</section>;
  }

  const { module, view } = state.payload;
  const isAdminCrudModule = ['usuarios', 'roles', 'modulos'].includes(module.slug);

  return (
    <section className="content-panel">
      <div className="hero-card">
        <div>
          <p className="eyebrow">Módulo actual</p>
          <h2>{module.name}</h2>
          <p className="hero-copy">{module.description}</p>
          <p className="view-caption">Vista: {view.name}</p>
        </div>
        <div className="permission-list">
          {view.permissions.length > 0 ? view.permissions.map((permission) => <PermissionChip key={permission} permission={permission} />) : <PermissionChip permission="sin permisos" />}
        </div>
      </div>

      <div className="metrics-grid">
        {metrics.map((metric) => (
          <article key={metric.label} className="metric-card">
            <p>{metric.label}</p>
            <strong>{metric.value}</strong>
            <span>{metric.trend}</span>
          </article>
        ))}
      </div>

      {isAdminCrudModule ? (
        <AdminCrudView moduleSlug={module.slug} dataController={dataController} permissions={view.permissions} />
      ) : (
        <div className="section-grid">
          <article className="info-card">
            <h3>Vista activa</h3>
            <p>{view.description}</p>
            <ul>
              <li>Ruta: {view.route}</li>
              <li>Componente: {view.component || 'No definido'}</li>
              <li>Permisos: {view.permissions.join(', ') || 'Sin permisos'}</li>
            </ul>
          </article>
          <article className="info-card">
            <h3>RBAC operativo</h3>
            <p>La navegación se construye desde la base de datos según el rol asociado al usuario autenticado.</p>
            <ul>
              <li>Sesión basada en Laravel</li>
              <li>Menú dinámico por módulo</li>
              <li>Privilegios por vista y acción</li>
            </ul>
          </article>
        </div>
      )}
    </section>
  );
}
