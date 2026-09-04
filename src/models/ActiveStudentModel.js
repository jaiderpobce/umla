import { apiRequest } from './apiClient.js';

export class ActiveStudentModel {
  async getStudents(filters = {}) {
    const params = new URLSearchParams();
    if (filters.search) params.append('search', filters.search);
    if (filters.program_id) params.append('program_id', filters.program_id);
    if (filters.period_id) params.append('period_id', filters.period_id);
    if (filters.status) params.append('status', filters.status);
    if (filters.per_page) params.append('per_page', filters.per_page);
    if (filters.page) params.append('page', filters.page);

    const queryString = params.toString() ? `?${params.toString()}` : '';
    return apiRequest(`/umla-api/api/alumnos-activos${queryString}`);
  }

  async previewCsv(file) {
    const formData = new FormData();
    formData.append('csv_file', file);

    return apiRequest('/umla-api/api/alumnos-activos/preview', {
      method: 'POST',
      body: formData,
    });
  }

  async confirmImport(token) {
    return apiRequest('/umla-api/api/alumnos-activos/confirm', {
      method: 'POST',
      body: JSON.stringify({ token }),
    });
  }
}
