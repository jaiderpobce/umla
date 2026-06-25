import { apiRequest } from './apiClient.js';

export class AuthModel {
  async login(credentials) {
    const response = await apiRequest('/umla-api/api/auth/login', {
      method: 'POST',
      body: JSON.stringify(credentials),
    });

    const user = response.user;
    if (user) user.requires_password_change = response.requires_password_change;
    return user;
  }

  async getCurrentUser() {
    const response = await apiRequest('/umla-api/api/auth/me');
    const user = response.user;
    if (user) user.requires_password_change = response.requires_password_change;
    return user;
  }

  async logout() {
    await apiRequest('/umla-api/api/auth/logout', {
      method: 'POST',
    });
  }

  async changePassword(data) {
    return await apiRequest('/umla-api/api/auth/change-password', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }
}
