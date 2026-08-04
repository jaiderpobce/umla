export function ProfileView({ user }) {
  const displayName = user?.name || user?.email?.split('@')[0] || 'Usuario';
  const displayEmail = user?.email || 'Sin correo';
  const avatarUrl = user?.avatar_url || user?.profile_photo_url || user?.photo || null;

  return (
    <section className="profile-page">
      <div className="profile-card">
        <div className="profile-avatar">
          {avatarUrl ? <img src={avatarUrl} alt={displayName} /> : <span>{displayName.slice(0, 2).toUpperCase()}</span>}
        </div>

        <div className="profile-details">
          <h2>{displayName}</h2>
          <p>{displayEmail}</p>
          <div className="profile-meta">
            <div>
              <label>Rol</label>
              <p>{user?.roles?.[0]?.name || 'Sin rol'}</p>
            </div>
            <div>
              <label>Usuario</label>
              <p>{user?.username || displayName}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
