import { AuthModel } from '../models/AuthModel.js';

export class AuthController {
  constructor() {
    this.model = new AuthModel();
  }

  async login(credentials) {
    return this.model.login(credentials);
  }

  async getCurrentUser() {
    return this.model.getCurrentUser();
  }

  async logout() {
    return this.model.logout();
  }

  async changePassword(data) {
    return this.model.changePassword(data);
  }
}
