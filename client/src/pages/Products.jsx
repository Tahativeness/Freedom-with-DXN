import { useState, useEffect } from 'react';
import axios from 'axios';
import ProductCard from '../components/ProductCard';
import { FiSearch, FiFilter } from 'react-icons/fi';

const CATEGORIES = ['all', 'coffee', 'ganoderma', 'supplements', 'skincare', 'beverages', 'other'];

export default function Products() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [category, setCategory] = useState('all');
  const [search, setSearch] = useState('');
  const [page, setPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);

  useEffect(() => {
    fetchProducts();
  }, [category, page]);

  const fetchProducts = async () => {
    setLoading(true);
    try {
      const params = { page, limit: 12 };
      if (category !== 'all') params.category = category;
      if (search) params.search = search;
      const { data } = await axios.get('/api/products', { params });
      if (!data?.products || !Array.isArray(data.products)) throw new Error('Invalid response');
      setProducts(data.products);
      setTotalPages(data.pages || 1);
    } catch {
      // Use demo products if API not available
      setProducts([
        { _id: '1', name: 'Lingzhi Coffee 3 in 1', category: 'coffee', price: 24.99, rating: 4.8, featured: true, inStock: true, description: 'Classic DXN coffee blended with Ganoderma' },
        { _id: '2', name: 'Reishi Gano (RG)', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true, description: 'Premium Ganoderma Lucidum extract' },
        { _id: '3', name: 'Gano Massage Oil', category: 'skincare', price: 19.99, rating: 4.7, featured: false, inStock: true, description: 'Relaxing massage oil with Ganoderma' },
        { _id: '4', name: 'Spirulina Tablet', category: 'supplements', price: 29.99, rating: 4.6, featured: false, inStock: true, description: 'High quality spirulina supplement' },
        { _id: '5', name: 'DXN Cocozhi', category: 'beverages', price: 22.99, rating: 4.5, featured: false, inStock: true, description: 'Delicious chocolate drink with Ganoderma' },
        { _id: '6', name: 'Lingzhi Black Coffee', category: 'coffee', price: 21.99, rating: 4.7, featured: false, inStock: true, description: 'Pure black coffee with Ganoderma' },
        { _id: '7', name: 'Ganozhi Toothpaste', category: 'other', price: 12.99, rating: 4.4, featured: false, inStock: true, description: 'Ganoderma-infused toothpaste' },
        { _id: '8', name: 'Myco Vege', category: 'supplements', price: 34.99, rating: 4.8, featured: false, inStock: true, description: 'Mushroom and vegetable supplement' },
      ]);
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = (e) => {
    e.preventDefault();
    setPage(1);
    fetchProducts();
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-dxn-darkgreen py-12 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-2">DXN Products</h1>
          <p className="text-gray-300">Premium health products powered by Ganoderma Lucidum</p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-10">
        {/* Search & Filter */}
        <div className="flex flex-col md:flex-row gap-4 mb-8">
          <form onSubmit={handleSearch} className="flex-1 flex gap-2">
            <div className="relative flex-1">
              <FiSearch className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
              <input
                type="text"
                placeholder="Search products..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="input-field pl-10"
              />
            </div>
            <button type="submit" className="btn-primary px-4 py-2">Search</button>
          </form>

          <div className="flex items-center gap-2 overflow-x-auto pb-1">
            <FiFilter className="text-gray-500 shrink-0" />
            {CATEGORIES.map((cat) => (
              <button
                key={cat}
                onClick={() => { setCategory(cat); setPage(1); }}
                className={`px-3 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors ${
                  category === cat ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'
                }`}
              >
                {cat.charAt(0).toUpperCase() + cat.slice(1)}
              </button>
            ))}
          </div>
        </div>

        {/* All Products */}
        <h2 className="text-2xl font-bold text-dxn-darkgreen mb-6">All Products</h2>
        {loading ? (
          <div className="flex justify-center py-20">
            <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin"></div>
          </div>
        ) : products.length > 0 ? (
          <>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
              {products.map((p) => <ProductCard key={p._id} product={p} />)}
            </div>
            {/* Pagination */}
            {totalPages > 1 && (
              <div className="flex justify-center gap-2 mt-10">
                {[...Array(totalPages)].map((_, i) => (
                  <button
                    key={i}
                    onClick={() => setPage(i + 1)}
                    className={`w-10 h-10 rounded-lg font-medium transition-colors ${
                      page === i + 1 ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'
                    }`}
                  >
                    {i + 1}
                  </button>
                ))}
              </div>
            )}
          </>
        ) : (
          <div className="text-center py-20 text-gray-500">
            <p className="text-xl">No products found</p>
          </div>
        )}
      </div>
    </div>
  );
}
