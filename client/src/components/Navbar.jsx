import { useState } from 'react';
import { Link, NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useCart } from '../context/CartContext';
import { useLang } from '../context/LanguageContext';
import { useSite } from '../context/SiteContext';
import { FiShoppingCart, FiMenu, FiX, FiUser, FiLogOut, FiGrid } from 'react-icons/fi';

export default function Navbar() {
  const { user, logout } = useAuth();
  const { cartCount } = useCart();
  const { lang, setLang, t } = useLang();
  const { settings } = useSite();
  const navigate = useNavigate();
  const [menuOpen, setMenuOpen] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(false);

  const handleLogout = () => {
    logout();
    navigate('/');
    setDropdownOpen(false);
  };

  const nb = settings?.navbar || {};
  const allNavLinks = [
    { to: '/',        labelKey: 'home',    show: nb.showHome     !== false },
    { to: '/about',   labelKey: 'about',   show: nb.showAbout    !== false },
    { to: '/products',labelKey: 'products',show: nb.showProducts !== false },
    { to: '/join',    labelKey: 'joinDxn', show: nb.showJoin     !== false },
    { to: '/zoom',    labelKey: 'zoom',    show: nb.showZoom     !== false },
    { to: '/blog',    labelKey: 'blog',    show: nb.showBlog     !== false },
    { to: '/contact', labelKey: 'contact', show: nb.showContact  !== false },
  ];
  const navLinks = allNavLinks.filter(l => l.show);

  return (
    <nav className="bg-dxn-green shadow-lg sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-20">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2 shrink-0">
            <img src="/logo.png" alt="Grow with DXN" className="h-14 w-auto object-contain" />
          </Link>

          {/* Desktop Nav */}
          <div className="hidden lg:flex items-center gap-5">
            {navLinks.map((l) => (
              <NavLink
                key={l.to}
                to={l.to}
                className={({ isActive }) =>
                  `text-sm font-medium transition-colors whitespace-nowrap ${isActive ? 'text-dxn-gold font-bold' : 'text-white hover:text-dxn-gold'}`
                }
                end={l.to === '/'}
              >
                {t(l.labelKey)}
              </NavLink>
            ))}
          </div>

          {/* Right side */}
          <div className="flex items-center gap-3 shrink-0">
            {/* Language Toggle */}
            <button
              onClick={() => setLang(lang === 'en' ? 'ar' : 'en')}
              className="flex items-center gap-1 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full transition-colors border border-white/20"
              title={lang === 'en' ? 'Switch to Arabic' : 'التبديل إلى الإنجليزية'}
            >
              {lang === 'en' ? '🇦🇪 AR' : '🇬🇧 EN'}
            </button>

            {/* Cart */}
            <Link to="/cart" className="relative text-white hover:text-dxn-gold transition-colors">
              <FiShoppingCart size={22} />
              {cartCount > 0 && (
                <span className="absolute -top-2 -right-2 bg-dxn-gold text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                  {cartCount}
                </span>
              )}
            </Link>

            {/* Auth */}
            {user ? (
              <div className="relative">
                <button
                  onClick={() => setDropdownOpen(!dropdownOpen)}
                  className="flex items-center gap-2 text-white hover:text-dxn-gold transition-colors"
                >
                  <div className="w-8 h-8 bg-dxn-gold rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {user.name?.charAt(0).toUpperCase()}
                  </div>
                </button>
                {dropdownOpen && (
                  <div className="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50">
                    <div className="px-4 py-2 border-b">
                      <p className="font-semibold text-gray-800 text-sm">{user.name}</p>
                      <p className="text-gray-500 text-xs">{user.role}</p>
                    </div>
                    <Link to="/dashboard" onClick={() => setDropdownOpen(false)} className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <FiGrid size={14} /> {lang === 'ar' ? 'لوحة التحكم' : 'Dashboard'}
                    </Link>
                    {user.role === 'admin' && (
                      <Link to="/admin" onClick={() => setDropdownOpen(false)} className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <FiUser size={14} /> {lang === 'ar' ? 'لوحة الإدارة' : 'Admin Panel'}
                      </Link>
                    )}
                    <button onClick={handleLogout} className="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                      <FiLogOut size={14} /> {lang === 'ar' ? 'تسجيل الخروج' : 'Logout'}
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <div className="hidden md:flex items-center gap-2">
                <Link to="/login" className="text-white hover:text-dxn-gold text-sm font-medium transition-colors">{t('login')}</Link>
                <Link to="/join" className="bg-dxn-gold text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-dxn-lightgold transition-colors whitespace-nowrap">
                  {t('joinNow')}
                </Link>
              </div>
            )}

            {/* Mobile menu button */}
            <button onClick={() => setMenuOpen(!menuOpen)} className="lg:hidden text-white hover:text-dxn-gold">
              {menuOpen ? <FiX size={24} /> : <FiMenu size={24} />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {menuOpen && (
          <div className="lg:hidden pb-4 border-t border-dxn-gold/30 mt-2">
            <div className="flex flex-col gap-1 pt-3">
              {navLinks.map((l) => (
                <NavLink key={l.to} to={l.to} onClick={() => setMenuOpen(false)}
                  className="text-white hover:text-dxn-gold px-2 py-2 text-sm font-medium" end={l.to === '/'}>
                  {t(l.labelKey)}
                </NavLink>
              ))}
              {!user && (
                <>
                  <Link to="/login" onClick={() => setMenuOpen(false)} className="text-white hover:text-dxn-gold px-2 py-2 text-sm">{t('login')}</Link>
                  <Link to="/join" onClick={() => setMenuOpen(false)} className="bg-dxn-gold text-white px-4 py-2 rounded-lg text-sm font-semibold text-center mt-2">
                    {t('joinNow')}
                  </Link>
                </>
              )}
            </div>
          </div>
        )}
      </div>
    </nav>
  );
}
