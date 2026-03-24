import { useState } from 'react';
import { Link } from 'react-router-dom';
import { FiMessageCircle, FiStar } from 'react-icons/fi';
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

export default function ProductCard({ product }) {
  const { lang } = useLang();
  const [hovered, setHovered] = useState(false);

  const displayName = lang === 'ar' && product.nameAr ? product.nameAr : product.name;
  const displayDesc = lang === 'ar' && product.descriptionAr ? product.descriptionAr : product.description;
  const mainImage = product.landingImage || product.image || '';
  const secondImage = product.images?.length > 0 ? product.images[0] : null;

  const handleWhatsApp = (e) => {
    e.preventDefault();
    window.open(WHATSAPP_URL, '_blank');
  };

  const Wrapper = product.landingPage
    ? ({ children, ...props }) => <a href={product.landingPage} {...props}>{children}</a>
    : ({ children, ...props }) => <Link to={`/products/${product._id}`} {...props}>{children}</Link>;

  return (
    <Wrapper
      className="card group block overflow-hidden"
      onMouseEnter={() => setHovered(true)}
      onMouseLeave={() => setHovered(false)}
    >
      <div className="relative overflow-hidden bg-gray-100 aspect-square">
        {mainImage ? (
          <>
            {/* Main image */}
            <img
              src={mainImage}
              alt={displayName}
              style={{
                opacity: hovered && secondImage ? 0 : 1,
                transform: hovered && secondImage ? 'scale(1.05)' : 'scale(1)',
                transition: 'opacity 0.4s ease, transform 0.4s ease',
              }}
              className="absolute inset-0 w-full h-full object-cover"
            />
            {/* Second image */}
            {secondImage && (
              <img
                src={secondImage}
                alt={`${product.name} alt`}
                style={{
                  opacity: hovered ? 1 : 0,
                  transform: hovered ? 'scale(1)' : 'scale(1.05)',
                  transition: 'opacity 0.4s ease, transform 0.4s ease',
                }}
                className="absolute inset-0 w-full h-full object-cover"
              />
            )}
          </>
        ) : (
          <div className="absolute inset-0 bg-gradient-to-br from-dxn-darkgreen to-dxn-green flex flex-col items-center justify-center p-4 text-center">
            <span className="text-dxn-gold text-4xl font-bold mb-2">DXN</span>
            <span className="text-white/90 text-sm font-medium leading-tight">{displayName}</span>
          </div>
        )}
        {product.featured && (
          <span className="absolute top-2 left-2 bg-dxn-gold text-white text-xs px-2 py-1 rounded-full font-semibold z-10">
            {lang === 'ar' ? 'مميز' : 'Featured'}
          </span>
        )}
        {!product.inStock && (
          <div className="absolute inset-0 bg-black/50 flex items-center justify-center z-10">
            <span className="text-white font-bold text-lg">{lang === 'ar' ? 'غير متوفر' : 'Out of Stock'}</span>
          </div>
        )}
      </div>
      <div className="p-4">
        <span className="text-xs text-dxn-green font-medium uppercase tracking-wide">{lang === 'ar' ? CATEGORY_AR[product.category] || product.category : product.category}</span>
        <h3 className="font-semibold text-gray-800 mt-1 mb-1 line-clamp-2 group-hover:text-dxn-green transition-colors">
          {displayName}
        </h3>
        <div className="flex items-center gap-1 mb-3">
          <FiStar className="text-yellow-400 fill-yellow-400" size={14} />
          <span className="text-sm text-gray-500">{product.rating?.toFixed(1) || '0.0'}</span>
        </div>
        <div className="flex items-center justify-between">
          <span className="text-dxn-darkgreen font-bold text-lg">${product.price?.toFixed(2)}</span>
          <button
            onClick={handleWhatsApp}
            disabled={!product.inStock}
            className="flex items-center gap-1 bg-[#dfc378] text-[#16392d] px-3 py-2 rounded-lg text-sm font-medium hover:bg-[#dcca8b] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <FiMessageCircle size={14} /> {lang === 'ar' ? 'اطلب' : 'Order'}
          </button>
        </div>
      </div>
    </Wrapper>
  );
}
