import { useEffect, useMemo, useState } from 'react';

function emptyUser() {
  return { id: null, name: '', email: '', password: '', role_ids: [] };
}

function emptyRole() {
  return { id: null, name: '', slug: '', description: '' };
}

function emptyPermission() {
  return { id: null, name: '', slug: '', description: '' };
}

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

function DataTable({ columns, rows, renderRow }) {
  return (
    <div className="table-shell">
      <table className="data-table">
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

export function AdminCrudView({ moduleSlug, dataController, permissions }) {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');
  const [boot, setBoot] = useState({ users: [], roles: [], permissions: [], modules: [] });
  const [userForm, setUserForm] = useState(emptyUser());
  const [roleForm, setRoleForm] = useState(emptyRole());
  const [permissionForm, setPermissionForm] = useState(emptyPermission());
  const [moduleForm, setModuleForm] = useState(emptyModule());
  const [viewForm, setViewForm] = useState(emptyModuleView());
  const [selectedRoleId, setSelectedRoleId] = useState(null);
  const [accessDraft, setAccessDraft] = useState({ module_ids: [], view_permissions: {} });
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
        setSelectedRoleId((current) => current || payload.roles[0]?.id || null);
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

  const selectedRole = useMemo(() => boot.roles.find((role) => role.id === selectedRoleId) || null, [boot.roles, selectedRoleId]);
  const selectedModule = useMemo(() => boot.modules.find((module) => module.id === selectedModuleId) || null, [boot.modules, selectedModuleId]);

  useEffect(() => {
    if (!selectedRole) {
      setAccessDraft({ module_ids: [], view_permissions: {} });
      return;
    }

    setAccessDraft({
      module_ids: selectedRole.module_ids || [],
      view_permissions: selectedRole.view_permissions || {},
    });
  }, [selectedRole]);

  useEffect(() => {
    if (selectedModuleId && viewForm.module_id !== selectedModuleId) {
      setViewForm(emptyModuleView(selectedModuleId));
    }
  }, [selectedModuleId]);

  function replaceCollection(key, value) {
    setBoot((current) => ({ ...current, [key]: value }));
  }

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

  async function submitUser(event) {
    event.preventDefault();
    await runAction(async () => {
      if (userForm.id) {
        await dataController.updateUser(userForm.id, userForm);
      } else {
        await dataController.createUser(userForm);
      }
      setUserForm(emptyUser());
    }, userForm.id ? 'Usuario actualizado.' : 'Usuario creado.');
  }

  async function submitRole(event) {
    event.preventDefault();
    await runAction(async () => {
      if (roleForm.id) {
        await dataController.updateRole(roleForm.id, roleForm);
      } else {
        await dataController.createRole(roleForm);
      }
      setRoleForm(emptyRole());
    }, roleForm.id ? 'Rol actualizado.' : 'Rol creado.');
  }

  async function submitPermission(event) {
    event.preventDefault();
    await runAction(async () => {
      if (permissionForm.id) {
        await dataController.updatePermission(permissionForm.id, permissionForm);
      } else {
        await dataController.createPermission(permissionForm);
      }
      setPermissionForm(emptyPermission());
    }, permissionForm.id ? 'Permiso actualizado.' : 'Permiso creado.');
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

  async function saveRoleAccess() {
    if (!selectedRoleId) {
      return;
    }

    await runAction(async () => {
      await dataController.syncRoleAccess(selectedRoleId, accessDraft);
    }, 'Acceso del rol actualizado.');
  }

  function toggleRoleForUser(roleId) {
    setUserForm((current) => ({
      ...current,
      role_ids: current.role_ids.includes(roleId)
        ? current.role_ids.filter((currentRoleId) => currentRoleId !== roleId)
        : [...current.role_ids, roleId],
    }));
  }

  function toggleModuleForRole(moduleId) {
    setAccessDraft((current) => ({
      ...current,
      module_ids: current.module_ids.includes(moduleId)
        ? current.module_ids.filter((currentModuleId) => currentModuleId !== moduleId)
        : [...current.module_ids, moduleId],
    }));
  }

  function togglePermissionForView(viewId, permissionId) {
    setAccessDraft((current) => {
      const currentViewPermissions = current.view_permissions[viewId] || [];
      const nextPermissions = currentViewPermissions.includes(permissionId)
        ? currentViewPermissions.filter((currentPermissionId) => currentPermissionId !== permissionId)
        : [...currentViewPermissions, permissionId];

      return {
        ...current,
        view_permissions: {
          ...current.view_permissions,
          [viewId]: nextPermissions,
        },
      };
    });
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

      {moduleSlug === 'usuarios' ? (
        <div className="admin-grid two-columns">
          <article className="info-card admin-card">
            <SectionHeader title="Usuarios" copy="CRUD real sobre cuentas y asignación de roles." />
            <DataTable
              columns={['Nombre', 'Correo', 'Roles', 'Acciones']}
              rows={boot.users}
              renderRow={(user) => (
                <tr key={user.id}>
                  <td>{user.name}</td>
                  <td>{user.email}</td>
                  <td>{(user.roles || []).map((role) => role.name).join(', ')}</td>
                  <td className="row-actions">
                    <button className="inline-button" onClick={() => setUserForm({ ...user, password: '', role_ids: user.role_ids || [] })}>Editar</button>
                    <button className="inline-button danger" onClick={() => runAction(() => dataController.deleteUser(user.id), 'Usuario eliminado.')}>Eliminar</button>
                  </td>
                </tr>
              )}
            />
          </article>

          <article className="info-card admin-card">
            <SectionHeader title={userForm.id ? 'Editar usuario' : 'Nuevo usuario'} copy="Si no cambias la contraseña en edición, déjala vacía." />
            <form className="admin-form" onSubmit={submitUser}>
              <label>
                Nombre
                <input value={userForm.name} onChange={(event) => setUserForm((current) => ({ ...current, name: event.target.value }))} />
              </label>
              <label>
                Correo
                <input type="email" value={userForm.email} onChange={(event) => setUserForm((current) => ({ ...current, email: event.target.value }))} />
              </label>
              <label>
                Contraseña
                <input type="password" value={userForm.password} onChange={(event) => setUserForm((current) => ({ ...current, password: event.target.value }))} />
              </label>
              <div>
                <span className="field-label">Roles</span>
                <div className="checkbox-grid">
                  {boot.roles.map((role) => (
                    <label key={role.id} className="checkbox-pill">
                      <input type="checkbox" checked={userForm.role_ids.includes(role.id)} onChange={() => toggleRoleForUser(role.id)} />
                      <span>{role.name}</span>
                    </label>
                  ))}
                </div>
              </div>
              <div className="form-actions">
                <button className="submit-button" type="submit">{userForm.id ? 'Actualizar' : 'Crear'}</button>
                <button className="inline-button" type="button" onClick={() => setUserForm(emptyUser())}>Limpiar</button>
              </div>
            </form>
          </article>
        </div>
      ) : null}

      {moduleSlug === 'roles' ? (
        <div className="admin-grid three-columns">
          <article className="info-card admin-card">
            <SectionHeader title="Roles" copy="Alta, edición y control de roles funcionales." />
            <DataTable
              columns={['Rol', 'Slug', 'Acciones']}
              rows={boot.roles}
              renderRow={(role) => (
                <tr key={role.id} className={selectedRoleId === role.id ? 'row-selected' : ''}>
                  <td>{role.name}</td>
                  <td>{role.slug}</td>
                  <td className="row-actions">
                    <button className="inline-button" onClick={() => { setSelectedRoleId(role.id); setRoleForm(role); }}>Editar</button>
                    <button className="inline-button" onClick={() => setSelectedRoleId(role.id)}>Acceso</button>
                    <button className="inline-button danger" onClick={() => runAction(() => dataController.deleteRole(role.id), 'Rol eliminado.')}>Eliminar</button>
                  </td>
                </tr>
              )}
            />
            <form className="admin-form compact-form" onSubmit={submitRole}>
              <input placeholder="Nombre" value={roleForm.name} onChange={(event) => setRoleForm((current) => ({ ...current, name: event.target.value }))} />
              <input placeholder="Slug" value={roleForm.slug} onChange={(event) => setRoleForm((current) => ({ ...current, slug: event.target.value }))} />
              <input placeholder="Descripción" value={roleForm.description || ''} onChange={(event) => setRoleForm((current) => ({ ...current, description: event.target.value }))} />
              <div className="form-actions">
                <button className="submit-button" type="submit">{roleForm.id ? 'Actualizar' : 'Crear'}</button>
                <button className="inline-button" type="button" onClick={() => setRoleForm(emptyRole())}>Limpiar</button>
              </div>
            </form>
          </article>

          <article className="info-card admin-card">
            <SectionHeader title="Permisos" copy="CRUD de privilegios reutilizables por vista." />
            <DataTable
              columns={['Permiso', 'Slug', 'Acciones']}
              rows={boot.permissions}
              renderRow={(permission) => (
                <tr key={permission.id}>
                  <td>{permission.name}</td>
                  <td>{permission.slug}</td>
                  <td className="row-actions">
                    <button className="inline-button" onClick={() => setPermissionForm(permission)}>Editar</button>
                    <button className="inline-button danger" onClick={() => runAction(() => dataController.deletePermission(permission.id), 'Permiso eliminado.')}>Eliminar</button>
                  </td>
                </tr>
              )}
            />
            <form className="admin-form compact-form" onSubmit={submitPermission}>
              <input placeholder="Nombre" value={permissionForm.name} onChange={(event) => setPermissionForm((current) => ({ ...current, name: event.target.value }))} />
              <input placeholder="Slug" value={permissionForm.slug} onChange={(event) => setPermissionForm((current) => ({ ...current, slug: event.target.value }))} />
              <input placeholder="Descripción" value={permissionForm.description || ''} onChange={(event) => setPermissionForm((current) => ({ ...current, description: event.target.value }))} />
              <div className="form-actions">
                <button className="submit-button" type="submit">{permissionForm.id ? 'Actualizar' : 'Crear'}</button>
                <button className="inline-button" type="button" onClick={() => setPermissionForm(emptyPermission())}>Limpiar</button>
              </div>
            </form>
          </article>

          <article className="info-card admin-card">
            <SectionHeader title="Matriz de acceso" copy={selectedRole ? `Configura módulos y privilegios para ${selectedRole.name}.` : 'Selecciona un rol.'} />
            {selectedRole ? (
              <div className="access-matrix">
                <div className="checkbox-grid">
                  {boot.modules.map((module) => (
                    <label key={module.id} className="checkbox-pill">
                      <input type="checkbox" checked={accessDraft.module_ids.includes(module.id)} onChange={() => toggleModuleForRole(module.id)} />
                      <span>{module.name}</span>
                    </label>
                  ))}
                </div>
                <div className="matrix-list">
                  {boot.modules.map((module) => (
                    <article key={module.id} className="matrix-card">
                      <strong>{module.name}</strong>
                      {module.views.map((view) => (
                        <div key={view.id} className="matrix-view-row">
                          <div>
                            <span>{view.name}</span>
                            <small>{view.route}</small>
                          </div>
                          <div className="checkbox-grid inline-grid">
                            {boot.permissions.map((permission) => (
                              <label key={permission.id} className="checkbox-pill slim">
                                <input
                                  type="checkbox"
                                  checked={(accessDraft.view_permissions[view.id] || []).includes(permission.id)}
                                  onChange={() => togglePermissionForView(view.id, permission.id)}
                                />
                                <span>{permission.slug}</span>
                              </label>
                            ))}
                          </div>
                        </div>
                      ))}
                    </article>
                  ))}
                </div>
                <button className="submit-button" type="button" onClick={saveRoleAccess} disabled={!permissions.includes('assign')}>Guardar acceso</button>
              </div>
            ) : (
              <p>No hay roles disponibles.</p>
            )}
          </article>
        </div>
      ) : null}

      {moduleSlug === 'modulos' ? (
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
