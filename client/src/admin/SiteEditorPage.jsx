import { useState, useEffect } from 'react';
import { useSite } from '../context/SiteContext';

const C = { gold: '#c9a84c', goldLight: '#dfc378', green: '#1a3a2e' };

const SECTIONS = [
  { id: 'colors',  label: '🎨 Colors' },
  { id: 'fonts',   label: '🔤 Fonts' },
  { id: 'hero',    label: '🏠 Hero Section' },
  { id: 'contact', label: '📞 Contact Info' },
  { id: 'social',  label: '🔗 Social Links' },
  { id: 'seo',     label: '🔍 SEO' },
  { id: 'footer',  label: '📄 Footer' },
  { id: 'navbar',  label: '🧭 Navbar' },
  { id: 'charts',  label: '📊 Charts' },
];

const HEADING_FONTS = ['Playfair Display','Lora','Merriweather','Cormorant Garamond','EB Garamond','Libre Baskerville','Abril Fatface'];
const BODY_FONTS    = ['Inter','Roboto','Open Sans','Lato','Nunito','Poppins','DM Sans','Source Sans 3','Raleway'];

function Section({ title, children }) {
  return (
    <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-5">
      <h3 className="font-bold text-lg text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>{title}</h3>
      {children}
    </div>
  );
}

function Field({ label, hint, children }) {
  return (
    <div>
      <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{label}</label>
      {hint && <p className="text-xs text-gray-400 mb-1">{hint}</p>}
      {children}
    </div>
  );
}

function TextInput({ value, onChange, placeholder }) {
  return (
    <input type="text" value={value || ''} onChange={e => onChange(e.target.value)} placeholder={placeholder}
      className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-yellow-400 transition-colors" />
  );
}

function TextArea({ value, onChange, rows = 3 }) {
  return (
    <textarea value={value || ''} onChange={e => onChange(e.target.value)} rows={rows}
      className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-yellow-400 transition-colors resize-none" />
  );
}

function ColorPicker({ label, value, onChange }) {
  return (
    <div className="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
      <div className="relative">
        <input type="color" value={value || '#000000'} onChange={e => onChange(e.target.value)}
          className="w-12 h-12 rounded-xl border-2 border-white shadow cursor-pointer p-0.5 bg-transparent" />
      </div>
      <div className="flex-1">
        <p className="text-sm font-semibold text-gray-700">{label}</p>
        <p className="text-xs text-gray-400 font-mono">{value}</p>
      </div>
    </div>
  );
}

function Toggle({ checked, onChange, label }) {
  return (
    <div className="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
      <span className="text-sm font-medium text-gray-700">{label}</span>
      <div onClick={() => onChange(!checked)}
        className="w-11 h-6 rounded-full cursor-pointer relative transition-all duration-200"
        style={{ background: checked ? C.gold : '#e5e7eb' }}>
        <div className={`absolute top-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200 ${checked ? 'translate-x-5' : 'translate-x-0.5'}`} />
      </div>
    </div>
  );
}

function ChartToggle({ label, value, options, onChange }) {
  return (
    <div className="space-y-2">
      <p className="text-sm font-semibold text-gray-700">{label}</p>
      <div className="flex gap-2">
        {options.map(opt => (
          <button key={opt} onClick={() => onChange(opt)}
            className="px-4 py-2 rounded-xl text-sm font-semibold border capitalize transition-all"
            style={value === opt ? { background: C.gold, color: '#fff', borderColor: C.gold } : { color: '#6b7280', borderColor: '#e5e7eb' }}>
            {opt}
          </button>
        ))}
      </div>
    </div>
  );
}

export default function SiteEditorPage({ showToast }) {
  const { settings, updateSettings } = useSite();
  const [active, setActive] = useState('colors');
  const [draft, setDraft] = useState(null);
  const [saving, setSaving] = useState(false);

  useEffect(() => { if (settings) setDraft(JSON.parse(JSON.stringify(settings))); }, [settings]);

  if (!draft) return <div className="text-gray-400 text-sm p-6">Loading settings…</div>;

  const patch = (section, key, val) =>
    setDraft(d => ({ ...d, [section]: { ...d[section], [key]: val } }));

  const save = async () => {
    setSaving(true);
    try {
      await updateSettings(draft);
      if (showToast) showToast('Site settings saved successfully!', 'success');
    } catch {
      if (showToast) showToast('Error saving settings', 'error');
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="space-y-5 max-w-3xl">
      {/* Section tabs */}
      <div className="bg-white rounded-2xl p-2 shadow-sm border border-gray-100 flex flex-wrap gap-1">
        {SECTIONS.map(({ id, label }) => (
          <button key={id} onClick={() => setActive(id)}
            className="px-3 py-2 rounded-xl text-sm font-medium transition-all whitespace-nowrap"
            style={active === id ? { background: C.gold, color: '#fff' } : { color: '#6b7280' }}>
            {label}
          </button>
        ))}
      </div>

      {/* ── COLORS ── */}
      {active === 'colors' && (
        <Section title="Colors & Theme">
          <p className="text-xs text-gray-400">Changes apply live to your site immediately after saving.</p>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
            <ColorPicker label="Primary / Gold"     value={draft.colors?.primary}    onChange={v => patch('colors','primary',v)} />
            <ColorPicker label="Accent / Dark Green" value={draft.colors?.accent}     onChange={v => patch('colors','accent',v)} />
            <ColorPicker label="Page Background"    value={draft.colors?.background} onChange={v => patch('colors','background',v)} />
            <ColorPicker label="Body Text"          value={draft.colors?.text}       onChange={v => patch('colors','text',v)} />
            <ColorPicker label="Hero Background"    value={draft.colors?.heroBg}     onChange={v => patch('colors','heroBg',v)} />
          </div>
          <div className="rounded-xl p-4 mt-2" style={{ background: draft.colors?.heroBg }}>
            <p className="text-xs font-semibold mb-1" style={{ color: draft.colors?.primary }}>Hero Preview</p>
            <p className="font-bold text-white text-lg">Grow Your Health & Wealth with DXN</p>
            <div className="flex gap-2 mt-2">
              <span className="px-3 py-1 rounded-lg text-sm font-semibold" style={{ background: draft.colors?.primary, color: draft.colors?.accent }}>Shop Products</span>
              <span className="px-3 py-1 rounded-lg text-sm font-semibold border-2 border-white text-white">Join as a Distributor</span>
            </div>
          </div>
        </Section>
      )}

      {/* ── FONTS ── */}
      {active === 'fonts' && (
        <Section title="Fonts & Typography">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
            <Field label="Heading Font">
              <select value={draft.fonts?.headingFont || 'Playfair Display'}
                onChange={e => patch('fonts','headingFont',e.target.value)}
                className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none">
                {HEADING_FONTS.map(f => <option key={f} value={f}>{f}</option>)}
              </select>
              <p className="mt-2 text-xl font-bold text-gray-700" style={{ fontFamily: `'${draft.fonts?.headingFont}', serif` }}>
                Preview: Freedom with DXN
              </p>
            </Field>
            <Field label="Body Font">
              <select value={draft.fonts?.bodyFont || 'Inter'}
                onChange={e => patch('fonts','bodyFont',e.target.value)}
                className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none">
                {BODY_FONTS.map(f => <option key={f} value={f}>{f}</option>)}
              </select>
              <p className="mt-2 text-sm text-gray-600" style={{ fontFamily: `'${draft.fonts?.bodyFont}', sans-serif` }}>
                Preview: DXN Lingzhi Coffee is your morning ritual.
              </p>
            </Field>
            <Field label="Base Font Size">
              <select value={draft.fonts?.baseSize || '16px'}
                onChange={e => patch('fonts','baseSize',e.target.value)}
                className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none">
                {['14px','15px','16px','17px','18px'].map(s => <option key={s}>{s}</option>)}
              </select>
            </Field>
            <Field label="H1 Heading Size">
              <select value={draft.fonts?.headingSize || '2.5rem'}
                onChange={e => patch('fonts','headingSize',e.target.value)}
                className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none">
                {['2rem','2.25rem','2.5rem','3rem','3.5rem','4rem'].map(s => <option key={s}>{s}</option>)}
              </select>
            </Field>
          </div>
        </Section>
      )}

      {/* ── HERO ── */}
      {active === 'hero' && (
        <Section title="Hero Section">
          <Field label="Badge Text" hint="Small label above the title">
            <TextInput value={draft.hero?.badge} onChange={v => patch('hero','badge',v)} placeholder="Independent DXN Distributor" />
          </Field>
          <Field label="Main Title">
            <TextInput value={draft.hero?.title} onChange={v => patch('hero','title',v)} placeholder="Grow Your Health & Wealth with DXN" />
          </Field>
          <Field label="Subtitle">
            <TextArea value={draft.hero?.subtitle} onChange={v => patch('hero','subtitle',v)} />
          </Field>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <Field label="Button 1 Text">
              <TextInput value={draft.hero?.btn1Text} onChange={v => patch('hero','btn1Text',v)} placeholder="Shop Products" />
            </Field>
            <Field label="Button 1 Link">
              <TextInput value={draft.hero?.btn1Link} onChange={v => patch('hero','btn1Link',v)} placeholder="/products" />
            </Field>
            <Field label="Button 2 Text">
              <TextInput value={draft.hero?.btn2Text} onChange={v => patch('hero','btn2Text',v)} placeholder="Join as a Distributor" />
            </Field>
            <Field label="Button 2 Link" hint="Use /join for internal or full URL for external">
              <TextInput value={draft.hero?.btn2Link} onChange={v => patch('hero','btn2Link',v)} placeholder="/join" />
            </Field>
          </div>
        </Section>
      )}

      {/* ── CONTACT ── */}
      {active === 'contact' && (
        <Section title="Contact Information">
          <Field label="Phone / WhatsApp Number">
            <TextInput value={draft.contact?.phone} onChange={v => patch('contact','phone',v)} placeholder="+971 50 666 2875" />
          </Field>
          <Field label="Email Address">
            <TextInput value={draft.contact?.email} onChange={v => patch('contact','email',v)} placeholder="info@freedomwithdxn.com" />
          </Field>
          <Field label="WhatsApp Link" hint="Full WhatsApp URL e.g. https://wa.me/message/XXXX">
            <TextInput value={draft.contact?.whatsapp} onChange={v => patch('contact','whatsapp',v)} placeholder="https://wa.me/message/..." />
          </Field>
          <Field label="Location">
            <TextInput value={draft.contact?.location} onChange={v => patch('contact','location',v)} placeholder="United Arab Emirates" />
          </Field>
        </Section>
      )}

      {/* ── SOCIAL ── */}
      {active === 'social' && (
        <Section title="Social Media Links">
          <Field label="Facebook URL">
            <TextInput value={draft.social?.facebook} onChange={v => patch('social','facebook',v)} placeholder="https://facebook.com/yourpage" />
          </Field>
          <Field label="Instagram URL">
            <TextInput value={draft.social?.instagram} onChange={v => patch('social','instagram',v)} placeholder="https://instagram.com/yourhandle" />
          </Field>
          <Field label="YouTube URL">
            <TextInput value={draft.social?.youtube} onChange={v => patch('social','youtube',v)} placeholder="https://youtube.com/yourchannel" />
          </Field>
        </Section>
      )}

      {/* ── SEO ── */}
      {active === 'seo' && (
        <Section title="SEO Settings">
          <Field label="Page Title" hint="Shows in browser tab and Google results">
            <TextInput value={draft.seo?.pageTitle} onChange={v => patch('seo','pageTitle',v)} placeholder="Freedom with DXN - Health & Business" />
          </Field>
          <Field label="Meta Description" hint="160 characters max — shown in Google search results">
            <TextArea value={draft.seo?.description} onChange={v => patch('seo','description',v)} rows={2} />
            <p className="text-xs text-gray-400 mt-1">{(draft.seo?.description || '').length}/160 characters</p>
          </Field>
          <Field label="Keywords" hint="Comma-separated keywords">
            <TextInput value={draft.seo?.keywords} onChange={v => patch('seo','keywords',v)} placeholder="DXN, Ganoderma, health, distributor" />
          </Field>
        </Section>
      )}

      {/* ── FOOTER ── */}
      {active === 'footer' && (
        <Section title="Footer Content">
          <Field label="Brand Description" hint="Short text below the logo in the footer">
            <TextArea value={draft.footer?.description} onChange={v => patch('footer','description',v)} />
          </Field>
          <Field label="Copyright Text">
            <TextInput value={draft.footer?.copyright} onChange={v => patch('footer','copyright',v)} placeholder="Freedom with DXN. All rights reserved." />
          </Field>
        </Section>
      )}

      {/* ── NAVBAR ── */}
      {active === 'navbar' && (
        <Section title="Navbar Link Visibility">
          <p className="text-xs text-gray-400">Toggle which links appear in the navigation bar.</p>
          <Toggle checked={draft.navbar?.showHome}     onChange={v => patch('navbar','showHome',v)}     label="Home" />
          <Toggle checked={draft.navbar?.showAbout}    onChange={v => patch('navbar','showAbout',v)}    label="About" />
          <Toggle checked={draft.navbar?.showProducts} onChange={v => patch('navbar','showProducts',v)} label="Products" />
          <Toggle checked={draft.navbar?.showJoin}     onChange={v => patch('navbar','showJoin',v)}     label="Join DXN" />
          <Toggle checked={draft.navbar?.showZoom}     onChange={v => patch('navbar','showZoom',v)}     label="Zoom Training" />
          <Toggle checked={draft.navbar?.showBlog}     onChange={v => patch('navbar','showBlog',v)}     label="Blog" />
          <Toggle checked={draft.navbar?.showContact}  onChange={v => patch('navbar','showContact',v)}  label="Contact" />
        </Section>
      )}

      {/* ── CHARTS ── */}
      {active === 'charts' && (
        <Section title="Dashboard Chart Types">
          <p className="text-xs text-gray-400">Choose how data is displayed in the admin dashboard.</p>
          <ChartToggle label="Sales Overview" value={draft.charts?.salesChartType}
            options={['line','bar']} onChange={v => patch('charts','salesChartType',v)} />
          <ChartToggle label="Sales by Category" value={draft.charts?.categoryChartType}
            options={['pie','bar']} onChange={v => patch('charts','categoryChartType',v)} />
          <ChartToggle label="Monthly Revenue" value={draft.charts?.revenueChartType}
            options={['bar','line']} onChange={v => patch('charts','revenueChartType',v)} />
        </Section>
      )}

      {/* Save bar */}
      <div className="flex items-center justify-between bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <p className="text-xs text-gray-400">Changes are saved to the database and applied to your live site instantly.</p>
        <button onClick={save} disabled={saving}
          className="px-6 py-2.5 text-sm font-semibold text-white rounded-xl disabled:opacity-50 transition-opacity"
          style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
          {saving ? 'Saving…' : 'Save Changes'}
        </button>
      </div>
    </div>
  );
}
