import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { FiShoppingCart, FiStar } from 'react-icons/fi';
import toast from 'react-hot-toast';

export default function ProductCard({ product }) {
  const { addToCart } = useCart();

  const handleAddToCart = (e) => {
    e.preventDefault();
    addToCart(product);
    toast.success(`${product.name} added to cart!`);
  };

  const mainImage = product.image || '';
  const secondImage = product.images?.length > 0 ? product.images[0] : null;

  return (
    <Link to={`/products/${product._id}`} className="card group block overflow-hidden">
      <div className="relative overflow-hidden bg-gray-100 aspect-square">
        {mainImage ? (
          <>
            <img
              src={mainImage}
              alt={product.name}
              className={`absolute inset-0 w-full h-full object-cover transition-all duration-500 ${secondImage ? 'group-hover:opacity-0 group-hover:scale-105' : 'group-hover:scale-105'}`}
            />
            {secondImage && (
              <img
                src={secondImage}
                alt={`${product.name} hover`}
                className="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-all duration-500 scale-105 group-hover:scale-100"
              />
            )}
          </>
        ) : (
          <div className="absolute inset-0 bg-gradient-to-br from-dxn-darkgreen to-dxn-green flex flex-col items-center justify-center p-4 text-center">
            <span className="text-dxn-gold text-4xl font-bold mb-2">DXN</span>
            <span className="text-white/90 text-sm font-medium leading-tight">{product.name}</span>
          </div>
        )}
        {product.featured && (
          <span className="absolute top-2 left-2 bg-dxn-gold text-white text-xs px-2 py-1 rounded-full font-semibold z-10">
            Featured
          </span>
        )}
        {!product.inStock && (
          <div className="absolute inset-0 bg-black/50 flex items-center justify-center z-10">
            <span className="text-white font-bold text-lg">Out of Stock</span>
          </div>
        )}
      </div>
      <div className="p-4">
        <span className="text-xs text-dxn-green font-medium uppercase tracking-wide">{product.category}</span>
        <h3 className="font-semibold text-gray-800 mt-1 mb-1 line-clamp-2 group-hover:text-dxn-green transition-colors">
          {product.name}
        </h3>
        <div className="flex items-center gap-1 mb-3">
          <FiStar className="text-yellow-400 fill-yellow-400" size={14} />
          <span className="text-sm text-gray-500">{product.rating?.toFixed(1) || '0.0'}</span>
        </div>
        <div className="flex items-center justify-between">
          <span className="text-dxn-darkgreen font-bold text-lg">${product.price?.toFixed(2)}</span>
          <button
            onClick={handleAddToCart}
            disabled={!product.inStock}
            className="flex items-center gap-1 bg-dxn-green text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-dxn-darkgreen transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <FiShoppingCart size={14} /> Add
          </button>
        </div>
      </div>
    </Link>
  );
}
