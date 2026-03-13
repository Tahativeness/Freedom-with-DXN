import { createContext, useContext, useState, useEffect, useCallback } from 'react';
import axios from 'axios';

const SiteContext = createContext(null);

const DEFAULT = {
  colors:  { primary: '#dfc378', accent: '#1a3a2e', background: '#ffffff', text: '#1a2e25', heroBg: '#0c3935' },
  fonts:   { headingFont: 'Playfair Display', bodyFont: 'Inter', baseSize: '16px', headingSize: '2.5rem' },
  hero:    { badge: 'Independent DXN Distributor', title: 'Grow Your Health & Wealth with DXN',
             subtitle: 'Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life.',
             btn1Text: 'Shop Products', btn1Link: '/products', btn2Text: 'Join as a Distributor', btn2Link: '/join' },
  contact: { phone: '+971 50 666 2875', email: 'info@freedomwithdxn.com', whatsapp: 'https://wa.me/message/EFSQ2IDNVG3YB1', location: 'United Arab Emirates' },
  social:  { facebook: '', instagram: '', youtube: '' },
  seo:     { pageTitle: 'Freedom with DXN', description: '', keywords: '' },
  footer:  { description: 'Your trusted DXN distributor.', copyright: 'Freedom with DXN. All rights reserved.' },
  navbar:  { showHome: true, showAbout: true, showProducts: true, showJoin: true, showZoom: true, showBlog: true, showContact: true },
  charts:  { salesChartType: 'line', categoryChartType: 'pie', revenueChartType: 'bar' },
};

function applyCSS(s) {
  const r = document.documentElement;
  r.style.setProperty('--color-primary',    s.colors.primary);
  r.style.setProperty('--color-accent',     s.colors.accent);
  r.style.setProperty('--color-background', s.colors.background);
  r.style.setProperty('--color-text',       s.colors.text);
  r.style.setProperty('--color-hero-bg',    s.colors.heroBg);
  r.style.setProperty('--font-heading',     `'${s.fonts.headingFont}', serif`);
  r.style.setProperty('--font-body',        `'${s.fonts.bodyFont}', sans-serif`);
  r.style.setProperty('--font-base-size',   s.fonts.baseSize);
  r.style.setProperty('--font-heading-size',s.fonts.headingSize);

  // Inject Google Fonts dynamically
  const url = `https://fonts.googleapis.com/css2?family=${s.fonts.headingFont.replace(/ /g,'+')}:wght@600;700&family=${s.fonts.bodyFont.replace(/ /g,'+')}:wght@400;500;600&display=swap`;
  let link = document.getElementById('gf-dynamic');
  if (!link) { link = document.createElement('link'); link.id = 'gf-dynamic'; link.rel = 'stylesheet'; document.head.appendChild(link); }
  link.href = url;

  // SEO meta
  document.title = s.seo?.pageTitle || 'Freedom with DXN';
  document.querySelector('meta[name="description"]')?.setAttribute('content', s.seo?.description || '');
  document.querySelector('meta[name="keywords"]')?.setAttribute('content', s.seo?.keywords || '');
}

export function SiteProvider({ children }) {
  const [settings, setSettings] = useState(DEFAULT);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('/api/site-settings')
      .then(({ data }) => { setSettings({ ...DEFAULT, ...data }); applyCSS({ ...DEFAULT, ...data }); })
      .catch(() => applyCSS(DEFAULT))
      .finally(() => setLoading(false));
  }, []);

  const updateSettings = useCallback(async (partial) => {
    const { data } = await axios.put('/api/site-settings', partial, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    });
    const merged = { ...DEFAULT, ...data };
    setSettings(merged);
    applyCSS(merged);
    return merged;
  }, []);

  return (
    <SiteContext.Provider value={{ settings, loading, updateSettings }}>
      {children}
    </SiteContext.Provider>
  );
}

export const useSite = () => {
  const ctx = useContext(SiteContext);
  if (!ctx) throw new Error('useSite must be used within SiteProvider');
  return ctx;
};
