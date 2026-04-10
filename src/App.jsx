import { createContext, useContext, useEffect, useState } from 'react';
import { BrowserRouter, Navigate, Outlet, Route, Routes, useLocation, useNavigate, useParams } from 'react-router-dom';
import { AuthController } from './controllers/AuthController.js';
import { DashboardController } from './controllers/DashboardController.js';
import { SidebarView } from './views/SidebarView.jsx';
import { TopbarView } from './views/TopbarView.jsx';
import { ModuleView } from './views/ModuleView.jsx';
import { LoginView } from './views/LoginView.jsx';

const authController = new AuthController();
const dashboardController = new DashboardController();

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
  const { user, navigation, onLogout } = useAppContext();
  const [mobileSidebarOpen, setMobileSidebarOpen] = useState(false);

  const activeModuleSlug = location.pathname.split('/')[1] || null;

  function handleModuleSelect(route) {
    navigate(route);
    setMobileSidebarOpen(false);
  }

  return (
    <div className="app-shell">
      <SidebarView
        brand="UMLA"
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

  return <ModuleView state={state} metrics={dashboardController.getMetricsForModule(moduleSlug)} dataController={dashboardController} />;
}

function LoginRoute() {
  const navigate = useNavigate();
  const location = useLocation();
  const { onLogin } = useAppContext();

  async function handleLogin(credentials) {
    await onLogin(credentials);
    navigate(location.state?.from?.pathname || '/', { replace: true });
  }

  return <LoginView onLogin={handleLogin} />;
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

  useEffect(() => {
    let isMounted = true;

    async function restoreSession() {
      try {
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

  return (
    <AppContext.Provider
      value={{
        user,
        navigation,
        onLogin: handleLogin,
        onLogout: handleLogout,
      }}
    >
      <BrowserRouter>
        <Routes>
          <Route element={<PublicRoute isAuthenticated={Boolean(user)} />}>
            <Route path="/login" element={<LoginRoute />} />
          </Route>

          <Route element={<ProtectedRoute isAuthenticated={Boolean(user)} isBooting={booting} />}>
            <Route element={<AppLayout />}>
              <Route path="/" element={<DefaultRoute />} />
              <Route path="/:moduleSlug/:viewSlug" element={<ModuleRoute />} />
            </Route>
          </Route>
        </Routes>
      </BrowserRouter>
    </AppContext.Provider>
  );
}
