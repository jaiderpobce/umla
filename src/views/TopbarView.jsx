import { useEffect, useRef, useState } from 'react';
import { useNavigate } from 'react-router-dom';

export function TopbarView({ user, onLogout, onMenuToggle }) {
  const [menuOpen, setMenuOpen] = useState(false);
  const dropdownRef = useRef(null);
  const navigate = useNavigate();

  const displayName = user?.name || user?.email?.split('@')[0] || 'Usuario';
  const displayEmail = user?.email || 'Sin correo';
  const avatarUrl = user?.avatar_url || user?.profile_photo_url || user?.photo || null;

  function getInitials() {
    if (user?.name) {
      const parts = user.name.trim().split(' ').filter(Boolean);
      return parts.length === 1
        ? parts[0].slice(0, 2).toUpperCase()
        : `${parts[0][0]}${parts[parts.length - 1][0]}`.toUpperCase();
    }

    if (user?.email) {
      return user.email.slice(0, 2).toUpperCase();
    }

    return 'US';
  }

  function goToProfile() {
    setMenuOpen(false);
    navigate('/profile');
  }

  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setMenuOpen(false);
      }
    }

    if (menuOpen) {
      document.addEventListener('mousedown', handleClickOutside);
    }

    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [menuOpen]);

  return (
    <header className="topbar">
      <div className="topbar-actions">
        <button className="menu-toggle" onClick={onMenuToggle} aria-label="Abrir menú">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>

      <div className="topbar-user-menu" ref={dropdownRef}>
        <button
          type="button"
          className="user-menu-trigger"
          aria-haspopup="true"
          aria-expanded={menuOpen}
          onClick={() => setMenuOpen((current) => !current)}
        >
          <div className="user-avatar">
            {avatarUrl ? (
              <img src={avatarUrl} alt={displayName} />
            ) : (
              <span>{getInitials()}</span>
            )}
          </div>
        </button>

        {menuOpen ? (
          <div className="user-menu-dropdown">
            <div className="user-menu-header">
              <div className="user-menu-avatar">
                {avatarUrl ? (
                  <img src={avatarUrl} alt={displayName} />
                ) : (
                  <span>{getInitials()}</span>
                )}
              </div>
              <div>
                <strong>{displayName}</strong>
              </div>
            </div>

            <div className="user-menu-items">
              <button type="button" className="user-menu-item" onClick={goToProfile}>
                Mis datos personales
              </button>
              <button type="button" className="user-menu-item" onClick={goToProfile}>
                Ver correo
              </button>
              <button type="button" className="user-menu-item" onClick={goToProfile}>
                Ajustes de cuenta
              </button>
            </div>

            <div className="user-menu-footer">
              <button className="logout-button" type="button" onClick={onLogout}>
                Salir
              </button>
            </div>
          </div>
        ) : null}
      </div>
    </header>
  );
}
