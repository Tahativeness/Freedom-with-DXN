import { useState } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { FiMail, FiPhone, FiMessageCircle, FiMapPin } from 'react-icons/fi';

export default function Contact() {
  const [form, setForm] = useState({ name: '', email: '', phone: '', subject: '', message: '', type: 'general' });
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      await axios.post('/api/auth/contact', form);
      toast.success('Message sent! I will get back to you soon.');
      setForm({ name: '', email: '', phone: '', subject: '', message: '', type: 'general' });
    } catch {
      toast.error('Failed to send message. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      {/* Header */}
      <div className="bg-dxn-darkgreen py-16 px-4 text-center">
        <h1 className="text-3xl md:text-4xl font-bold text-white mb-2">Get In Touch</h1>
        <p className="text-gray-300">I'm here to answer your questions about DXN products or the business opportunity.</p>
      </div>

      <div className="max-w-6xl mx-auto px-4 py-16">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
          {/* Contact Info */}
          <div className="space-y-6">
            <div>
              <h2 className="text-xl font-bold text-dxn-darkgreen mb-4">Contact Information</h2>
              <p className="text-gray-600 text-sm leading-relaxed">
                Whether you want to try DXN products, learn about the business opportunity, or join my team — I'm just a message away!
              </p>
            </div>
            {[
              { icon: FiPhone, label: 'Phone / WhatsApp', value: '+1 234 567 890' },
              { icon: FiMail, label: 'Email', value: 'info@growwithdxn.com' },
              { icon: FiMessageCircle, label: 'Telegram', value: '@growwithdxn' },
              { icon: FiMapPin, label: 'Location', value: 'Your City, Country' },
            ].map(({ icon: Icon, label, value }) => (
              <div key={label} className="flex items-start gap-3">
                <div className="w-10 h-10 bg-dxn-green/10 rounded-lg flex items-center justify-center shrink-0">
                  <Icon className="text-dxn-green" size={18} />
                </div>
                <div>
                  <p className="text-sm font-medium text-gray-700">{label}</p>
                  <p className="text-sm text-gray-500">{value}</p>
                </div>
              </div>
            ))}

            <div className="bg-dxn-gold/10 border border-dxn-gold/30 rounded-xl p-5">
              <h3 className="font-bold text-dxn-darkgreen mb-2">Want to Join?</h3>
              <p className="text-sm text-gray-600 mb-3">Select "Join as Distributor" in the form and I'll personally guide you through the registration process.</p>
            </div>
          </div>

          {/* Form */}
          <div className="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8">
            <h2 className="text-xl font-bold text-dxn-darkgreen mb-6">Send a Message</h2>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">What can I help you with?</label>
                <select name="type" value={form.type} onChange={handleChange} className="input-field">
                  <option value="general">General Inquiry</option>
                  <option value="product_inquiry">Product Question</option>
                  <option value="join_distributor">I want to join as a distributor</option>
                </select>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                  <input type="text" name="name" required value={form.name} onChange={handleChange} className="input-field" placeholder="John Doe" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Phone / WhatsApp</label>
                  <input type="tel" name="phone" value={form.phone} onChange={handleChange} className="input-field" placeholder="+1 234 567 890" />
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                <input type="email" name="email" required value={form.email} onChange={handleChange} className="input-field" placeholder="you@example.com" />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                <input type="text" name="subject" required value={form.subject} onChange={handleChange} className="input-field" placeholder="How can I help you?" />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                <textarea name="message" required rows={5} value={form.message} onChange={handleChange} className="input-field resize-none" placeholder="Tell me more..." />
              </div>

              <button type="submit" disabled={loading} className="btn-primary w-full justify-center flex items-center gap-2 disabled:opacity-70">
                {loading ? <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin" /> : null}
                {loading ? 'Sending...' : 'Send Message'}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}
