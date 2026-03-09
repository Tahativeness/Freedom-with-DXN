import { useState, useEffect } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { useRef } from 'react';
import { FiUsers, FiShoppingBag, FiPackage, FiPlus, FiEdit, FiTrash2, FiX, FiFileText, FiBold, FiItalic, FiList, FiLink, FiImage, FiMinus } from 'react-icons/fi';

const EMPTY_FORM = { name: '', description: '', price: '', category: 'coffee', inStock: true, featured: false, image: '', images: ['', '', '', '', ''] };
const EMPTY_BLOG_FORM = { title: '', excerpt: '', content: '', category: 'health', tags: '', image: '', published: true };
const BLOG_CATEGORIES = ['health', 'business', 'products', 'success-stories', 'tips'];

export default function AdminPanel() {
  const [activeTab, setActiveTab] = useState('products');
  const [products, setProducts] = useState([]);
  const [orders, setOrders] = useState([]);
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [showProductForm, setShowProductForm] = useState(false);
  const [editingProduct, setEditingProduct] = useState(null);
  const [productForm, setProductForm] = useState({ ...EMPTY_FORM });
  const [blogs, setBlogs] = useState([]);
  const [showBlogForm, setShowBlogForm] = useState(false);
  const [editingBlog, setEditingBlog] = useState(null);
  const [blogForm, setBlogForm] = useState({ ...EMPTY_BLOG_FORM });

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
      } else if (activeTab === 'blogs') {
        const { data } = await axios.get('/api/blog?limit=50');
        setBlogs(data.posts || []);
      }
    } catch {}
    setLoading(false);
  };

  const resetForm = () => {
    setProductForm({ ...EMPTY_FORM });
    setEditingProduct(null);
    setShowProductForm(false);
  };

  const handleEditProduct = (product) => {
    const existingImages = product.images || [];
    const paddedImages = [...existingImages, '', '', '', '', ''].slice(0, 5);
    setProductForm({
      name: product.name || '',
      description: product.description || '',
      price: product.price?.toString() || '',
      category: product.category || 'coffee',
      inStock: product.inStock ?? true,
      featured: product.featured ?? false,
      image: product.image || '',
      images: paddedImages,
    });
    setEditingProduct(product._id);
    setShowProductForm(true);
  };

  const handleSubmitProduct = async (e) => {
    e.preventDefault();
    try {
      const data = {
        ...productForm,
        price: Number(productForm.price),
        images: productForm.images.filter((url) => url.trim() !== ''),
      };

      if (editingProduct) {
        await axios.put(`/api/products/${editingProduct}`, data);
        toast.success('Product updated!');
      } else {
        await axios.post('/api/products', data);
        toast.success('Product created!');
      }
      resetForm();
      loadData();
    } catch {
      toast.error(editingProduct ? 'Failed to update product' : 'Failed to create product');
    }
  };

  const handleDeleteProduct = async (id) => {
    if (!window.confirm('Delete this product?')) return;
    try {
      await axios.delete(`/api/products/${id}`);
      toast.success('Product deleted');
      if (editingProduct === id) resetForm();
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

  const resetBlogForm = () => {
    setBlogForm({ ...EMPTY_BLOG_FORM });
    setEditingBlog(null);
    setShowBlogForm(false);
  };

  const handleEditBlog = (blog) => {
    setBlogForm({
      title: blog.title || '',
      excerpt: blog.excerpt || '',
      content: blog.content || '',
      category: blog.category || 'health',
      tags: (blog.tags || []).join(', '),
      image: blog.image || '',
      published: blog.published ?? true,
    });
    setEditingBlog(blog._id);
    setShowBlogForm(true);
  };

  const handleSubmitBlog = async (e) => {
    e.preventDefault();
    try {
      const data = {
        ...blogForm,
        tags: blogForm.tags.split(',').map((t) => t.trim()).filter(Boolean),
      };
      if (editingBlog) {
        await axios.put(`/api/blog/${editingBlog}`, data);
        toast.success('Blog post updated!');
      } else {
        await axios.post('/api/blog', data);
        toast.success('Blog post created!');
      }
      resetBlogForm();
      loadData();
    } catch {
      toast.error(editingBlog ? 'Failed to update post' : 'Failed to create post');
    }
  };

  const handleDeleteBlog = async (id) => {
    if (!window.confirm('Delete this blog post?')) return;
    try {
      await axios.delete(`/api/blog/${id}`);
      toast.success('Blog post deleted');
      if (editingBlog === id) resetBlogForm();
      loadData();
    } catch { toast.error('Failed'); }
  };

  const contentRef = useRef(null);
  const excerptRef = useRef(null);

  const insertFormat = (ref, before, after = '', placeholder = '') => {
    const el = ref.current;
    if (!el) return;
    const start = el.selectionStart;
    const end = el.selectionEnd;
    const text = el.value;
    const selected = text.substring(start, end) || placeholder;
    const newText = text.substring(0, start) + before + selected + after + text.substring(end);
    const field = ref === contentRef ? 'content' : 'excerpt';
    setBlogForm((prev) => ({ ...prev, [field]: newText }));
    setTimeout(() => {
      el.focus();
      const cursorPos = start + before.length + selected.length + after.length;
      el.setSelectionRange(cursorPos, cursorPos);
    }, 0);
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
          {[['products', FiPackage, 'Products'], ['blogs', FiFileText, 'Blog Posts'], ['orders', FiShoppingBag, 'Orders'], ['users', FiUsers, 'Users']].map(([tab, Icon, label]) => (
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
                  <button
                    onClick={() => {
                      if (showProductForm && !editingProduct) {
                        resetForm();
                      } else {
                        resetForm();
                        setShowProductForm(true);
                      }
                    }}
                    className="btn-primary flex items-center gap-2 text-sm"
                  >
                    <FiPlus /> Add Product
                  </button>
                </div>

                {showProductForm && (
                  <form onSubmit={handleSubmitProduct} className="card p-6 mb-6 border-2 border-dxn-green/30">
                    <div className="flex justify-between items-center mb-4">
                      <h3 className="font-bold text-dxn-darkgreen">
                        {editingProduct ? 'Edit Product' : 'New Product'}
                      </h3>
                      <button type="button" onClick={resetForm} className="text-gray-400 hover:text-gray-600">
                        <FiX size={20} />
                      </button>
                    </div>
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
                        <label className="block text-sm font-medium mb-1">Main Image URL</label>
                        <input value={productForm.image} onChange={(e) => setProductForm({...productForm, image: e.target.value})} className="input-field" placeholder="https://..." />
                      </div>
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-1">Description *</label>
                        <textarea required rows={3} value={productForm.description} onChange={(e) => setProductForm({...productForm, description: e.target.value})} className="input-field resize-none" />
                      </div>
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-2">Additional Images (up to 5)</label>
                        <div className="grid grid-cols-1 sm:grid-cols-5 gap-3">
                          {productForm.images.map((url, idx) => (
                            <input
                              key={idx}
                              value={url}
                              onChange={(e) => {
                                const newImages = [...productForm.images];
                                newImages[idx] = e.target.value;
                                setProductForm({...productForm, images: newImages});
                              }}
                              className="input-field text-sm"
                              placeholder={`Image ${idx + 1} URL`}
                            />
                          ))}
                        </div>
                        <p className="text-xs text-gray-400 mt-1">Paste direct image URLs (e.g. https://i.imgur.com/example.jpg)</p>
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
                      <button type="submit" className="btn-primary text-sm">
                        {editingProduct ? 'Update Product' : 'Save Product'}
                      </button>
                      <button type="button" onClick={resetForm} className="btn-outline text-sm">Cancel</button>
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
                          <tr key={p._id} className={`border-b hover:bg-gray-50 ${editingProduct === p._id ? 'bg-green-50' : ''}`}>
                            <td className="px-4 py-3">
                              <div className="flex items-center gap-3">
                                <img
                                  src={p.image || `https://placehold.co/40x40/1a5c2e/white?text=${encodeURIComponent(p.name?.charAt(0))}`}
                                  alt={p.name}
                                  className="w-10 h-10 rounded-lg object-cover bg-gray-100"
                                />
                                <span className="font-medium">{p.name}</span>
                              </div>
                            </td>
                            <td className="px-4 py-3 text-gray-500 capitalize">{p.category}</td>
                            <td className="px-4 py-3 font-semibold text-dxn-green">${p.price?.toFixed(2)}</td>
                            <td className="px-4 py-3"><span className={`badge ${p.inStock ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>{p.inStock ? 'In Stock' : 'Out'}</span></td>
                            <td className="px-4 py-3"><span className={`badge ${p.featured ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500'}`}>{p.featured ? 'Yes' : 'No'}</span></td>
                            <td className="px-4 py-3">
                              <div className="flex items-center gap-2">
                                <button onClick={() => handleEditProduct(p)} className="text-blue-500 hover:text-blue-700" title="Edit">
                                  <FiEdit size={16} />
                                </button>
                                <button onClick={() => handleDeleteProduct(p._id)} className="text-red-400 hover:text-red-600" title="Delete">
                                  <FiTrash2 size={16} />
                                </button>
                              </div>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            )}

            {/* Blogs Tab */}
            {activeTab === 'blogs' && (
              <div>
                <div className="flex justify-between items-center mb-4">
                  <h2 className="font-bold text-dxn-darkgreen text-lg">Blog Posts ({blogs.length})</h2>
                  <button
                    onClick={() => {
                      if (showBlogForm && !editingBlog) { resetBlogForm(); } else { resetBlogForm(); setShowBlogForm(true); }
                    }}
                    className="btn-primary flex items-center gap-2 text-sm"
                  >
                    <FiPlus /> New Post
                  </button>
                </div>

                {showBlogForm && (
                  <form onSubmit={handleSubmitBlog} className="card p-6 mb-6 border-2 border-dxn-green/30">
                    <div className="flex justify-between items-center mb-4">
                      <h3 className="font-bold text-dxn-darkgreen">
                        {editingBlog ? 'Edit Blog Post' : 'New Blog Post'}
                      </h3>
                      <button type="button" onClick={resetBlogForm} className="text-gray-400 hover:text-gray-600">
                        <FiX size={20} />
                      </button>
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-1">Title *</label>
                        <input required value={blogForm.title} onChange={(e) => setBlogForm({...blogForm, title: e.target.value})} className="input-field" placeholder="Blog post title" />
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Category *</label>
                        <select value={blogForm.category} onChange={(e) => setBlogForm({...blogForm, category: e.target.value})} className="input-field">
                          {BLOG_CATEGORIES.map((c) => <option key={c} value={c}>{c.replace('-', ' ')}</option>)}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Cover Image URL</label>
                        <input value={blogForm.image} onChange={(e) => setBlogForm({...blogForm, image: e.target.value})} className="input-field" placeholder="https://..." />
                      </div>
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-1">Excerpt / Summary *</label>
                        <div className="flex gap-1 mb-1 flex-wrap">
                          <button type="button" onClick={() => insertFormat(excerptRef, '**', '**', 'bold text')} className="toolbar-btn" title="Bold"><FiBold size={14} /></button>
                          <button type="button" onClick={() => insertFormat(excerptRef, '*', '*', 'italic text')} className="toolbar-btn" title="Italic"><FiItalic size={14} /></button>
                        </div>
                        <textarea ref={excerptRef} required rows={2} value={blogForm.excerpt} onChange={(e) => setBlogForm({...blogForm, excerpt: e.target.value})} className="input-field resize-none" placeholder="Brief summary shown on blog listing..." />
                      </div>
                      <div className="sm:col-span-2">
                        <label className="block text-sm font-medium mb-1">Content *</label>
                        <div className="flex gap-1 mb-1 flex-wrap bg-gray-50 p-2 rounded-lg border">
                          <button type="button" onClick={() => insertFormat(contentRef, '**', '**', 'bold text')} className="toolbar-btn" title="Bold"><FiBold size={14} /></button>
                          <button type="button" onClick={() => insertFormat(contentRef, '*', '*', 'italic text')} className="toolbar-btn" title="Italic"><FiItalic size={14} /></button>
                          <span className="w-px bg-gray-300 mx-1" />
                          <button type="button" onClick={() => insertFormat(contentRef, '\n**', '**\n', 'Heading')} className="toolbar-btn text-xs font-bold" title="Heading">H</button>
                          <button type="button" onClick={() => insertFormat(contentRef, '\n## ', '\n', 'Subheading')} className="toolbar-btn text-xs font-bold" title="Subheading">H2</button>
                          <span className="w-px bg-gray-300 mx-1" />
                          <button type="button" onClick={() => insertFormat(contentRef, '\n- ', '\n', 'list item')} className="toolbar-btn" title="Bullet List"><FiList size={14} /></button>
                          <button type="button" onClick={() => insertFormat(contentRef, '\n1. ', '\n', 'list item')} className="toolbar-btn text-xs font-bold" title="Numbered List">1.</button>
                          <span className="w-px bg-gray-300 mx-1" />
                          <button type="button" onClick={() => insertFormat(contentRef, '[', '](https://)', 'link text')} className="toolbar-btn" title="Insert Link"><FiLink size={14} /></button>
                          <button type="button" onClick={() => insertFormat(contentRef, '![', '](https://image-url)', 'alt text')} className="toolbar-btn" title="Insert Image"><FiImage size={14} /></button>
                          <span className="w-px bg-gray-300 mx-1" />
                          <button type="button" onClick={() => insertFormat(contentRef, '\n> ', '\n', 'quote text')} className="toolbar-btn text-lg leading-none" title="Blockquote">"</button>
                          <button type="button" onClick={() => insertFormat(contentRef, '\n---\n', '', '')} className="toolbar-btn" title="Horizontal Rule"><FiMinus size={14} /></button>
                        </div>
                        <textarea ref={contentRef} required rows={12} value={blogForm.content} onChange={(e) => setBlogForm({...blogForm, content: e.target.value})} className="input-field resize-y font-mono text-sm" placeholder="Write your blog post content here...&#10;&#10;Use the toolbar above to format text." />
                        <p className="text-xs text-gray-400 mt-1">Tip: Select text then click a toolbar button to wrap it with formatting.</p>
                      </div>
                      <div>
                        <label className="block text-sm font-medium mb-1">Tags (comma separated)</label>
                        <input value={blogForm.tags} onChange={(e) => setBlogForm({...blogForm, tags: e.target.value})} className="input-field" placeholder="health, ganoderma, tips" />
                      </div>
                      <div className="flex items-center">
                        <label className="flex items-center gap-2 text-sm">
                          <input type="checkbox" checked={blogForm.published} onChange={(e) => setBlogForm({...blogForm, published: e.target.checked})} />
                          Published
                        </label>
                      </div>
                    </div>
                    <div className="flex gap-2 mt-4">
                      <button type="submit" className="btn-primary text-sm">
                        {editingBlog ? 'Update Post' : 'Publish Post'}
                      </button>
                      <button type="button" onClick={resetBlogForm} className="btn-outline text-sm">Cancel</button>
                    </div>
                  </form>
                )}

                <div className="card overflow-hidden">
                  <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                      <thead className="bg-gray-50">
                        <tr className="border-b text-left text-gray-500">
                          <th className="px-4 py-3">Title</th>
                          <th className="px-4 py-3">Category</th>
                          <th className="px-4 py-3">Views</th>
                          <th className="px-4 py-3">Status</th>
                          <th className="px-4 py-3">Date</th>
                          <th className="px-4 py-3">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        {blogs.map((b) => (
                          <tr key={b._id} className={`border-b hover:bg-gray-50 ${editingBlog === b._id ? 'bg-green-50' : ''}`}>
                            <td className="px-4 py-3">
                              <span className="font-medium line-clamp-1">{b.title}</span>
                              <span className="text-xs text-gray-400 block">/blog/{b.slug}</span>
                            </td>
                            <td className="px-4 py-3 text-gray-500 capitalize">{b.category?.replace('-', ' ')}</td>
                            <td className="px-4 py-3 text-gray-500">{b.views || 0}</td>
                            <td className="px-4 py-3">
                              <span className={`badge ${b.published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                                {b.published ? 'Published' : 'Draft'}
                              </span>
                            </td>
                            <td className="px-4 py-3 text-gray-400">{new Date(b.createdAt).toLocaleDateString()}</td>
                            <td className="px-4 py-3">
                              <div className="flex items-center gap-2">
                                <button onClick={() => handleEditBlog(b)} className="text-blue-500 hover:text-blue-700" title="Edit">
                                  <FiEdit size={16} />
                                </button>
                                <button onClick={() => handleDeleteBlog(b._id)} className="text-red-400 hover:text-red-600" title="Delete">
                                  <FiTrash2 size={16} />
                                </button>
                              </div>
                            </td>
                          </tr>
                        ))}
                        {blogs.length === 0 && (
                          <tr><td colSpan={6} className="px-4 py-8 text-center text-gray-400">No blog posts yet. Click "New Post" to create one.</td></tr>
                        )}
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
                        <th className="px-4 py-3">Payment</th>
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
