import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import ProductCard from '../components/ProductCard';
import Bestsellers from '../components/Bestsellers';
import { FiArrowRight, FiStar, FiUsers, FiGlobe, FiAward, FiCheck } from 'react-icons/fi';

const STATS = [
  { label: 'Countries', value: '180+', icon: FiGlobe },
  { label: 'Members', value: '9M+', icon: FiUsers },
  { label: 'Years', value: '35+', icon: FiAward },
  { label: 'Products', value: '1000+', icon: FiStar },
];

const TESTIMONIALS = [
  { name: 'Sarah M.', role: 'Diamond Distributor', text: 'DXN changed my life. The Ganoderma products improved my health and I now earn a full-time income.', avatar: 'S' },
  { name: 'James K.', role: 'Gold Distributor', text: 'I joined DXN 2 years ago and built a team of 50+ distributors. Best decision ever!', avatar: 'J' },
  { name: 'Maria L.', role: 'Star Ruby Member', text: 'The coffee is absolutely amazing and my downline keeps growing every month!', avatar: 'M' },
];

const WHY_JOIN = [
  'Low startup cost to become a distributor',
  'World-class Ganoderma-based products',
  'One-world, one-market global business',
  'Passive income through downline network',
  'Free training and support from upline',
  'No monthly purchase quota required',
];

export default function Home() {
  const [featured, setFeatured] = useState([]);

  useEffect(() => {
    axios.get('/api/products?featured=true&limit=4', { timeout: 3000 })
      .then((r) => {
        if (Array.isArray(r.data?.products) && r.data.products.length > 0) {
          setFeatured(r.data.products);
        } else {
          throw new Error('No data');
        }
      })
      .catch(() => {
        setFeatured([
          { _id: '1', name: 'Lingzhi Coffee 3 in 1', category: 'coffee', price: 24.99, rating: 4.8, featured: true, inStock: true, description: 'Classic DXN coffee blended with Ganoderma' },
          { _id: '2', name: 'Reishi Gano (RG)', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true, description: 'Premium Ganoderma Lucidum extract' },
          { _id: '3', name: 'Spirulina Tablet', category: 'supplements', price: 29.99, rating: 4.6, featured: true, inStock: true, description: 'High quality spirulina supplement' },
          { _id: '4', name: 'DXN Cocozhi', category: 'beverages', price: 22.99, rating: 4.5, featured: true, inStock: true, description: 'Delicious chocolate drink with Ganoderma' },
        ]);
      });
  }, []);

  return (
    <div>
      {/* Hero */}
      <section className="bg-hero min-h-[85vh] flex items-center relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 30% 50%, #dfc378 0%, transparent 50%)' }} />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
              Independent DXN Distributor
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
              Grow Your Health &{' '}
              <span className="text-dxn-gold">Wealth</span> with DXN
            </h1>
            <p className="text-gray-300 text-lg mb-8 max-w-lg">
              Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life. Join thousands of successful distributors worldwide.
            </p>
            <div className="flex flex-col sm:flex-row gap-4">
              <Link to="/products" className="btn-gold text-center">
                Shop Products
              </Link>
              <Link to="/business" className="btn-outline border-white text-white hover:bg-white hover:text-dxn-darkgreen text-center px-6 py-3 rounded-lg font-semibold transition-all">
                Join as Distributor
              </Link>
            </div>
          </div>
          <div className="hidden lg:flex justify-center">
            <div className="relative">
              <div className="w-80 h-80 bg-dxn-gold/20 rounded-full flex items-center justify-center">
                <div className="w-64 h-64 bg-dxn-gold/30 rounded-full flex items-center justify-center">
                  <div className="text-center text-white">
                    <div className="text-6xl font-bold text-dxn-gold">DXN</div>
                    <div className="text-xl mt-2">Ganoderma</div>
                    <div className="text-sm text-gray-300 mt-1">Since 1993</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="bg-dxn-green py-12">
        <div className="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
          {STATS.map(({ label, value, icon: Icon }) => (
            <div key={label} className="text-center text-white">
              <Icon className="mx-auto mb-2 text-dxn-gold" size={28} />
              <div className="text-3xl font-bold">{value}</div>
              <div className="text-gray-300 text-sm">{label}</div>
            </div>
          ))}
        </div>
      </section>

      {/* Featured Products */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">Featured Products</h2>
          <p className="section-subtitle">Premium quality health products powered by the King of Herbs — Ganoderma Lucidum</p>
          {featured.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {featured.map((p) => <ProductCard key={p._id} product={p} />)}
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {[
                { _id: '1', name: 'Lingzhi Coffee 3 in 1', category: 'coffee', price: 24.99, rating: 4.8, featured: true, inStock: true },
                { _id: '2', name: 'Reishi Gano (RG)', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true },
                { _id: '3', name: 'Gano Massage Oil', category: 'skincare', price: 19.99, rating: 4.7, featured: false, inStock: true },
                { _id: '4', name: 'Spirulina Tablet', category: 'supplements', price: 29.99, rating: 4.6, featured: false, inStock: true },
              ].map((p) => <ProductCard key={p._id} product={p} />)}
            </div>
          )}
          <div className="text-center mt-10">
            <Link to="/products" className="btn-primary inline-flex items-center gap-2">
              View All Products <FiArrowRight />
            </Link>
          </div>
        </div>
      </section>

      {/* Bestsellers */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4">
          <Bestsellers limit={4} />
        </div>
      </section>

      {/* Why Join */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <span className="text-dxn-gold font-semibold text-sm uppercase tracking-widest">Business Opportunity</span>
            <h2 className="text-3xl md:text-4xl font-bold text-dxn-darkgreen mt-2 mb-6">Why Join DXN as a Distributor?</h2>
            <ul className="space-y-3 mb-8">
              {WHY_JOIN.map((item) => (
                <li key={item} className="flex items-start gap-3">
                  <div className="w-5 h-5 bg-dxn-green rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <FiCheck className="text-white" size={12} />
                  </div>
                  <span className="text-gray-600">{item}</span>
                </li>
              ))}
            </ul>
            <Link to="/business" className="btn-primary inline-flex items-center gap-2">
              Learn More <FiArrowRight />
            </Link>
          </div>
          <div className="grid grid-cols-2 gap-4">
            {[
              { title: 'Health', desc: 'Transform your health with Ganoderma', color: 'bg-green-50 border-green-200' },
              { title: 'Wealth', desc: 'Build passive income streams', color: 'bg-yellow-50 border-yellow-200' },
              { title: 'Network', desc: 'Global community of distributors', color: 'bg-blue-50 border-blue-200' },
              { title: 'Freedom', desc: 'Work on your own schedule', color: 'bg-purple-50 border-purple-200' },
            ].map(({ title, desc, color }) => (
              <div key={title} className={`p-6 rounded-xl border-2 ${color}`}>
                <h3 className="font-bold text-dxn-darkgreen text-xl mb-2">{title}</h3>
                <p className="text-gray-600 text-sm">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">Success Stories</h2>
          <p className="section-subtitle">Real people. Real results. Real transformation.</p>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {TESTIMONIALS.map(({ name, role, text, avatar }) => (
              <div key={name} className="card p-6">
                <div className="flex items-center gap-1 mb-4">
                  {[...Array(5)].map((_, i) => <FiStar key={i} className="text-yellow-400 fill-yellow-400" size={16} />)}
                </div>
                <p className="text-gray-600 italic mb-6">"{text}"</p>
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-dxn-green rounded-full flex items-center justify-center text-white font-bold">
                    {avatar}
                  </div>
                  <div>
                    <p className="font-semibold text-gray-800">{name}</p>
                    <p className="text-sm text-dxn-gold">{role}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Blog Preview */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">Latest from Our Blog</h2>
          <p className="section-subtitle">Health tips, business guides, and success stories</p>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {[
              { title: '10 Amazing Benefits of Ganoderma', slug: '10-benefits-ganoderma', category: 'health', excerpt: 'Discover why Ganoderma has been called the King of Herbs for over 2000 years.' },
              { title: 'How to Start Your DXN Business', slug: 'start-dxn-business-2026', category: 'business', excerpt: 'A complete guide for beginners who want to start earning with DXN.' },
              { title: '5 Tips to Grow Your Downline Fast', slug: '5-tips-grow-downline', category: 'tips', excerpt: 'Proven strategies to build your DXN downline using social media and referrals.' },
            ].map((post) => (
              <Link key={post.slug} to={`/blog/${post.slug}`} className="card group overflow-hidden">
                <div className="bg-gradient-to-br from-dxn-green to-dxn-darkgreen h-36 flex items-center justify-center">
                  <div className="text-center">
                    <div className="text-dxn-gold text-2xl font-bold">DXN</div>
                    <div className="text-green-200 text-xs uppercase tracking-widest">{post.category}</div>
                  </div>
                </div>
                <div className="p-5">
                  <span className="text-xs text-dxn-gold font-medium uppercase">{post.category}</span>
                  <h3 className="font-bold text-dxn-darkgreen mt-1 mb-2 group-hover:text-dxn-green transition-colors">{post.title}</h3>
                  <p className="text-gray-600 text-sm line-clamp-2">{post.excerpt}</p>
                </div>
              </Link>
            ))}
          </div>
          <div className="text-center mt-8">
            <Link to="/blog" className="btn-outline inline-flex items-center gap-2">
              Read More Articles <FiArrowRight />
            </Link>
          </div>
        </div>
      </section>

      {/* CTA Banner */}
      <section className="bg-hero py-20">
        <div className="max-w-4xl mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Start Your DXN Journey?</h2>
          <p className="text-gray-300 text-lg mb-8">Join our growing family of distributors and start building your health and wealth today.</p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/register" className="btn-gold">Create Free Account</Link>
            <Link to="/contact" className="btn-outline border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
              Contact Us
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
