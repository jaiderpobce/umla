export function SidebarView({ brand, modules, activeModuleSlug, isOpen, onClose, onModuleSelect }) {
  return (
    <>
      <button className={`sidebar-backdrop ${isOpen ? 'is-visible' : ''}`} onClick={onClose} aria-label="Cerrar menú" />
      <aside className={`sidebar ${isOpen ? 'is-open' : ''}`}>
        <div className="sidebar-brand">
          <span className="sidebar-brand-mark">U</span>
          <div>
            <strong>{brand}</strong>
            <p>Control de acceso y permisos</p>
          </div>
        </div>
        <nav className="sidebar-nav">
          {modules.map((module) => (
            <button
              key={module.id}
              className={`sidebar-link ${activeModuleSlug === module.slug ? 'is-active' : ''}`}
              onClick={() => onModuleSelect(module.views[0]?.route || '/')}
            >
              <span className="sidebar-icon">{module.icon}</span>
              <span>{module.name}</span>
            </button>
          ))}
        </nav>
      </aside>
    </>
  );
}
