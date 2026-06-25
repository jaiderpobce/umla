import { useState } from 'react';
import { Eye, EyeOff, KeyRound, Loader2, LogOut } from 'lucide-react';
import '../styles/app.css';

export function ChangePasswordModal({ user, branding, onChangePassword, onLogout }) {
  const [currentPassword, setCurrentPassword] = useState('');
  const [newPassword, setNewPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  
  const [showCurrent, setShowCurrent] = useState(false);
  const [showNew, setShowNew] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  async function handleSubmit(e) {
    e.preventDefault();
    setError('');

    if (newPassword.length < 8) {
      setError('La nueva contraseña debe tener al menos 8 caracteres.');
      return;
    }

    if (newPassword !== confirmPassword) {
      setError('Las contraseñas nuevas no coinciden.');
      return;
    }

    setLoading(true);
    try {
      await onChangePassword({
        current_password: currentPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword
      });
      // After success, App.jsx handles state update
    } catch (err) {
      setError(err.message || 'Error al cambiar la contraseña.');
      setLoading(false);
    }
  }

  return (
    <div className="modal-overlay" style={{
      position: 'fixed', top: 0, left: 0, right: 0, bottom: 0,
      backgroundColor: 'rgba(0,0,0,0.7)', backdropFilter: 'blur(4px)',
      display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 9999
    }}>
      <div className="login-card" style={{ maxWidth: '400px', width: '100%', padding: '2rem', borderRadius: '12px', background: 'var(--surface-color)', boxShadow: 'var(--shadow-xl)' }}>
        
        <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
          {branding?.logo_path ? (
            <img src={branding.logo_path} alt="Logo" style={{ height: '48px', marginBottom: '1rem', objectFit: 'contain' }} />
          ) : (
            <div className="brand-icon" style={{ backgroundColor: branding?.brand_color || 'var(--primary-color)', color: 'white', width: '48px', height: '48px', borderRadius: '8px', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 1rem' }}>
              <KeyRound size={24} />
            </div>
          )}
          <h2 style={{ fontSize: '1.25rem', fontWeight: 600, color: 'var(--text-color)' }}>
            Actualización Requerida
          </h2>
          <p style={{ fontSize: '0.875rem', color: 'var(--text-muted)', marginTop: '0.5rem' }}>
            Hola, {user?.name.split(' ')[0]}. Por tu seguridad, debes cambiar tu contraseña inicial antes de continuar.
          </p>
        </div>

        {error && (
          <div className="form-error" style={{ marginBottom: '1.5rem', padding: '0.75rem', backgroundColor: '#fef2f2', color: '#b91c1c', borderRadius: '6px', fontSize: '0.875rem' }}>
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
          
          <div className="form-group">
            <label className="form-label" style={{ fontSize: '0.875rem', fontWeight: 500 }}>Contraseña Actual (passwd)</label>
            <div className="input-with-icon" style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showCurrent ? 'text' : 'password'}
                className="form-input"
                value={currentPassword}
                onChange={(e) => setCurrentPassword(e.target.value)}
                required
                style={{ width: '100%', padding: '0.625rem 2.5rem 0.625rem 0.75rem', borderRadius: '6px', border: '1px solid var(--border-color)', outline: 'none' }}
              />
              <button 
                type="button" 
                onClick={() => setShowCurrent(!showCurrent)}
                style={{ position: 'absolute', right: '0.75rem', background: 'none', border: 'none', cursor: 'pointer', color: 'var(--text-muted)' }}
              >
                {showCurrent ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div className="form-group">
            <label className="form-label" style={{ fontSize: '0.875rem', fontWeight: 500 }}>Nueva Contraseña</label>
            <div className="input-with-icon" style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showNew ? 'text' : 'password'}
                className="form-input"
                value={newPassword}
                onChange={(e) => setNewPassword(e.target.value)}
                required
                minLength={8}
                style={{ width: '100%', padding: '0.625rem 2.5rem 0.625rem 0.75rem', borderRadius: '6px', border: '1px solid var(--border-color)', outline: 'none' }}
              />
              <button 
                type="button" 
                onClick={() => setShowNew(!showNew)}
                style={{ position: 'absolute', right: '0.75rem', background: 'none', border: 'none', cursor: 'pointer', color: 'var(--text-muted)' }}
              >
                {showNew ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div className="form-group">
            <label className="form-label" style={{ fontSize: '0.875rem', fontWeight: 500 }}>Confirmar Nueva Contraseña</label>
            <div className="input-with-icon" style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showConfirm ? 'text' : 'password'}
                className="form-input"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
                minLength={8}
                style={{ width: '100%', padding: '0.625rem 2.5rem 0.625rem 0.75rem', borderRadius: '6px', border: '1px solid var(--border-color)', outline: 'none' }}
              />
              <button 
                type="button" 
                onClick={() => setShowConfirm(!showConfirm)}
                style={{ position: 'absolute', right: '0.75rem', background: 'none', border: 'none', cursor: 'pointer', color: 'var(--text-muted)' }}
              >
                {showConfirm ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div style={{ display: 'flex', gap: '0.75rem', marginTop: '1rem' }}>
            <button 
              type="button" 
              onClick={onLogout}
              className="btn btn-secondary" 
              disabled={loading}
              style={{ flex: 1, padding: '0.625rem', borderRadius: '6px', border: '1px solid var(--border-color)', background: 'transparent', cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem' }}
            >
              <LogOut size={16} /> Salir
            </button>
            
            <button 
              type="submit" 
              className="btn btn-primary" 
              disabled={loading}
              style={{ flex: 2, padding: '0.625rem', borderRadius: '6px', border: 'none', backgroundColor: branding?.brand_color || 'var(--primary-color)', color: 'white', cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', fontWeight: 500 }}
            >
              {loading ? <Loader2 size={16} className="animate-spin" /> : 'Actualizar Contraseña'}
            </button>
          </div>

        </form>
      </div>
    </div>
  );
}
