import { apiRequest } from './apiClient.js';

const metricsByModule = {
  dashboard: [
    { label: 'Usuarios activos', value: '1,284', trend: '+8%' },
    { label: 'Roles registrados', value: '16', trend: '+2' },
    { label: 'Módulos protegidos', value: '28', trend: '100%' },
  ],
  calificaciones: [
    { label: 'Formato esperado', value: 'ZIP + CSV', trend: '11 columnas' },
    { label: 'Destino', value: 'calificaciones_old', trend: 'upsert activo' },
    { label: 'Clave única', value: 'Matrícula + Asignatura', trend: 'sin duplicados' },
  ],
  notas: [],
  usuarios: [],
  roles: [],
  modulos: [],
  auditoria: [],
};

export class NavigationModel {
  async getNavigation() {
    const response = await apiRequest('/umla-api/api/navigation');
    return response.navigation;
  }

  async getModuleView(moduleSlug, viewSlug) {
    return apiRequest(`/umla-api/api/modules/${moduleSlug}/${viewSlug}`);
  }

  getModuleMetrics(moduleSlug) {
    return metricsByModule[moduleSlug] ?? [];
  }
}
