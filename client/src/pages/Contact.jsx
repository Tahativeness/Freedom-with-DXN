import { useState } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { FiMail, FiPhone, FiMessageCircle, FiMapPin } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';
import { WhatsAppButton } from '../components/WhatsAppFloat';

export default function Contact() {
  const { lang, t } = useLang();
  const [form, setForm] = useState({ name: '', email: '', phone: '', subject: '', message: '', type: 'general' });
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      await axios.post('/api/auth/contact', form);
      toast.success(lang === 'ar' ? 'تم إرسال رسالتك! سأرد عليك قريباً.' : 'Message sent! I will get back to you soon.');
      setForm({ name: '', email: '', phone: '', subject: '', message: '', type: 'general' });
    } catch {
      toast.error(lang === 'ar' ? 'فشل الإرسال. حاول مجدداً.' : 'Failed to send message. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  const contactItems = [
    { icon: FiPhone, label: lang === 'ar' ? 'هاتف / واتساب' : 'Phone / WhatsApp', value: '+971 50 123 4567' },
    { icon: FiMail, label: lang === 'ar' ? 'البريد الإلكتروني' : 'Email', value: 'info@growwithdxn.com' },
    { icon: FiMessageCircle, label: lang === 'ar' ? 'تيليغرام' : 'Telegram', value: '@growwithdxn' },
    { icon: FiMapPin, label: lang === 'ar' ? 'الموقع' : 'Location', value: lang === 'ar' ? 'الإمارات العربية المتحدة' : 'United Arab Emirates' },
  ];

  return (
    <div>
      {/* Header */}
      <div className="bg-dxn-darkgreen py-16 px-4 text-center relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 70% 50%, #dfc378 0%, transparent 60%)' }} />
        <div className="relative">
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-2">{t('contactTitle')}</h1>
          <p className="text-gray-300">{t('contactSub')}</p>
        </div>
      </div>

      {/* WhatsApp Direct CTA */}
      <div className="bg-[#25D366]/10 border-b border-[#25D366]/20 py-5">
        <div className="max-w-4xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div>
            <p className="font-bold text-gray-800 text-lg">
              {lang === 'ar' ? 'تفضّل الحديث المباشر؟' : 'Prefer to chat directly?'}
            </p>
            <p className="text-gray-600 text-sm">
              {lang === 'ar' ? 'أنا متاح على واتساب 7 أيام في الأسبوع.' : "I'm available on WhatsApp 7 days a week."}
            </p>
          </div>
          <WhatsAppButton label={t('whatsappDirect')} />
        </div>
      </div>

      <div className="max-w-6xl mx-auto px-4 py-16">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
          {/* Contact Info */}
          <div className="space-y-6">
            <div>
              <h2 className="text-xl font-bold text-dxn-darkgreen mb-4">
                {lang === 'ar' ? 'معلومات التواصل' : 'Contact Information'}
              </h2>
              <p className="text-gray-600 text-sm leading-relaxed">
                {lang === 'ar'
                  ? 'سواء أردت تجربة منتجات DXN أو معرفة المزيد عن فرصة العمل أو الانضمام لفريقي — أنا على بعد رسالة!'
                  : "Whether you want to try DXN products, learn about the business opportunity, or join my team — I'm just a message away!"}
              </p>
            </div>
            {contactItems.map(({ icon: Icon, label, value }) => (
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
              <h3 className="font-bold text-dxn-darkgreen mb-2">
                {lang === 'ar' ? 'هل تريد الانضمام؟' : 'Want to Join?'}
              </h3>
              <p className="text-sm text-gray-600 mb-3">
                {lang === 'ar'
                  ? 'اختر "الانضمام كموزع" في النموذج وسأرشدك شخصياً خلال عملية التسجيل.'
                  : 'Select "Join as Distributor" in the form and I\'ll personally guide you through the registration process.'}
              </p>
              <WhatsAppButton label={lang === 'ar' ? 'واتساب مباشر' : 'WhatsApp Me'} className="w-full justify-center" />
            </div>
          </div>

          {/* Form */}
          <div className="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8">
            <h2 className="text-xl font-bold text-dxn-darkgreen mb-6">
              {lang === 'ar' ? 'أرسل رسالة' : 'Send a Message'}
            </h2>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  {lang === 'ar' ? 'كيف يمكنني مساعدتك؟' : 'What can I help you with?'}
                </label>
                <select name="type" value={form.type} onChange={handleChange} className="input-field">
                  <option value="general">{lang === 'ar' ? 'استفسار عام' : 'General Inquiry'}</option>
                  <option value="product_inquiry">{lang === 'ar' ? 'سؤال عن منتج' : 'Product Question'}</option>
                  <option value="join_distributor">{lang === 'ar' ? 'أريد الانضمام كموزع' : 'I want to join as a distributor'}</option>
                  <option value="zoom">{lang === 'ar' ? 'أريد حضور جلسة زووم' : 'I want to attend a Zoom session'}</option>
                </select>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'الاسم الكامل *' : 'Full Name *'}
                  </label>
                  <input type="text" name="name" required value={form.name} onChange={handleChange} className="input-field"
                    placeholder={lang === 'ar' ? 'أدخل اسمك' : 'John Doe'} />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'هاتف / واتساب' : 'Phone / WhatsApp'}
                  </label>
                  <input type="tel" name="phone" value={form.phone} onChange={handleChange} className="input-field"
                    placeholder="+971 50 123 4567" />
                </div>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  {lang === 'ar' ? 'البريد الإلكتروني *' : 'Email Address *'}
                </label>
                <input type="email" name="email" required value={form.email} onChange={handleChange} className="input-field"
                  placeholder="you@example.com" />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  {lang === 'ar' ? 'الموضوع *' : 'Subject *'}
                </label>
                <input type="text" name="subject" required value={form.subject} onChange={handleChange} className="input-field"
                  placeholder={lang === 'ar' ? 'كيف يمكنني مساعدتك؟' : 'How can I help you?'} />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  {lang === 'ar' ? 'الرسالة *' : 'Message *'}
                </label>
                <textarea name="message" required rows={5} value={form.message} onChange={handleChange} className="input-field resize-none"
                  placeholder={lang === 'ar' ? 'أخبرني المزيد...' : 'Tell me more...'} />
              </div>
              <button type="submit" disabled={loading} className="btn-primary w-full justify-center flex items-center gap-2 disabled:opacity-70">
                {loading ? <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin" /> : null}
                {loading ? (lang === 'ar' ? 'جاري الإرسال...' : 'Sending...') : (lang === 'ar' ? 'إرسال الرسالة' : 'Send Message')}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}
