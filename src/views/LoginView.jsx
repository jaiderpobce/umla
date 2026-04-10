import { useState } from 'react';

export function LoginView({ onLogin }) {
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
        <p className="eyebrow">Laravel + React + MariaDB</p>
        <h1>Acceso UMLA</h1>
        <p>Inicia sesión para cargar los módulos visibles según el rol asignado en la base de datos.</p>

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