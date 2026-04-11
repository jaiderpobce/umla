import { defineConfig, loadEnv } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  const appBasePath = env.VITE_APP_BASE_PATH || '/umla/';

  return {
    base: mode === 'development' ? '/' : appBasePath,
    plugins: [react()],
    server: {
      host: '0.0.0.0',
      port: 5173,
      proxy: {
        '/umla-api': {
          target: 'http://localhost',
          changeOrigin: true,
        },
      },
    },
  };
});
