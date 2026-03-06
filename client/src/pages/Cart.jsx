import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { FiTrash2, FiArrowLeft, FiShoppingBag } from 'react-icons/fi';

export default function Cart() {
  const { cart, removeFromCart, updateQuantity, cartTotal } = useCart();

  if (cart.length === 0) return (
    <div className="min-h-screen bg-gray-50 flex flex-col items-center justify-center gap-4">
      <FiShoppingBag size={60} className="text-gray-300" />
      <h2 className="text-xl font-semibold text-gray-500">Your cart is empty</h2>
      <Link to="/products" className="btn-primary">Browse Products</Link>
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-5xl mx-auto px-4 py-10">
        <Link to="/products" className="inline-flex items-center gap-2 text-dxn-green hover:text-dxn-darkgreen mb-6">
          <FiArrowLeft /> Continue Shopping
        </Link>
        <h1 className="text-2xl font-bold text-dxn-darkgreen mb-8">Shopping Cart ({cart.length} items)</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Items */}
          <div className="lg:col-span-2 space-y-4">
            {cart.map((item) => (
              <div key={item._id} className="card p-4 flex gap-4 items-center">
                <img
                  src={item.image || `https://placehold.co/80x80/1a5c2e/white?text=${encodeURIComponent(item.name?.charAt(0))}`}
                  alt={item.name}
                  className="w-20 h-20 object-cover rounded-lg bg-gray-100"
                />
                <div className="flex-1 min-w-0">
                  <h3 className="font-semibold text-gray-800 truncate">{item.name}</h3>
                  <p className="text-dxn-green font-bold">${item.price?.toFixed(2)}</p>
                </div>
                <div className="flex items-center gap-2">
                  <button onClick={() => updateQuantity(item._id, item.quantity - 1)} className="w-8 h-8 border rounded-lg hover:bg-gray-100 font-bold">-</button>
                  <span className="w-8 text-center font-semibold">{item.quantity}</span>
                  <button onClick={() => updateQuantity(item._id, item.quantity + 1)} className="w-8 h-8 border rounded-lg hover:bg-gray-100 font-bold">+</button>
                </div>
                <div className="text-right">
                  <p className="font-bold text-gray-800">${(item.price * item.quantity).toFixed(2)}</p>
                  <button onClick={() => removeFromCart(item._id)} className="text-red-400 hover:text-red-600 mt-1">
                    <FiTrash2 size={16} />
                  </button>
                </div>
              </div>
            ))}
          </div>

          {/* Summary */}
          <div className="card p-6 h-fit">
            <h2 className="font-bold text-dxn-darkgreen text-lg mb-4">Order Summary</h2>
            <div className="space-y-2 text-sm mb-4">
              {cart.map((item) => (
                <div key={item._id} className="flex justify-between text-gray-600">
                  <span className="truncate mr-2">{item.name} x{item.quantity}</span>
                  <span>${(item.price * item.quantity).toFixed(2)}</span>
                </div>
              ))}
            </div>
            <div className="border-t pt-4">
              <div className="flex justify-between font-bold text-lg text-dxn-darkgreen">
                <span>Total</span>
                <span>${cartTotal.toFixed(2)}</span>
              </div>
            </div>
            <Link to="/checkout" className="btn-primary w-full text-center mt-6 block">
              Proceed to Checkout
            </Link>
            <p className="text-xs text-gray-400 text-center mt-3">Secure checkout. Contact me for payment info.</p>
          </div>
        </div>
      </div>
    </div>
  );
}
