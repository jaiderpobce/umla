import { apiRequest } from './apiClient.js';

export class AdminModel {
  async getBootstrap() {
    return apiRequest('/umla-api/api/admin/bootstrap');
  }

  async createUser(payload) {
    return apiRequest('/umla-api/api/admin/users', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async updateUser(userId, payload) {
    return apiRequest(`/umla-api/api/admin/users/${userId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deleteUser(userId) {
    return apiRequest(`/umla-api/api/admin/users/${userId}`, {
      method: 'DELETE',
    });
  }

  async createRole(payload) {
    return apiRequest('/umla-api/api/admin/roles', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async updateRole(roleId, payload) {
    return apiRequest(`/umla-api/api/admin/roles/${roleId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deleteRole(roleId) {
    return apiRequest(`/umla-api/api/admin/roles/${roleId}`, {
      method: 'DELETE',
    });
  }

  async syncRoleAccess(roleId, payload) {
    return apiRequest(`/umla-api/api/admin/roles/${roleId}/access`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async createPermission(payload) {
    return apiRequest('/umla-api/api/admin/permissions', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async updatePermission(permissionId, payload) {
    return apiRequest(`/umla-api/api/admin/permissions/${permissionId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deletePermission(permissionId) {
    return apiRequest(`/umla-api/api/admin/permissions/${permissionId}`, {
      method: 'DELETE',
    });
  }

  async createModule(payload) {
    return apiRequest('/umla-api/api/admin/modules', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async updateModule(moduleId, payload) {
    return apiRequest(`/umla-api/api/admin/modules/${moduleId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deleteModule(moduleId) {
    return apiRequest(`/umla-api/api/admin/modules/${moduleId}`, {
      method: 'DELETE',
    });
  }

  async createModuleView(moduleId, payload) {
    return apiRequest(`/umla-api/api/admin/modules/${moduleId}/views`, {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async updateModuleView(viewId, payload) {
    return apiRequest(`/umla-api/api/admin/module-views/${viewId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deleteModuleView(viewId) {
    return apiRequest(`/umla-api/api/admin/module-views/${viewId}`, {
      method: 'DELETE',
    });
  }
}
