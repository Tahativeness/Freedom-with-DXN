import { useState } from 'react';
import { Link, NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useCart } from '../context/CartContext';
import { FiShoppingCart, FiMenu, FiX, FiUser, FiLogOut, FiGrid } from 'react-icons/fi';

export default function Navbar() {
  const { user, logout } = useAuth();
  const { cartCount } = useCart();
  const navigate = useNavigate();
  const [menuOpen, setMenuOpen] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(false);

  const handleLogout = () => {
    logout();
    navigate('/');
    setDropdownOpen(false);
  };

  const navLinks = [
    { to: '/', label: 'Home' },
    { to: '/products', label: 'Products' },
    { to: '/business', label: 'Business' },
    { to: '/contact', label: 'Contact' },
  ];

  return (
    <nav className="bg-dxn-darkgreen shadow-lg sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <div className="w-9 h-9 bg-dxn-gold rounded-full flex items-center justify-center font-bold text-white text-sm">DXN</div>
            <span className="text-white font-bold text-lg hidden sm:block">Grow with DXN</span>
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-6">
            {navLinks.map((l) => (
              <NavLink
                key={l.to}
                to={l.to}
                className={({ isActive }) =>
                  `text-sm font-medium transition-colors ${isActive ? 'text-dxn-gold' : 'text-gray-200 hover:text-white'}`
                }
                end={l.to === '/'}
              >
                {l.label}
              </NavLink>
            ))}
          </div>

          {/* Right side */}
          <div className="flex items-center gap-3">
            {/* Cart */}
            <Link to="/cart" className="relative text-gray-200 hover:text-white transition-colors">
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
                  className="flex items-center gap-2 text-gray-200 hover:text-white transition-colors"
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
                      <FiGrid size={14} /> Dashboard
                    </Link>
                    {user.role === 'admin' && (
                      <Link to="/admin" onClick={() => setDropdownOpen(false)} className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <FiUser size={14} /> Admin Panel
                      </Link>
                    )}
                    <button onClick={handleLogout} className="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                      <FiLogOut size={14} /> Logout
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <div className="hidden md:flex items-center gap-2">
                <Link to="/login" className="text-gray-200 hover:text-white text-sm font-medium transition-colors">Login</Link>
                <Link to="/register" className="bg-dxn-gold text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-dxn-lightgold transition-colors">
                  Join Now
                </Link>
              </div>
            )}

            {/* Mobile menu button */}
            <button onClick={() => setMenuOpen(!menuOpen)} className="md:hidden text-gray-200 hover:text-white">
              {menuOpen ? <FiX size={24} /> : <FiMenu size={24} />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {menuOpen && (
          <div className="md:hidden pb-4 border-t border-green-800 mt-2">
            <div className="flex flex-col gap-2 pt-3">
              {navLinks.map((l) => (
                <NavLink key={l.to} to={l.to} onClick={() => setMenuOpen(false)} className="text-gray-200 hover:text-white px-2 py-2 text-sm font-medium" end={l.to === '/'}>
                  {l.label}
                </NavLink>
              ))}
              {!user && (
                <>
                  <Link to="/login" onClick={() => setMenuOpen(false)} className="text-gray-200 hover:text-white px-2 py-2 text-sm">Login</Link>
                  <Link to="/register" onClick={() => setMenuOpen(false)} className="bg-dxn-gold text-white px-4 py-2 rounded-lg text-sm font-semibold text-center">Join Now</Link>
                </>
              )}
            </div>
          </div>
        )}
      </div>
    </nav>
  );
}
