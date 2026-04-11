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
  usuarios: [
    { label: 'Nuevas cuentas', value: '42', trend: '+12%' },
    { label: 'Pendientes', value: '9', trend: '-3' },
    { label: 'Suspendidos', value: '5', trend: '0' },
  ],
  roles: [
    { label: 'Roles activos', value: '7', trend: '+1' },
    { label: 'Permisos críticos', value: '13', trend: '+4%' },
    { label: 'Asignaciones', value: '216', trend: '+17%' },
  ],
  modulos: [
    { label: 'Módulos publicados', value: '11', trend: '+2' },
    { label: 'Vistas protegidas', value: '37', trend: '+5' },
    { label: 'Cobertura móvil', value: '98%', trend: '+3%' },
  ],
  auditoria: [
    { label: 'Eventos hoy', value: '324', trend: '+14%' },
    { label: 'Exportaciones', value: '18', trend: '+6' },
    { label: 'Hallazgos', value: '3', trend: '-2' },
  ],
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
