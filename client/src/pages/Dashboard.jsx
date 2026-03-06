import { useState, useEffect } from 'react';
import axios from 'axios';
import { useAuth } from '../context/AuthContext';
import { Link } from 'react-router-dom';
import { FiUsers, FiShoppingBag, FiLink, FiCopy, FiUser, FiTrendingUp } from 'react-icons/fi';
import toast from 'react-hot-toast';

export default function Dashboard() {
  const { user } = useAuth();
  const [data, setData] = useState(null);
  const [downlines, setDownlines] = useState([]);
  const [loading, setLoading] = useState(true);
  const [activeTab, setActiveTab] = useState('overview');

  useEffect(() => {
    Promise.all([
      axios.get('/api/distributors/dashboard'),
      axios.get('/api/distributors/downlines'),
    ]).then(([dashRes, downRes]) => {
      setData(dashRes.data);
      setDownlines(downRes.data);
    }).catch(() => {}).finally(() => setLoading(false));
  }, []);

  const referralLink = `${window.location.origin}/register?ref=${user?.referralCode}`;

  const copyReferralLink = () => {
    navigator.clipboard.writeText(referralLink);
    toast.success('Referral link copied!');
  };

  if (loading) return (
    <div className="flex justify-center items-center min-h-screen">
      <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
    </div>
  );

  const stats = [
    { label: 'Total Downlines', value: data?.user?.totalDownlines || downlines.length || 0, icon: FiUsers, color: 'bg-blue-50 text-blue-600' },
    { label: 'Total Orders', value: data?.totalOrders || 0, icon: FiShoppingBag, color: 'bg-green-50 text-green-600' },
    { label: 'Total Sales ($)', value: `$${(data?.user?.totalSales || 0).toFixed(2)}`, icon: FiTrendingUp, color: 'bg-yellow-50 text-yellow-600' },
    { label: 'My Rank', value: user?.role || 'Member', icon: FiUser, color: 'bg-purple-50 text-purple-600' },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-dxn-darkgreen py-8 px-4">
        <div className="max-w-7xl mx-auto flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold text-white">Welcome, {user?.name}!</h1>
            <p className="text-gray-300 text-sm mt-1">Your DXN Dashboard</p>
          </div>
          <Link to="/products" className="btn-gold text-sm">Shop Products</Link>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Stats */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
          {stats.map(({ label, value, icon: Icon, color }) => (
            <div key={label} className="card p-5">
              <div className={`w-10 h-10 rounded-lg flex items-center justify-center mb-3 ${color}`}>
                <Icon size={20} />
              </div>
              <div className="text-2xl font-bold text-dxn-darkgreen">{value}</div>
              <div className="text-sm text-gray-500 mt-1">{label}</div>
            </div>
          ))}
        </div>

        {/* Referral Link */}
        <div className="card p-6 mb-8 border-2 border-dxn-gold/30 bg-yellow-50">
          <div className="flex items-start gap-3 mb-3">
            <FiLink className="text-dxn-gold mt-1" size={20} />
            <div>
              <h3 className="font-bold text-dxn-darkgreen">Your Referral Link</h3>
              <p className="text-sm text-gray-500">Share this link to recruit new distributors to your team</p>
            </div>
          </div>
          <div className="flex gap-2">
            <input
              readOnly
              value={referralLink}
              className="input-field text-sm bg-white flex-1"
            />
            <button onClick={copyReferralLink} className="btn-primary flex items-center gap-2 text-sm whitespace-nowrap">
              <FiCopy size={14} /> Copy
            </button>
          </div>
          <p className="text-xs text-gray-400 mt-2">Referral Code: <strong className="text-dxn-green">{user?.referralCode}</strong></p>
        </div>

        {/* Tabs */}
        <div className="flex gap-2 mb-6">
          {['overview', 'downlines', 'orders'].map((tab) => (
            <button
              key={tab}
              onClick={() => setActiveTab(tab)}
              className={`px-4 py-2 rounded-lg text-sm font-medium capitalize transition-colors ${activeTab === tab ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'}`}
            >
              {tab}
            </button>
          ))}
        </div>

        {/* Tab Content */}
        {activeTab === 'overview' && (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="card p-6">
              <h3 className="font-bold text-dxn-darkgreen mb-4">Profile Info</h3>
              <div className="space-y-3 text-sm">
                {[['Name', user?.name], ['Email', user?.email], ['Role', user?.role], ['Phone', user?.phone || 'Not set'], ['Country', user?.country || 'Not set'], ['DXN Member ID', user?.dxnMemberId || 'Not set']].map(([k, v]) => (
                  <div key={k} className="flex justify-between py-2 border-b last:border-0">
                    <span className="text-gray-500">{k}</span>
                    <span className="font-medium text-gray-800">{v}</span>
                  </div>
                ))}
              </div>
            </div>
            <div className="card p-6">
              <h3 className="font-bold text-dxn-darkgreen mb-4">Recent Orders</h3>
              {data?.recentOrders?.length > 0 ? (
                <div className="space-y-3">
                  {data.recentOrders.map((order) => (
                    <div key={order._id} className="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                      <div>
                        <p className="font-medium">#{order._id.slice(-6).toUpperCase()}</p>
                        <p className="text-gray-400 text-xs">{new Date(order.createdAt).toLocaleDateString()}</p>
                      </div>
                      <div className="text-right">
                        <p className="font-bold text-dxn-green">${order.totalAmount?.toFixed(2)}</p>
                        <span className={`text-xs px-2 py-0.5 rounded-full ${order.status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                          {order.status}
                        </span>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <div className="text-center py-8 text-gray-400">
                  <FiShoppingBag size={32} className="mx-auto mb-2 opacity-50" />
                  <p>No orders yet</p>
                  <Link to="/products" className="text-dxn-green text-sm hover:underline">Browse products</Link>
                </div>
              )}
            </div>
          </div>
        )}

        {activeTab === 'downlines' && (
          <div className="card p-6">
            <h3 className="font-bold text-dxn-darkgreen mb-4">My Downlines ({downlines.length})</h3>
            {downlines.length > 0 ? (
              <div className="overflow-x-auto">
                <table className="w-full text-sm">
                  <thead>
                    <tr className="border-b text-left text-gray-500">
                      <th className="pb-3 pr-4">Name</th>
                      <th className="pb-3 pr-4">Email</th>
                      <th className="pb-3 pr-4">Country</th>
                      <th className="pb-3 pr-4">Their Downlines</th>
                      <th className="pb-3">Joined</th>
                    </tr>
                  </thead>
                  <tbody>
                    {downlines.map((d) => (
                      <tr key={d._id} className="border-b last:border-0">
                        <td className="py-3 pr-4 font-medium">{d.name}</td>
                        <td className="py-3 pr-4 text-gray-500">{d.email}</td>
                        <td className="py-3 pr-4 text-gray-500">{d.country || '-'}</td>
                        <td className="py-3 pr-4">{d.totalDownlines}</td>
                        <td className="py-3 text-gray-400">{new Date(d.createdAt).toLocaleDateString()}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            ) : (
              <div className="text-center py-12 text-gray-400">
                <FiUsers size={40} className="mx-auto mb-3 opacity-50" />
                <p className="font-medium mb-1">No downlines yet</p>
                <p className="text-sm">Share your referral link above to start building your team!</p>
              </div>
            )}
          </div>
        )}

        {activeTab === 'orders' && (
          <div className="card p-6">
            <h3 className="font-bold text-dxn-darkgreen mb-4">My Orders</h3>
            <div className="text-center py-12 text-gray-400">
              <FiShoppingBag size={40} className="mx-auto mb-3 opacity-50" />
              <p>Your order history will appear here</p>
              <Link to="/products" className="btn-primary inline-block mt-4 text-sm">Shop Now</Link>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
