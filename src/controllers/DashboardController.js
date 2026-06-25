import { NavigationModel } from '../models/NavigationModel.js';
import { AdminModel } from '../models/AdminModel.js';
import { CalificacionesImportModel } from '../models/CalificacionesImportModel.js';
import { NotasModel } from '../models/NotasModel.js';
import { BrandingModel } from '../models/BrandingModel.js';

export class DashboardController {
  constructor() {
    this.model = new NavigationModel();
    this.adminModel = new AdminModel();
    this.calificacionesImportModel = new CalificacionesImportModel();
    this.notasModel = new NotasModel();
    this.brandingModel = new BrandingModel();
  }

  async getBranding() {
    return this.brandingModel.getBranding();
  }

  async getNavigation() {
    return this.model.getNavigation();
  }

  async getModuleView(moduleSlug, viewSlug) {
    return this.model.getModuleView(moduleSlug, viewSlug);
  }

  getMetricsForModule(moduleSlug) {
    return this.model.getModuleMetrics(moduleSlug);
  }

  async getAdminBootstrap() {
    return this.adminModel.getBootstrap();
  }

  async getAdminBranding() {
    return this.adminModel.getBranding();
  }

  async updateAdminBranding(payload) {
    return this.adminModel.updateBranding(payload);
  }

  async createUser(payload) {
    return this.adminModel.createUser(payload);
  }

  async updateUser(userId, payload) {
    return this.adminModel.updateUser(userId, payload);
  }

  async deleteUser(userId) {
    return this.adminModel.deleteUser(userId);
  }

  async resetStudentPasswords() {
    return this.adminModel.resetStudentPasswords();
  }

  async resetUserPassword(userId) {
    return this.adminModel.resetUserPassword(userId);
  }

  async createRole(payload) {
    return this.adminModel.createRole(payload);
  }

  async updateRole(roleId, payload) {
    return this.adminModel.updateRole(roleId, payload);
  }

  async deleteRole(roleId) {
    return this.adminModel.deleteRole(roleId);
  }

  async syncRoleAccess(roleId, payload) {
    return this.adminModel.syncRoleAccess(roleId, payload);
  }

  async createPermission(payload) {
    return this.adminModel.createPermission(payload);
  }

  async updatePermission(permissionId, payload) {
    return this.adminModel.updatePermission(permissionId, payload);
  }

  async deletePermission(permissionId) {
    return this.adminModel.deletePermission(permissionId);
  }

  async createModule(payload) {
    return this.adminModel.createModule(payload);
  }

  async updateModule(moduleId, payload) {
    return this.adminModel.updateModule(moduleId, payload);
  }

  async deleteModule(moduleId) {
    return this.adminModel.deleteModule(moduleId);
  }

  async createModuleView(moduleId, payload) {
    return this.adminModel.createModuleView(moduleId, payload);
  }

  async updateModuleView(viewId, payload) {
    return this.adminModel.updateModuleView(viewId, payload);
  }

  async deleteModuleView(viewId) {
    return this.adminModel.deleteModuleView(viewId);
  }

  async getCalificacionesImportSummary() {
    return this.calificacionesImportModel.getSummary();
  }

  async previewCalificacionesZip(file) {
    return this.calificacionesImportModel.previewZip(file);
  }

  async confirmCalificacionesImport(token) {
    return this.calificacionesImportModel.confirmImport(token);
  }

  async getNotas(params) {
    return this.notasModel.getNotas(params);
  }

  async updateNota(notaId, payload) {
    return this.notasModel.updateNota(notaId, payload);
  }

  async deleteNota(notaId) {
    return this.notasModel.deleteNota(notaId);
  }
}
