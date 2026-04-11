import { apiRequest } from './apiClient.js';

export class NotasModel {
  async getNotas({ search = '', page = 1, perPage = 15 } = {}) {
    const params = new URLSearchParams({
      search,
      page: String(page),
      per_page: String(perPage),
    });

    return apiRequest(`/umla-api/api/notas?${params.toString()}`);
  }

  async updateNota(notaId, payload) {
    return apiRequest(`/umla-api/api/notas/${notaId}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  }

  async deleteNota(notaId) {
    return apiRequest(`/umla-api/api/notas/${notaId}`, {
      method: 'DELETE',
    });
  }
}