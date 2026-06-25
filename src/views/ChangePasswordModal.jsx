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
    } catch (err) {
      setError(err.message || 'Error al cambiar la contraseña.');
      setLoading(false);
    }
  }

  const brandColor = branding?.brand_color || '#d96c3f';

  return (
    <div className="modal-overlay" style={{
      position: 'fixed',
      top: 0,
      left: 0,
      right: 0,
      bottom: 0,
      backgroundColor: 'rgba(17, 26, 35, 0.65)',
      backdropFilter: 'blur(12px)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      zIndex: 9999,
      padding: '20px'
    }}>
      <div style={{
        maxWidth: '440px',
        width: '100%',
        padding: '36px',
        borderRadius: '24px',
        background: 'rgba(255, 250, 244, 0.95)',
        border: '1px solid var(--line)',
        boxShadow: '0 30px 60px rgba(0, 0, 0, 0.16)',
        backdropFilter: 'blur(20px)'
      }}>
        
        <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
          {branding?.logo_path ? (
            <img src={branding.logo_path} alt="Logo" style={{ height: '56px', marginBottom: '1.25rem', objectFit: 'contain' }} />
          ) : (
            <div style={{
              backgroundColor: `${brandColor}18`,
              color: brandColor,
              width: '56px',
              height: '56px',
              borderRadius: '16px',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              margin: '0 auto 1.25rem',
              boxShadow: `0 8px 20px ${brandColor}24`
            }}>
              <KeyRound size={28} />
            </div>
          )}
          <h2 style={{
            fontSize: '1.5rem',
            fontWeight: 700,
            color: 'var(--text)',
            margin: '0 0 8px',
            fontFamily: "'Space Grotesk', sans-serif"
          }}>
            Actualizar Contraseña
          </h2>
          <p style={{
            fontSize: '0.88rem',
            color: 'var(--muted)',
            margin: 0,
            lineHeight: 1.5
          }}>
            Hola, <strong style={{ color: 'var(--text)' }}>{user?.name.split(' ')[0]}</strong>. Por seguridad de tu cuenta, es necesario actualizar la contraseña temporal antes de continuar.
          </p>
        </div>

        {error && (
          <div style={{
            marginBottom: '1.5rem',
            padding: '12px 16px',
            backgroundColor: 'rgba(166, 58, 50, 0.08)',
            borderLeft: '4px solid var(--accent-ember)',
            color: '#a63a32',
            borderRadius: '12px',
            fontSize: '0.88rem',
            lineHeight: 1.4,
            fontWeight: 500
          }}>
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1.25rem' }}>
          
          <div style={{ display: 'grid', gap: '6px' }}>
            <label style={{ fontSize: '0.85rem', fontWeight: 600, color: 'var(--muted)' }}>
              Contraseña Temporal Actual
            </label>
            <div style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showCurrent ? 'text' : 'password'}
                value={currentPassword}
                onChange={(e) => setCurrentPassword(e.target.value)}
                required
                placeholder="Escribe passwd"
                style={{
                  width: '100%',
                  padding: '12px 42px 12px 14px',
                  borderRadius: '12px',
                  border: '1px solid var(--line)',
                  background: 'rgba(255, 255, 255, 0.82)',
                  fontSize: '0.95rem',
                  outline: 'none',
                  color: 'var(--text)',
                  transition: 'all 0.2s'
                }}
              />
              <button 
                type="button" 
                onClick={() => setShowCurrent(!showCurrent)}
                style={{
                  position: 'absolute',
                  right: '12px',
                  background: 'none',
                  border: 'none',
                  cursor: 'pointer',
                  color: 'var(--muted)',
                  display: 'flex',
                  alignItems: 'center',
                  padding: 0
                }}
              >
                {showCurrent ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div style={{ display: 'grid', gap: '6px' }}>
            <label style={{ fontSize: '0.85rem', fontWeight: 600, color: 'var(--muted)' }}>
              Nueva Contraseña
            </label>
            <div style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showNew ? 'text' : 'password'}
                value={newPassword}
                onChange={(e) => setNewPassword(e.target.value)}
                required
                minLength={8}
                placeholder="Mínimo 8 caracteres"
                style={{
                  width: '100%',
                  padding: '12px 42px 12px 14px',
                  borderRadius: '12px',
                  border: '1px solid var(--line)',
                  background: 'rgba(255, 255, 255, 0.82)',
                  fontSize: '0.95rem',
                  outline: 'none',
                  color: 'var(--text)',
                  transition: 'all 0.2s'
                }}
              />
              <button 
                type="button" 
                onClick={() => setShowNew(!showNew)}
                style={{
                  position: 'absolute',
                  right: '12px',
                  background: 'none',
                  border: 'none',
                  cursor: 'pointer',
                  color: 'var(--muted)',
                  display: 'flex',
                  alignItems: 'center',
                  padding: 0
                }}
              >
                {showNew ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div style={{ display: 'grid', gap: '6px' }}>
            <label style={{ fontSize: '0.85rem', fontWeight: 600, color: 'var(--muted)' }}>
              Confirmar Nueva Contraseña
            </label>
            <div style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <input
                type={showConfirm ? 'text' : 'password'}
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
                minLength={8}
                placeholder="Repite la nueva contraseña"
                style={{
                  width: '100%',
                  padding: '12px 42px 12px 14px',
                  borderRadius: '12px',
                  border: '1px solid var(--line)',
                  background: 'rgba(255, 255, 255, 0.82)',
                  fontSize: '0.95rem',
                  outline: 'none',
                  color: 'var(--text)',
                  transition: 'all 0.2s'
                }}
              />
              <button 
                type="button" 
                onClick={() => setShowConfirm(!showConfirm)}
                style={{
                  position: 'absolute',
                  right: '12px',
                  background: 'none',
                  border: 'none',
                  cursor: 'pointer',
                  color: 'var(--muted)',
                  display: 'flex',
                  alignItems: 'center',
                  padding: 0
                }}
              >
                {showConfirm ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div style={{
            display: 'flex',
            gap: '12px',
            marginTop: '1.25rem'
          }}>
            <button 
              type="button" 
              onClick={onLogout}
              disabled={loading}
              style={{
                flex: '1',
                padding: '12px 16px',
                borderRadius: '12px',
                border: '1px solid var(--line)',
                background: 'rgba(17, 26, 35, 0.05)',
                color: 'var(--text)',
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                gap: '8px',
                fontSize: '0.92rem',
                fontWeight: 600,
                transition: 'all 0.2s'
              }}
            >
              <LogOut size={16} />
              <span>Salir</span>
            </button>
            
            <button 
              type="submit" 
              disabled={loading}
              style={{
                flex: '2',
                padding: '12px 16px',
                borderRadius: '12px',
                border: 'none',
                backgroundColor: brandColor,
                color: 'white',
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                gap: '8px',
                fontSize: '0.92rem',
                fontWeight: 600,
                boxShadow: `0 4px 14px ${brandColor}3d`,
                transition: 'all 0.2s'
              }}
            >
              {loading ? (
                <>
                  <Loader2 size={16} className="animate-spin" />
                  <span>Guardando...</span>
                </>
              ) : (
                <span>Actualizar Contraseña</span>
              )}
            </button>
          </div>

        </form>
      </div>
    </div>
  );
}
