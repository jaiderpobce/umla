export function TopbarView({ user, onLogout, onMenuToggle }) {
  return (
    <header className="topbar">
      <div>
        <button className="menu-toggle" onClick={onMenuToggle} aria-label="Abrir menú">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <p className="eyebrow">Frontend MVC con RBAC</p>
        <h1>Dashboard de administración UMLA</h1>
      </div>
      <div className="role-switcher">
        <div>
          <span className="role-badge">{user?.roles?.[0]?.name || 'Sin rol'}</span>
          <p className="user-caption">{user?.email}</p>
        </div>
        <button className="logout-button" onClick={onLogout}>Salir</button>
      </div>
    </header>
  );
}
