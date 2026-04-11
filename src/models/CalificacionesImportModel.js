import { apiRequest } from './apiClient.js';

export class CalificacionesImportModel {
  async getSummary() {
    return apiRequest('/umla-api/api/calificaciones/importacion/summary');
  }

  async previewZip(file) {
    const formData = new FormData();
    formData.append('zip_file', file);

    return apiRequest('/umla-api/api/calificaciones/importacion/preview', {
      method: 'POST',
      body: formData,
    });
  }

  async confirmImport(token) {
    return apiRequest('/umla-api/api/calificaciones/importacion/upload', {
      method: 'POST',
      body: JSON.stringify({ token }),
    });
  }
}