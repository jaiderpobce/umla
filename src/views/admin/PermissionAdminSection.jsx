import { Eraser, PencilLine, Plus, Save, Trash2 } from 'lucide-react';
import { useMemo, useState } from 'react';

import { AdminDataGrid } from './AdminDataGrid';

// Estado base para altas o reinicios del formulario de permisos.
function emptyPermission() {
  return { id: null, name: '', slug: '', description: '' };
}

// Pantalla independiente para administrar permisos con el mismo patron visual del panel.
export function PermissionAdminSection({ permissionCatalog, dataController, runAction, grantedPermissions = [] }) {
  const [selectedPermissionId, setSelectedPermissionId] = useState(null);
  const [permissionForm, setPermissionForm] = useState(emptyPermission());
  const [permissionModalOpen, setPermissionModalOpen] = useState(false);

  const selectedPermission = useMemo(
    () => permissionCatalog.find((permission) => permission.id === selectedPermissionId) || null,
    [permissionCatalog, selectedPermissionId],
  );
  const canCreate = grantedPermissions.includes('create');
  const canEdit = grantedPermissions.includes('edit');
  const canDelete = grantedPermissions.includes('delete');

  // Prepara una modal limpia para registrar un permiso nuevo.
  function openCreatePermissionModal() {
    setPermissionForm(emptyPermission());
    setPermissionModalOpen(true);
  }

  // Carga el permiso activo dentro de la modal para editarlo.
  function openEditPermissionModal(permission) {
    setSelectedPermissionId(permission.id);
    setPermissionForm(permission);
    setPermissionModalOpen(true);
  }

  // Restablece la modal de permisos para el siguiente uso.
  function closePermissionModal() {
    setPermissionModalOpen(false);
    setPermissionForm(emptyPermission());
  }

  // Persiste la alta o edicion del permiso y refresca el bootstrap externo.
  async function submitPermission(event) {
    event.preventDefault();

    await runAction(async () => {
      if (permissionForm.id) {
        await dataController.updatePermission(permissionForm.id, permissionForm);
      } else {
        await dataController.createPermission(permissionForm);
      }

      setPermissionModalOpen(false);
      setPermissionForm(emptyPermission());
    }, permissionForm.id ? 'Permiso actualizado.' : 'Permiso creado.');
  }

  // Elimina el permiso activo y limpia la seleccion para evitar referencias obsoletas.
  async function deleteSelectedPermission() {
    if (!selectedPermission) {
      return;
    }

    await runAction(async () => {
      await dataController.deletePermission(selectedPermission.id);
      setSelectedPermissionId(null);
    }, 'Permiso eliminado.');
  }

  return (
    <>
      <AdminDataGrid
        title="Permisos"
        copy="Vista independiente para administrar privilegios reutilizables por vista."
        rows={permissionCatalog}
        pageSize={10}
        searchableFields={['name', 'slug', 'description']}
        getRowId={(permission) => permission.id}
        selectedRowId={selectedPermissionId}
        onSelectionChange={(permission) => setSelectedPermissionId(permission?.id || null)}
        searchPlaceholder="Buscar por nombre, slug o descripcion..."
        shellClassName="users-table-shell"
        tableClassName="users-table"
        colorScheme={{
          rowOddBg: 'rgba(255, 250, 244, 0.18)',
          rowEvenBg: 'rgba(240, 236, 248, 0.38)',
          rowHoverBg: 'rgba(95, 84, 140, 0.12)',
          rowSelectedBg: 'rgba(95, 84, 140, 0.18)',
        }}
        columns={[
          {
            key: 'name',
            label: 'Permiso',
            render: (permission) => (
              <div className="users-name-cell">
                <strong>{permission.name}</strong>
                <span>{permission.description || 'Sin descripcion'}</span>
              </div>
            ),
          },
          {
            key: 'slug',
            label: 'Slug',
            render: (permission) => <span className="grid-code-pill alt">{permission.slug}</span>,
          },
        ]}
        renderActions={() => (
          <>
            <div className="users-selection-pill">
              {selectedPermission ? `Seleccionado: ${selectedPermission.name}` : 'Selecciona un permiso de la lista'}
            </div>
            <div className="users-toolbar-actions">
              <button className="submit-button icon-button" type="button" onClick={openCreatePermissionModal} disabled={!canCreate}>
                <Plus size={15} />
                <span>Nuevo</span>
              </button>
              <button className="inline-button icon-button" type="button" disabled={!selectedPermission || !canEdit} onClick={() => selectedPermission && openEditPermissionModal(selectedPermission)}>
                <PencilLine size={15} />
                <span>Editar</span>
              </button>
              <button className="inline-button danger icon-button" type="button" disabled={!selectedPermission || !canDelete} onClick={deleteSelectedPermission}>
                <Trash2 size={15} />
                <span>Eliminar</span>
              </button>
            </div>
          </>
        )}
      />

      {permissionModalOpen ? (
        <div className="modal-backdrop" onClick={closePermissionModal}>
          <article className="modal-card roles-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Gestion de permisos</p>
                <h3>{permissionForm.id ? 'Editar permiso' : 'Nuevo permiso'}</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closePermissionModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>
            <form className="admin-form roles-modal-form" onSubmit={submitPermission}>
              <p className="roles-modal-copy">Define el permiso reutilizable que podra asignarse dentro de las vistas del sistema.</p>
              <label>
                Nombre
                <input value={permissionForm.name} onChange={(event) => setPermissionForm((current) => ({ ...current, name: event.target.value }))} />
              </label>
              <label>
                Slug
                <input value={permissionForm.slug} onChange={(event) => setPermissionForm((current) => ({ ...current, slug: event.target.value }))} />
              </label>
              <label>
                Descripcion
                <input value={permissionForm.description || ''} onChange={(event) => setPermissionForm((current) => ({ ...current, description: event.target.value }))} />
              </label>
              <div className="form-actions">
                <button className="submit-button icon-button" type="submit"><Save size={16} /><span>{permissionForm.id ? 'Actualizar' : 'Crear'}</span></button>
                <button className="inline-button icon-button" type="button" onClick={closePermissionModal}><Eraser size={15} /><span>Cancelar</span></button>
              </div>
            </form>
          </article>
        </div>
      ) : null}
    </>
  );
}