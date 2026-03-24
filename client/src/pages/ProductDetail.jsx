import { useState, useEffect, useRef } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { FiArrowLeft, FiStar, FiCheck, FiMessageCircle } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';

const WHATSAPP_URL = 'https://wa.me/message/EFSQ2IDNVG3YB1';

const CATEGORY_AR = {
  coffee: 'قهوة',
  ganoderma: 'غانوديرما',
  supplements: 'مكملات',
  skincare: 'العناية بالبشرة',
  beverages: 'مشروبات',
  'personal-care': 'العناية الشخصية',
  other: 'أخرى',
};

export default function ProductDetail() {
  const { id } = useParams();
  const { lang } = useLang();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [selectedImage, setSelectedImage] = useState(null);
  const [zoom, setZoom] = useState(false);
  const [zoomPos, setZoomPos] = useState({ x: 50, y: 50 });

  const displayName = lang === 'ar' && product?.nameAr ? product.nameAr : product?.name;
  const displayDesc = lang === 'ar' && product?.descriptionAr ? product.descriptionAr : product?.description;
  const displayBenefits = lang === 'ar' && product?.benefitsAr?.length > 0 ? product.benefitsAr : product?.benefits;
  const displayUsage = lang === 'ar' && product?.usageAr ? product.usageAr : product?.usage;
  const displayCategory = lang === 'ar' ? CATEGORY_AR[product?.category] || product?.category : product?.category;
  const defaultImage = product?.landingImage || product?.image || null;
  const imgContainerRef = useRef(null);

  const handleMouseMove = (e) => {
    if (!imgContainerRef.current) return;
    const rect = imgContainerRef.current.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width) * 100;
    const y = ((e.clientY - rect.top) / rect.height) * 100;
    setZoomPos({ x, y });
  };

  useEffect(() => {
    axios.get(`/api/products/${id}`)
      .then((r) => setProduct(r.data))
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [id]);

  const handleWhatsApp = () => {
    window.open(WHATSAPP_URL, '_blank');
  };

  if (loading) return (
    <div className="flex justify-center items-center min-h-screen">
      <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!product) return (
    <div className="flex flex-col items-center justify-center min-h-screen gap-4">
      <p className="text-xl text-gray-500">Product not found.</p>
      <Link to="/products" className="btn-primary">Back to Products</Link>
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 py-10">
        <Link to="/products" className="inline-flex items-center gap-2 text-dxn-green hover:text-dxn-darkgreen mb-6">
          <FiArrowLeft /> {lang === 'ar' ? 'العودة للمنتجات' : 'Back to Products'}
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden p-8">
          {/* Images */}
          <div>
            <div
              ref={imgContainerRef}
              className="bg-gray-100 rounded-xl overflow-hidden aspect-square mb-3 relative"
              style={{ cursor: zoom ? 'crosshair' : 'zoom-in' }}
              onMouseEnter={() => setZoom(true)}
              onMouseLeave={() => setZoom(false)}
              onMouseMove={handleMouseMove}
            >
              {/* Base image — hidden when zooming */}
              <img
                src={selectedImage || defaultImage || `https://placehold.co/600x600/16392d/white?text=${encodeURIComponent(product.name)}`}
                alt={product.name}
                className="w-full h-full object-cover"
                style={{ opacity: zoom ? 0 : 1 }}
                draggable={false}
              />
              {/* Zoom overlay */}
              <div
                className="absolute inset-0 pointer-events-none"
                style={{
                  backgroundImage: `url(${selectedImage || defaultImage || `https://placehold.co/600x600/16392d/white?text=${encodeURIComponent(product.name)}`})`,
                  backgroundSize: '300%',
                  backgroundPosition: `${zoomPos.x}% ${zoomPos.y}%`,
                  backgroundRepeat: 'no-repeat',
                  opacity: zoom ? 1 : 0,
                  transition: 'opacity 0.15s ease',
                }}
              />
              {zoom && (
                <span className="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded pointer-events-none">
                  🔍 Move to zoom
                </span>
              )}
            </div>
            {product.images?.length > 0 && (
              <div className="grid grid-cols-5 gap-2">
                <button
                  onClick={() => setSelectedImage(null)}
                  className={`aspect-square rounded-lg overflow-hidden border-2 transition-colors ${!selectedImage ? 'border-dxn-green' : 'border-gray-200 hover:border-gray-400'}`}
                >
                  <img
                    src={product.image || `https://placehold.co/100x100/16392d/white?text=${encodeURIComponent(product.name?.charAt(0))}`}
                    alt="Main"
                    className="w-full h-full object-cover"
                  />
                </button>
                {product.images.map((img, idx) => (
                  <button
                    key={idx}
                    onClick={() => setSelectedImage(img)}
                    className={`aspect-square rounded-lg overflow-hidden border-2 transition-colors ${selectedImage === img ? 'border-dxn-green' : 'border-gray-200 hover:border-gray-400'}`}
                  >
                    <img src={img} alt={`${product.name} ${idx + 1}`} className="w-full h-full object-cover" />
                  </button>
                ))}
              </div>
            )}
          </div>

          {/* Info */}
          <div>
            <span className="text-sm text-dxn-gold font-semibold uppercase tracking-widest">{displayCategory}</span>
            <h1 className="text-3xl font-bold text-dxn-darkgreen mt-2 mb-3">{displayName}</h1>

            <div className="flex items-center gap-2 mb-4">
              {[...Array(5)].map((_, i) => (
                <FiStar key={i} size={18} className={i < Math.round(product.rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'} />
              ))}
              <span className="text-gray-500 text-sm">({product.reviews?.length || 0} reviews)</span>
            </div>

            <p className="text-3xl font-bold text-dxn-green mb-4">${product.price?.toFixed(2)}</p>
            <p className="text-gray-600 mb-6">{displayDesc}</p>

            {displayBenefits?.length > 0 && (
              <div className="mb-6">
                <h3 className="font-semibold text-gray-800 mb-3">{lang === 'ar' ? 'الفوائد الرئيسية' : 'Key Benefits'}</h3>
                <ul className="space-y-2">
                  {displayBenefits.map((b) => (
                    <li key={b} className="flex items-center gap-2 text-gray-600">
                      <FiCheck className="text-dxn-green shrink-0" /> {b}
                    </li>
                  ))}
                </ul>
              </div>
            )}

            {displayUsage && (
              <div className="mb-6 p-4 bg-green-50 rounded-lg">
                <h3 className="font-semibold text-gray-800 mb-1">{lang === 'ar' ? 'طريقة الاستخدام' : 'How to Use'}</h3>
                <p className="text-gray-600 text-sm">{displayUsage}</p>
              </div>
            )}

            {/* Order via WhatsApp */}
            <button
              onClick={handleWhatsApp}
              disabled={!product.inStock}
              className="w-full flex items-center justify-center gap-3 bg-[#dfc378] hover:bg-[#dcca8b] text-[#16392d] font-bold py-4 px-6 rounded-xl text-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
            >
              <FiMessageCircle size={22} />
              {product.inStock
                ? (lang === 'ar' ? 'اطلب عبر واتساب' : 'Order via WhatsApp')
                : (lang === 'ar' ? 'غير متوفر' : 'Out of Stock')}
            </button>
            <p className="text-center text-sm text-gray-500 mt-2">
              {lang === 'ar' ? 'سيتم تحويلك إلى واتساب لإتمام الطلب' : 'You will be redirected to WhatsApp to complete your order'}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
