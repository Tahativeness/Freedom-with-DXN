import { useState } from 'react';
import { FiCalendar, FiClock, FiGlobe, FiVideo, FiCheck, FiPlay } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';
import { WhatsAppButton } from '../components/WhatsAppFloat';
import toast from 'react-hot-toast';

const ZOOM_LINK = 'https://zoom.us/j/your-meeting-id'; // Update with your actual Zoom link

const SCHEDULE_EN = [
  { day: 'Monday', time: '8:00 PM (UAE)', lang: 'Arabic', topic: 'DXN Products Overview & Health Benefits', badge: 'عربي' },
  { day: 'Wednesday', time: '8:00 PM (UAE)', lang: 'English', topic: 'Business Opportunity & Compensation Plan', badge: 'EN' },
  { day: 'Friday', time: '9:00 PM (UAE)', lang: 'Arabic & English', topic: 'Success Stories & Live Q&A', badge: 'AR/EN' },
  { day: 'Saturday', time: '6:00 PM (UAE)', lang: 'English', topic: 'Getting Started — New Member Training', badge: 'EN' },
];

const SCHEDULE_AR = [
  { day: 'الاثنين', time: '8:00 مساءً (الإمارات)', lang: 'عربي', topic: 'نظرة عامة على منتجات DXN وفوائدها الصحية', badge: 'عربي' },
  { day: 'الأربعاء', time: '8:00 مساءً (الإمارات)', lang: 'إنجليزي', topic: 'فرصة العمل وخطة التعويض', badge: 'EN' },
  { day: 'الجمعة', time: '9:00 مساءً (الإمارات)', lang: 'عربي وإنجليزي', topic: 'قصص النجاح وأسئلة مباشرة', badge: 'AR/EN' },
  { day: 'السبت', time: '6:00 مساءً (الإمارات)', lang: 'إنجليزي', topic: 'البدء — تدريب الأعضاء الجدد', badge: 'EN' },
];

const RECORDINGS_EN = [
  { title: 'Introduction to Ganoderma & DXN Products', duration: '45 min', date: 'March 2026', views: 312 },
  { title: 'How the DXN Compensation Plan Works', duration: '52 min', date: 'Feb 2026', views: 289 },
  { title: 'How to Build Your DXN Team on Social Media', duration: '38 min', date: 'Feb 2026', views: 256 },
  { title: 'Is DXN Halal? — Full Explanation', duration: '22 min', date: 'Jan 2026', views: 418 },
  { title: 'Success Stories from UAE Distributors', duration: '61 min', date: 'Jan 2026', views: 501 },
  { title: 'DXN Morning Routine for Maximum Health', duration: '29 min', date: 'Dec 2025', views: 387 },
];

const RECORDINGS_AR = [
  { title: 'مقدمة في الغانودرما ومنتجات DXN', duration: '45 دقيقة', date: 'مارس 2026', views: 312 },
  { title: 'كيف تعمل خطة التعويض في DXN', duration: '52 دقيقة', date: 'فبراير 2026', views: 289 },
  { title: 'كيف تبني فريق DXN على وسائل التواصل الاجتماعي', duration: '38 دقيقة', date: 'فبراير 2026', views: 256 },
  { title: 'هل DXN حلال؟ — شرح كامل', duration: '22 دقيقة', date: 'يناير 2026', views: 418 },
  { title: 'قصص نجاح من موزعي الإمارات', duration: '61 دقيقة', date: 'يناير 2026', views: 501 },
  { title: 'روتين الصباح مع DXN لأقصى صحة', duration: '29 دقيقة', date: 'ديسمبر 2025', views: 387 },
];

const WHAT_YOU_LEARN_EN = [
  'What Ganoderma is and why millions trust it',
  'Full overview of DXN\'s product range',
  'How the DXN compensation plan works',
  'How to register and get started for free',
  'Tips to build your team using social media',
  'Live Q&A — ask anything, no pressure',
];

const WHAT_YOU_LEARN_AR = [
  'ما هو الغانودرما ولماذا يثق به الملايين',
  'نظرة شاملة على مجموعة منتجات DXN',
  'كيف تعمل خطة التعويض في DXN',
  'كيفية التسجيل والبدء مجاناً',
  'نصائح لبناء فريقك عبر وسائل التواصل الاجتماعي',
  'أسئلة وأجوبة مباشرة — اسأل أي شيء، بدون ضغط',
];

export default function ZoomTraining() {
  const { t, lang } = useLang();
  const [form, setForm] = useState({ name: '', phone: '', email: '', session: 'Monday' });
  const [submitted, setSubmitted] = useState(false);

  const schedule = lang === 'ar' ? SCHEDULE_AR : SCHEDULE_EN;
  const recordings = lang === 'ar' ? RECORDINGS_AR : RECORDINGS_EN;
  const whatYouLearn = lang === 'ar' ? WHAT_YOU_LEARN_AR : WHAT_YOU_LEARN_EN;

  const handleSubmit = (e) => {
    e.preventDefault();
    // In production, send to backend/WhatsApp
    toast.success(lang === 'ar' ? 'تم التسجيل! سأرسل لك رابط زووم قريباً.' : 'Registered! I\'ll send you the Zoom link shortly.');
    setSubmitted(true);
  };

  return (
    <div>
      {/* Header */}
      <div className="bg-dxn-darkgreen py-20 px-4 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 70% 30%, #dfc378 0%, transparent 60%)' }} />
        <div className="relative max-w-4xl mx-auto text-center">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
            {lang === 'ar' ? 'مجاني 100%' : '100% Free'}
          </span>
          <h1 className="text-4xl md:text-5xl font-bold text-white mb-4">{t('zoomTitle')}</h1>
          <p className="text-gray-300 text-lg max-w-2xl mx-auto">{t('zoomSub')}</p>
          <div className="flex flex-wrap gap-4 justify-center mt-8">
            <a href={ZOOM_LINK} target="_blank" rel="noopener noreferrer"
              className="inline-flex items-center gap-2 bg-[#2D8CFF] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#1a6fd4] transition-all">
              <FiVideo size={18} /> {lang === 'ar' ? 'انضم إلى زووم الآن' : 'Join Zoom Now'}
            </a>
            <WhatsAppButton label={lang === 'ar' ? 'احصل على الرابط عبر واتساب' : 'Get Link on WhatsApp'} />
          </div>
        </div>
      </div>

      {/* What You'll Learn */}
      <section className="py-16 bg-white">
        <div className="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <h2 className="text-3xl font-bold text-dxn-darkgreen mb-6">
              {lang === 'ar' ? 'ماذا ستتعلم' : "What You'll Learn"}
            </h2>
            <ul className="space-y-4">
              {whatYouLearn.map((item, i) => (
                <li key={i} className="flex items-start gap-3">
                  <div className="w-6 h-6 bg-dxn-green rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <FiCheck className="text-white" size={13} />
                  </div>
                  <span className="text-gray-600">{item}</span>
                </li>
              ))}
            </ul>
          </div>
          <div className="grid grid-cols-3 gap-4 text-center">
            {[
              { icon: FiVideo, label: lang === 'ar' ? 'مباشر عبر زووم' : 'Live on Zoom', sub: lang === 'ar' ? 'تفاعلي' : 'Interactive' },
              { icon: FiGlobe, label: lang === 'ar' ? 'ثنائي اللغة' : 'Bilingual', sub: lang === 'ar' ? 'عربي وإنجليزي' : 'Arabic & English' },
              { icon: FiCalendar, label: lang === 'ar' ? 'كل أسبوع' : 'Every Week', sub: lang === 'ar' ? '4 جلسات' : '4 Sessions' },
            ].map(({ icon: Icon, label, sub }) => (
              <div key={label} className="bg-gray-50 rounded-2xl p-6">
                <Icon className="mx-auto mb-3 text-dxn-green" size={28} />
                <p className="font-bold text-dxn-darkgreen text-sm">{label}</p>
                <p className="text-gray-500 text-xs mt-1">{sub}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Schedule */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-4xl mx-auto px-4">
          <div className="text-center mb-10">
            <h2 className="text-3xl font-bold text-dxn-darkgreen">
              {lang === 'ar' ? 'جدول الجلسات الأسبوعية' : 'Weekly Session Schedule'}
            </h2>
            <p className="text-gray-500 mt-2 flex items-center justify-center gap-1">
              <FiClock size={14} /> {lang === 'ar' ? 'التوقيت: توقيت الإمارات (GST +4)' : 'All times in UAE Time (GST +4)'}
            </p>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {schedule.map((s, i) => (
              <div key={i} className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div className="flex items-start justify-between mb-3">
                  <div>
                    <h3 className="font-bold text-dxn-darkgreen text-lg">{s.day}</h3>
                    <p className="text-dxn-gold text-sm font-medium flex items-center gap-1">
                      <FiClock size={12} /> {s.time}
                    </p>
                  </div>
                  <span className="bg-dxn-green text-white text-xs px-2 py-1 rounded-full font-bold">{s.badge}</span>
                </div>
                <p className="text-gray-600 text-sm">{s.topic}</p>
                <div className="mt-4 flex gap-2">
                  <a href={ZOOM_LINK} target="_blank" rel="noopener noreferrer"
                    className="flex-1 text-center bg-[#2D8CFF] text-white text-xs font-semibold py-2 rounded-lg hover:bg-[#1a6fd4] transition-colors">
                    {lang === 'ar' ? 'انضم' : 'Join'}
                  </a>
                  <WhatsAppButton className="flex-1 text-xs py-2 px-2 justify-center rounded-lg" label={lang === 'ar' ? 'تذكير' : 'Reminder'} />
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Registration Form + Recordings side by side */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Register Form */}
          <div>
            <h2 className="text-2xl font-bold text-dxn-darkgreen mb-2">
              {lang === 'ar' ? 'سجّل لأقرب جلسة' : 'Register for the Next Session'}
            </h2>
            <p className="text-gray-500 text-sm mb-6">
              {lang === 'ar' ? 'سأرسل لك رابط زووم مباشرة على واتساب أو بريدك الإلكتروني.' : "I'll send you the Zoom link directly on WhatsApp or email."}
            </p>
            {submitted ? (
              <div className="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
                <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <FiCheck className="text-green-600" size={28} />
                </div>
                <h3 className="font-bold text-green-800 text-lg mb-2">
                  {lang === 'ar' ? 'تم التسجيل بنجاح!' : 'Registration Successful!'}
                </h3>
                <p className="text-green-600 text-sm">
                  {lang === 'ar' ? 'سأتواصل معك قريباً برابط زووم.' : "I'll reach out soon with your Zoom link."}
                </p>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'الاسم الكامل *' : 'Full Name *'}
                  </label>
                  <input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })}
                    className="input-field" placeholder={lang === 'ar' ? 'أدخل اسمك' : 'Enter your name'} />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'رقم واتساب *' : 'WhatsApp Number *'}
                  </label>
                  <input required type="tel" value={form.phone} onChange={(e) => setForm({ ...form, phone: e.target.value })}
                    className="input-field" placeholder="+971 50 123 4567" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'البريد الإلكتروني' : 'Email (optional)'}
                  </label>
                  <input type="email" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })}
                    className="input-field" placeholder="you@email.com" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    {lang === 'ar' ? 'اختر الجلسة المفضلة' : 'Preferred Session'}
                  </label>
                  <select value={form.session} onChange={(e) => setForm({ ...form, session: e.target.value })} className="input-field">
                    {schedule.map((s, i) => (
                      <option key={i} value={s.day}>{s.day} — {s.time}</option>
                    ))}
                  </select>
                </div>
                <button type="submit" className="btn-primary w-full justify-center flex items-center gap-2">
                  <FiCalendar size={16} /> {lang === 'ar' ? 'سجّل مجاناً' : 'Register for Free'}
                </button>
              </form>
            )}
          </div>

          {/* Recordings */}
          <div>
            <h2 className="text-2xl font-bold text-dxn-darkgreen mb-2">
              {lang === 'ar' ? 'جلسات سابقة مسجلة' : 'Past Session Recordings'}
            </h2>
            <p className="text-gray-500 text-sm mb-6">
              {lang === 'ar' ? 'فاتتك جلسة؟ شاهد التسجيلات في أي وقت.' : "Missed a session? Watch recordings anytime."}
            </p>
            <div className="space-y-3">
              {recordings.map((r, i) => (
                <div key={i} className="flex items-center gap-4 bg-gray-50 rounded-xl p-4 border border-gray-100 hover:shadow-sm transition-shadow group cursor-pointer">
                  <div className="w-10 h-10 bg-[#2D8CFF]/10 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-[#2D8CFF]/20 transition-colors">
                    <FiPlay className="text-[#2D8CFF]" size={16} />
                  </div>
                  <div className="flex-1 min-w-0">
                    <p className="font-medium text-gray-800 text-sm leading-snug truncate">{r.title}</p>
                    <div className="flex items-center gap-3 mt-1 text-xs text-gray-400">
                      <span className="flex items-center gap-1"><FiClock size={10} /> {r.duration}</span>
                      <span>{r.date}</span>
                      <span>{r.views} {lang === 'ar' ? 'مشاهدة' : 'views'}</span>
                    </div>
                  </div>
                </div>
              ))}
            </div>
            <p className="text-xs text-gray-400 mt-4 text-center">
              {lang === 'ar' ? 'سجّل أو تواصل معنا للحصول على روابط التسجيلات الكاملة.' : 'Register or contact us to get full recording links.'}
            </p>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="bg-dxn-green py-16">
        <div className="max-w-3xl mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">
            {lang === 'ar' ? 'لديك سؤال؟ تحدث معي مباشرة' : 'Have a Question? Talk to Me Directly'}
          </h2>
          <p className="text-green-200 mb-6">
            {lang === 'ar' ? 'أنا متاح على واتساب لأجيب على أي سؤال قبل أو بعد الجلسة.' : "I'm available on WhatsApp to answer any question before or after the session."}
          </p>
          <WhatsAppButton />
        </div>
      </section>
    </div>
  );
}
