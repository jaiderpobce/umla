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

  async getBranding() {
    const response = await apiRequest('/umla-api/api/admin/branding');
    return response.branding;
  }

  async updateBranding(payload) {
    const formData = new FormData();
    formData.append('institution_name', payload.institution_name || '');
    formData.append('subtitle', payload.subtitle || '');
    formData.append('brand_color', payload.brand_color || '#d96c3f');
    formData.append('remove_logo', payload.remove_logo ? '1' : '0');

    if (payload.logo) {
      formData.append('logo', payload.logo);
    }

    const response = await apiRequest('/umla-api/api/admin/branding', {
      method: 'POST',
      body: formData,
    });

    return response.branding;
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
