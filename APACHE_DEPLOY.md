# UMLA en Apache

## URL esperada

- Frontend: `http://localhost/umla/`
- Backend Laravel: `http://localhost/umla-api`

## Build del frontend

Desde la raiz de UMLA:

```bash
npm install
npm run build
```

El build queda en `dist/` y ya incluye un `.htaccess` para que Apache resuelva rutas SPA.

## Publicacion en Apache

Publica el contenido de `dist/` en una carpeta servida por Apache como `/umla`.

Ejemplo tipico:

```bash
sudo mkdir -p /var/www/html/umla
sudo rsync -av --delete dist/ /var/www/html/umla/
```

## Requisitos de Apache

- `mod_rewrite` habilitado
- `AllowOverride All` para la carpeta publicada del frontend
- Alias o ruta publica para Laravel en `/umla-api`

Ejemplo minimo para el frontend:

```apache
Alias /umla /var/www/html/umla

<Directory /var/www/html/umla>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

## Notas

- En desarrollo con Vite se mantiene `http://localhost:5173`.
- En produccion o pruebas sobre Apache, el frontend queda preparado para ejecutarse bajo `/umla/`.
- Las llamadas API siguen yendo a `/umla-api/api/...`.