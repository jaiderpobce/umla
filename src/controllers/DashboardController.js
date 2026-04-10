import { NavigationModel } from '../models/NavigationModel.js';
import { AdminModel } from '../models/AdminModel.js';

export class DashboardController {
  constructor() {
    this.model = new NavigationModel();
    this.adminModel = new AdminModel();
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

  async createUser(payload) {
    return this.adminModel.createUser(payload);
  }

  async updateUser(userId, payload) {
    return this.adminModel.updateUser(userId, payload);
  }

  async deleteUser(userId) {
    return this.adminModel.deleteUser(userId);
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
}
