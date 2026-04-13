import { Eraser, PencilLine, Plus, Save, ShieldCheck, Trash2 } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

import { AdminDataGrid } from './AdminDataGrid';

// Estado base para altas o reinicios del formulario de roles.
function emptyRole() {
  return { id: null, name: '', slug: '', description: '' };
}

// Unifica la experiencia visual y operativa del modulo de roles con el patron de usuarios.
export function RolesAdminSection({ roles, permissionCatalog, modules, grantedPermissions, dataController, runAction }) {
  const [selectedRoleId, setSelectedRoleId] = useState(null);
  const [roleForm, setRoleForm] = useState(emptyRole());
  const [accessDraft, setAccessDraft] = useState({ module_ids: [], view_permissions: {} });
  const [roleModalOpen, setRoleModalOpen] = useState(false);
  const [accessModalOpen, setAccessModalOpen] = useState(false);

  const selectedRole = useMemo(() => roles.find((role) => role.id === selectedRoleId) || null, [roles, selectedRoleId]);

  useEffect(() => {
    if (!selectedRole && roles.length > 0) {
      setSelectedRoleId(roles[0].id);
    }
  }, [roles, selectedRole]);

  useEffect(() => {
    if (!selectedRole) {
      setAccessDraft({ module_ids: [], view_permissions: {} });
      setRoleModalOpen(false);
      setAccessModalOpen(false);
      return;
    }

    setAccessDraft({
      module_ids: selectedRole.module_ids || [],
      view_permissions: selectedRole.view_permissions || {},
    });
  }, [selectedRole]);

  // Prepara una modal limpia para registrar un rol nuevo.
  function openCreateRoleModal() {
    setRoleForm(emptyRole());
    setRoleModalOpen(true);
  }

  // Carga el rol seleccionado dentro de la modal para editarlo.
  function openEditRoleModal(role) {
    setSelectedRoleId(role.id);
    setRoleForm(role);
    setRoleModalOpen(true);
  }

  // Restablece la modal del rol para el siguiente uso.
  function closeRoleModal() {
    setRoleModalOpen(false);
    setRoleForm(emptyRole());
  }

  // Abre la modal de acceso reutilizando el borrador del rol actualmente seleccionado.
  function openAccessModal() {
    if (!selectedRole) {
      return;
    }

    setAccessDraft({
      module_ids: selectedRole.module_ids || [],
      view_permissions: selectedRole.view_permissions || {},
    });
    setAccessModalOpen(true);
  }

  // Cierra la modal de matriz sin perder la fila activa dentro del grid.
  function closeAccessModal() {
    setAccessModalOpen(false);
  }

  // Persiste la alta o edicion del rol y refresca el bootstrap externo.
  async function submitRole(event) {
    event.preventDefault();

    await runAction(async () => {
      if (roleForm.id) {
        await dataController.updateRole(roleForm.id, roleForm);
      } else {
        await dataController.createRole(roleForm);
      }

      setRoleModalOpen(false);
      setRoleForm(emptyRole());
    }, roleForm.id ? 'Rol actualizado.' : 'Rol creado.');
  }

  // Elimina el rol activo y limpia la seleccion para evitar referencias obsoletas.
  async function deleteSelectedRole() {
    if (!selectedRole) {
      return;
    }

    await runAction(async () => {
      await dataController.deleteRole(selectedRole.id);
      setSelectedRoleId(null);
    }, 'Rol eliminado.');
  }

  // Agrega o quita modulos del borrador de acceso del rol activo.
  function toggleModuleForRole(moduleId) {
    setAccessDraft((current) => ({
      ...current,
      module_ids: current.module_ids.includes(moduleId)
        ? current.module_ids.filter((currentModuleId) => currentModuleId !== moduleId)
        : [...current.module_ids, moduleId],
    }));
  }

  // Agrega o quita permisos por vista dentro del borrador de acceso.
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

  // Sincroniza la matriz de acceso del rol activo con el backend.
  async function saveRoleAccess() {
    if (!selectedRoleId) {
      return;
    }

    await runAction(async () => {
      await dataController.syncRoleAccess(selectedRoleId, accessDraft);
      setAccessModalOpen(false);
    }, 'Acceso del rol actualizado.');
  }

  return (
    <>
      <div className="admin-grid">
        <AdminDataGrid
          title="Roles"
          copy="Alta, edicion y control de roles funcionales."
          rows={roles}
          pageSize={8}
          searchableFields={['name', 'slug', 'description']}
          getRowId={(role) => role.id}
          selectedRowId={selectedRoleId}
          onSelectionChange={(role) => setSelectedRoleId(role?.id || null)}
          searchPlaceholder="Buscar por nombre, slug o descripcion..."
          shellClassName="users-table-shell"
          tableClassName="users-table"
          colorScheme={{
            rowOddBg: 'rgba(255, 250, 244, 0.18)',
            rowEvenBg: 'rgba(232, 243, 242, 0.42)',
            rowHoverBg: 'rgba(22, 122, 127, 0.1)',
            rowSelectedBg: 'rgba(217, 108, 63, 0.18)',
          }}
          columns={[
            {
              key: 'name',
              label: 'Rol',
              render: (role) => (
                <div className="users-name-cell">
                  <strong>{role.name}</strong>
                  <span>{role.description || 'Sin descripcion'}</span>
                </div>
              ),
            },
            {
              key: 'slug',
              label: 'Slug',
              render: (role) => <span className="grid-code-pill">{role.slug}</span>,
            },
          ]}
          renderActions={() => (
            <>
              <div className="users-selection-pill">
                {selectedRole ? `Seleccionado: ${selectedRole.name}` : 'Selecciona un rol de la lista'}
              </div>
              <div className="users-toolbar-actions">
                <button className="submit-button icon-button" type="button" onClick={openCreateRoleModal}>
                  <Plus size={15} />
                  <span>Nuevo</span>
                </button>
                <button className="inline-button icon-button" type="button" disabled={!selectedRole} onClick={() => selectedRole && openEditRoleModal(selectedRole)}>
                  <PencilLine size={15} />
                  <span>Editar</span>
                </button>
                <button className="inline-button icon-button" type="button" disabled={!selectedRole} onClick={openAccessModal}>
                  <ShieldCheck size={15} />
                  <span>Acceso</span>
                </button>
                <button className="inline-button danger icon-button" type="button" disabled={!selectedRole} onClick={deleteSelectedRole}>
                  <Trash2 size={15} />
                  <span>Eliminar</span>
                </button>
              </div>
            </>
          )}
        />
      </div>

      {roleModalOpen ? (
        <div className="modal-backdrop" onClick={closeRoleModal}>
          <article className="modal-card roles-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Gestion de roles</p>
                <h3>{roleForm.id ? 'Editar rol' : 'Nuevo rol'}</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closeRoleModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>
            <form className="admin-form roles-modal-form" onSubmit={submitRole}>
              <p className="roles-modal-copy">Define los datos base del rol. La matriz de acceso se configura desde la modal de acceso.</p>
              <label>
                Nombre
                <input value={roleForm.name} onChange={(event) => setRoleForm((current) => ({ ...current, name: event.target.value }))} />
              </label>
              <label>
                Slug
                <input value={roleForm.slug} onChange={(event) => setRoleForm((current) => ({ ...current, slug: event.target.value }))} />
              </label>
              <label>
                Descripcion
                <input value={roleForm.description || ''} onChange={(event) => setRoleForm((current) => ({ ...current, description: event.target.value }))} />
              </label>
              <div className="form-actions">
                <button className="submit-button icon-button" type="submit"><Save size={16} /><span>{roleForm.id ? 'Actualizar' : 'Crear'}</span></button>
                <button className="inline-button icon-button" type="button" onClick={closeRoleModal}><Eraser size={15} /><span>Cancelar</span></button>
              </div>
            </form>
          </article>
        </div>
      ) : null}

      {accessModalOpen && selectedRole ? (
        <div className="modal-backdrop" onClick={closeAccessModal}>
          <article className="modal-card roles-modal-card access-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Matriz de acceso</p>
                <h3>Accesos de {selectedRole.name}</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closeAccessModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>

            <AdminDataGrid
              title="Matriz de acceso"
              copy={`Configura modulos y privilegios para ${selectedRole.name}.`}
              rows={modules}
              pageSize={6}
              searchableFields={[
                'name',
                (module) => (module.views || []).map((view) => `${view.name} ${view.route}`).join(' '),
              ]}
              filters={[
                {
                  key: 'assignment',
                  label: 'Estado',
                  options: [
                    { value: '', label: 'Todos' },
                    { value: 'assigned', label: 'Asignados' },
                    { value: 'unassigned', label: 'No asignados' },
                  ],
                  matches: (module, value) => value === 'assigned'
                    ? accessDraft.module_ids.includes(module.id)
                    : !accessDraft.module_ids.includes(module.id),
                },
              ]}
              getRowId={(module) => module.id}
              searchPlaceholder="Buscar por modulo, vista o ruta..."
              shellClassName="users-table-shell access-grid-shell"
              tableClassName="users-table access-grid-table"
              colorScheme={{
                rowOddBg: 'rgba(255, 250, 244, 0.18)',
                rowEvenBg: 'rgba(232, 243, 242, 0.42)',
                rowHoverBg: 'rgba(22, 122, 127, 0.1)',
                rowSelectedBg: 'rgba(217, 108, 63, 0.18)',
              }}
              columns={[
                {
                  key: 'module',
                  label: 'Modulo',
                  render: (module) => (
                    <div className="access-module-cell">
                      <label className="checkbox-pill access-module-toggle" onClick={(event) => event.stopPropagation()}>
                        <input type="checkbox" checked={accessDraft.module_ids.includes(module.id)} onChange={() => toggleModuleForRole(module.id)} />
                        <span>Activo</span>
                      </label>
                      <div className="users-name-cell">
                        <strong>{module.name}</strong>
                        <span>{module.slug}</span>
                      </div>
                    </div>
                  ),
                },
                {
                  key: 'views',
                  label: 'Vistas y permisos',
                  render: (module) => (
                    <div className="matrix-list access-grid-matrix-list">
                      {(module.views || []).map((view) => (
                        <div key={view.id} className="matrix-view-row access-grid-view-row">
                          <div>
                            <span>{view.name}</span>
                            <small>{view.route}</small>
                          </div>
                          <div className="checkbox-grid inline-grid" onClick={(event) => event.stopPropagation()}>
                            {permissionCatalog.map((permission) => (
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
                    </div>
                  ),
                },
              ]}
              renderActions={() => (
                <>
                  <div className="users-selection-pill">Rol activo: {selectedRole.name}</div>
                  <div className="users-toolbar-actions">
                    <button className="submit-button icon-button" type="button" onClick={saveRoleAccess} disabled={!grantedPermissions.includes('assign')}>
                      <ShieldCheck size={16} />
                      <span>Guardar acceso</span>
                    </button>
                  </div>
                </>
              )}
            />
          </article>
        </div>
      ) : null}
    </>
  );
}