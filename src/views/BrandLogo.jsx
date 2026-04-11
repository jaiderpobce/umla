import { useState } from 'react';

const DEFAULT_LOGO_CANDIDATES = [
  'branding/logos/logo.png',
  'branding/logos/logo.svg',
  'branding/logos/logo.webp',
  'branding/logos/logo.jpg',
  'branding/logos/logo-institucion.png',
  'branding/logos/logo-empresa.png',
];

function resolveAssetPath(relativePath) {
  if (!relativePath) {
    return '';
  }

  if (/^https?:\/\//i.test(relativePath) || relativePath.startsWith('/')) {
    return relativePath;
  }

  return `${import.meta.env.BASE_URL}${relativePath}`;
}

function buildInitials(title) {
  return String(title || 'UMLA')
    .split(/\s+/)
    .filter(Boolean)
    .slice(0, 2)
    .map((chunk) => chunk[0]?.toUpperCase() || '')
    .join('') || 'UM';
}

function normalizeHexColor(value, fallback = '#d96c3f') {
  return /^#[0-9A-Fa-f]{6}$/.test(value || '') ? value : fallback;
}

function withAlpha(hexColor, alphaHex) {
  return `${normalizeHexColor(hexColor)}${alphaHex}`;
}

export function BrandLogo({
  alt = 'Logo institucional',
  title = 'UMLA',
  subtitle = 'Plataforma académica',
  brandColor = '#d96c3f',
  candidates = DEFAULT_LOGO_CANDIDATES,
  logoPath = '',
  useDefaultCandidates = true,
  className = '',
}) {
  const [candidateIndex, setCandidateIndex] = useState(0);
  const [isHorizontal, setIsHorizontal] = useState(false);
  const assetCandidates = logoPath
    ? [logoPath]
    : (useDefaultCandidates ? candidates : []);
  const assetPath = assetCandidates[candidateIndex] ? resolveAssetPath(assetCandidates[candidateIndex]) : null;
  const resolvedBrandColor = normalizeHexColor(brandColor);
  const logoStyle = {
    '--brand-accent': resolvedBrandColor,
    '--brand-accent-soft': withAlpha(resolvedBrandColor, '2b'),
    '--brand-accent-glow': withAlpha(resolvedBrandColor, '45'),
  };

  function handleError() {
    setCandidateIndex((current) => current + 1);
    setIsHorizontal(false);
  }

  function handleLoad(event) {
    const { naturalWidth, naturalHeight } = event.currentTarget;
    setIsHorizontal(naturalWidth > naturalHeight * 1.35);
  }

  if (assetPath) {
    return (
      <div className={`brand-logo ${isHorizontal ? 'is-horizontal' : ''} ${className}`.trim()} style={logoStyle}>
        <img className="brand-logo-image" src={assetPath} alt={alt} onError={handleError} onLoad={handleLoad} />
        <div className="brand-logo-copy">
          <strong>{title}</strong>
          <span>{subtitle}</span>
        </div>
      </div>
    );
  }

  return (
    <div className={`brand-logo ${className}`.trim()} style={logoStyle}>
      <div className="brand-logo-fallback" aria-hidden="true">{buildInitials(title)}</div>
      <div className="brand-logo-copy">
        <strong>{title}</strong>
        <span>{subtitle}</span>
      </div>
    </div>
  );
}