import { createContext, useContext, useEffect, useState } from 'react';
import { BrowserRouter, Navigate, Outlet, Route, Routes, useLocation, useNavigate, useParams } from 'react-router-dom';
import { AuthController } from './controllers/AuthController.js';
import { DashboardController } from './controllers/DashboardController.js';
import { SidebarView } from './views/SidebarView.jsx';
import { TopbarView } from './views/TopbarView.jsx';
import { ModuleView } from './views/ModuleView.jsx';
import { LoginView } from './views/LoginView.jsx';
import { ChangePasswordModal } from './views/ChangePasswordModal.jsx';
import { ProfileView } from './views/ProfileView.jsx';

const authController = new AuthController();
const dashboardController = new DashboardController();
const routerBasename = import.meta.env.BASE_URL === '/' ? undefined : import.meta.env.BASE_URL.replace(/\/$/, '');

export const AppContext = createContext(null);

function ProtectedRoute({ isAuthenticated, isBooting }) {
  const location = useLocation();

  if (isBooting) {
    return <section className="empty-state">Cargando sesión...</section>;
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  return <Outlet />;
}

function PublicRoute({ isAuthenticated }) {
  if (isAuthenticated) {
    return <Navigate to="/" replace />;
  }

  return <Outlet />;
}

function DefaultRoute() {
  const { navigation } = useAppContext();
  const firstView = navigation[0]?.views?.[0];

  if (!firstView) {
    return <section className="empty-state">No hay módulos disponibles para este usuario.</section>;
  }

  return <Navigate to={firstView.route} replace />;
}

function AppLayout() {
  const navigate = useNavigate();
  const location = useLocation();
  const { user, navigation, branding, onLogout } = useAppContext();
  const [mobileSidebarOpen, setMobileSidebarOpen] = useState(false);

  const activeModuleSlug = location.pathname.split('/')[1] || null;

  function handleModuleSelect(route) {
    navigate(route);
    setMobileSidebarOpen(false);
  }

  return (
    <div className="app-shell">
      <SidebarView
        branding={branding}
        modules={navigation}
        activeModuleSlug={activeModuleSlug}
        isOpen={mobileSidebarOpen}
        onClose={() => setMobileSidebarOpen(false)}
        onModuleSelect={handleModuleSelect}
      />
      <main className="main-panel">
        <TopbarView
          user={user}
          onLogout={onLogout}
          onMenuToggle={() => setMobileSidebarOpen((current) => !current)}
        />
        <Outlet />
      </main>
    </div>
  );
}

function ModuleRoute() {
  const { moduleSlug, viewSlug } = useParams();
  const { branding, onBrandingChange } = useAppContext();
  const [state, setState] = useState({ loading: true, error: '', payload: null });

  useEffect(() => {
    let isMounted = true;

    async function loadModule() {
      setState({ loading: true, error: '', payload: null });

      try {
        const payload = await dashboardController.getModuleView(moduleSlug, viewSlug);
        if (isMounted) {
          setState({ loading: false, error: '', payload });
        }
      } catch (error) {
        if (isMounted) {
          setState({ loading: false, error: error.message, payload: null });
        }
      }
    }

    loadModule();

    return () => {
      isMounted = false;
    };
  }, [moduleSlug, viewSlug]);

  return <ModuleView state={state} metrics={dashboardController.getMetricsForModule(moduleSlug)} dataController={dashboardController} branding={branding} onBrandingChange={onBrandingChange} />;
}

function LoginRoute() {
  const navigate = useNavigate();
  const location = useLocation();
  const { branding, onLogin } = useAppContext();

  async function handleLogin(credentials) {
    await onLogin(credentials);
    navigate(location.state?.from?.pathname || '/', { replace: true });
  }

  return <LoginView branding={branding} onLogin={handleLogin} />;
}

function useAppContext() {
  const context = useContext(AppContext);

  if (!context) {
    throw new Error('AppContext no disponible.');
  }

  return context;
}

export default function App() {
  const [booting, setBooting] = useState(true);
  const [user, setUser] = useState(null);
  const [navigation, setNavigation] = useState([]);
  const [branding, setBranding] = useState({
    institution_name: 'UMLA',
    subtitle: 'Plataforma académica',
    brand_color: '#d96c3f',
    logo_path: '',
  });

  useEffect(() => {
    let isMounted = true;

    async function restoreSession() {
      try {
        const nextBranding = await dashboardController.getBranding();

        if (isMounted) {
          setBranding(nextBranding);
        }

        const currentUser = await authController.getCurrentUser();
        const nextNavigation = await dashboardController.getNavigation();

        if (isMounted) {
          setUser(currentUser);
          setNavigation(nextNavigation);
        }
      } catch (error) {
        if (isMounted) {
          setUser(null);
          setNavigation([]);
          try {
            const nextBranding = await dashboardController.getBranding();
            if (isMounted) {
              setBranding(nextBranding);
            }
          } catch (brandingError) {
            if (isMounted) {
              setBranding({
                institution_name: 'UMLA',
                subtitle: 'Plataforma académica',
                brand_color: '#d96c3f',
                logo_path: '',
              });
            }
          }
        }
      } finally {
        if (isMounted) {
          setBooting(false);
        }
      }
    }

    restoreSession();

    return () => {
      isMounted = false;
    };
  }, []);

  async function handleLogin(credentials) {
    const currentUser = await authController.login(credentials);
    const nextNavigation = await dashboardController.getNavigation();
    setUser(currentUser);
    setNavigation(nextNavigation);
  }

  async function handleLogout() {
    await authController.logout();
    setUser(null);
    setNavigation([]);
  }

  async function handleChangePassword(data) {
    await authController.changePassword(data);
    setUser({ ...user, requires_password_change: false });
  }

  return (
    <AppContext.Provider
      value={{
        user,
        navigation,
        branding,
        onBrandingChange: setBranding,
        onLogin: handleLogin,
        onLogout: handleLogout,
      }}
    >
      <BrowserRouter basename={routerBasename}>
        <Routes>
          <Route element={<PublicRoute isAuthenticated={Boolean(user)} />}>
            <Route path="/login" element={<LoginRoute />} />
          </Route>

          <Route element={<ProtectedRoute isAuthenticated={Boolean(user)} isBooting={booting} />}>
            <Route element={<AppLayout />}>
              <Route path="/" element={<DefaultRoute />} />
              <Route path="/profile" element={<ProfileView user={user} />} />
              <Route path="/:moduleSlug/:viewSlug" element={<ModuleRoute />} />
            </Route>
          </Route>
        </Routes>
      </BrowserRouter>

      {user?.requires_password_change && (
        <ChangePasswordModal 
          user={user} 
          branding={branding} 
          onChangePassword={handleChangePassword} 
          onLogout={handleLogout} 
        />
      )}
    </AppContext.Provider>
  );
}
