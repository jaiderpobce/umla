export async function apiRequest(url, options = {}) {
  const isFormData = typeof FormData !== 'undefined' && options.body instanceof FormData;
  const headers = {
    Accept: 'application/json',
    ...(options.headers || {}),
  };

  if (!isFormData) {
    headers['Content-Type'] = 'application/json';
  }

  const response = await fetch(url, {
    credentials: 'include',
    headers,
    ...options,
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok) {
    throw new Error(data.message || 'La solicitud no pudo completarse.');
  }

  return data;
}
