import { useState, useEffect, useRef, useCallback } from 'react';
import {
  LayoutDashboard, ShoppingCart, Package, Users, DollarSign,
  BarChart2, Megaphone, Settings, LogOut, Bell, Search,
  ChevronDown, TrendingUp, TrendingDown, Copy, Share2,
  Eye, Edit, Trash2, Plus, Filter, Download, ChevronRight,
  ChevronLeft, ArrowUpRight, Check, X, Menu, Award,
  CheckCircle, Clock, XCircle, ChevronUp, Shield, Globe,
  Phone, Mail, User, Lock, Camera, Link, Facebook, Twitter,
  Instagram, Star, RefreshCw, AlertCircle,
} from 'lucide-react';
import {
  LineChart, Line, BarChart, Bar, XAxis, YAxis, CartesianGrid,
  Tooltip, ResponsiveContainer, PieChart, Pie, Cell,
} from 'recharts';
import { salesData, categoryData, orders, members, commissions, topProducts } from './mockData';

// ── Brand colors ──────────────────────────────────────────────
const C = {
  sidebar: '#1a3a2e',
  sidebarHover: '#243f33',
  gold: '#c9a84c',
  goldLight: '#e8c97e',
  cream: '#f5f0e8',
  green: '#2d7a4f',
  text: '#1a2e25',
};

// ── Helpers ───────────────────────────────────────────────────
const fmt = (n) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 }).format(n);
const fmtD = (d) => new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

function StatusBadge({ status }) {
  const map = {
    Delivered:  'bg-green-100 text-green-700',
    Shipped:    'bg-blue-100 text-blue-700',
    Pending:    'bg-yellow-100 text-yellow-700',
    Cancelled:  'bg-red-100 text-red-700',
    Active:     'bg-green-100 text-green-700',
    Inactive:   'bg-gray-100 text-gray-500',
    Paid:       'bg-green-100 text-green-700',
    Gold:       'bg-yellow-100 text-yellow-700',
    Silver:     'bg-gray-100 text-gray-600',
    Bronze:     'bg-orange-100 text-orange-700',
  };
  const icons = { Delivered: CheckCircle, Shipped: RefreshCw, Pending: Clock, Cancelled: XCircle, Paid: CheckCircle };
  const Icon = icons[status];
  return (
    <span className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold ${map[status] || 'bg-gray-100 text-gray-600'}`}>
      {Icon && <Icon size={10} />}{status}
    </span>
  );
}

function Toast({ msg, onClose }) {
  useEffect(() => { const t = setTimeout(onClose, 3000); return () => clearTimeout(t); }, [onClose]);
  return (
    <div className="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-gray-100 shadow-2xl rounded-xl px-4 py-3 animate-fade-in">
      <div className="w-7 h-7 rounded-full flex items-center justify-center" style={{ background: C.gold }}>
        <Check size={14} className="text-white" />
      </div>
      <span className="text-sm font-medium text-gray-800">{msg}</span>
      <button onClick={onClose}><X size={14} className="text-gray-400" /></button>
    </div>
  );
}

// ── Count-up animation ────────────────────────────────────────
function CountUp({ end, prefix = '', suffix = '', duration = 1500 }) {
  const [val, setVal] = useState(0);
  useEffect(() => {
    let start = 0; const step = end / (duration / 16);
    const t = setInterval(() => {
      start += step;
      if (start >= end) { setVal(end); clearInterval(t); } else setVal(Math.floor(start));
    }, 16);
    return () => clearInterval(t);
  }, [end, duration]);
  return <>{prefix}{val.toLocaleString()}{suffix}</>;
}

// ── Skeleton ──────────────────────────────────────────────────
function Skeleton({ className = '' }) {
  return <div className={`animate-pulse bg-gray-200 rounded-lg ${className}`} />;
}

// ══════════════════════════════════════════════════════════════
// SIDEBAR
// ══════════════════════════════════════════════════════════════
const NAV = [
  { id: 'dashboard',    label: 'Dashboard',       Icon: LayoutDashboard },
  { id: 'orders',       label: 'Orders',           Icon: ShoppingCart },
  { id: 'products',     label: 'Products',         Icon: Package },
  { id: 'members',      label: 'Members',          Icon: Users },
  { id: 'commissions',  label: 'Commissions',      Icon: DollarSign },
  { id: 'reports',      label: 'Reports',          Icon: BarChart2 },
  { id: 'marketing',    label: 'Marketing',        Icon: Megaphone },
  { id: 'settings',     label: 'Settings',         Icon: Settings },
];

function Sidebar({ active, setActive, collapsed, setCollapsed }) {
  return (
    <aside
      className="fixed left-0 top-0 h-full z-30 flex flex-col transition-all duration-300"
      style={{ width: collapsed ? 72 : 240, background: C.sidebar }}
    >
      {/* Logo */}
      <div className="flex items-center gap-3 px-4 py-5 border-b border-white/10">
        <div className="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style={{ background: C.gold }}>
          <span className="text-white font-bold text-sm">DXN</span>
        </div>
        {!collapsed && (
          <div className="overflow-hidden">
            <div className="text-white font-bold text-sm leading-tight" style={{ fontFamily: 'Playfair Display, serif' }}>Freedom with DXN</div>
            <div className="text-xs" style={{ color: C.gold }}>Admin Dashboard</div>
          </div>
        )}
      </div>

      {/* Nav */}
      <nav className="flex-1 py-4 overflow-y-auto">
        {NAV.map(({ id, label, Icon }) => {
          const isActive = active === id;
          return (
            <button
              key={id}
              onClick={() => setActive(id)}
              className="w-full flex items-center gap-3 px-4 py-3 mx-2 rounded-xl transition-all duration-200 group relative"
              style={{
                width: 'calc(100% - 16px)',
                background: isActive ? C.gold + '22' : 'transparent',
                borderLeft: isActive ? `3px solid ${C.gold}` : '3px solid transparent',
              }}
            >
              <Icon size={18} color={isActive ? C.gold : '#9ca3af'} className="shrink-0 transition-colors group-hover:text-white" />
              {!collapsed && (
                <span className="text-sm font-medium transition-colors" style={{ color: isActive ? C.gold : '#d1d5db' }}>
                  {label}
                </span>
              )}
              {collapsed && (
                <div className="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                  {label}
                </div>
              )}
            </button>
          );
        })}
      </nav>

      {/* Collapse toggle + Logout */}
      <div className="border-t border-white/10 p-3 space-y-1">
        <button
          onClick={() => setActive('logout')}
          className="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors hover:bg-red-500/10 group"
        >
          <LogOut size={18} color="#ef4444" className="shrink-0" />
          {!collapsed && <span className="text-sm text-red-400 font-medium">Logout</span>}
        </button>
        <button
          onClick={() => setCollapsed(!collapsed)}
          className="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors hover:bg-white/5"
        >
          {collapsed ? <ChevronRight size={16} color="#9ca3af" className="mx-auto" /> : <ChevronLeft size={16} color="#9ca3af" />}
          {!collapsed && <span className="text-xs text-gray-400">Collapse</span>}
        </button>
      </div>
    </aside>
  );
}

// ══════════════════════════════════════════════════════════════
// TOPBAR
// ══════════════════════════════════════════════════════════════
function Topbar({ page, collapsed, setCollapsed, showToast }) {
  const [notifOpen, setNotifOpen] = useState(false);
  const [userOpen, setUserOpen]   = useState(false);
  const notifs = [
    { msg: 'New order #ORD-013 received', time: '2 min ago', unread: true },
    { msg: 'Ahmad Hassan joined your team', time: '1 hour ago', unread: true },
    { msg: 'Commission payout processed', time: '3 hours ago', unread: false },
    { msg: 'Monthly report ready', time: '1 day ago', unread: false },
  ];
  const unread = notifs.filter(n => n.unread).length;

  return (
    <header className="fixed top-0 right-0 z-20 flex items-center gap-4 px-6 py-4 bg-white border-b border-gray-100 shadow-sm"
      style={{ left: collapsed ? 72 : 240, transition: 'left 0.3s' }}>
      <button className="md:hidden" onClick={() => setCollapsed(!collapsed)}>
        <Menu size={20} className="text-gray-500" />
      </button>
      <div>
        <h1 className="text-lg font-bold capitalize" style={{ color: C.text, fontFamily: 'Playfair Display, serif' }}>
          {page.replace('-', ' ')}
        </h1>
      </div>

      {/* Search */}
      <div className="flex-1 max-w-md ml-4 hidden md:block">
        <div className="relative">
          <Search size={15} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
          <input placeholder="Search orders, members, products…" className="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent" style={{ '--tw-ring-color': C.gold + '60' }} />
        </div>
      </div>

      <div className="flex items-center gap-3 ml-auto">
        {/* Notifications */}
        <div className="relative">
          <button onClick={() => { setNotifOpen(!notifOpen); setUserOpen(false); }}
            className="relative w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
            <Bell size={17} className="text-gray-600" />
            {unread > 0 && <span className="absolute -top-1 -right-1 w-4 h-4 rounded-full text-white text-[10px] font-bold flex items-center justify-center" style={{ background: C.gold }}>{unread}</span>}
          </button>
          {notifOpen && (
            <div className="absolute right-0 top-12 w-80 bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden z-50">
              <div className="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span className="font-semibold text-sm text-gray-800">Notifications</span>
                <button className="text-xs font-medium" style={{ color: C.gold }}>Mark all read</button>
              </div>
              {notifs.map((n, i) => (
                <div key={i} className={`flex gap-3 px-4 py-3 border-b border-gray-50 hover:bg-gray-50 ${n.unread ? 'bg-amber-50/40' : ''}`}>
                  <div className="w-2 h-2 mt-1.5 rounded-full shrink-0" style={{ background: n.unread ? C.gold : '#e5e7eb' }} />
                  <div>
                    <p className="text-sm text-gray-800">{n.msg}</p>
                    <p className="text-xs text-gray-400 mt-0.5">{n.time}</p>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* User avatar */}
        <div className="relative">
          <button onClick={() => { setUserOpen(!userOpen); setNotifOpen(false); }}
            className="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-gray-50 transition-colors">
            <div className="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold" style={{ background: C.gold }}>T</div>
            <div className="hidden md:block text-left">
              <div className="text-sm font-semibold text-gray-800">Taha Mina</div>
              <div className="text-xs text-gray-400">Admin</div>
            </div>
            <ChevronDown size={14} className="text-gray-400" />
          </button>
          {userOpen && (
            <div className="absolute right-0 top-12 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden z-50">
              {['Profile', 'Settings', 'Help'].map(item => (
                <button key={item} className="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">{item}</button>
              ))}
              <div className="border-t border-gray-100">
                <button className="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50">Logout</button>
              </div>
            </div>
          )}
        </div>
      </div>
    </header>
  );
}

// ══════════════════════════════════════════════════════════════
// DASHBOARD PAGE
// ══════════════════════════════════════════════════════════════
function DashboardPage({ showToast }) {
  const [loading, setLoading] = useState(true);
  useEffect(() => { setTimeout(() => setLoading(false), 1000); }, []);

  const stats = [
    { label: 'Total Downlines', value: 47, prefix: '', suffix: '', trend: +12.5, Icon: Users, color: '#3b82f6' },
    { label: 'Orders This Month', value: 89, prefix: '', suffix: '', trend: +8.3, Icon: ShoppingCart, color: C.green },
    { label: 'Total Sales', value: 12840, prefix: '$', suffix: '', trend: +15.2, Icon: DollarSign, color: C.gold },
    { label: 'Current Rank', value: 'Gold', isText: true, trend: null, Icon: Award, color: '#f59e0b', cta: 'Upgrade to Diamond' },
  ];

  const referralLink = 'https://freedomwithdxn.com/join?ref=TAHA2026';

  return (
    <div className="space-y-6">
      {/* Stats */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {stats.map(({ label, value, prefix, suffix, trend, Icon, color, isText, cta }) => (
          <div key={label} className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            {loading ? (
              <div className="space-y-3"><Skeleton className="h-4 w-24" /><Skeleton className="h-8 w-20" /></div>
            ) : (
              <>
                <div className="flex items-center justify-between mb-3">
                  <span className="text-sm text-gray-500 font-medium">{label}</span>
                  <div className="w-9 h-9 rounded-xl flex items-center justify-center" style={{ background: color + '18' }}>
                    <Icon size={17} style={{ color }} />
                  </div>
                </div>
                <div className="text-2xl font-bold" style={{ color: C.text, fontFamily: 'Playfair Display, serif' }}>
                  {isText ? value : <CountUp end={value} prefix={prefix} suffix={suffix} />}
                </div>
                {trend !== null ? (
                  <div className={`flex items-center gap-1 mt-1.5 text-xs font-medium ${trend > 0 ? 'text-green-600' : 'text-red-500'}`}>
                    {trend > 0 ? <TrendingUp size={12} /> : <TrendingDown size={12} />}
                    {Math.abs(trend)}% from last month
                  </div>
                ) : (
                  <div className="mt-1.5">
                    <span className="text-xs font-semibold cursor-pointer hover:underline" style={{ color: C.gold }}>{cta} →</span>
                  </div>
                )}
              </>
            )}
          </div>
        ))}
      </div>

      {/* Charts row */}
      <div className="grid grid-cols-1 xl:grid-cols-3 gap-4">
        {/* Sales line chart */}
        <div className="xl:col-span-2 bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div className="flex items-center justify-between mb-5">
            <div>
              <h3 className="font-bold text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>Sales Overview</h3>
              <p className="text-xs text-gray-400 mt-0.5">Last 30 days revenue</p>
            </div>
            <div className="flex gap-2">
              {['7D', '30D', '90D'].map(p => (
                <button key={p} className={`px-3 py-1 text-xs rounded-lg font-medium transition-colors ${p === '30D' ? 'text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-100'}`}
                  style={p === '30D' ? { background: C.gold } : {}}>
                  {p}
                </button>
              ))}
            </div>
          </div>
          {loading ? <Skeleton className="h-52 w-full" /> : (
            <ResponsiveContainer width="100%" height={200}>
              <LineChart data={salesData}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis dataKey="date" tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} />
                <YAxis tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} tickFormatter={v => `$${v/1000}k`} />
                <Tooltip formatter={(v) => [`$${v.toLocaleString()}`, 'Sales']} contentStyle={{ borderRadius: 12, border: 'none', boxShadow: '0 4px 20px rgba(0,0,0,0.1)' }} />
                <Line type="monotone" dataKey="sales" stroke={C.gold} strokeWidth={2.5} dot={false} activeDot={{ r: 5, fill: C.gold }} />
              </LineChart>
            </ResponsiveContainer>
          )}
        </div>

        {/* Category pie */}
        <div className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <h3 className="font-bold text-gray-800 mb-1" style={{ fontFamily: 'Playfair Display, serif' }}>Sales by Category</h3>
          <p className="text-xs text-gray-400 mb-4">Product breakdown</p>
          {loading ? <Skeleton className="h-52 w-full" /> : (
            <>
              <ResponsiveContainer width="100%" height={160}>
                <PieChart>
                  <Pie data={categoryData} cx="50%" cy="50%" innerRadius={45} outerRadius={70} paddingAngle={3} dataKey="value">
                    {categoryData.map((entry, i) => <Cell key={i} fill={entry.color} />)}
                  </Pie>
                  <Tooltip formatter={(v) => [`${v}%`]} contentStyle={{ borderRadius: 10, border: 'none', boxShadow: '0 4px 16px rgba(0,0,0,0.1)' }} />
                </PieChart>
              </ResponsiveContainer>
              <div className="space-y-2 mt-2">
                {categoryData.map(({ name, value, color }) => (
                  <div key={name} className="flex items-center justify-between text-xs">
                    <div className="flex items-center gap-2">
                      <div className="w-2.5 h-2.5 rounded-full" style={{ background: color }} />
                      <span className="text-gray-600">{name}</span>
                    </div>
                    <span className="font-semibold text-gray-800">{value}%</span>
                  </div>
                ))}
              </div>
            </>
          )}
        </div>
      </div>

      {/* Bottom row */}
      <div className="grid grid-cols-1 xl:grid-cols-3 gap-4">
        {/* Recent orders */}
        <div className="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div className="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 className="font-bold text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>Recent Orders</h3>
            <button className="text-xs font-medium flex items-center gap-1" style={{ color: C.gold }}>View all <ArrowUpRight size={12} /></button>
          </div>
          {loading ? (
            <div className="p-4 space-y-3">{[1,2,3].map(i => <Skeleton key={i} className="h-12 w-full" />)}</div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead><tr className="bg-gray-50">{['Order ID','Customer','Product','Amount','Status'].map(h => <th key={h} className="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">{h}</th>)}</tr></thead>
                <tbody>
                  {orders.slice(0,5).map(o => (
                    <tr key={o.id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                      <td className="px-4 py-3 font-mono text-xs text-gray-500">{o.id}</td>
                      <td className="px-4 py-3 font-medium text-gray-800">{o.customer}</td>
                      <td className="px-4 py-3 text-gray-500 max-w-[160px] truncate">{o.product}</td>
                      <td className="px-4 py-3 font-semibold text-gray-800">${o.amount.toFixed(2)}</td>
                      <td className="px-4 py-3"><StatusBadge status={o.status} /></td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>

        {/* Right column */}
        <div className="space-y-4">
          {/* Top products */}
          <div className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 className="font-bold text-gray-800 mb-4" style={{ fontFamily: 'Playfair Display, serif' }}>Top Products</h3>
            {loading ? <div className="space-y-3">{[1,2,3].map(i => <Skeleton key={i} className="h-10 w-full" />)}</div> : (
              <div className="space-y-3">
                {topProducts.slice(0,4).map((p, i) => (
                  <div key={p.name} className="flex items-center gap-3">
                    <span className="text-xs font-bold text-gray-300 w-4">{i+1}</span>
                    <div className="w-9 h-9 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                      <img src={p.image} alt={p.name} className="w-full h-full object-cover" onError={e => { e.target.style.display='none'; }} />
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="text-xs font-semibold text-gray-800 truncate">{p.name}</p>
                      <p className="text-xs text-gray-400">{p.sold} sold</p>
                    </div>
                    <span className="text-xs font-bold text-green-600">{fmt(p.revenue)}</span>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Referral link */}
          <div className="rounded-2xl p-5 shadow-sm border" style={{ background: C.sidebar, borderColor: C.gold + '30' }}>
            <div className="flex items-center gap-2 mb-3">
              <Link size={15} style={{ color: C.gold }} />
              <h3 className="font-bold text-white text-sm" style={{ fontFamily: 'Playfair Display, serif' }}>Your Referral Link</h3>
            </div>
            <div className="flex gap-2 mb-3">
              <input readOnly value="freedomwithdxn.com/join?ref=TAHA2026"
                className="flex-1 text-xs bg-white/10 text-white/80 border border-white/10 rounded-lg px-3 py-2 focus:outline-none min-w-0" />
              <button onClick={() => { navigator.clipboard.writeText('https://freedomwithdxn.com/join?ref=TAHA2026'); showToast('Link copied!'); }}
                className="px-3 py-2 rounded-lg text-xs font-semibold text-white flex items-center gap-1 shrink-0" style={{ background: C.gold }}>
                <Copy size={12} /> Copy
              </button>
            </div>
            <div className="flex gap-2">
              {[{ Icon: Facebook, color: '#1877f2' }, { Icon: Twitter, color: '#1da1f2' }, { Icon: Instagram, color: '#e1306c' }].map(({ Icon, color }) => (
                <button key={color} className="w-8 h-8 rounded-lg flex items-center justify-center bg-white/10 hover:bg-white/20 transition-colors">
                  <Icon size={14} style={{ color }} />
                </button>
              ))}
              <button className="flex-1 text-xs font-medium text-white/60 hover:text-white transition-colors flex items-center justify-end gap-1">
                <Share2 size={12} /> Share
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// ORDERS PAGE
// ══════════════════════════════════════════════════════════════
function OrdersPage({ showToast }) {
  const [search, setSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('All');
  const [page, setPage] = useState(1);
  const [sortBy, setSortBy] = useState('date');
  const [sortDir, setSortDir] = useState('desc');
  const PER_PAGE = 8;

  const statuses = ['All', 'Pending', 'Shipped', 'Delivered', 'Cancelled'];

  const filtered = orders
    .filter(o => (statusFilter === 'All' || o.status === statusFilter) &&
      (o.customer.toLowerCase().includes(search.toLowerCase()) || o.id.toLowerCase().includes(search.toLowerCase())))
    .sort((a, b) => {
      const dir = sortDir === 'asc' ? 1 : -1;
      if (sortBy === 'amount') return (a.amount - b.amount) * dir;
      if (sortBy === 'date') return (new Date(a.date) - new Date(b.date)) * dir;
      return a.customer.localeCompare(b.customer) * dir;
    });

  const pages = Math.ceil(filtered.length / PER_PAGE);
  const paginated = filtered.slice((page - 1) * PER_PAGE, page * PER_PAGE);

  const toggle = (col) => { if (sortBy === col) setSortDir(d => d === 'asc' ? 'desc' : 'asc'); else { setSortBy(col); setSortDir('desc'); } };
  const SortIcon = ({ col }) => sortBy === col ? (sortDir === 'asc' ? <ChevronUp size={12} /> : <ChevronDown size={12} />) : null;

  const exportCSV = () => {
    const rows = [['Order ID','Customer','Product','Amount','Status','Date'],...filtered.map(o => [o.id,o.customer,o.product,o.amount,o.status,o.date])];
    const csv = rows.map(r => r.join(',')).join('\n');
    const a = document.createElement('a'); a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv); a.download = 'orders.csv'; a.click();
    showToast('Orders exported as CSV');
  };

  return (
    <div className="space-y-5">
      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        {[['Total', orders.length, '#6366f1'], ['Pending', orders.filter(o=>o.status==='Pending').length, '#f59e0b'],
          ['Shipped', orders.filter(o=>o.status==='Shipped').length, '#3b82f6'],
          ['Delivered', orders.filter(o=>o.status==='Delivered').length, '#10b981']].map(([l, v, c]) => (
          <div key={l} className="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl flex items-center justify-center" style={{ background: c + '18' }}>
              <ShoppingCart size={16} style={{ color: c }} />
            </div>
            <div><p className="text-2xl font-bold" style={{ color: C.text }}>{v}</p><p className="text-xs text-gray-400">{l}</p></div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {/* Toolbar */}
        <div className="flex flex-col md:flex-row gap-3 p-4 border-b border-gray-100">
          <div className="relative flex-1">
            <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
            <input value={search} onChange={e => { setSearch(e.target.value); setPage(1); }}
              placeholder="Search by name or order ID…"
              className="w-full pl-9 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none" />
          </div>
          <div className="flex gap-2 flex-wrap">
            {statuses.map(s => (
              <button key={s} onClick={() => { setStatusFilter(s); setPage(1); }}
                className={`px-3 py-2 text-xs font-semibold rounded-xl transition-colors ${statusFilter === s ? 'text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'}`}
                style={statusFilter === s ? { background: C.gold } : {}}>
                {s}
              </button>
            ))}
          </div>
          <button onClick={exportCSV} className="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors whitespace-nowrap">
            <Download size={14} /> Export CSV
          </button>
        </div>

        {/* Table */}
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="bg-gray-50">
                {[['Order ID', null], ['Customer', 'customer'], ['Product', null], ['Amount', 'amount'], ['Status', null], ['Date', 'date'], ['', null]].map(([h, col]) => (
                  <th key={h} onClick={() => col && toggle(col)}
                    className={`text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide ${col ? 'cursor-pointer hover:text-gray-700 select-none' : ''}`}>
                    <span className="flex items-center gap-1">{h}{col && <SortIcon col={col} />}</span>
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>
              {paginated.map(o => (
                <tr key={o.id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                  <td className="px-4 py-3.5 font-mono text-xs font-semibold text-gray-500">{o.id}</td>
                  <td className="px-4 py-3.5">
                    <div className="font-semibold text-gray-800">{o.customer}</div>
                    <div className="text-xs text-gray-400">{o.email}</div>
                  </td>
                  <td className="px-4 py-3.5 text-gray-600 max-w-[180px] truncate">{o.product}</td>
                  <td className="px-4 py-3.5 font-bold text-gray-800">${o.amount.toFixed(2)}</td>
                  <td className="px-4 py-3.5"><StatusBadge status={o.status} /></td>
                  <td className="px-4 py-3.5 text-gray-500 text-xs">{fmtD(o.date)}</td>
                  <td className="px-4 py-3.5">
                    <button className="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"><Eye size={14} /></button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* Pagination */}
        <div className="flex items-center justify-between px-4 py-3 border-t border-gray-100">
          <span className="text-xs text-gray-400">Showing {(page-1)*PER_PAGE+1}–{Math.min(page*PER_PAGE, filtered.length)} of {filtered.length}</span>
          <div className="flex gap-1">
            <button onClick={() => setPage(p => Math.max(1,p-1))} disabled={page===1} className="p-2 rounded-lg hover:bg-gray-100 disabled:opacity-30">
              <ChevronLeft size={14} />
            </button>
            {[...Array(pages)].map((_,i) => (
              <button key={i} onClick={() => setPage(i+1)}
                className={`w-8 h-8 text-xs rounded-lg font-medium ${page===i+1 ? 'text-white' : 'hover:bg-gray-100 text-gray-600'}`}
                style={page===i+1 ? { background: C.gold } : {}}>
                {i+1}
              </button>
            ))}
            <button onClick={() => setPage(p => Math.min(pages,p+1))} disabled={page===pages} className="p-2 rounded-lg hover:bg-gray-100 disabled:opacity-30">
              <ChevronRight size={14} />
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// PRODUCTS PAGE
// ══════════════════════════════════════════════════════════════
const PRODUCT_CATEGORIES = ['coffee','ganoderma','supplements','skincare','beverages','personal-care','other'];

function ProductsPage({ showToast }) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editing, setEditing] = useState(null);
  const [search, setSearch] = useState('');
  const [catFilter, setCatFilter] = useState('all');
  const [form, setForm] = useState({ name:'', description:'', price:'', category:'coffee', inStock:true, featured:false, image:'' });

  useEffect(() => {
    fetch('/api/products?limit=100').then(r => r.json()).then(d => { setProducts(d.products || []); setLoading(false); }).catch(() => setLoading(false));
  }, []);

  const filtered = products.filter(p =>
    (catFilter === 'all' || p.category === catFilter) &&
    p.name.toLowerCase().includes(search.toLowerCase())
  );

  const openAdd = () => { setEditing(null); setForm({ name:'', description:'', price:'', category:'coffee', inStock:true, featured:false, image:'' }); setShowModal(true); };
  const openEdit = (p) => { setEditing(p); setForm({ name:p.name, description:p.description, price:p.price, category:p.category, inStock:p.inStock, featured:p.featured, image:p.image||'' }); setShowModal(true); };

  const save = async () => {
    const token = localStorage.getItem('token');
    const url = editing ? `/api/products/${editing._id}` : '/api/products';
    const method = editing ? 'PUT' : 'POST';
    try {
      const res = await fetch(url, { method, headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` }, body: JSON.stringify({ ...form, price: parseFloat(form.price) }) });
      if (!res.ok) throw new Error();
      const data = await res.json();
      if (editing) setProducts(ps => ps.map(p => p._id === editing._id ? data : p));
      else setProducts(ps => [data, ...ps]);
      setShowModal(false);
      showToast(editing ? 'Product updated!' : 'Product added!');
    } catch { showToast('Error saving product'); }
  };

  const del = async (id) => {
    if (!confirm('Delete this product?')) return;
    const token = localStorage.getItem('token');
    try {
      await fetch(`/api/products/${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${token}` } });
      setProducts(ps => ps.filter(p => p._id !== id));
      showToast('Product deleted');
    } catch { showToast('Error deleting product'); }
  };

  return (
    <div className="space-y-5">
      {/* Toolbar */}
      <div className="flex flex-col md:flex-row gap-3">
        <div className="relative flex-1">
          <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
          <input value={search} onChange={e => setSearch(e.target.value)} placeholder="Search products…"
            className="w-full pl-9 pr-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none shadow-sm" />
        </div>
        <div className="flex gap-2 overflow-x-auto">
          {['all', ...PRODUCT_CATEGORIES].map(c => (
            <button key={c} onClick={() => setCatFilter(c)}
              className={`px-3 py-2 text-xs font-semibold rounded-xl whitespace-nowrap transition-colors ${catFilter===c ? 'text-white' : 'bg-white text-gray-600 border border-gray-200'}`}
              style={catFilter===c ? { background: C.gold } : {}}>
              {c.replace('-', ' ').replace(/^\w/, s => s.toUpperCase())}
            </button>
          ))}
        </div>
        <button onClick={openAdd} className="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl whitespace-nowrap shadow-sm"
          style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
          <Plus size={15} /> Add Product
        </button>
      </div>

      {loading ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          {[...Array(8)].map((_, i) => <Skeleton key={i} className="h-64" />)}
        </div>
      ) : filtered.length === 0 ? (
        <div className="bg-white rounded-2xl p-16 text-center border border-gray-100">
          <Package size={40} className="mx-auto text-gray-300 mb-3" />
          <p className="text-gray-500 font-medium">No products found</p>
          <button onClick={openAdd} className="mt-4 px-5 py-2 text-sm font-semibold text-white rounded-xl" style={{ background: C.gold }}>Add First Product</button>
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          {filtered.map(p => (
            <div key={p._id} className="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
              <div className="relative h-44 bg-gray-100">
                {p.image ? (
                  <img src={p.image} alt={p.name} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                ) : (
                  <div className="w-full h-full flex items-center justify-center" style={{ background: C.sidebar }}>
                    <span className="text-2xl font-bold" style={{ color: C.gold }}>DXN</span>
                  </div>
                )}
                <div className="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button onClick={() => openEdit(p)} className="p-1.5 bg-white rounded-lg shadow-sm hover:bg-blue-50"><Edit size={12} className="text-blue-500" /></button>
                  <button onClick={() => del(p._id)} className="p-1.5 bg-white rounded-lg shadow-sm hover:bg-red-50"><Trash2 size={12} className="text-red-400" /></button>
                </div>
                {p.featured && <span className="absolute top-2 left-2 text-xs px-2 py-0.5 rounded-full text-white font-semibold" style={{ background: C.gold }}>Featured</span>}
              </div>
              <div className="p-4">
                <span className="text-xs font-medium uppercase tracking-wide" style={{ color: C.green }}>{p.category}</span>
                <h4 className="font-semibold text-gray-800 mt-0.5 mb-2 line-clamp-1 text-sm">{p.name}</h4>
                <div className="flex items-center justify-between">
                  <span className="font-bold text-lg" style={{ color: C.text }}>${p.price?.toFixed(2)}</span>
                  <span className={`text-xs px-2 py-0.5 rounded-full font-medium ${p.inStock ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500'}`}>
                    {p.inStock ? 'In Stock' : 'Out'}
                  </span>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
          <div className="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
            <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100">
              <h3 className="font-bold text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>{editing ? 'Edit Product' : 'Add New Product'}</h3>
              <button onClick={() => setShowModal(false)} className="p-1.5 rounded-lg hover:bg-gray-100"><X size={16} /></button>
            </div>
            <div className="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
              {[['Product Name', 'name', 'text'], ['Price (USD)', 'price', 'number'], ['Image URL', 'image', 'text']].map(([label, key, type]) => (
                <div key={key}>
                  <label className="text-xs font-semibold text-gray-600 uppercase tracking-wide">{label}</label>
                  <input type={type} value={form[key]} onChange={e => setForm(f => ({ ...f, [key]: e.target.value }))}
                    className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none" />
                </div>
              ))}
              <div>
                <label className="text-xs font-semibold text-gray-600 uppercase tracking-wide">Description</label>
                <textarea value={form.description} onChange={e => setForm(f => ({ ...f, description: e.target.value }))} rows={3}
                  className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none resize-none" />
              </div>
              <div>
                <label className="text-xs font-semibold text-gray-600 uppercase tracking-wide">Category</label>
                <select value={form.category} onChange={e => setForm(f => ({ ...f, category: e.target.value }))}
                  className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none bg-white">
                  {PRODUCT_CATEGORIES.map(c => <option key={c} value={c}>{c}</option>)}
                </select>
              </div>
              <div className="flex gap-6">
                {[['In Stock', 'inStock'], ['Featured', 'featured']].map(([l, k]) => (
                  <label key={k} className="flex items-center gap-2 cursor-pointer">
                    <div onClick={() => setForm(f => ({ ...f, [k]: !f[k] }))}
                      className={`w-10 h-5 rounded-full transition-colors relative ${form[k] ? '' : 'bg-gray-200'}`}
                      style={form[k] ? { background: C.gold } : {}}>
                      <div className={`absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform ${form[k] ? 'translate-x-5' : 'translate-x-0.5'}`} />
                    </div>
                    <span className="text-sm text-gray-700">{l}</span>
                  </label>
                ))}
              </div>
            </div>
            <div className="flex gap-3 px-6 py-4 border-t border-gray-100">
              <button onClick={() => setShowModal(false)} className="flex-1 py-2.5 text-sm font-semibold border border-gray-200 rounded-xl hover:bg-gray-50">Cancel</button>
              <button onClick={save} className="flex-1 py-2.5 text-sm font-semibold text-white rounded-xl shadow-sm"
                style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
                {editing ? 'Save Changes' : 'Add Product'}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// MEMBERS PAGE
// ══════════════════════════════════════════════════════════════
function MembersPage() {
  const [search, setSearch] = useState('');
  const [sortBy, setSortBy] = useState('totalSales');
  const [sortDir, setSortDir] = useState('desc');
  const [expanded, setExpanded] = useState(null);

  const filtered = members.filter(m =>
    m.name.toLowerCase().includes(search.toLowerCase()) || m.email.toLowerCase().includes(search.toLowerCase())
  ).sort((a, b) => {
    const dir = sortDir === 'asc' ? 1 : -1;
    if (sortBy === 'totalSales') return (a.totalSales - b.totalSales) * dir;
    if (sortBy === 'joinDate') return (new Date(a.joinDate) - new Date(b.joinDate)) * dir;
    return a.name.localeCompare(b.name) * dir;
  });

  const toggle = (col) => { if (sortBy === col) setSortDir(d => d === 'asc' ? 'desc' : 'asc'); else { setSortBy(col); setSortDir('desc'); } };

  return (
    <div className="space-y-5">
      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        {[['Total Members', members.length, '#8b5cf6'], ['Active', members.filter(m=>m.status==='Active').length, C.green],
          ['Gold Rank', members.filter(m=>m.rank==='Gold').length, C.gold],
          ['Total Downlines', members.reduce((a,m)=>a+m.downlines,0), '#3b82f6']].map(([l,v,c]) => (
          <div key={l} className="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <div className="text-2xl font-bold" style={{ color: c }}>{v}</div>
            <div className="text-xs text-gray-400 mt-0.5">{l}</div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="flex items-center gap-3 p-4 border-b border-gray-100">
          <div className="relative flex-1">
            <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
            <input value={search} onChange={e => setSearch(e.target.value)} placeholder="Search members…"
              className="w-full pl-9 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none" />
          </div>
          <button className="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50">
            <Download size={14} /> Export
          </button>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="bg-gray-50">
                {[['Member', 'name'], ['Country', null], ['Join Date', 'joinDate'], ['Rank', null], ['Total Sales', 'totalSales'], ['Downlines', null], ['Status', null], ['', null]].map(([h, col]) => (
                  <th key={h} onClick={() => col && toggle(col)}
                    className={`text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide ${col ? 'cursor-pointer hover:text-gray-700' : ''}`}>
                    <span className="flex items-center gap-1">{h}{col && sortBy === col && (sortDir==='asc' ? <ChevronUp size={11}/> : <ChevronDown size={11}/>)}</span>
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>
              {filtered.map(m => (
                <>
                  <tr key={m.id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td className="px-4 py-3.5">
                      <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style={{ background: C.gold }}>
                          {m.name.charAt(0)}
                        </div>
                        <div>
                          <div className="font-semibold text-gray-800">{m.name}</div>
                          <div className="text-xs text-gray-400">{m.email}</div>
                        </div>
                      </div>
                    </td>
                    <td className="px-4 py-3.5 text-gray-500 text-xs">{m.country}</td>
                    <td className="px-4 py-3.5 text-gray-500 text-xs">{fmtD(m.joinDate)}</td>
                    <td className="px-4 py-3.5"><StatusBadge status={m.rank} /></td>
                    <td className="px-4 py-3.5 font-bold text-gray-800">{fmt(m.totalSales)}</td>
                    <td className="px-4 py-3.5 text-center font-semibold text-gray-600">{m.downlines}</td>
                    <td className="px-4 py-3.5"><StatusBadge status={m.status} /></td>
                    <td className="px-4 py-3.5">
                      <button onClick={() => setExpanded(expanded === m.id ? null : m.id)} className="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400">
                        {expanded === m.id ? <ChevronUp size={14} /> : <ChevronDown size={14} />}
                      </button>
                    </td>
                  </tr>
                  {expanded === m.id && (
                    <tr key={m.id+'exp'} className="bg-amber-50/30">
                      <td colSpan={8} className="px-6 py-4">
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                          <div><span className="text-gray-400 text-xs">Phone</span><p className="font-medium text-gray-700">{m.phone}</p></div>
                          <div><span className="text-gray-400 text-xs">Member ID</span><p className="font-medium text-gray-700">{m.id}</p></div>
                          <div><span className="text-gray-400 text-xs">Direct Downlines</span><p className="font-bold" style={{ color: C.gold }}>{m.downlines}</p></div>
                          <div><span className="text-gray-400 text-xs">Total Revenue</span><p className="font-bold" style={{ color: C.green }}>{fmt(m.totalSales)}</p></div>
                        </div>
                      </td>
                    </tr>
                  )}
                </>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// COMMISSIONS PAGE
// ══════════════════════════════════════════════════════════════
function CommissionsPage() {
  const paid = commissions.filter(c => c.status === 'Paid').reduce((a, c) => a + c.amount, 0);
  const pending = commissions.filter(c => c.status === 'Pending').reduce((a, c) => a + c.amount, 0);
  const thisMonth = commissions.filter(c => c.period === 'Mar 2026').reduce((a, c) => a + c.amount, 0);

  return (
    <div className="space-y-5">
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {[['Total Paid', paid, '#10b981', CheckCircle], ['Pending', pending, '#f59e0b', Clock], ['This Month', thisMonth, C.gold, DollarSign]].map(([l, v, c, Icon]) => (
          <div key={l} className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div className="flex items-center justify-between mb-3">
              <span className="text-sm text-gray-500">{l}</span>
              <div className="w-9 h-9 rounded-xl flex items-center justify-center" style={{ background: c + '18' }}>
                <Icon size={16} style={{ color: c }} />
              </div>
            </div>
            <div className="text-2xl font-bold" style={{ color: C.text, fontFamily: 'Playfair Display, serif' }}>{fmt(v)}</div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="flex items-center justify-between px-5 py-4 border-b border-gray-100">
          <h3 className="font-bold text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>Commission History</h3>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="bg-gray-50">{['ID','Period','Type','Members','Amount','Status','Pay Date'].map(h => <th key={h} className="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">{h}</th>)}</tr>
            </thead>
            <tbody>
              {commissions.map(c => (
                <tr key={c.id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                  <td className="px-4 py-3.5 font-mono text-xs text-gray-400">{c.id}</td>
                  <td className="px-4 py-3.5 font-semibold text-gray-800">{c.period}</td>
                  <td className="px-4 py-3.5">
                    <span className="px-2.5 py-1 text-xs rounded-full bg-blue-50 text-blue-600 font-medium">{c.type}</span>
                  </td>
                  <td className="px-4 py-3.5 text-center text-gray-500">{c.members || '—'}</td>
                  <td className="px-4 py-3.5 font-bold text-gray-800">${c.amount.toFixed(2)}</td>
                  <td className="px-4 py-3.5"><StatusBadge status={c.status} /></td>
                  <td className="px-4 py-3.5 text-gray-500 text-xs">{fmtD(c.payDate)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// REPORTS PAGE
// ══════════════════════════════════════════════════════════════
function ReportsPage() {
  return (
    <div className="space-y-5">
      <div className="grid grid-cols-1 xl:grid-cols-2 gap-5">
        <div className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <h3 className="font-bold text-gray-800 mb-5" style={{ fontFamily: 'Playfair Display, serif' }}>Monthly Revenue</h3>
          <ResponsiveContainer width="100%" height={220}>
            <BarChart data={salesData.slice(0, 8)}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
              <XAxis dataKey="date" tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} />
              <YAxis tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} tickFormatter={v => `$${v/1000}k`} />
              <Tooltip formatter={v => [`$${v.toLocaleString()}`, 'Revenue']} contentStyle={{ borderRadius: 12, border: 'none', boxShadow: '0 4px 20px rgba(0,0,0,0.1)' }} />
              <Bar dataKey="sales" fill={C.gold} radius={[6, 6, 0, 0]} />
            </BarChart>
          </ResponsiveContainer>
        </div>
        <div className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <h3 className="font-bold text-gray-800 mb-5" style={{ fontFamily: 'Playfair Display, serif' }}>Orders Per Day</h3>
          <ResponsiveContainer width="100%" height={220}>
            <LineChart data={salesData.slice(0, 8)}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
              <XAxis dataKey="date" tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} />
              <YAxis tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} />
              <Tooltip contentStyle={{ borderRadius: 12, border: 'none', boxShadow: '0 4px 20px rgba(0,0,0,0.1)' }} />
              <Line type="monotone" dataKey="orders" stroke={C.green} strokeWidth={2.5} dot={false} activeDot={{ r: 5 }} />
            </LineChart>
          </ResponsiveContainer>
        </div>
      </div>
      <div className="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 className="font-bold text-gray-800 mb-5" style={{ fontFamily: 'Playfair Display, serif' }}>Top Products Performance</h3>
        <div className="space-y-4">
          {topProducts.map(p => (
            <div key={p.name} className="flex items-center gap-4">
              <div className="w-8 h-8 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                <img src={p.image} alt={p.name} className="w-full h-full object-cover" onError={e => { e.target.style.display='none'; }} />
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center justify-between mb-1">
                  <span className="text-sm font-medium text-gray-800 truncate">{p.name}</span>
                  <span className="text-xs font-bold ml-2" style={{ color: C.gold }}>{fmt(p.revenue)}</span>
                </div>
                <div className="h-2 bg-gray-100 rounded-full overflow-hidden">
                  <div className="h-full rounded-full transition-all duration-700" style={{ width: `${(p.sold / 248) * 100}%`, background: `linear-gradient(90deg, ${C.gold}, ${C.goldLight})` }} />
                </div>
                <span className="text-xs text-gray-400 mt-0.5">{p.sold} units sold</span>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// MARKETING PAGE
// ══════════════════════════════════════════════════════════════
function MarketingPage({ showToast }) {
  const referralLink = 'https://freedomwithdxn.com/join?ref=TAHA2026';
  const shareLinks = [
    { label: 'WhatsApp', color: '#25d366', msg: `Join me on Freedom with DXN and start your health & wealth journey! 🌿 ${referralLink}` },
    { label: 'Facebook', color: '#1877f2', msg: referralLink },
    { label: 'Twitter', color: '#1da1f2', msg: `Discover the power of Ganoderma with DXN! Join my team → ${referralLink}` },
    { label: 'Telegram', color: '#0088cc', msg: `Join Freedom with DXN ${referralLink}` },
  ];

  return (
    <div className="space-y-5">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
        {/* Referral card */}
        <div className="rounded-2xl p-6 text-white" style={{ background: C.sidebar }}>
          <div className="flex items-center gap-2 mb-4">
            <div className="w-8 h-8 rounded-xl flex items-center justify-center" style={{ background: C.gold + '30' }}>
              <Link size={16} style={{ color: C.gold }} />
            </div>
            <h3 className="font-bold" style={{ fontFamily: 'Playfair Display, serif' }}>Your Referral Link</h3>
          </div>
          <div className="bg-white/10 rounded-xl px-4 py-3 mb-3 text-sm text-white/80 font-mono break-all">{referralLink}</div>
          <button onClick={() => { navigator.clipboard.writeText(referralLink); showToast('Referral link copied!'); }}
            className="w-full py-2.5 rounded-xl text-sm font-semibold text-white flex items-center justify-center gap-2 transition-opacity hover:opacity-90"
            style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
            <Copy size={14} /> Copy Link
          </button>
        </div>

        {/* Stats */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <h3 className="font-bold text-gray-800 mb-4" style={{ fontFamily: 'Playfair Display, serif' }}>Referral Performance</h3>
          <div className="space-y-4">
            {[['Total Referrals', '47', '#8b5cf6'], ['This Month', '8', C.gold], ['Conversion Rate', '34%', C.green], ['Total Earned', '$1,247', '#10b981']].map(([l,v,c]) => (
              <div key={l} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <span className="text-sm text-gray-500">{l}</span>
                <span className="font-bold text-lg" style={{ color: c }}>{v}</span>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Share buttons */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 className="font-bold text-gray-800 mb-4" style={{ fontFamily: 'Playfair Display, serif' }}>Share on Social Media</h3>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
          {shareLinks.map(({ label, color, msg }) => (
            <button key={label} onClick={() => showToast(`Opening ${label}…`)}
              className="py-3 rounded-xl text-white text-sm font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity"
              style={{ background: color }}>
              <Share2 size={14} /> {label}
            </button>
          ))}
        </div>
      </div>

      {/* Promo messages */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 className="font-bold text-gray-800 mb-4" style={{ fontFamily: 'Playfair Display, serif' }}>Ready-to-Share Messages</h3>
        <div className="space-y-3">
          {[
            '🌿 Transform your health with DXN\'s Ganoderma products. Used by millions worldwide. Join my team today!',
            '💰 Looking for a side income? I earn passive income with DXN. No monthly quotas, no pressure. DM me to learn more!',
            '☕ Did you know your morning coffee can also boost your immune system? Try DXN Lingzhi Coffee — Ganoderma infused!',
          ].map((msg, i) => (
            <div key={i} className="flex items-start gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
              <p className="flex-1 text-sm text-gray-700">{msg}</p>
              <button onClick={() => { navigator.clipboard.writeText(msg); showToast('Message copied!'); }}
                className="shrink-0 p-2 rounded-lg hover:bg-gray-200 transition-colors">
                <Copy size={13} className="text-gray-400" />
              </button>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// SETTINGS PAGE
// ══════════════════════════════════════════════════════════════
function SettingsPage({ showToast }) {
  const [profile, setProfile] = useState({ name: 'Taha Mina', email: 'tahamina@ecommerized.com', phone: '+60-12-345-6789', country: 'Malaysia', dxnId: 'DXN-2026-TAHA', bio: 'DXN Independent Distributor | Health & Wellness Advocate' });
  const [pass, setPass] = useState({ current: '', newPass: '', confirm: '' });
  const [activeTab, setActiveTab] = useState('profile');

  const tabs = [{ id: 'profile', label: 'Profile', Icon: User }, { id: 'security', label: 'Security', Icon: Lock }, { id: 'referral', label: 'Referral', Icon: Link }];

  return (
    <div className="max-w-2xl space-y-5">
      {/* Tabs */}
      <div className="flex gap-2 bg-white rounded-2xl p-1.5 shadow-sm border border-gray-100 w-fit">
        {tabs.map(({ id, label, Icon }) => (
          <button key={id} onClick={() => setActiveTab(id)}
            className={`flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all ${activeTab === id ? 'text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'}`}
            style={activeTab === id ? { background: C.gold } : {}}>
            <Icon size={14} />{label}
          </button>
        ))}
      </div>

      {activeTab === 'profile' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-5">
          {/* Avatar */}
          <div className="flex items-center gap-4">
            <div className="relative">
              <div className="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold" style={{ background: C.gold }}>T</div>
              <button className="absolute -bottom-1 -right-1 w-7 h-7 rounded-lg flex items-center justify-center shadow-md bg-white border border-gray-200 hover:bg-gray-50">
                <Camera size={12} className="text-gray-500" />
              </button>
            </div>
            <div>
              <h3 className="font-bold text-gray-800 text-lg">{profile.name}</h3>
              <p className="text-sm text-gray-400">Admin • Gold Distributor</p>
            </div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {[['Full Name', 'name', 'text'], ['Email', 'email', 'email'], ['Phone', 'phone', 'tel'], ['Country', 'country', 'text'], ['DXN Member ID', 'dxnId', 'text']].map(([l, k, t]) => (
              <div key={k} className={k === 'dxnId' ? 'md:col-span-2' : ''}>
                <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">{l}</label>
                <input type={t} value={profile[k]} onChange={e => setProfile(p => ({ ...p, [k]: e.target.value }))}
                  className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none" />
              </div>
            ))}
            <div className="md:col-span-2">
              <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">Bio</label>
              <textarea value={profile.bio} onChange={e => setProfile(p => ({ ...p, bio: e.target.value }))} rows={2}
                className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none resize-none" />
            </div>
          </div>
          <button onClick={() => showToast('Profile saved successfully!')}
            className="px-6 py-2.5 text-sm font-semibold text-white rounded-xl"
            style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
            Save Changes
          </button>
        </div>
      )}

      {activeTab === 'security' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
          <div className="flex items-center gap-3 p-4 rounded-xl bg-green-50 border border-green-100">
            <Shield size={18} className="text-green-500" />
            <div>
              <p className="text-sm font-semibold text-green-700">Account Secured</p>
              <p className="text-xs text-green-500">Two-factor authentication available</p>
            </div>
          </div>
          {[['Current Password', 'current'], ['New Password', 'newPass'], ['Confirm New Password', 'confirm']].map(([l, k]) => (
            <div key={k}>
              <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">{l}</label>
              <input type="password" value={pass[k]} onChange={e => setPass(p => ({ ...p, [k]: e.target.value }))}
                className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none" />
            </div>
          ))}
          <button onClick={() => showToast('Password updated!')}
            className="px-6 py-2.5 text-sm font-semibold text-white rounded-xl"
            style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
            Update Password
          </button>
        </div>
      )}

      {activeTab === 'referral' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-5">
          <div className="rounded-2xl p-5" style={{ background: C.sidebar }}>
            <p className="text-xs text-gray-400 mb-1">Your Referral Code</p>
            <div className="flex items-center justify-between">
              <span className="text-2xl font-bold tracking-widest" style={{ color: C.gold }}>TAHA2026</span>
              <button onClick={() => { navigator.clipboard.writeText('TAHA2026'); showToast('Code copied!'); }}
                className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold" style={{ background: C.gold + '30', color: C.gold }}>
                <Copy size={11} /> Copy
              </button>
            </div>
          </div>
          <div>
            <p className="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Full Referral Link</p>
            <div className="flex gap-2">
              <input readOnly value="https://freedomwithdxn.com/join?ref=TAHA2026"
                className="flex-1 px-3 py-2.5 text-xs border border-gray-200 rounded-xl bg-gray-50 text-gray-600 min-w-0" />
              <button onClick={() => { navigator.clipboard.writeText('https://freedomwithdxn.com/join?ref=TAHA2026'); showToast('Link copied!'); }}
                className="px-4 py-2.5 text-sm font-semibold text-white rounded-xl whitespace-nowrap" style={{ background: C.gold }}>
                Copy
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// ROOT COMPONENT
// ══════════════════════════════════════════════════════════════
export default function AdminDashboard() {
  const [active, setActive]       = useState('dashboard');
  const [collapsed, setCollapsed] = useState(false);
  const [toast, setToast]         = useState(null);

  const showToast = useCallback((msg) => setToast(msg), []);

  const pages = {
    dashboard:   <DashboardPage showToast={showToast} />,
    orders:      <OrdersPage showToast={showToast} />,
    products:    <ProductsPage showToast={showToast} />,
    members:     <MembersPage />,
    commissions: <CommissionsPage />,
    reports:     <ReportsPage />,
    marketing:   <MarketingPage showToast={showToast} />,
    settings:    <SettingsPage showToast={showToast} />,
  };

  return (
    <>
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap');
        body { font-family: 'DM Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes fade-in { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .animate-fade-in { animation: fade-in 0.2s ease-out; }
      `}</style>

      <div className="min-h-screen" style={{ background: C.cream }}>
        <Sidebar active={active} setActive={setActive} collapsed={collapsed} setCollapsed={setCollapsed} />
        <Topbar page={active} collapsed={collapsed} setCollapsed={setCollapsed} showToast={showToast} />
        <main
          className="transition-all duration-300 pt-20 p-6 min-h-screen"
          style={{ marginLeft: collapsed ? 72 : 240 }}
        >
          {pages[active] || pages.dashboard}
        </main>
        {toast && <Toast msg={toast} onClose={() => setToast(null)} />}
      </div>
    </>
  );
}
