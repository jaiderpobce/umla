import { apiRequest } from './apiClient.js';

export class AuthModel {
  async login(credentials) {
    const response = await apiRequest('/umla-api/api/auth/login', {
      method: 'POST',
      body: JSON.stringify(credentials),
    });

    return response.user;
  }

  async getCurrentUser() {
    const response = await apiRequest('/umla-api/api/auth/me');
    return response.user;
  }

  async logout() {
    await apiRequest('/umla-api/api/auth/logout', {
      method: 'POST',
    });
  }
}
