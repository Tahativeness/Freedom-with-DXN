import { Link } from 'react-router-dom';
import { FiFacebook, FiInstagram, FiYoutube, FiMail, FiPhone, FiMapPin } from 'react-icons/fi';
import { useSite } from '../context/SiteContext';

export default function Footer() {
  const { settings } = useSite();
  const contact = settings?.contact || {};
  const social  = settings?.social  || {};
  const footer  = settings?.footer  || {};

  return (
    <footer className="bg-dxn-darkgreen text-gray-300">
      <div className="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        {/* Brand */}
        <div className="col-span-1 md:col-span-1">
          <div className="flex items-center gap-2 mb-4">
            <img src="/logo.png" alt="Grow with DXN" className="h-10 w-auto object-contain" />
          </div>
          <p className="text-sm text-gray-400 mb-4">
            {footer.description || "Your trusted DXN distributor. We help you achieve health and financial freedom through DXN's world-class products."}
          </p>
          <div className="flex gap-3">
            {social.facebook  && <a href={social.facebook}  target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiFacebook size={20} /></a>}
            {social.instagram && <a href={social.instagram} target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiInstagram size={20} /></a>}
            {social.youtube   && <a href={social.youtube}   target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiYoutube size={20} /></a>}
          </div>
        </div>

        {/* Quick Links */}
        <div>
          <h3 className="text-white font-semibold mb-4">Quick Links</h3>
          <ul className="space-y-2 text-sm">
            {[['/', 'Home'], ['/products', 'Products'], ['/business', 'Business Opportunity'], ['/blog', 'Blog'], ['/contact', 'Contact Us']].map(([to, label]) => (
              <li key={to}><Link to={to} className="text-gray-400 hover:text-dxn-gold transition-colors">{label}</Link></li>
            ))}
          </ul>
        </div>

        {/* Products */}
        <div>
          <h3 className="text-white font-semibold mb-4">Products</h3>
          <ul className="space-y-2 text-sm">
            {[
              { label: 'Ganoderma', cat: 'ganoderma' },
              { label: 'DXN Coffee', cat: 'coffee' },
              { label: 'Health Supplements', cat: 'supplements' },
              { label: 'Skincare', cat: 'skincare' },
              { label: 'Beverages', cat: 'beverages' },
            ].map(({ label, cat }) => (
              <li key={cat}><Link to={`/products?category=${cat}`} className="text-gray-400 hover:text-dxn-gold transition-colors">{label}</Link></li>
            ))}
          </ul>
        </div>

        {/* Contact */}
        <div>
          <h3 className="text-white font-semibold mb-4">Contact</h3>
          <ul className="space-y-3 text-sm">
            <li className="flex items-start gap-2">
              <FiMapPin className="text-dxn-gold mt-0.5 shrink-0" />
              <span className="text-gray-400">{contact.location || 'United Arab Emirates'}</span>
            </li>
            <li className="flex items-center gap-2">
              <FiPhone className="text-dxn-gold shrink-0" />
              <span className="text-gray-400">{contact.phone || '+971 50 666 2875'}</span>
            </li>
            <li className="flex items-center gap-2">
              <FiMail className="text-dxn-gold shrink-0" />
              <span className="text-gray-400">{contact.email || 'info@freedomwithdxn.com'}</span>
            </li>
          </ul>
        </div>
      </div>

      <div className="border-t border-dxn-green py-4 text-center text-sm text-gray-500">
        <p>&copy; {new Date().getFullYear()} {footer.copyright || 'Freedom with DXN. All rights reserved.'}</p>
        <p className="text-xs mt-1 text-gray-600">Independent DXN Distributor. DXN is a registered trademark of DXN Holdings Berhad.</p>
      </div>
    </footer>
  );
}
