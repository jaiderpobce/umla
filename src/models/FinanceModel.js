import { apiRequest } from './apiClient.js';

export class FinanceModel {
  async getAdminData(filters = {}) {
    const params = new URLSearchParams();
    if (filters.status) params.append('status', filters.status);
    if (filters.search) params.append('search', filters.search);
    if (filters.per_page) params.append('per_page', filters.per_page);
    if (filters.career) params.append('career', filters.career);
    if (filters.charges_page) params.append('charges_page', filters.charges_page);
    if (filters.pending_page) params.append('pending_page', filters.pending_page);

    const queryString = params.toString() ? `?${params.toString()}` : '';
    return apiRequest(`/umla-api/api/finanzas/admin${queryString}`);
  }

  async generateChargesByCareer(payload) {
    return apiRequest('/umla-api/api/finanzas/charges/generate-by-career', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  }

  async getStudentData(filters = {}) {
    const params = new URLSearchParams();
    if (filters.status) params.append('status', filters.status);
    if (filters.search) params.append('search', filters.search);
    if (filters.per_page) params.append('per_page', filters.per_page);
    if (filters.charges_page) params.append('charges_page', filters.charges_page);
    if (filters.receipts_page) params.append('receipts_page', filters.receipts_page);

    const queryString = params.toString() ? `?${params.toString()}` : '';
    return apiRequest(`/umla-api/api/finanzas/student${queryString}`);
  }

  async reportPayment(formData) {
    return apiRequest('/umla-api/api/finanzas/payments/report', {
      method: 'POST',
      body: formData,
    });
  }

  async approvePayment(paymentId, notes) {
    return apiRequest(`/umla-api/api/finanzas/payments/${paymentId}/approve`, {
      method: 'POST',
      body: JSON.stringify({ notes }),
    });
  }

  async rejectPayment(paymentId, notes) {
    return apiRequest(`/umla-api/api/finanzas/payments/${paymentId}/reject`, {
      method: 'POST',
      body: JSON.stringify({ notes }),
    });
  }
}
