import { apiRequest } from './apiClient.js';

export class BrandingModel {
  async getBranding() {
    const response = await apiRequest('/umla-api/api/branding');
    return response.branding;
  }
}