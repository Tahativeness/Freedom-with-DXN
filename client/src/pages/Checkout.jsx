import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { useCart } from '../context/CartContext';
import toast from 'react-hot-toast';

export default function Checkout() {
  const { cart, cartTotal, clearCart } = useCart();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [form, setForm] = useState({
    fullName: '', address: '', city: '', state: '', country: '', zipCode: '', phone: '',
  });
  const [paymentMethod, setPaymentMethod] = useState('bank_transfer');
  const [notes, setNotes] = useState('');

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (cart.length === 0) return toast.error('Cart is empty');
    setLoading(true);
    try {
      await axios.post('/api/orders', {
        items: cart.map((i) => ({ product: i._id, name: i.name, price: i.price, quantity: i.quantity, image: i.image })),
        shippingAddress: form,
        paymentMethod,
        notes,
      });
      clearCart();
      toast.success('Order placed! We will contact you with payment details.');
      navigate('/dashboard');
    } catch {
      toast.error('Failed to place order. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-5xl mx-auto px-4 py-10">
        <h1 className="text-2xl font-bold text-dxn-darkgreen mb-8">Checkout</h1>
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <form onSubmit={handleSubmit} className="lg:col-span-2 space-y-6">
            {/* Shipping */}
            <div className="bg-white rounded-xl shadow p-6">
              <h2 className="font-bold text-dxn-darkgreen mb-4">Shipping Address</h2>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {[
                  ['fullName', 'Full Name', 'text', true],
                  ['phone', 'Phone', 'tel', true],
                  ['address', 'Address', 'text', true],
                  ['city', 'City', 'text', true],
                  ['state', 'State / Province', 'text', false],
                  ['zipCode', 'ZIP / Postal Code', 'text', false],
                  ['country', 'Country', 'text', true],
                ].map(([name, label, type, req]) => (
                  <div key={name} className={name === 'address' ? 'sm:col-span-2' : ''}>
                    <label className="block text-sm font-medium text-gray-700 mb-1">{label}{req ? ' *' : ''}</label>
                    <input type={type} name={name} required={req} value={form[name]} onChange={handleChange} className="input-field" />
                  </div>
                ))}
              </div>
            </div>

            {/* Payment */}
            <div className="bg-white rounded-xl shadow p-6">
              <h2 className="font-bold text-dxn-darkgreen mb-4">Payment Method</h2>
              <div className="space-y-3">
                {[['bank_transfer', 'Bank Transfer', 'We will send you bank details after order confirmation.'],
                  ['cash', 'Cash on Delivery / Pickup', 'Pay when you receive your order.'],
                  ['online', 'Online Payment', 'We will send you a payment link via email/WhatsApp.'],
                ].map(([val, label, desc]) => (
                  <label key={val} className={`flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition-colors ${paymentMethod === val ? 'border-dxn-green bg-green-50' : 'border-gray-200'}`}>
                    <input type="radio" name="payment" value={val} checked={paymentMethod === val} onChange={() => setPaymentMethod(val)} className="mt-1" />
                    <div>
                      <p className="font-medium text-gray-800">{label}</p>
                      <p className="text-sm text-gray-500">{desc}</p>
                    </div>
                  </label>
                ))}
              </div>
            </div>

            {/* Notes */}
            <div className="bg-white rounded-xl shadow p-6">
              <h2 className="font-bold text-dxn-darkgreen mb-4">Order Notes (optional)</h2>
              <textarea
                value={notes}
                onChange={(e) => setNotes(e.target.value)}
                className="input-field"
                rows={3}
                placeholder="Any special instructions..."
              />
            </div>

            <button type="submit" disabled={loading} className="btn-primary w-full justify-center flex items-center gap-2 disabled:opacity-70 py-4 text-lg">
              {loading ? <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin" /> : null}
              {loading ? 'Placing Order...' : 'Place Order'}
            </button>
          </form>

          {/* Order Summary */}
          <div className="card p-6 h-fit">
            <h2 className="font-bold text-dxn-darkgreen mb-4">Order Summary</h2>
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
          </div>
        </div>
      </div>
    </div>
  );
}
