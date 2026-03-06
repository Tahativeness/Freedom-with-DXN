import { useState, useEffect } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { FiUsers, FiShoppingBag, FiPackage, FiPlus, FiEdit, FiTrash2 } from 'react-icons/fi';

export default function AdminPanel() {
  const [activeTab, setActiveTab] = useState('products');
  const [products, setProducts] = useState([]);
  const [orders, setOrders] = useState([]);
  const [users, setUsers] = useState([]);
  const [messages, setMessages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [showProductForm, setShowProductForm] = useState(false);
  const [productForm, setProductForm] = useState({ name: '', description: '', price: '', category: 'coffee', inStock: true, featured: false, image: '' });

  useEffect(() => {
    loadData();
  }, [activeTab]);

  const loadData = async () => {
    setLoading(true);
    try {
      if (activeTab === 'products') {
        const { data } = await axios.get('/api/products?limit=50');
        setProducts(data.products);
      } else if (activeTab === 'orders') {
        const { data } = await axios.get('/api/orders');
        setOrders(data);
      } else if (activeTab === 'users') {
        const { data } = await axios.get('/api/distributors/all');
        setUsers(data);
      }
    } catch {}
    setLoading(false);
  };

  const handleCreateProduct = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/api/products', { ...productForm, price: Number(productForm.price) });
      toast.success('Product created!');
      setShowProductForm(false);
      setProductForm({ name: '', description: '', price: '', category: 'coffee', inStock: true, featured: false, image: '' });
      loadData();
    } catch {
      toast.error('Failed to create product');
    }
  };

  const handleDeleteProduct = async (id) => {
    if (!window.confirm('Delete this product?')) return;
    try {
      await axios.delete(`/api/products/${id}`);
      toast.success('Product deleted');
      loadData();
    } catch { toast.error('Failed'); }
  };

  const handleUpdateOrderStatus = async (id, status) => {
    try {
      await axios.put(`/api/orders/${id}/status`, { status });
      toast.success('Status updated');
      loadData();
    } catch { toast.error('Failed'); }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="bg-dxn-darkgreen py-8 px-4">
        <div className="max-w-7xl mx-auto">
          <h1 className="text-2xl font-bold text-white">Admin Panel</h1>
          <p className="text-gray-300 text-sm">Manage your Grow with DXN website</p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Tabs */}
        <div className="flex gap-2 mb-6 flex-wrap">
          {[['products', FiPackage, 'Products'], ['orders', FiShoppingBag, 'Orders'], ['users', FiUsers, 'Users']].map(([tab, Icon, label]) => (
            <button
              key={tab}
              onClick={() => setActiveTab(tab)}
              className={`flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors ${activeTab === tab ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'}`}
            >
              <Icon size={16} /> {label}
            </button>
          ))}
        </div>

        {loading ? (
          <div className="flex justify-center py-20">
            <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
          </div>
        ) : (
          <>
            {/* Products Tab */}
            {activeTab === 'products' && (
              <div>
                <div className="flex justify-between items-center mb-4">
                  <h2 className="font-bold text-dxn-darkgreen text-lg">Products ({products.length})</h2>
                  <button onClick={() => setShowProductForm(!showProductForm)} className="btn-primary flex items-center gap-2 text-sm">
                    <FiPlus /> Add Product
                  </button>
                </div>

                {showProductForm && (
                  <form onSubmit={handleCreateProduct} className="card p-6 mb-6 border-2 border-dxn-green/30">
                    <h3 className="font-bold mb-4 text-dxn-darkgreen">New Product</h3>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                        <label className="block text-sm font-medium mb-1">Name *</label>
                        <input required value={productForm.name} onChange={(e) => setProductForm({...productForm, name: e.target.value})} className="input-field" />
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Price *</label>
                        <input type="number" step="0.01" required value={productForm.price} onChange={(e) => setProductForm({...productForm, price: e.target.value})} className="input-field" />
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Category *</label>
                        <select value={productForm.category} onChange={(e) => setProductForm({...productForm, category: e.target.value})} className="input-field">
                          {['coffee', 'ganoderma', 'supplements', 'skincare', 'beverages', 'other'].map((c) => <option key={c}>{c}</option>)}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Image URL</label>
                        <input value={productForm.image} onChange={(e) => setProductForm({...productForm, image: e.target.value})} className="input-field" placeholder="https://..." />
                      </div>
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-1">Description *</label>
                        <textarea required rows={3} value={productForm.description} onChange={(e) => setProductForm({...productForm, description: e.target.value})} className="input-field resize-none" />
                      </div>
                      <div className="flex gap-4">
                        <label className="flex items-center gap-2 text-sm">
                          <input type="checkbox" checked={productForm.inStock} onChange={(e) => setProductForm({...productForm, inStock: e.target.checked})} />
                          In Stock
                        </label>
                        <label className="flex items-center gap-2 text-sm">
                          <input type="checkbox" checked={productForm.featured} onChange={(e) => setProductForm({...productForm, featured: e.target.checked})} />
                          Featured
                        </label>
                      </div>
                    </div>
                    <div className="flex gap-2 mt-4">
                      <button type="submit" className="btn-primary text-sm">Save Product</button>
                      <button type="button" onClick={() => setShowProductForm(false)} className="btn-outline text-sm">Cancel</button>
                    </div>
                  </form>
                )}

                <div className="card overflow-hidden">
                  <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                      <thead className="bg-gray-50">
                        <tr className="border-b text-left text-gray-500">
                          <th className="px-4 py-3">Product</th>
                          <th className="px-4 py-3">Category</th>
                          <th className="px-4 py-3">Price</th>
                          <th className="px-4 py-3">Stock</th>
                          <th className="px-4 py-3">Featured</th>
                          <th className="px-4 py-3">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        {products.map((p) => (
                          <tr key={p._id} className="border-b hover:bg-gray-50">
                            <td className="px-4 py-3 font-medium">{p.name}</td>
                            <td className="px-4 py-3 text-gray-500 capitalize">{p.category}</td>
                            <td className="px-4 py-3 font-semibold text-dxn-green">${p.price?.toFixed(2)}</td>
                            <td className="px-4 py-3"><span className={`badge ${p.inStock ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>{p.inStock ? 'In Stock' : 'Out'}</span></td>
                            <td className="px-4 py-3"><span className={`badge ${p.featured ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500'}`}>{p.featured ? 'Yes' : 'No'}</span></td>
                            <td className="px-4 py-3">
                              <button onClick={() => handleDeleteProduct(p._id)} className="text-red-400 hover:text-red-600"><FiTrash2 /></button>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            )}

            {/* Orders Tab */}
            {activeTab === 'orders' && (
              <div className="card overflow-hidden">
                <div className="p-4 border-b"><h2 className="font-bold text-dxn-darkgreen">All Orders ({orders.length})</h2></div>
                <div className="overflow-x-auto">
                  <table className="w-full text-sm">
                    <thead className="bg-gray-50">
                      <tr className="border-b text-left text-gray-500">
                        <th className="px-4 py-3">Order ID</th>
                        <th className="px-4 py-3">Customer</th>
                        <th className="px-4 py-3">Amount</th>
                        <th className="px-4 py-3">Status</th>
                        <th className="px-4 py-3">Date</th>
                        <th className="px-4 py-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      {orders.map((o) => (
                        <tr key={o._id} className="border-b hover:bg-gray-50">
                          <td className="px-4 py-3 font-mono text-xs">#{o._id.slice(-6).toUpperCase()}</td>
                          <td className="px-4 py-3">{o.user?.name || 'N/A'}</td>
                          <td className="px-4 py-3 font-semibold text-dxn-green">${o.totalAmount?.toFixed(2)}</td>
                          <td className="px-4 py-3">
                            <select value={o.status} onChange={(e) => handleUpdateOrderStatus(o._id, e.target.value)} className="text-xs border rounded px-2 py-1">
                              {['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'].map((s) => <option key={s}>{s}</option>)}
                            </select>
                          </td>
                          <td className="px-4 py-3 text-gray-400">{new Date(o.createdAt).toLocaleDateString()}</td>
                          <td className="px-4 py-3 text-gray-400 text-xs">{o.paymentMethod}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            )}

            {/* Users Tab */}
            {activeTab === 'users' && (
              <div className="card overflow-hidden">
                <div className="p-4 border-b"><h2 className="font-bold text-dxn-darkgreen">All Members ({users.length})</h2></div>
                <div className="overflow-x-auto">
                  <table className="w-full text-sm">
                    <thead className="bg-gray-50">
                      <tr className="border-b text-left text-gray-500">
                        <th className="px-4 py-3">Name</th>
                        <th className="px-4 py-3">Email</th>
                        <th className="px-4 py-3">Role</th>
                        <th className="px-4 py-3">Downlines</th>
                        <th className="px-4 py-3">Referred By</th>
                        <th className="px-4 py-3">Joined</th>
                      </tr>
                    </thead>
                    <tbody>
                      {users.map((u) => (
                        <tr key={u._id} className="border-b hover:bg-gray-50">
                          <td className="px-4 py-3 font-medium">{u.name}</td>
                          <td className="px-4 py-3 text-gray-500">{u.email}</td>
                          <td className="px-4 py-3"><span className="badge bg-blue-100 text-blue-700 capitalize">{u.role}</span></td>
                          <td className="px-4 py-3">{u.totalDownlines}</td>
                          <td className="px-4 py-3 text-gray-500">{u.referredBy?.name || '-'}</td>
                          <td className="px-4 py-3 text-gray-400">{new Date(u.createdAt).toLocaleDateString()}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
}
