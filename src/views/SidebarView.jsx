import { useEffect, useRef, useState } from 'react';
import { Blocks, Building2, FileArchive, LayoutDashboard, NotebookTabs, ScrollText, Settings2, ShieldCheck, Users } from 'lucide-react';
import { BrandLogo } from './BrandLogo.jsx';

const moduleIcons = {
  dashboard: LayoutDashboard,
  calificaciones: FileArchive,
  notas: NotebookTabs,
  usuarios: Users,
  roles: ShieldCheck,
  modulos: Blocks,
  institucion: Building2,
  auditoria: ScrollText,
};

const configurationModuleSlugs = ['usuarios', 'roles', 'modulos', 'institucion', 'auditoria'];

function ModuleIcon({ slug, className }) {
  const Icon = moduleIcons[slug] || Settings2;
  return <Icon className={className} strokeWidth={2} />;
}

function moduleLabel(module) {
  if (module.slug === 'calificaciones') {
    return 'Cargar archivo ZIP';
  }

  return module.name;
}

export function SidebarView({ branding, modules, activeModuleSlug, isOpen, onClose, onModuleSelect }) {
  const dashboardModule = modules.find((module) => module.slug === 'dashboard') || null;
  const configModule = modules.find((module) => module.slug === 'configuracion') || null;
  
  const primaryModules = modules.filter((module) => 
    module.slug !== 'dashboard' && 
    module.slug !== 'configuracion' &&
    !configurationModuleSlugs.includes(module.slug)
  );

  const configurationModules = modules.filter((module) => configurationModuleSlugs.includes(module.slug));
  
  // Use either separate modules or views from the 'configuracion' module
  const hasConfiguration = configurationModules.length > 0 || configModule;
  const configurationActive = configurationModules.some((module) => module.slug === activeModuleSlug) || (configModule && activeModuleSlug === configModule.slug);
  
  const [configurationOpen, setConfigurationOpen] = useState(false);
  const [notesOpen, setNotesOpen] = useState(true);
  const isFirstRender = useRef(true);

  useEffect(() => {
    if (isFirstRender.current) {
      isFirstRender.current = false;
      return;
    }

    if (configurationActive) {
      setConfigurationOpen(true);
    }
  }, [configurationActive]);

  function handleConfigurationToggle() {
    setConfigurationOpen((current) => !current);
  }

  return (
    <>
      <button className={`sidebar-backdrop ${isOpen ? 'is-visible' : ''}`} onClick={onClose} aria-label="Cerrar menú" />
      <aside className={`sidebar ${isOpen ? 'is-open' : ''}`}>
        <div className="sidebar-brand">
          <BrandLogo
            className="sidebar-brand-logo"
            title={branding?.institution_name || 'UMLA'}
            subtitle={branding?.subtitle || 'Plataforma académica'}
            brandColor={branding?.brand_color || '#d96c3f'}
            logoPath={branding?.logo_path || ''}
            useDefaultCandidates={false}
          />
        </div>
        <nav className="sidebar-nav">
          {dashboardModule ? (
            <button
              key={dashboardModule.id}
              className={`sidebar-link ${activeModuleSlug === dashboardModule.slug ? 'is-active' : ''}`}
              onClick={() => onModuleSelect(dashboardModule.views[0]?.route || '/')}
            >
              <span className="sidebar-icon">
                <ModuleIcon slug={dashboardModule.slug} className="sidebar-icon-svg" />
              </span>
              <span>{moduleLabel(dashboardModule)}</span>
            </button>
          ) : null}

          {primaryModules.map((module) => module.slug === 'notas' && module.views.length > 1 ? (
            <section key={module.id} className={`sidebar-group ${activeModuleSlug === module.slug ? 'is-active' : ''}`}>
              <button className={`sidebar-link sidebar-group-toggle ${notesOpen ? 'is-open' : ''}`} onClick={() => setNotesOpen((current) => !current)}>
                <span className="sidebar-icon"><ModuleIcon slug={module.slug} className="sidebar-icon-svg" /></span>
                <span className="sidebar-group-copy"><strong>{moduleLabel(module)}</strong></span>
                <span className="sidebar-group-caret" aria-hidden="true">{notesOpen ? '−' : '+'}</span>
              </button>
              {notesOpen ? <div className="sidebar-subnav">
                {module.views.map((view) => <button key={view.id} className="sidebar-sublink" onClick={() => onModuleSelect(view.route)}>
                  <span className="sidebar-subicon"><ModuleIcon slug={module.slug} className="sidebar-subicon-svg" /></span>
                  <span>{view.name}</span>
                </button>)}
              </div> : null}
            </section>
          ) : (
            <button key={module.id} className={`sidebar-link ${activeModuleSlug === module.slug ? 'is-active' : ''}`} onClick={() => onModuleSelect(module.views[0]?.route || '/')}>
              <span className="sidebar-icon"><ModuleIcon slug={module.slug} className="sidebar-icon-svg" /></span>
              <span>{moduleLabel(module)}</span>
            </button>
          ))}

          {hasConfiguration ? (
            <section className={`sidebar-group ${configurationActive ? 'is-active' : ''}`}>
              <button className={`sidebar-link sidebar-group-toggle ${configurationOpen ? 'is-open' : ''}`} onClick={handleConfigurationToggle}>
                <span className="sidebar-icon">
                  <Settings2 className="sidebar-icon-svg" strokeWidth={2} />
                </span>
                <span className="sidebar-group-copy">
                  <strong>Configuración</strong>
                </span>
                <span className="sidebar-group-caret" aria-hidden="true">{configurationOpen ? '−' : '+'}</span>
              </button>

              {configurationOpen ? (
                <div className="sidebar-subnav">
                  {/* Separate modules mode */}
                  {configurationModules.map((module) => (
                    <button
                      key={module.id}
                      className={`sidebar-sublink ${activeModuleSlug === module.slug ? 'is-active' : ''}`}
                      onClick={() => onModuleSelect(module.views[0]?.route || '/')}
                    >
                      <span className="sidebar-subicon">
                        <ModuleIcon slug={module.slug} className="sidebar-subicon-svg" />
                      </span>
                      <span>{moduleLabel(module)}</span>
                    </button>
                  ))}
                  
                  {/* Single module with multiple views mode */}
                  {configModule?.views.map((view) => (
                    <button
                      key={view.id}
                      className={`sidebar-sublink ${activeModuleSlug === configModule.slug ? 'is-active' : ''}`} // Simplified check
                      onClick={() => onModuleSelect(view.route)}
                    >
                      <span className="sidebar-subicon">
                        <ModuleIcon slug={view.slug} className="sidebar-subicon-svg" />
                      </span>
                      <span>{view.name}</span>
                    </button>
                  ))}
                </div>
              ) : null}
            </section>
          ) : null}
        </nav>
      </aside>
    </>
  );
}
