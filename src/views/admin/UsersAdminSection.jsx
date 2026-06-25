import { Eraser, Key, PencilLine, Plus, Save, ShieldCheck, Trash2, UserRound } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

import { AdminDataGrid } from './AdminDataGrid';

// Devuelve el estado base del formulario para altas o reinicios de edicion.
function emptyUser() {
  return { id: null, name: '', email: '', password: '', role_ids: [] };
}

// Encapsula todo el comportamiento del modulo de usuarios para facilitar su mantenimiento.
export function UsersAdminSection({ users, roles, dataController, runAction }) {
  const [selectedUserId, setSelectedUserId] = useState(null);
  const [userForm, setUserForm] = useState(emptyUser());
  const [userRolesDraft, setUserRolesDraft] = useState([]);
  const [rolesModalOpen, setRolesModalOpen] = useState(false);
  const [userModalOpen, setUserModalOpen] = useState(false);

  const selectedUser = useMemo(() => users.find((user) => user.id === selectedUserId) || null, [users, selectedUserId]);

  useEffect(() => {
    if (!selectedUser) {
      setUserRolesDraft([]);
      setRolesModalOpen(false);
      return;
    }

    setUserRolesDraft(selectedUser.role_ids || []);
  }, [selectedUser]);

  // Marca la fila activa para habilitar acciones contextuales sobre el usuario.
  function selectUser(user) {
    setSelectedUserId(user.id);
  }

  // Prepara una modal limpia para crear un usuario sin heredar datos previos.
  function openCreateUserModal() {
    setUserForm(emptyUser());
    setUserModalOpen(true);
  }

  // Carga el usuario seleccionado dentro de la modal de edicion.
  function startEditingUser(user) {
    setSelectedUserId(user.id);
    setUserForm({ ...user, password: '', role_ids: user.role_ids || [] });
    setUserModalOpen(true);
  }

  // Abre la modal de roles copiando el estado actual del usuario seleccionado.
  function openRolesModal() {
    if (!selectedUser) {
      return;
    }

    setUserRolesDraft(selectedUser.role_ids || []);
    setRolesModalOpen(true);
  }

  // Cierra la modal de roles sin alterar la seleccion actual de la tabla.
  function closeRolesModal() {
    setRolesModalOpen(false);
  }

  // Cierra la modal de usuario y reinicia el formulario para el siguiente uso.
  function closeUserModal() {
    setUserModalOpen(false);
    setUserForm(emptyUser());
  }

  // Persiste el alta o edicion del usuario y refresca el bootstrap del panel.
  async function submitUser(event) {
    event.preventDefault();

    await runAction(async () => {
      if (userForm.id) {
        await dataController.updateUser(userForm.id, userForm);
      } else {
        await dataController.createUser(userForm);
      }

      setUserModalOpen(false);
      setUserForm(emptyUser());
    }, userForm.id ? 'Usuario actualizado.' : 'Usuario creado.');
  }

  // Sincroniza los roles marcados en la modal con el usuario activo.
  async function submitUserRoles(event) {
    event.preventDefault();

    if (!selectedUser) {
      return;
    }

    await runAction(async () => {
      await dataController.updateUser(selectedUser.id, {
        name: selectedUser.name,
        email: selectedUser.email,
        password: '',
        role_ids: userRolesDraft,
      });
      setRolesModalOpen(false);
    }, 'Roles del usuario actualizados.');
  }

  // Agrega o quita un rol del borrador antes de guardar la asignacion final.
  function toggleRoleForSelectedUser(roleId) {
    setUserRolesDraft((current) => current.includes(roleId)
      ? current.filter((currentRoleId) => currentRoleId !== roleId)
      : [...current, roleId]);
  }

  // Elimina el usuario seleccionado y limpia la seleccion para evitar referencias obsoletas.
  async function deleteSelectedUser() {
    if (!selectedUser) {
      return;
    }

    await runAction(async () => {
      await dataController.deleteUser(selectedUser.id);
      setSelectedUserId(null);
    }, 'Usuario eliminado.');
  }

  // Restablece la contraseña de todos los estudiantes a "passwd"
  async function handleResetStudentPasswords() {
    if (!window.confirm('¿Estás seguro de que deseas restablecer la contraseña de TODOS los estudiantes a "passwd"?')) {
      return;
    }

    await runAction(async () => {
      await dataController.resetStudentPasswords();
    }, 'Contraseñas de estudiantes restablecidas a "passwd".');
  }

  // Restablece la contraseña del usuario seleccionado a "passwd"
  async function handleResetUserPassword() {
    if (!selectedUser) {
      return;
    }

    if (!window.confirm(`¿Estás seguro de que deseas restablecer la contraseña de ${selectedUser.name} a "passwd"?`)) {
      return;
    }

    await runAction(async () => {
      await dataController.resetUserPassword(selectedUser.id);
    }, `Contraseña de ${selectedUser.name} restablecida a "passwd".`);
  }


  return (
    <>
      <AdminDataGrid
        title="Usuarios"
        copy="CRUD real sobre cuentas y asignacion de roles."
        rows={users}
        pageSize={10}
        colorScheme={{
          rowOddBg: 'rgba(255, 250, 244, 0.18)',
          rowEvenBg: 'rgba(232, 243, 242, 0.42)',
          rowHoverBg: 'rgba(22, 122, 127, 0.1)',
          rowSelectedBg: 'rgba(217, 108, 63, 0.18)',
        }}
        searchableFields={[
          'name',
          'email',
          (user) => (user.roles || []).map((role) => role.name).join(' '),
        ]}
        filters={[
          {
            key: 'role',
            label: 'Rol',
            options: [
              { value: '', label: 'Todos los roles' },
              ...roles.map((role) => ({ value: String(role.id), label: role.name })),
            ],
            matches: (user, roleId) => (user.role_ids || []).includes(Number(roleId)),
          },
        ]}
        getRowId={(user) => user.id}
        selectedRowId={selectedUserId}
        onSelectionChange={(user) => setSelectedUserId(user?.id || null)}
        searchPlaceholder="Buscar por nombre, correo o rol..."
        shellClassName="users-table-shell"
        tableClassName="users-table"
        columns={[
          {
            key: 'name',
            label: 'Nombre',
            render: (user) => (
              <div className="users-name-cell">
                <strong>{user.name}</strong>
                <span>#{user.id}</span>
              </div>
            ),
          },
          { key: 'email', label: 'Correo' },
          {
            key: 'roles',
            label: 'Roles',
            render: (user) => (
              <div className="users-role-list">
                {(user.roles || []).length > 0 ? (user.roles || []).map((role) => (
                  <span key={role.id} className="role-badge users-role-badge">{role.name}</span>
                )) : <span className="users-empty-role">Sin roles</span>}
              </div>
            ),
          },
        ]}
        renderActions={() => (
          <>
            <div className="users-selection-pill">
              {selectedUser ? `Seleccionado: ${selectedUser.name}` : 'Selecciona un usuario de la lista'}
            </div>
            <div className="users-toolbar-actions">
              <button className="submit-button icon-button" type="button" onClick={openCreateUserModal}>
                <Plus size={15} />
                <span>Nuevo</span>
              </button>
              <button className="inline-button icon-button" type="button" disabled={!selectedUser} onClick={() => selectedUser && startEditingUser(selectedUser)}>
                <PencilLine size={15} />
                <span>Editar</span>
              </button>
              <button className="inline-button icon-button" type="button" disabled={!selectedUser} onClick={openRolesModal}>
                <ShieldCheck size={15} />
                <span>Roles</span>
              </button>
              <button className="inline-button danger icon-button" type="button" disabled={!selectedUser} onClick={deleteSelectedUser}>
                <Trash2 size={15} />
                <span>Eliminar</span>
              </button>
              <button className="inline-button icon-button" type="button" disabled={!selectedUser} onClick={handleResetUserPassword}>
                <Key size={15} />
                <span>Reset Contraseña</span>
              </button>
              <button className="inline-button danger icon-button" type="button" onClick={handleResetStudentPasswords}>
                <Key size={15} />
                <span>Reset Alumnos</span>
              </button>
            </div>
          </>
        )}
      />

      {userModalOpen ? (
        <div className="modal-backdrop" onClick={closeUserModal}>
          <article className="modal-card roles-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Gestion de cuentas</p>
                <h3>{userForm.id ? 'Editar usuario' : 'Nuevo usuario'}</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closeUserModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>

            <form className="admin-form roles-modal-form" onSubmit={submitUser}>
              <p className="roles-modal-copy">Completa los datos base del usuario. Los roles se asignan desde la modal de roles.</p>
              <label>
                Nombre
                <input value={userForm.name} onChange={(event) => setUserForm((current) => ({ ...current, name: event.target.value }))} />
              </label>
              <label>
                Correo
                <input type="email" value={userForm.email} onChange={(event) => setUserForm((current) => ({ ...current, email: event.target.value }))} />
              </label>
              <label>
                Contrasena
                <input type="password" value={userForm.password} onChange={(event) => setUserForm((current) => ({ ...current, password: event.target.value }))} />
              </label>
              <div className="form-actions">
                <button className="submit-button icon-button" type="submit"><UserRound size={16} /><span>{userForm.id ? 'Actualizar' : 'Crear'}</span></button>
                <button className="inline-button icon-button" type="button" onClick={closeUserModal}><Eraser size={15} /><span>Cancelar</span></button>
              </div>
            </form>
          </article>
        </div>
      ) : null}

      {rolesModalOpen && selectedUser ? (
        <div className="modal-backdrop" onClick={closeRolesModal}>
          <article className="modal-card roles-modal-card" onClick={(event) => event.stopPropagation()}>
            <div className="modal-header">
              <div>
                <p className="eyebrow">Asignacion operativa</p>
                <h3>Roles de {selectedUser.name}</h3>
              </div>
              <button className="inline-button icon-button" type="button" onClick={closeRolesModal}>
                <Eraser size={15} />
                <span>Cerrar</span>
              </button>
            </div>

            <form className="admin-form roles-modal-form" onSubmit={submitUserRoles}>
              <p className="roles-modal-copy">Selecciona los roles asignados al usuario y guarda los cambios.</p>
              <div className="checkbox-grid roles-modal-grid">
                {roles.map((role) => (
                  <label key={role.id} className="checkbox-pill">
                    <input type="checkbox" checked={userRolesDraft.includes(role.id)} onChange={() => toggleRoleForSelectedUser(role.id)} />
                    <span>{role.name}</span>
                  </label>
                ))}
              </div>
              <div className="form-actions">
                <button className="submit-button icon-button" type="submit"><Save size={16} /><span>Guardar roles</span></button>
                <button className="inline-button icon-button" type="button" onClick={closeRolesModal}><Eraser size={15} /><span>Cancelar</span></button>
              </div>
            </form>
          </article>
        </div>
      ) : null}
    </>
  );
}