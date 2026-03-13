import React, { useState, useEffect, useRef, useCallback } from 'react';
import SiteEditorPage from './SiteEditorPage';
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
  { id: 'site-editor',  label: 'Site Editor',       Icon: Globe },
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
const CAT_COLORS = { coffee:'#7c3f1e', ganoderma:'#2d7a4f', supplements:'#c9a84c', skincare:'#e1306c', beverages:'#d4a017', 'personal-care':'#6b7280', other:'#8b5cf6' };

function DashboardPage({ showToast }) {
  const [loading, setLoading]         = useState(true);
  const [allOrders, setAllOrders]     = useState([]);
  const [allProducts, setAllProducts] = useState([]);
  const [memberCount, setMemberCount] = useState(0);
  const [myProfile, setMyProfile]     = useState(null);
  const TOKEN = localStorage.getItem('token');

  useEffect(() => {
    const h = { Authorization: `Bearer ${TOKEN}` };
    Promise.all([
      fetch('/api/orders',       { headers: h }).then(r => r.json()),
      fetch('/api/products?limit=100').then(r => r.json()),
      fetch('/api/auth/users',   { headers: h }).then(r => r.json()),
      fetch('/api/auth/me',      { headers: h }).then(r => r.json()),
    ]).then(([orders, prods, users, me]) => {
      setAllOrders(Array.isArray(orders) ? orders : []);
      setAllProducts((prods?.products || []).slice(0, 4));
      setMemberCount(Array.isArray(users) ? users.length : 0);
      setMyProfile(me);
    }).catch(() => {}).finally(() => setLoading(false));
  }, []);

  // Stats
  const now = new Date();
  const thisMonthOrders = allOrders.filter(o => {
    const d = new Date(o.createdAt);
    return d.getMonth() === now.getMonth() && d.getFullYear() === now.getFullYear();
  });
  const totalSales = allOrders.reduce((s, o) => s + (o.totalAmount || 0), 0);

  // Sales chart — group by date (last 30 days)
  const salesChartData = (() => {
    const map = {};
    const cutoff = new Date(); cutoff.setDate(cutoff.getDate() - 30);
    allOrders.forEach(o => {
      const d = new Date(o.createdAt);
      if (d < cutoff) return;
      const key = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
      map[key] = (map[key] || 0) + (o.totalAmount || 0);
    });
    return Object.entries(map).map(([date, sales]) => ({ date, sales: Math.round(sales) }))
      .sort((a, b) => new Date(a.date) - new Date(b.date));
  })();

  // Category chart — count items per category from orders
  const catChartData = (() => {
    const map = {};
    allOrders.forEach(o => {
      (o.items || []).forEach(item => {
        const cat = item.category || 'other';
        map[cat] = (map[cat] || 0) + (item.price * item.quantity || 0);
      });
    });
    const total = Object.values(map).reduce((a, b) => a + b, 0) || 1;
    return Object.entries(map).map(([name, val]) => ({
      name: name.charAt(0).toUpperCase() + name.slice(1),
      value: Math.round((val / total) * 100),
      color: CAT_COLORS[name] || '#8b5cf6',
    })).sort((a, b) => b.value - a.value).slice(0, 6);
  })();

  const referralLink = `https://freedomwithdxn.com/join?ref=${myProfile?.referralCode || ''}`;

  const stats = [
    { label: 'Total Members',      value: memberCount,                    prefix: '',  Icon: Users,         color: '#3b82f6' },
    { label: 'Orders This Month',  value: thisMonthOrders.length,         prefix: '',  Icon: ShoppingCart,  color: C.green },
    { label: 'Total Revenue',      value: Math.round(totalSales),         prefix: '$', Icon: DollarSign,    color: C.gold },
    { label: 'Total Orders',       value: allOrders.length,               prefix: '',  Icon: Award,         color: '#f59e0b' },
  ];

  return (
    <div className="space-y-6">
      {/* Stats */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {stats.map(({ label, value, prefix, Icon, color }) => (
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
                  <CountUp end={value} prefix={prefix} />
                </div>
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
          </div>
          {loading ? <Skeleton className="h-52 w-full" /> : salesChartData.length === 0 ? (
            <div className="h-52 flex items-center justify-center text-gray-400 text-sm">No sales data yet</div>
          ) : (
            <ResponsiveContainer width="100%" height={200}>
              <LineChart data={salesChartData}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis dataKey="date" tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} />
                <YAxis tick={{ fontSize: 11, fill: '#9ca3af' }} tickLine={false} axisLine={false} tickFormatter={v => `$${v}`} />
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
          {loading ? <Skeleton className="h-52 w-full" /> : catChartData.length === 0 ? (
            <div className="h-40 flex items-center justify-center text-gray-400 text-sm">No order data yet</div>
          ) : (
            <>
              <ResponsiveContainer width="100%" height={160}>
                <PieChart>
                  <Pie data={catChartData} cx="50%" cy="50%" innerRadius={45} outerRadius={70} paddingAngle={3} dataKey="value">
                    {catChartData.map((entry, i) => <Cell key={i} fill={entry.color} />)}
                  </Pie>
                  <Tooltip formatter={(v) => [`${v}%`]} contentStyle={{ borderRadius: 10, border: 'none', boxShadow: '0 4px 16px rgba(0,0,0,0.1)' }} />
                </PieChart>
              </ResponsiveContainer>
              <div className="space-y-2 mt-2">
                {catChartData.map(({ name, value, color }) => (
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
            <span className="text-xs text-gray-400">{allOrders.length} total</span>
          </div>
          {loading ? (
            <div className="p-4 space-y-3">{[1,2,3].map(i => <Skeleton key={i} className="h-12 w-full" />)}</div>
          ) : allOrders.length === 0 ? (
            <div className="p-8 text-center text-gray-400 text-sm">No orders yet</div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead><tr className="bg-gray-50">{['Order ID','Customer','Items','Amount','Status'].map(h => <th key={h} className="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">{h}</th>)}</tr></thead>
                <tbody>
                  {allOrders.slice(0, 5).map(o => (
                    <tr key={o._id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                      <td className="px-4 py-3 font-mono text-xs text-gray-400">{o._id?.slice(-8).toUpperCase()}</td>
                      <td className="px-4 py-3 font-medium text-gray-800">{o.user?.name || '—'}</td>
                      <td className="px-4 py-3 text-gray-500 text-xs">{o.items?.length || 0} item{o.items?.length !== 1 ? 's' : ''}</td>
                      <td className="px-4 py-3 font-semibold text-gray-800">${(o.totalAmount || 0).toFixed(2)}</td>
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
            <h3 className="font-bold text-gray-800 mb-4" style={{ fontFamily: 'Playfair Display, serif' }}>Products</h3>
            {loading ? <div className="space-y-3">{[1,2,3].map(i => <Skeleton key={i} className="h-10 w-full" />)}</div> : allProducts.length === 0 ? (
              <p className="text-sm text-gray-400">No products added yet</p>
            ) : (
              <div className="space-y-3">
                {allProducts.map((p, i) => (
                  <div key={p._id} className="flex items-center gap-3">
                    <span className="text-xs font-bold text-gray-300 w-4">{i+1}</span>
                    <div className="w-9 h-9 rounded-lg overflow-hidden bg-gray-100 shrink-0" style={{ background: C.sidebar }}>
                      {p.image ? <img src={p.image} alt={p.name} className="w-full h-full object-cover" onError={e => { e.target.style.display='none'; }} /> : null}
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="text-xs font-semibold text-gray-800 truncate">{p.name}</p>
                      <p className="text-xs text-gray-400 capitalize">{p.category}</p>
                    </div>
                    <span className="text-xs font-bold" style={{ color: C.gold }}>${p.price?.toFixed(2)}</span>
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
              <input readOnly value={myProfile?.referralCode ? referralLink : 'Loading…'}
                className="flex-1 text-xs bg-white/10 text-white/80 border border-white/10 rounded-lg px-3 py-2 focus:outline-none min-w-0" />
              <button onClick={() => { navigator.clipboard.writeText(referralLink); showToast('Link copied!'); }}
                className="px-3 py-2 rounded-lg text-xs font-semibold text-white flex items-center gap-1 shrink-0" style={{ background: C.gold }}>
                <Copy size={12} /> Copy
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

// ══════════════════════════════════════════════════════════════
// ORDERS PAGE — live data from API
// ══════════════════════════════════════════════════════════════
function OrdersPage({ showToast }) {
  const [allOrders, setAllOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('All');
  const [page, setPage] = useState(1);
  const [sortBy, setSortBy] = useState('date');
  const [sortDir, setSortDir] = useState('desc');
  const [updatingId, setUpdatingId] = useState(null);
  const PER_PAGE = 8;
  const TOKEN = localStorage.getItem('token');

  const fetchOrders = () => {
    setLoading(true);
    fetch('/api/orders', { headers: { Authorization: `Bearer ${TOKEN}` } })
      .then(r => r.json())
      .then(data => setAllOrders(Array.isArray(data) ? data : []))
      .catch(() => showToast('Failed to load orders', 'error'))
      .finally(() => setLoading(false));
  };
  useEffect(fetchOrders, []);

  const statuses = ['All', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];

  const filtered = allOrders
    .filter(o => {
      const name = o.user?.name || '';
      const email = o.user?.email || '';
      const id = o._id || '';
      const matchSearch = name.toLowerCase().includes(search.toLowerCase()) ||
        email.toLowerCase().includes(search.toLowerCase()) ||
        id.toLowerCase().includes(search.toLowerCase());
      const matchStatus = statusFilter === 'All' || o.status === statusFilter;
      return matchSearch && matchStatus;
    })
    .sort((a, b) => {
      const dir = sortDir === 'asc' ? 1 : -1;
      if (sortBy === 'amount') return (a.totalAmount - b.totalAmount) * dir;
      return (new Date(a.createdAt) - new Date(b.createdAt)) * dir;
    });

  const totalPages = Math.ceil(filtered.length / PER_PAGE);
  const paginated = filtered.slice((page - 1) * PER_PAGE, page * PER_PAGE);

  const toggle = (col) => { if (sortBy === col) setSortDir(d => d === 'asc' ? 'desc' : 'asc'); else { setSortBy(col); setSortDir('desc'); } };

  const updateStatus = async (id, status) => {
    setUpdatingId(id);
    try {
      const r = await fetch(`/api/orders/${id}/status`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${TOKEN}` },
        body: JSON.stringify({ status }),
      });
      if (!r.ok) throw new Error();
      setAllOrders(prev => prev.map(o => o._id === id ? { ...o, status } : o));
      showToast('Order status updated!', 'success');
    } catch {
      showToast('Failed to update status', 'error');
    } finally {
      setUpdatingId(null);
    }
  };

  const exportCSV = () => {
    const rows = [['Order ID','Customer','Email','Amount','Status','Date'],
      ...filtered.map(o => [o._id, o.user?.name||'', o.user?.email||'', o.totalAmount, o.status, o.createdAt])];
    const csv = rows.map(r => r.join(',')).join('\n');
    const a = document.createElement('a'); a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv); a.download = 'orders.csv'; a.click();
    showToast('Orders exported as CSV');
  };

  const statCounts = {
    total: allOrders.length,
    pending: allOrders.filter(o => o.status === 'pending').length,
    shipped: allOrders.filter(o => o.status === 'shipped').length,
    delivered: allOrders.filter(o => o.status === 'delivered').length,
  };

  return (
    <div className="space-y-5">
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        {[['Total', statCounts.total, '#6366f1'], ['Pending', statCounts.pending, '#f59e0b'],
          ['Shipped', statCounts.shipped, '#3b82f6'], ['Delivered', statCounts.delivered, '#10b981']].map(([l, v, c]) => (
          <div key={l} className="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl flex items-center justify-center" style={{ background: c + '18' }}>
              <ShoppingCart size={16} style={{ color: c }} />
            </div>
            <div><p className="text-2xl font-bold" style={{ color: C.text }}>{v}</p><p className="text-xs text-gray-400">{l}</p></div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="flex flex-col md:flex-row gap-3 p-4 border-b border-gray-100">
          <div className="relative flex-1">
            <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
            <input value={search} onChange={e => { setSearch(e.target.value); setPage(1); }}
              placeholder="Search by name, email or order ID…"
              className="w-full pl-9 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none" />
          </div>
          <div className="flex gap-2 flex-wrap">
            {statuses.map(s => (
              <button key={s} onClick={() => { setStatusFilter(s); setPage(1); }}
                className={`px-3 py-2 text-xs font-semibold rounded-xl capitalize transition-colors ${statusFilter === s ? 'text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'}`}
                style={statusFilter === s ? { background: C.gold } : {}}>
                {s}
              </button>
            ))}
          </div>
          <div className="flex gap-2">
            <button onClick={fetchOrders} className="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
              <RefreshCw size={14} />
            </button>
            <button onClick={exportCSV} className="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors whitespace-nowrap">
              <Download size={14} /> Export CSV
            </button>
          </div>
        </div>

        {loading ? (
          <div className="p-8 text-center text-gray-400 text-sm">Loading orders…</div>
        ) : filtered.length === 0 ? (
          <div className="p-8 text-center text-gray-400 text-sm">No orders found.</div>
        ) : (
          <>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead>
                  <tr className="bg-gray-50">
                    {[['Order ID', null], ['Customer', null], ['Items', null], ['Amount', 'amount'], ['Status', null], ['Date', 'date'], ['Update Status', null]].map(([h, col]) => (
                      <th key={h} onClick={() => col && toggle(col)}
                        className={`text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide ${col ? 'cursor-pointer hover:text-gray-700 select-none' : ''}`}>
                        {h}
                      </th>
                    ))}
                  </tr>
                </thead>
                <tbody>
                  {paginated.map(o => (
                    <tr key={o._id} className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                      <td className="px-4 py-3.5 font-mono text-xs font-semibold text-gray-400">{o._id.slice(-8).toUpperCase()}</td>
                      <td className="px-4 py-3.5">
                        <div className="font-semibold text-gray-800">{o.user?.name || 'Unknown'}</div>
                        <div className="text-xs text-gray-400">{o.user?.email || ''}</div>
                      </td>
                      <td className="px-4 py-3.5 text-gray-500 text-xs">{o.items?.length || 0} item{o.items?.length !== 1 ? 's' : ''}</td>
                      <td className="px-4 py-3.5 font-bold text-gray-800">${(o.totalAmount || 0).toFixed(2)}</td>
                      <td className="px-4 py-3.5"><StatusBadge status={o.status} /></td>
                      <td className="px-4 py-3.5 text-gray-500 text-xs">{fmtD(o.createdAt)}</td>
                      <td className="px-4 py-3.5">
                        <select value={o.status} onChange={e => updateStatus(o._id, e.target.value)}
                          disabled={updatingId === o._id}
                          className="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none bg-white disabled:opacity-50 capitalize">
                          {['pending','processing','shipped','delivered','cancelled'].map(s => (
                            <option key={s} value={s} className="capitalize">{s}</option>
                          ))}
                        </select>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            <div className="flex items-center justify-between px-4 py-3 border-t border-gray-100">
              <span className="text-xs text-gray-400">Showing {(page-1)*PER_PAGE+1}–{Math.min(page*PER_PAGE, filtered.length)} of {filtered.length}</span>
              <div className="flex gap-1">
                <button onClick={() => setPage(p => Math.max(1,p-1))} disabled={page===1} className="p-2 rounded-lg hover:bg-gray-100 disabled:opacity-30"><ChevronLeft size={14} /></button>
                {[...Array(totalPages)].map((_,i) => (
                  <button key={i} onClick={() => setPage(i+1)}
                    className={`w-8 h-8 text-xs rounded-lg font-medium ${page===i+1 ? 'text-white' : 'hover:bg-gray-100 text-gray-600'}`}
                    style={page===i+1 ? { background: C.gold } : {}}>{i+1}</button>
                ))}
                <button onClick={() => setPage(p => Math.min(totalPages,p+1))} disabled={page===totalPages} className="p-2 rounded-lg hover:bg-gray-100 disabled:opacity-30"><ChevronRight size={14} /></button>
              </div>
            </div>
          </>
        )}
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
function CreateAdminModal({ onClose, onCreated, TOKEN }) {
  const [form, setForm] = useState({ name: '', email: '', password: '', confirm: '', phone: '', country: '' });
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');

  const submit = async (e) => {
    e.preventDefault();
    setError('');
    if (form.password !== form.confirm) { setError('Passwords do not match'); return; }
    if (form.password.length < 6) { setError('Password must be at least 6 characters'); return; }
    setSaving(true);
    try {
      const res = await fetch('/api/auth/create-admin', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${TOKEN}` },
        body: JSON.stringify({ name: form.name, email: form.email, password: form.password, phone: form.phone, country: form.country }),
      });
      const data = await res.json();
      if (!res.ok) { setError(data.message || 'Failed to create admin'); return; }
      onCreated();
      onClose();
    } catch { setError('Network error'); }
    finally { setSaving(false); }
  };

  const field = (label, key, type = 'text', placeholder = '') => (
    <div>
      <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{label}</label>
      <input type={type} value={form[key]} onChange={e => setForm(f => ({ ...f, [key]: e.target.value }))}
        placeholder={placeholder} required={['name','email','password','confirm'].includes(key)}
        className="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400/40" />
    </div>
  );

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4" style={{ background: 'rgba(0,0,0,0.5)' }}>
      <div className="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg flex items-center justify-center" style={{ background: C.gold }}>
              <Shield size={14} className="text-white" />
            </div>
            <h2 className="font-bold text-gray-800" style={{ fontFamily: 'Playfair Display, serif' }}>Create Admin Account</h2>
          </div>
          <button onClick={onClose} className="p-1.5 rounded-lg hover:bg-gray-100"><X size={16} /></button>
        </div>
        <form onSubmit={submit} className="p-6 space-y-4">
          {error && (
            <div className="flex items-center gap-2 p-3 bg-red-50 border border-red-100 rounded-xl text-sm text-red-600">
              <AlertCircle size={14} /> {error}
            </div>
          )}
          {field('Full Name', 'name', 'text', 'Admin full name')}
          {field('Email', 'email', 'email', 'admin@example.com')}
          <div className="grid grid-cols-2 gap-3">
            {field('Password', 'password', 'password', '••••••••')}
            {field('Confirm Password', 'confirm', 'password', '••••••••')}
          </div>
          <div className="grid grid-cols-2 gap-3">
            {field('Phone', 'phone', 'text', '+1 (optional)')}
            {field('Country', 'country', 'text', 'Optional')}
          </div>
          <div className="flex gap-3 pt-2">
            <button type="button" onClick={onClose} className="flex-1 py-2.5 text-sm font-semibold border border-gray-200 rounded-xl hover:bg-gray-50">Cancel</button>
            <button type="submit" disabled={saving}
              className="flex-1 py-2.5 text-sm font-semibold text-white rounded-xl disabled:opacity-60"
              style={{ background: C.gold }}>
              {saving ? 'Creating…' : 'Create Admin'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}

function MembersPage() {
  const [allMembers, setAllMembers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [sortBy, setSortBy] = useState('createdAt');
  const [sortDir, setSortDir] = useState('desc');
  const [expanded, setExpanded] = useState(null);
  const [showCreateAdmin, setShowCreateAdmin] = useState(false);
  const TOKEN = localStorage.getItem('token');

  const fetchMembers = () => {
    setLoading(true);
    fetch('/api/auth/users', { headers: { Authorization: `Bearer ${TOKEN}` } })
      .then(r => r.json())
      .then(data => setAllMembers(Array.isArray(data) ? data : []))
      .catch(() => {})
      .finally(() => setLoading(false));
  };
  useEffect(fetchMembers, []);

  const filtered = allMembers
    .filter(m => m.name?.toLowerCase().includes(search.toLowerCase()) || m.email?.toLowerCase().includes(search.toLowerCase()))
    .sort((a, b) => {
      const dir = sortDir === 'asc' ? 1 : -1;
      if (sortBy === 'totalSales') return ((a.totalSales||0) - (b.totalSales||0)) * dir;
      if (sortBy === 'createdAt') return (new Date(a.createdAt) - new Date(b.createdAt)) * dir;
      return (a.name||'').localeCompare(b.name||'') * dir;
    });

  const toggle = (col) => { if (sortBy === col) setSortDir(d => d === 'asc' ? 'desc' : 'asc'); else { setSortBy(col); setSortDir('desc'); } };

  const exportCSV = () => {
    const rows = [['Name','Email','Phone','Country','Role','DXN ID','Referral Code','Joined'],
      ...filtered.map(m => [m.name,m.email,m.phone||'',m.country||'',m.role,m.dxnMemberId||'',m.referralCode||'',m.createdAt])];
    const csv = rows.map(r => r.join(',')).join('\n');
    const a = document.createElement('a'); a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv); a.download = 'members.csv'; a.click();
  };

  const activeCount = allMembers.filter(m => m.isActive).length;
  const adminCount  = allMembers.filter(m => m.role === 'admin').length;
  const distCount   = allMembers.filter(m => m.role === 'distributor').length;

  return (
    <div className="space-y-5">
      {showCreateAdmin && (
        <CreateAdminModal TOKEN={TOKEN} onClose={() => setShowCreateAdmin(false)} onCreated={fetchMembers} />
      )}

      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        {[['Total Members', allMembers.length, '#8b5cf6'], ['Active', activeCount, C.green],
          ['Distributors', distCount, C.gold], ['Admins', adminCount, '#3b82f6']].map(([l,v,c]) => (
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
          <button onClick={fetchMembers} className="p-2.5 rounded-xl border border-gray-200 hover:bg-gray-50"><RefreshCw size={14} /></button>
          <button onClick={exportCSV} className="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50">
            <Download size={14} /> Export
          </button>
          <button onClick={() => setShowCreateAdmin(true)}
            className="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl"
            style={{ background: C.gold }}>
            <Plus size={14} /> Add Admin
          </button>
        </div>

        {loading ? (
          <div className="p-8 text-center text-gray-400 text-sm">Loading members…</div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50">
                  {[['Member', 'name'], ['Country', null], ['Joined', 'createdAt'], ['Role', null], ['DXN ID', null], ['Total Sales', 'totalSales'], ['Status', null], ['', null]].map(([h, col]) => (
                    <th key={h} onClick={() => col && toggle(col)}
                      className={`text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide ${col ? 'cursor-pointer hover:text-gray-700' : ''}`}>
                      <span className="flex items-center gap-1">{h}{col && sortBy === col && (sortDir==='asc' ? <ChevronUp size={11}/> : <ChevronDown size={11}/>)}</span>
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {filtered.map(m => (
                  <React.Fragment key={m._id}>
                    <tr className="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                      <td className="px-4 py-3.5">
                        <div className="flex items-center gap-3">
                          <div className="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style={{ background: C.gold }}>
                            {(m.name||'?').charAt(0).toUpperCase()}
                          </div>
                          <div>
                            <div className="font-semibold text-gray-800">{m.name}</div>
                            <div className="text-xs text-gray-400">{m.email}</div>
                          </div>
                        </div>
                      </td>
                      <td className="px-4 py-3.5 text-gray-500 text-xs">{m.country || '—'}</td>
                      <td className="px-4 py-3.5 text-gray-500 text-xs">{fmtD(m.createdAt)}</td>
                      <td className="px-4 py-3.5"><StatusBadge status={m.role} /></td>
                      <td className="px-4 py-3.5 font-mono text-xs text-gray-500">{m.dxnMemberId || '—'}</td>
                      <td className="px-4 py-3.5 font-bold text-gray-800">{fmt(m.totalSales || 0)}</td>
                      <td className="px-4 py-3.5"><StatusBadge status={m.isActive ? 'Active' : 'Inactive'} /></td>
                      <td className="px-4 py-3.5">
                        <button onClick={() => setExpanded(expanded === m._id ? null : m._id)} className="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400">
                          {expanded === m._id ? <ChevronUp size={14} /> : <ChevronDown size={14} />}
                        </button>
                      </td>
                    </tr>
                    {expanded === m._id && (
                      <tr className="bg-amber-50/30">
                        <td colSpan={8} className="px-6 py-4">
                          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div><span className="text-gray-400 text-xs">Phone</span><p className="font-medium text-gray-700">{m.phone || '—'}</p></div>
                            <div><span className="text-gray-400 text-xs">Referral Code</span><p className="font-medium font-mono text-gray-700">{m.referralCode || '—'}</p></div>
                            <div><span className="text-gray-400 text-xs">Downlines</span><p className="font-bold" style={{ color: C.gold }}>{m.totalDownlines || 0}</p></div>
                            <div><span className="text-gray-400 text-xs">Bio</span><p className="text-gray-500 text-xs">{m.bio || '—'}</p></div>
                          </div>
                        </td>
                      </tr>
                    )}
                  </React.Fragment>
                ))}
              </tbody>
            </table>
          </div>
        )}
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
  const TOKEN = localStorage.getItem('token');
  const [profile, setProfile] = useState({ name: '', email: '', phone: '', country: '', dxnMemberId: '', bio: '', referralCode: '' });
  const [pass, setPass] = useState({ current: '', newPass: '', confirm: '' });
  const [activeTab, setActiveTab] = useState('profile');
  const [savingProfile, setSavingProfile] = useState(false);
  const [savingPass, setSavingPass] = useState(false);

  useEffect(() => {
    fetch('/api/auth/me', { headers: { Authorization: `Bearer ${TOKEN}` } })
      .then(r => r.json())
      .then(u => setProfile({
        name: u.name || '', email: u.email || '', phone: u.phone || '',
        country: u.country || '', dxnMemberId: u.dxnMemberId || '',
        bio: u.bio || '', referralCode: u.referralCode || '',
      }))
      .catch(() => {});
  }, []);

  const saveProfile = async () => {
    setSavingProfile(true);
    try {
      const r = await fetch('/api/auth/profile', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${TOKEN}` },
        body: JSON.stringify({ name: profile.name, phone: profile.phone, country: profile.country, dxnMemberId: profile.dxnMemberId, bio: profile.bio }),
      });
      if (!r.ok) throw new Error();
      showToast('Profile saved successfully!');
    } catch {
      showToast('Failed to save profile');
    } finally {
      setSavingProfile(false);
    }
  };

  const changePassword = async () => {
    if (!pass.current || !pass.newPass) return showToast('Please fill all fields');
    if (pass.newPass !== pass.confirm) return showToast('Passwords do not match');
    if (pass.newPass.length < 6) return showToast('Password must be at least 6 characters');
    setSavingPass(true);
    try {
      const r = await fetch('/api/auth/change-password', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${TOKEN}` },
        body: JSON.stringify({ currentPassword: pass.current, newPassword: pass.newPass }),
      });
      const data = await r.json();
      if (!r.ok) throw new Error(data.message);
      setPass({ current: '', newPass: '', confirm: '' });
      showToast('Password updated successfully!');
    } catch (err) {
      showToast(err.message || 'Failed to update password');
    } finally {
      setSavingPass(false);
    }
  };

  const referralLink = `https://freedomwithdxn.com/join?ref=${profile.referralCode}`;
  const tabs = [{ id: 'profile', label: 'Profile', Icon: User }, { id: 'security', label: 'Security', Icon: Lock }, { id: 'referral', label: 'Referral', Icon: Link }];

  return (
    <div className="max-w-2xl space-y-5">
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
          <div className="flex items-center gap-4">
            <div className="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold" style={{ background: C.gold }}>
              {profile.name?.charAt(0)?.toUpperCase() || '?'}
            </div>
            <div>
              <h3 className="font-bold text-gray-800 text-lg">{profile.name || 'Loading…'}</h3>
              <p className="text-sm text-gray-400">{profile.email}</p>
            </div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {[['Full Name', 'name', 'text'], ['Phone', 'phone', 'tel'], ['Country', 'country', 'text'], ['DXN Member ID', 'dxnMemberId', 'text']].map(([l, k, t]) => (
              <div key={k}>
                <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">{l}</label>
                <input type={t} value={profile[k] || ''} onChange={e => setProfile(p => ({ ...p, [k]: e.target.value }))}
                  className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none" />
              </div>
            ))}
            <div className="md:col-span-2">
              <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email (read-only)</label>
              <input readOnly value={profile.email} className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-100 rounded-xl bg-gray-50 text-gray-400" />
            </div>
            <div className="md:col-span-2">
              <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">Bio</label>
              <textarea value={profile.bio || ''} onChange={e => setProfile(p => ({ ...p, bio: e.target.value }))} rows={2}
                className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none resize-none" />
            </div>
          </div>
          <button onClick={saveProfile} disabled={savingProfile}
            className="px-6 py-2.5 text-sm font-semibold text-white rounded-xl disabled:opacity-50"
            style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
            {savingProfile ? 'Saving…' : 'Save Changes'}
          </button>
        </div>
      )}

      {activeTab === 'security' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
          <div className="flex items-center gap-3 p-4 rounded-xl bg-green-50 border border-green-100">
            <Shield size={18} className="text-green-500" />
            <div>
              <p className="text-sm font-semibold text-green-700">Account Secured</p>
              <p className="text-xs text-green-500">Change your password below</p>
            </div>
          </div>
          {[['Current Password', 'current'], ['New Password', 'newPass'], ['Confirm New Password', 'confirm']].map(([l, k]) => (
            <div key={k}>
              <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide">{l}</label>
              <input type="password" value={pass[k]} onChange={e => setPass(p => ({ ...p, [k]: e.target.value }))}
                className="w-full mt-1 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none" />
            </div>
          ))}
          <button onClick={changePassword} disabled={savingPass}
            className="px-6 py-2.5 text-sm font-semibold text-white rounded-xl disabled:opacity-50"
            style={{ background: `linear-gradient(135deg, ${C.gold}, ${C.goldLight})` }}>
            {savingPass ? 'Updating…' : 'Update Password'}
          </button>
        </div>
      )}

      {activeTab === 'referral' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-5">
          <div className="rounded-2xl p-5" style={{ background: C.sidebar }}>
            <p className="text-xs text-gray-400 mb-1">Your Referral Code</p>
            <div className="flex items-center justify-between">
              <span className="text-2xl font-bold tracking-widest" style={{ color: C.gold }}>{profile.referralCode || '—'}</span>
              <button onClick={() => { navigator.clipboard.writeText(profile.referralCode); showToast('Code copied!'); }}
                className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold" style={{ background: C.gold + '30', color: C.gold }}>
                <Copy size={11} /> Copy
              </button>
            </div>
          </div>
          <div>
            <p className="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Full Referral Link</p>
            <div className="flex gap-2">
              <input readOnly value={referralLink}
                className="flex-1 px-3 py-2.5 text-xs border border-gray-200 rounded-xl bg-gray-50 text-gray-600 min-w-0" />
              <button onClick={() => { navigator.clipboard.writeText(referralLink); showToast('Link copied!'); }}
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
    'site-editor': <SiteEditorPage showToast={showToast} />,
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
