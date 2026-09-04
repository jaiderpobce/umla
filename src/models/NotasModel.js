import { apiRequest } from './apiClient.js';

export class NotasModel {
  async getNotas({ search = '', page = 1, perPage = 15, matricula = '' } = {}) {
    const params = new URLSearchParams({
      search,
      page: String(page),
      per_page: String(perPage),
    });

    if (matricula) {
      params.append('matricula', matricula);
    }

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

  async getReportOptions(career = '', matricula = '') {
    const params = new URLSearchParams();
    if (career) params.set('career', career);
    if (matricula) params.set('matricula', matricula);
    return apiRequest(`/umla-api/api/notas/reportes/detalle/options${params.toString() ? `?${params}` : ''}`);
  }

  async getReportDetail(career, matricula) {
    const params = new URLSearchParams({ career, matricula });
    return apiRequest(`/umla-api/api/notas/reportes/detalle?${params.toString()}`);
  }
}