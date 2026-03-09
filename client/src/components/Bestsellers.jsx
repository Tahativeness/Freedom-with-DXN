import { useState, useEffect } from 'react';
import axios from 'axios';
import ProductCard from './ProductCard';
import { FiTrendingUp } from 'react-icons/fi';

const DEMO_BESTSELLERS = [
  { _id: 'bs1', name: 'Lingzhi Coffee 3 in 1', category: 'coffee', price: 24.99, rating: 4.9, featured: true, inStock: true, description: 'DXN\'s #1 selling product worldwide. Smooth coffee blended with Ganoderma extract.' },
  { _id: 'bs2', name: 'Reishi Gano (RG)', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true, description: 'Premium Ganoderma Lucidum extract — the King of Herbs.' },
  { _id: 'bs3', name: 'Spirulina Tablet', category: 'supplements', price: 29.99, rating: 4.8, featured: true, inStock: true, description: 'Superfood supplement packed with vitamins and minerals.' },
  { _id: 'bs4', name: 'Lingzhi Black Coffee', category: 'coffee', price: 21.99, rating: 4.8, featured: false, inStock: true, description: 'Pure black coffee enriched with Ganoderma for health-conscious coffee lovers.' },
];

export default function Bestsellers({ limit = 4, showTitle = true }) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get(`/api/products?limit=${limit}`)
      .then((r) => {
        const sorted = r.data.products.sort((a, b) => (b.rating || 0) - (a.rating || 0));
        setProducts(sorted.length > 0 ? sorted.slice(0, limit) : DEMO_BESTSELLERS.slice(0, limit));
      })
      .catch(() => setProducts(DEMO_BESTSELLERS.slice(0, limit)))
      .finally(() => setLoading(false));
  }, [limit]);

  if (loading) return (
    <div className="flex justify-center py-12">
      <div className="w-10 h-10 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
    </div>
  );

  return (
    <div>
      {showTitle && (
        <div className="text-center mb-10">
          <div className="flex items-center justify-center gap-2 mb-3">
            <FiTrendingUp className="text-dxn-gold" size={24} />
            <span className="text-dxn-gold font-semibold text-sm uppercase tracking-widest">Most Popular</span>
          </div>
          <h2 className="section-title">Bestsellers</h2>
          <p className="section-subtitle">Our top-rated products loved by distributors and customers worldwide</p>
        </div>
      )}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {products.map((p) => <ProductCard key={p._id} product={p} />)}
      </div>
    </div>
  );
}
