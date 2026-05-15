import { useEffect, useMemo, useState } from 'react';

import { PermissionAdminSection } from './admin/PermissionAdminSection';
import { RolesAdminSection } from './admin/RolesAdminSection';
import { UsersAdminSection } from './admin/UsersAdminSection';

function emptyModule() {
  return { id: null, name: '', slug: '', icon: '', description: '', sort_order: 0, is_active: true };
}

function emptyModuleView(moduleId = '') {
  return { id: null, module_id: moduleId, name: '', slug: '', route: '', component: '', description: '', sort_order: 0, is_active: true };
}

function SectionHeader({ title, copy }) {
  return (
    <div className="admin-section-header">
      <h3>{title}</h3>
      <p>{copy}</p>
    </div>
  );
}

function DataTable({ columns, rows, renderRow, shellClassName = '', tableClassName = '' }) {
  return (
    <div className={`table-shell ${shellClassName}`.trim()}>
      <table className={`data-table ${tableClassName}`.trim()}>
        <thead>
          <tr>
            {columns.map((column) => (
              <th key={column}>{column}</th>
            ))}
          </tr>
        </thead>
        <tbody>{rows.map(renderRow)}</tbody>
      </table>
    </div>
  );
}

function MessageBar({ message, error }) {
  if (!message && !error) {
    return null;
  }

  return <p className={`admin-message ${error ? 'is-error' : 'is-success'}`}>{error || message}</p>;
}

export function AdminCrudView({ moduleSlug, adminViewSlug, dataController, permissions }) {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');
  const [boot, setBoot] = useState({ users: [], roles: [], permissions: [], modules: [] });
  const [moduleForm, setModuleForm] = useState(emptyModule());
  const [viewForm, setViewForm] = useState(emptyModuleView());
  const [selectedModuleId, setSelectedModuleId] = useState(null);

  useEffect(() => {
    let isMounted = true;

    async function loadBootstrap() {
      setLoading(true);
      setError('');
      try {
        const payload = await dataController.getAdminBootstrap();
        if (!isMounted) {
          return;
        }

        setBoot(payload);
        setSelectedModuleId((current) => current || payload.modules[0]?.id || null);
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

    loadBootstrap();

    return () => {
      isMounted = false;
    };
  }, [dataController]);

  const selectedModule = useMemo(() => boot.modules.find((module) => module.id === selectedModuleId) || null, [boot.modules, selectedModuleId]);

  useEffect(() => {
    if (selectedModuleId && viewForm.module_id !== selectedModuleId) {
      setViewForm(emptyModuleView(selectedModuleId));
    }
  }, [selectedModuleId]);

  async function reloadBootstrap(messageText = '') {
    const payload = await dataController.getAdminBootstrap();
    setBoot(payload);
    setMessage(messageText);
    setError('');
  }

  async function runAction(action, successMessage) {
    setMessage('');
    setError('');
    try {
      await action();
      await reloadBootstrap(successMessage);
    } catch (actionError) {
      setError(actionError.message);
    }
  }

  async function submitModule(event) {
    event.preventDefault();
    await runAction(async () => {
      if (moduleForm.id) {
        await dataController.updateModule(moduleForm.id, moduleForm);
      } else {
        await dataController.createModule(moduleForm);
      }
      setModuleForm(emptyModule());
    }, moduleForm.id ? 'Módulo actualizado.' : 'Módulo creado.');
  }

  async function submitModuleView(event) {
    event.preventDefault();
    await runAction(async () => {
      if (viewForm.id) {
        await dataController.updateModuleView(viewForm.id, viewForm);
      } else {
        await dataController.createModuleView(viewForm.module_id, viewForm);
      }
      setViewForm(emptyModuleView(selectedModuleId || ''));
    }, viewForm.id ? 'Vista actualizada.' : 'Vista creada.');
  }

  if (loading) {
    return <section className="empty-state">Cargando panel administrativo...</section>;
  }

  if (error && !boot.roles.length && !boot.modules.length && !boot.users.length) {
    return <section className="empty-state">{error}</section>;
  }

  return (
    <section className="admin-panel">
      <MessageBar message={message} error={error} />

      {(moduleSlug === 'usuarios' || (moduleSlug === 'configuracion' && adminViewSlug === 'usuario')) ? (
        <UsersAdminSection
          users={boot.users}
          roles={boot.roles}
          dataController={dataController}
          runAction={runAction}
        />
      ) : null}

      {(moduleSlug === 'roles' || (moduleSlug === 'configuracion' && adminViewSlug === 'rol')) ? (
        adminViewSlug === 'permisos' ? (
          <PermissionAdminSection
            permissionCatalog={boot.permissions}
            grantedPermissions={permissions}
            dataController={dataController}
            runAction={runAction}
          />
        ) : (
          <RolesAdminSection
            roles={boot.roles}
            permissionCatalog={boot.permissions}
            modules={boot.modules}
            grantedPermissions={permissions}
            dataController={dataController}
            runAction={runAction}
          />
        )
      ) : null}

      {(moduleSlug === 'modulos' || (moduleSlug === 'configuracion' && adminViewSlug === 'modulos')) ? (
        <div className="admin-grid two-columns">
          <article className="info-card admin-card">
            <SectionHeader title="Módulos" copy="CRUD del catálogo de módulos visibles en navegación." />
            <DataTable
              columns={['Módulo', 'Slug', 'Orden', 'Acciones']}
              rows={boot.modules}
              renderRow={(module) => (
                <tr key={module.id} className={selectedModuleId === module.id ? 'row-selected' : ''}>
                  <td>{module.name}</td>
                  <td>{module.slug}</td>
                  <td>{module.sort_order}</td>
                  <td className="row-actions">
                    <button className="inline-button" onClick={() => { setSelectedModuleId(module.id); setModuleForm(module); }}>Editar</button>
                    <button className="inline-button" onClick={() => setSelectedModuleId(module.id)}>Vistas</button>
                    <button className="inline-button danger" onClick={() => runAction(() => dataController.deleteModule(module.id), 'Módulo eliminado.')}>Eliminar</button>
                  </td>
                </tr>
              )}
            />
            <form className="admin-form" onSubmit={submitModule}>
              <label>Nombre<input value={moduleForm.name} onChange={(event) => setModuleForm((current) => ({ ...current, name: event.target.value }))} /></label>
              <label>Slug<input value={moduleForm.slug} onChange={(event) => setModuleForm((current) => ({ ...current, slug: event.target.value }))} /></label>
              <label>Icono<input value={moduleForm.icon || ''} onChange={(event) => setModuleForm((current) => ({ ...current, icon: event.target.value }))} /></label>
              <label>Descripción<input value={moduleForm.description || ''} onChange={(event) => setModuleForm((current) => ({ ...current, description: event.target.value }))} /></label>
              <label>Orden<input type="number" value={moduleForm.sort_order} onChange={(event) => setModuleForm((current) => ({ ...current, sort_order: Number(event.target.value) }))} /></label>
              <label className="checkbox-pill"><input type="checkbox" checked={moduleForm.is_active} onChange={(event) => setModuleForm((current) => ({ ...current, is_active: event.target.checked }))} /><span>Activo</span></label>
              <div className="form-actions">
                <button className="submit-button" type="submit">{moduleForm.id ? 'Actualizar' : 'Crear'}</button>
                <button className="inline-button" type="button" onClick={() => setModuleForm(emptyModule())}>Limpiar</button>
              </div>
            </form>
          </article>

          <article className="info-card admin-card">
            <SectionHeader title="Vistas por módulo" copy={selectedModule ? `CRUD de vistas internas para ${selectedModule.name}.` : 'Selecciona un módulo.'} />
            {selectedModule ? (
              <>
                <DataTable
                  columns={['Vista', 'Ruta', 'Orden', 'Acciones']}
                  rows={selectedModule.views}
                  renderRow={(view) => (
                    <tr key={view.id}>
                      <td>{view.name}</td>
                      <td>{view.route}</td>
                      <td>{view.sort_order}</td>
                      <td className="row-actions">
                        <button className="inline-button" onClick={() => setViewForm(view)}>Editar</button>
                        <button className="inline-button danger" onClick={() => runAction(() => dataController.deleteModuleView(view.id), 'Vista eliminada.')}>Eliminar</button>
                      </td>
                    </tr>
                  )}
                />
                <form className="admin-form" onSubmit={submitModuleView}>
                  <label>Nombre<input value={viewForm.name} onChange={(event) => setViewForm((current) => ({ ...current, name: event.target.value }))} /></label>
                  <label>Slug<input value={viewForm.slug} onChange={(event) => setViewForm((current) => ({ ...current, slug: event.target.value, module_id: selectedModule.id }))} /></label>
                  <label>Ruta<input value={viewForm.route} onChange={(event) => setViewForm((current) => ({ ...current, route: event.target.value, module_id: selectedModule.id }))} /></label>
                  <label>Componente<input value={viewForm.component || ''} onChange={(event) => setViewForm((current) => ({ ...current, component: event.target.value, module_id: selectedModule.id }))} /></label>
                  <label>Descripción<input value={viewForm.description || ''} onChange={(event) => setViewForm((current) => ({ ...current, description: event.target.value, module_id: selectedModule.id }))} /></label>
                  <label>Orden<input type="number" value={viewForm.sort_order} onChange={(event) => setViewForm((current) => ({ ...current, sort_order: Number(event.target.value), module_id: selectedModule.id }))} /></label>
                  <label className="checkbox-pill"><input type="checkbox" checked={viewForm.is_active} onChange={(event) => setViewForm((current) => ({ ...current, is_active: event.target.checked, module_id: selectedModule.id }))} /><span>Activa</span></label>
                  <div className="form-actions">
                    <button className="submit-button" type="submit">{viewForm.id ? 'Actualizar vista' : 'Crear vista'}</button>
                    <button className="inline-button" type="button" onClick={() => setViewForm(emptyModuleView(selectedModule.id))}>Limpiar</button>
                  </div>
                </form>
              </>
            ) : (
              <p>No hay módulos disponibles.</p>
            )}
          </article>
        </div>
      ) : null}
    </section>
  );
}
