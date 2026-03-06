import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { useCart } from '../context/CartContext';
import { FiShoppingCart, FiArrowLeft, FiStar, FiCheck } from 'react-icons/fi';
import toast from 'react-hot-toast';

export default function ProductDetail() {
  const { id } = useParams();
  const { addToCart } = useCart();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [qty, setQty] = useState(1);

  useEffect(() => {
    axios.get(`/api/products/${id}`)
      .then((r) => setProduct(r.data))
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [id]);

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
          <FiArrowLeft /> Back to Products
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden p-8">
          {/* Image */}
          <div className="bg-gray-100 rounded-xl overflow-hidden aspect-square">
            <img
              src={product.image || `https://placehold.co/600x600/1a5c2e/white?text=${encodeURIComponent(product.name)}`}
              alt={product.name}
              className="w-full h-full object-cover"
            />
          </div>

          {/* Info */}
          <div>
            <span className="text-sm text-dxn-gold font-semibold uppercase tracking-widest">{product.category}</span>
            <h1 className="text-3xl font-bold text-dxn-darkgreen mt-2 mb-3">{product.name}</h1>

            <div className="flex items-center gap-2 mb-4">
              {[...Array(5)].map((_, i) => (
                <FiStar key={i} size={18} className={i < Math.round(product.rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'} />
              ))}
              <span className="text-gray-500 text-sm">({product.reviews?.length || 0} reviews)</span>
            </div>

            <p className="text-3xl font-bold text-dxn-green mb-4">${product.price?.toFixed(2)}</p>
            <p className="text-gray-600 mb-6">{product.description}</p>

            {product.benefits?.length > 0 && (
              <div className="mb-6">
                <h3 className="font-semibold text-gray-800 mb-3">Key Benefits</h3>
                <ul className="space-y-2">
                  {product.benefits.map((b) => (
                    <li key={b} className="flex items-center gap-2 text-gray-600">
                      <FiCheck className="text-dxn-green shrink-0" /> {b}
                    </li>
                  ))}
                </ul>
              </div>
            )}

            {product.usage && (
              <div className="mb-6 p-4 bg-green-50 rounded-lg">
                <h3 className="font-semibold text-gray-800 mb-1">How to Use</h3>
                <p className="text-gray-600 text-sm">{product.usage}</p>
              </div>
            )}

            {/* Quantity & Add to Cart */}
            <div className="flex items-center gap-4">
              <div className="flex items-center border rounded-lg overflow-hidden">
                <button onClick={() => setQty(Math.max(1, qty - 1))} className="px-3 py-2 hover:bg-gray-100 font-bold text-lg">-</button>
                <span className="px-4 py-2 font-semibold">{qty}</span>
                <button onClick={() => setQty(qty + 1)} className="px-3 py-2 hover:bg-gray-100 font-bold text-lg">+</button>
              </div>
              <button
                onClick={() => { addToCart(product, qty); toast.success('Added to cart!'); }}
                disabled={!product.inStock}
                className="btn-primary flex items-center gap-2 flex-1 justify-center disabled:opacity-50"
              >
                <FiShoppingCart /> {product.inStock ? 'Add to Cart' : 'Out of Stock'}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
