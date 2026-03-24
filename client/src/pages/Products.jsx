import { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import axios from 'axios';
import ProductCard from '../components/ProductCard';
import { FiSearch, FiFilter, FiGrid, FiList } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';

const CATEGORIES = [
  { value: 'all',           label: 'All Products',   labelAr: 'جميع المنتجات', icon: '🌿' },
  { value: 'coffee',        label: 'Coffee',          labelAr: 'قهوة',          icon: '☕' },
  { value: 'beverages',     label: 'Beverages',       labelAr: 'مشروبات',       icon: '🧃' },
  { value: 'supplements',   label: 'Supplements',     labelAr: 'مكملات',        icon: '💊' },
  { value: 'personal-care', label: 'Personal Care',   labelAr: 'العناية الشخصية', icon: '🧴' },
  { value: 'skincare',      label: 'Skin Care',       labelAr: 'العناية بالبشرة', icon: '✨' },
  { value: 'ganoderma',     label: 'Ganoderma',       labelAr: 'غانوديرما',     icon: '🍄' },
  { value: 'other',         label: 'Other',           labelAr: 'أخرى',          icon: '📦' },
];

const SORT_OPTIONS = [
  { value: 'default',     label: 'Default',            labelAr: 'افتراضي' },
  { value: 'price-asc',   label: 'Price: Low → High',  labelAr: 'السعر: من الأقل' },
  { value: 'price-desc',  label: 'Price: High → Low',  labelAr: 'السعر: من الأعلى' },
  { value: 'rating-desc', label: 'Top Rated',           labelAr: 'الأعلى تقييماً' },
  { value: 'name-asc',    label: 'Name A → Z',          labelAr: 'الاسم أ → ي' },
];

export default function Products() {
  const { lang } = useLang();
  const [searchParams] = useSearchParams();
  const [products, setProducts]     = useState([]);
  const [loading, setLoading]       = useState(true);
  const [category, setCategory]     = useState(searchParams.get('category') || 'all');
  const [search, setSearch]         = useState('');
  const [sort, setSort]             = useState('default');
  const [page, setPage]             = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [total, setTotal]           = useState(0);
  const [view, setView]             = useState('grid'); // grid | list

  useEffect(() => {
    const cat = searchParams.get('category') || 'all';
    setCategory(cat);
    setSearch('');
    setPage(1);
  }, [searchParams]);

  useEffect(() => { fetchProducts(); }, [category, page, sort]);

  const fetchProducts = async () => {
    setLoading(true);
    try {
      const params = { page, limit: 12 };
      if (category !== 'all') params.category = category;
      if (search) params.search = search;
      if (sort !== 'default') params.sort = sort;
      const { data } = await axios.get('/api/products', { params, timeout: 5000 });
      if (!data?.products || !Array.isArray(data.products)) throw new Error('Invalid response');
      setProducts(data.products);
      setTotalPages(data.pages || 1);
      setTotal(data.total || data.products.length);
    } catch {
      setProducts([]);
      setTotalPages(1);
      setTotal(0);
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = (e) => {
    e.preventDefault();
    setPage(1);
    fetchProducts();
  };

  const handleCategoryChange = (cat) => {
    setCategory(cat);
    setPage(1);
  };

  const activeCat = CATEGORIES.find((c) => c.value === category);

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-dxn-darkgreen py-14 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
            {lang === 'ar' ? 'منتجات DXN الرسمية' : 'Official DXN Products'}
          </span>
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-2">{lang === 'ar' ? 'كتالوج منتجات DXN' : 'DXN Product Catalog'}</h1>
          <p className="text-gray-300">{lang === 'ar' ? 'منتجات صحية فاخرة مدعومة بفطر غانوديرما لوسيدوم' : 'Premium health products powered by Ganoderma Lucidum'}</p>
        </div>
      </div>

      {/* Category Tabs */}
      <div className="bg-white border-b sticky top-0 z-10 shadow-sm">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex items-center gap-1 overflow-x-auto py-3 scrollbar-hide">
            {CATEGORIES.map((cat) => (
              <button
                key={cat.value}
                onClick={() => handleCategoryChange(cat.value)}
                className={`flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all ${
                  category === cat.value
                    ? 'bg-dxn-green text-white shadow-md'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                }`}
              >
                <span>{cat.icon}</span>
                {lang === 'ar' ? cat.labelAr : cat.label}
              </button>
            ))}
          </div>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Search + Sort + View */}
        <div className="flex flex-col md:flex-row gap-3 mb-6">
          {/* Search */}
          <form onSubmit={handleSearch} className="flex-1 flex gap-2">
            <div className="relative flex-1">
              <FiSearch className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
              <input
                type="text"
                placeholder={lang === 'ar' ? 'ابحث عن منتج...' : 'Search products...'}
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-dxn-green bg-white"
              />
            </div>
            <button type="submit" className="btn-primary px-5 py-2.5 rounded-xl">{lang === 'ar' ? 'بحث' : 'Search'}</button>
          </form>

          {/* Sort */}
          <div className="flex items-center gap-2">
            <select
              value={sort}
              onChange={(e) => { setSort(e.target.value); setPage(1); }}
              className="border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-dxn-green"
            >
              {SORT_OPTIONS.map((o) => (
                <option key={o.value} value={o.value}>{lang === 'ar' ? o.labelAr : o.label}</option>
              ))}
            </select>

            {/* View toggle */}
            <div className="flex border border-gray-200 rounded-xl overflow-hidden">
              <button
                onClick={() => setView('grid')}
                className={`p-2.5 ${view === 'grid' ? 'bg-dxn-green text-white' : 'bg-white text-gray-500 hover:bg-gray-50'}`}
              >
                <FiGrid size={16} />
              </button>
              <button
                onClick={() => setView('list')}
                className={`p-2.5 ${view === 'list' ? 'bg-dxn-green text-white' : 'bg-white text-gray-500 hover:bg-gray-50'}`}
              >
                <FiList size={16} />
              </button>
            </div>
          </div>
        </div>

        {/* Results bar */}
        <div className="flex items-center justify-between mb-5">
          <h2 className="text-lg font-bold text-dxn-darkgreen">
            {activeCat?.icon} {lang === 'ar' ? activeCat?.labelAr : activeCat?.label}
            {total > 0 && <span className="text-sm font-normal text-gray-400 ml-2">({total} {lang === 'ar' ? 'منتج' : 'products'})</span>}
          </h2>
        </div>

        {/* Product Grid / List */}
        {loading ? (
          <div className="flex justify-center py-24">
            <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
          </div>
        ) : products.length > 0 ? (
          <>
            <div className={
              view === 'grid'
                ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6'
                : 'flex flex-col gap-4'
            }>
              {products.map((p) => (
                <ProductCard key={p._id} product={p} listView={view === 'list'} />
              ))}
            </div>

            {/* Pagination */}
            {totalPages > 1 && (
              <div className="flex justify-center gap-2 mt-10">
                <button
                  onClick={() => setPage((p) => Math.max(1, p - 1))}
                  disabled={page === 1}
                  className="px-4 py-2 rounded-xl border bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-40"
                >
                  {lang === 'ar' ? 'السابق ←' : '← Prev'}
                </button>
                {[...Array(totalPages)].map((_, i) => (
                  <button
                    key={i}
                    onClick={() => setPage(i + 1)}
                    className={`w-10 h-10 rounded-xl font-medium transition-colors ${
                      page === i + 1 ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'
                    }`}
                  >
                    {i + 1}
                  </button>
                ))}
                <button
                  onClick={() => setPage((p) => Math.min(totalPages, p + 1))}
                  disabled={page === totalPages}
                  className="px-4 py-2 rounded-xl border bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-40"
                >
                  {lang === 'ar' ? '→ التالي' : 'Next →'}
                </button>
              </div>
            )}
          </>
        ) : (
          <div className="text-center py-24 text-gray-400">
            <div className="text-5xl mb-4">🔍</div>
            <p className="text-xl font-medium">{lang === 'ar' ? 'لم يتم العثور على منتجات' : 'No products found'}</p>
            <p className="text-sm mt-1">{lang === 'ar' ? 'جرب فئة أو كلمة بحث مختلفة' : 'Try a different category or search term'}</p>
            <button
              onClick={() => { setCategory('all'); setSearch(''); setPage(1); }}
              className="mt-4 btn-primary px-6 py-2"
            >
              {lang === 'ar' ? 'عرض جميع المنتجات' : 'View All Products'}
            </button>
          </div>
        )}
      </div>
    </div>
  );
}
