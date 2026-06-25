import { ImagePlus, Save, Trash2 } from 'lucide-react';
import { useEffect, useState } from 'react';

function emptyForm() {
  return {
    institution_name: '',
    subtitle: '',
    brand_color: '#d96c3f',
    logo: null,
    remove_logo: false,
  };
}

export function InstitutionSettingsView({ dataController, branding, onBrandingChange, permissions }) {
  const [form, setForm] = useState(emptyForm());
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const canEdit = permissions.includes('edit');

  useEffect(() => {
    let isMounted = true;

    async function loadBranding() {
      setLoading(true);
      setError('');
      try {
        const payload = await dataController.getAdminBranding();
        if (!isMounted) {
          return;
        }

        setForm({
          institution_name: payload.institution_name || '',
          subtitle: payload.subtitle || '',
          brand_color: payload.brand_color || '#d96c3f',
          logo: null,
          remove_logo: false,
        });
      } catch (loadError) {
        if (isMounted) {
          setError(loadError.message);
        }
      } finally {
        if (isMounted) {
          setLoading(false);
        }
      }
    }

    loadBranding();

    return () => {
      isMounted = false;
    };
  }, [dataController]);

  useEffect(() => {
    if (message || error) {
      const timer = setTimeout(() => {
        setMessage('');
        setError('');
      }, 5000);
      return () => clearTimeout(timer);
    }
  }, [message, error]);

  async function handleSubmit(event) {
    event.preventDefault();
    setSaving(true);
    setMessage('');
    setError('');

    try {
      const payload = await dataController.updateAdminBranding(form);
      setMessage('Configuración institucional actualizada.');
      setForm((current) => ({
        ...current,
        institution_name: payload.institution_name || '',
        subtitle: payload.subtitle || '',
        brand_color: payload.brand_color || '#d96c3f',
        logo: null,
        remove_logo: false,
      }));
      onBrandingChange(payload);
    } catch (submitError) {
      setError(submitError.message);
    } finally {
      setSaving(false);
    }
  }

  if (loading) {
    return <section className="empty-state">Cargando configuración institucional...</section>;
  }

  return (
    <section className="admin-panel institution-panel">
      <article className="info-card institution-card">
        <div className="admin-section-header">
          <h3>Identidad institucional</h3>
          <p>Actualiza el nombre visible, el subtítulo y el logotipo utilizado en login y sidebar.</p>
        </div>

        <div className="institution-preview">
          <div className="institution-preview-copy">
            <strong>{branding?.institution_name || form.institution_name || 'UMLA'}</strong>
            <span>{branding?.subtitle || form.subtitle || 'Plataforma académica'}</span>
          </div>
          <div className="institution-color-chip" style={{ backgroundColor: form.brand_color || '#d96c3f' }}>
            <span>{form.brand_color || '#d96c3f'}</span>
          </div>
          {branding?.logo_path ? (
            <img className="institution-preview-image" src={branding.logo_path} alt="Logo institucional actual" />
          ) : (
            <div className="institution-preview-fallback">Sin logo</div>
          )}
        </div>

        <form className="admin-form institution-form" onSubmit={handleSubmit}>
          <label>
            Nombre de la institución
            <input
              value={form.institution_name}
              onChange={(event) => setForm((current) => ({ ...current, institution_name: event.target.value }))}
              disabled={!canEdit || saving}
            />
          </label>

          <label>
            Subtítulo
            <input
              value={form.subtitle}
              onChange={(event) => setForm((current) => ({ ...current, subtitle: event.target.value }))}
              disabled={!canEdit || saving}
            />
          </label>

          <label>
            Color institucional
            <div className="institution-color-field">
              <input
                className="institution-color-picker"
                type="color"
                value={form.brand_color || '#d96c3f'}
                onChange={(event) => setForm((current) => ({ ...current, brand_color: event.target.value }))}
                disabled={!canEdit || saving}
              />
              <input
                value={form.brand_color || '#d96c3f'}
                onChange={(event) => setForm((current) => ({ ...current, brand_color: event.target.value }))}
                disabled={!canEdit || saving}
              />
            </div>
          </label>

          <label>
            Logotipo
            <div className="institution-upload-shell">
              <ImagePlus size={18} />
              <input
                type="file"
                accept=".png,.jpg,.jpeg,.svg,.webp"
                onChange={(event) => setForm((current) => ({ ...current, logo: event.target.files?.[0] || null, remove_logo: false }))}
                disabled={!canEdit || saving}
              />
            </div>
          </label>

          <div className="form-actions">
            {canEdit ? (
              <>
                <button className="submit-button icon-button" type="submit" disabled={saving}>
                  <Save size={16} />
                  <span>{saving ? 'Guardando...' : 'Guardar cambios'}</span>
                </button>
                <button
                  className="inline-button danger icon-button"
                  type="button"
                  disabled={saving}
                  onClick={() => setForm((current) => ({ ...current, logo: null, remove_logo: true }))}
                >
                  <Trash2 size={15} />
                  <span>Quitar logo</span>
                </button>
              </>
            ) : null}
          </div>

          {message ? <p className="admin-message is-success">{message}</p> : null}
          {error ? <p className="admin-message is-error">{error}</p> : null}
        </form>
      </article>
    </section>
  );
}