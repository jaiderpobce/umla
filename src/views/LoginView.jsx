import { useState } from 'react';
import { BrandLogo } from './BrandLogo.jsx';

export function LoginView({ branding, onLogin }) {
  const [form, setForm] = useState({
    email: 'admin@umla.local',
    password: 'password',
  });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event) {
    event.preventDefault();
    setError('');
    setLoading(true);

    try {
      await onLogin(form);
    } catch (submitError) {
      setError(submitError.message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <section className="login-shell">
      <div className="login-card">
        <BrandLogo
          className="login-brand"
          title={branding?.institution_name || 'UMLA'}
          subtitle={branding?.subtitle || 'Plataforma académica'}
          brandColor={branding?.brand_color || '#d96c3f'}
          logoPath={branding?.logo_path || ''}
          useDefaultCandidates={false}
        />

        <form className="login-form" onSubmit={handleSubmit}>
          <label>
            Correo
            <input
              type="email"
              value={form.email}
              onChange={(event) => setForm((current) => ({ ...current, email: event.target.value }))}
            />
          </label>

          <label>
            Contraseña
            <input
              type="password"
              value={form.password}
              onChange={(event) => setForm((current) => ({ ...current, password: event.target.value }))}
            />
          </label>

          {error ? <p className="form-error">{error}</p> : null}

          <button className="submit-button" type="submit" disabled={loading}>
            {loading ? 'Ingresando...' : 'Entrar'}
          </button>
        </form>
      </div>
    </section>
  );
}