export async function apiRequest(url, options = {}) {
  const isFormData = typeof FormData !== 'undefined' && options.body instanceof FormData;
  
  let method = (options.method || 'GET').toUpperCase();
  const headers = {
    Accept: 'application/json',
    ...(options.headers || {}),
  };

  if (!isFormData && method !== 'GET' && method !== 'HEAD') {
    headers['Content-Type'] = 'application/json';
  }

  // Si el servidor o cortafuegos bloquea PUT/DELETE, lo cambiamos a POST
  // y enviamos el método original en el encabezado X-HTTP-Method-Override
  if (method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
    headers['X-HTTP-Method-Override'] = method;
    method = 'POST';
  }

  const response = await fetch(url, {
    credentials: 'include',
    headers,
    ...options,
    method,
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok) {
    throw new Error(data.message || 'La solicitud no pudo completarse.');
  }

  return data;
}
