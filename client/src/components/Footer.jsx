import { Link } from 'react-router-dom';
import { FiFacebook, FiInstagram, FiYoutube, FiMail, FiPhone, FiMapPin } from 'react-icons/fi';

export default function Footer() {
  return (
    <footer className="bg-dxn-darkgreen text-gray-300">
      <div className="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        {/* Brand */}
        <div className="col-span-1 md:col-span-1">
          <div className="flex items-center gap-2 mb-4">
            <div className="w-9 h-9 bg-dxn-gold rounded-full flex items-center justify-center font-bold text-white text-sm">DXN</div>
            <span className="text-white font-bold text-lg">Grow with DXN</span>
          </div>
          <p className="text-sm text-gray-400 mb-4">
            Your trusted DXN distributor. We help you achieve health and financial freedom through DXN's world-class products.
          </p>
          <div className="flex gap-3">
            <a href="#" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiFacebook size={20} /></a>
            <a href="#" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiInstagram size={20} /></a>
            <a href="#" className="text-gray-400 hover:text-dxn-gold transition-colors"><FiYoutube size={20} /></a>
          </div>
        </div>

        {/* Quick Links */}
        <div>
          <h3 className="text-white font-semibold mb-4">Quick Links</h3>
          <ul className="space-y-2 text-sm">
            {[['/', 'Home'], ['/products', 'Products'], ['/business', 'Business Opportunity'], ['/contact', 'Contact Us']].map(([to, label]) => (
              <li key={to}><Link to={to} className="text-gray-400 hover:text-dxn-gold transition-colors">{label}</Link></li>
            ))}
          </ul>
        </div>

        {/* Products */}
        <div>
          <h3 className="text-white font-semibold mb-4">Products</h3>
          <ul className="space-y-2 text-sm">
            {['Ganoderma', 'DXN Coffee', 'Health Supplements', 'Skincare', 'Beverages'].map((item) => (
              <li key={item}><Link to="/products" className="text-gray-400 hover:text-dxn-gold transition-colors">{item}</Link></li>
            ))}
          </ul>
        </div>

        {/* Contact */}
        <div>
          <h3 className="text-white font-semibold mb-4">Contact</h3>
          <ul className="space-y-3 text-sm">
            <li className="flex items-start gap-2">
              <FiMapPin className="text-dxn-gold mt-0.5 shrink-0" />
              <span className="text-gray-400">Your City, Your Country</span>
            </li>
            <li className="flex items-center gap-2">
              <FiPhone className="text-dxn-gold shrink-0" />
              <span className="text-gray-400">+1 234 567 890</span>
            </li>
            <li className="flex items-center gap-2">
              <FiMail className="text-dxn-gold shrink-0" />
              <span className="text-gray-400">info@growwithdxn.com</span>
            </li>
          </ul>
        </div>
      </div>

      <div className="border-t border-green-900 py-4 text-center text-sm text-gray-500">
        <p>&copy; {new Date().getFullYear()} Grow with DXN. All rights reserved.</p>
        <p className="text-xs mt-1 text-gray-600">Independent DXN Distributor. DXN is a registered trademark of DXN Holdings Berhad.</p>
      </div>
    </footer>
  );
}
