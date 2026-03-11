import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import ProductCard from '../components/ProductCard';
import Bestsellers from '../components/Bestsellers';
import { WhatsAppButton } from '../components/WhatsAppFloat';
import { useLang } from '../context/LanguageContext';
import { FiArrowRight, FiStar, FiUsers, FiGlobe, FiAward, FiCheck, FiVideo, FiCalendar } from 'react-icons/fi';

const STATS = [
  { k: 'countries', v: '180+', icon: FiGlobe },
  { k: 'members', v: '9M+', icon: FiUsers },
  { k: 'years', v: '35+', icon: FiAward },
  { k: 'products', v: '1000+', icon: FiStar },
];
const SL = {
  en: { countries: 'Countries', members: 'Members', years: 'Years', products: 'Products' },
  ar: { countries: 'دولة', members: 'عضو', years: 'عاماً', products: 'منتج' },
};
const WHY = {
  en: ['Low startup cost', 'World-class Ganoderma products', 'One-world one-market', 'Passive income via downline', 'Free training', 'No monthly quota'],
  ar: ['تكلفة بداية منخفضة', 'منتجات غانودرما عالمية', 'عمل عالمي واحد', 'دخل سلبي عبر الشبكة', 'تدريب مجاني', 'لا حصة شهرية'],
};
const TESTI = {
  en: [
    { name: 'Sarah M.', role: 'Diamond Distributor', text: 'DXN changed my life. Ganoderma improved my health and I earn full-time income.', avatar: 'S' },
    { name: 'James K.', role: 'Gold Distributor', text: 'Built a team of 50+ distributors. Best decision ever!', avatar: 'J' },
    { name: 'Maria L.', role: 'Star Ruby', text: 'The coffee is amazing and my downline keeps growing!', avatar: 'M' },
  ],
  ar: [
    { name: 'سارة م.', role: 'موزعة ماسية', text: 'غيّرت DXN حياتي. حسّنت صحتي وأصبحت أكسب دخلاً كاملاً.', avatar: 'س' },
    { name: 'جيمس ك.', role: 'موزع ذهبي', text: 'بنيت فريقاً من أكثر من 50 موزعاً. أفضل قرار!', avatar: 'ج' },
    { name: 'ماريا ل.', role: 'عضوة نجمة ياقوتية', text: 'القهوة رائعة وفريقي يتنامى كل شهر!', avatar: 'م' },
  ],
};

export default function Home() {
  const { lang, t } = useLang();
  const [featured, setFeatured] = useState([]);

  useEffect(() => {
    axios.get('/api/products?featured=true&limit=4', { timeout: 3000 })
      .then((r) => {
        if (Array.isArray(r.data?.products) && r.data.products.length > 0) setFeatured(r.data.products);
        else throw new Error();
      })
      .catch(() => setFeatured([
        { _id: '1', name: 'Lingzhi Coffee 3 in 1', category: 'coffee', price: 24.99, rating: 4.8, featured: true, inStock: true },
        { _id: '2', name: 'Reishi Gano (RG)', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true },
        { _id: '3', name: 'Spirulina Tablet', category: 'supplements', price: 29.99, rating: 4.6, featured: true, inStock: true },
        { _id: '4', name: 'DXN Cocozhi', category: 'beverages', price: 22.99, rating: 4.5, featured: true, inStock: true },
      ]));
  }, []);

  const testi = TESTI[lang] || TESTI.en;
  const why = WHY[lang] || WHY.en;
  const sl = SL[lang] || SL.en;

  return (
    <div>
      {/* Hero */}
      <section className="bg-hero min-h-[85vh] flex items-center relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 30% 50%, #dfc378 0%, transparent 50%)' }} />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
              {lang === 'ar' ? 'موزع مستقل معتمد من DXN' : 'Independent DXN Distributor'}
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
              {lang === 'ar'
                ? <><span>نمّ صحتك و</span><span className="text-dxn-gold">ثروتك</span><span> مع DXN</span></>
                : <><span>Grow Your Health &amp; </span><span className="text-dxn-gold">Wealth</span><span> with DXN</span></>
              }
            </h1>
            <p className="text-gray-300 text-lg mb-8 max-w-lg">{t('heroSub')}</p>
            <div className="flex flex-col sm:flex-row gap-4">
              <Link to="/products" className="btn-gold text-center">{t('heroBtn1')}</Link>
              <Link to="/zoom" className="inline-flex items-center justify-center gap-2 border-2 border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
                <FiVideo size={16} /> {t('heroBtn2')}
              </Link>
            </div>
          </div>
          <div className="hidden lg:flex justify-center">
            <div className="w-80 h-80 bg-dxn-gold/20 rounded-full flex items-center justify-center">
              <div className="w-64 h-64 bg-dxn-gold/30 rounded-full flex items-center justify-center">
                <div className="text-center text-white">
                  <div className="text-6xl font-bold text-dxn-gold">DXN</div>
                  <div className="text-xl mt-2">Ganoderma</div>
                  <div className="text-sm text-gray-300 mt-1">{lang === 'ar' ? 'منذ 1993' : 'Since 1993'}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="bg-dxn-green py-12">
        <div className="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
          {STATS.map(({ k, v, icon: Icon }) => (
            <div key={k} className="text-center text-white">
              <Icon className="mx-auto mb-2 text-dxn-gold" size={28} />
              <div className="text-3xl font-bold">{v}</div>
              <div className="text-gray-300 text-sm">{sl[k]}</div>
            </div>
          ))}
        </div>
      </section>

      {/* Featured Products */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">{lang === 'ar' ? 'المنتجات المميزة' : 'Featured Products'}</h2>
          <p className="section-subtitle">{lang === 'ar' ? 'منتجات صحية عالية الجودة مدعومة بالغانودرما' : 'Premium health products powered by Ganoderma Lucidum'}</p>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {featured.map((p) => <ProductCard key={p._id} product={p} />)}
          </div>
          <div className="text-center mt-10">
            <Link to="/products" className="btn-primary inline-flex items-center gap-2">{t('viewAll')} <FiArrowRight /></Link>
          </div>
        </div>
      </section>

      {/* Bestsellers */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4"><Bestsellers limit={4} /></div>
      </section>

      {/* Free Zoom Banner */}
      <section className="py-16 bg-blue-50 border-y border-blue-100">
        <div className="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <div>
            <div className="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold mb-3">
              <FiVideo size={14} /> {lang === 'ar' ? 'مجاني 100%' : '100% Free'}
            </div>
            <h2 className="text-2xl md:text-3xl font-bold text-dxn-darkgreen mb-3">
              {lang === 'ar' ? 'احضر جلسة زووم مجانية' : 'Attend a Free Zoom Session'}
            </h2>
            <p className="text-gray-600 mb-4">
              {lang === 'ar'
                ? 'تعرف على منتجات DXN وفرصة العمل. جلسات أسبوعية بالعربية والإنجليزية.'
                : 'Learn about DXN products and the business opportunity. Weekly sessions in Arabic and English.'}
            </p>
            <div className="flex flex-wrap gap-3">
              <Link to="/zoom" className="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                <FiCalendar size={16} /> {lang === 'ar' ? 'عرض الجدول' : 'View Schedule'}
              </Link>
              <WhatsAppButton label={lang === 'ar' ? 'احصل على الرابط' : 'Get the Link'} />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-4">
            {[
              { d: lang === 'ar' ? 'الاثنين' : 'Monday', b: lang === 'ar' ? 'عربي' : 'Arabic' },
              { d: lang === 'ar' ? 'الأربعاء' : 'Wednesday', b: 'English' },
              { d: lang === 'ar' ? 'الجمعة' : 'Friday', b: 'AR/EN' },
              { d: lang === 'ar' ? 'السبت' : 'Saturday', b: 'English' },
            ].map((s) => (
              <div key={s.d} className="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">
                <p className="font-bold text-dxn-darkgreen">{s.d}</p>
                <span className="inline-block bg-blue-50 text-blue-600 text-xs px-2 py-0.5 rounded-full mt-1">{s.b}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Why Join */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <span className="text-dxn-gold font-semibold text-sm uppercase tracking-widest">
              {lang === 'ar' ? 'فرصة العمل' : 'Business Opportunity'}
            </span>
            <h2 className="text-3xl md:text-4xl font-bold text-dxn-darkgreen mt-2 mb-6">{t('whyJoinTitle')}</h2>
            <ul className="space-y-3 mb-8">
              {why.map((item) => (
                <li key={item} className="flex items-start gap-3">
                  <div className="w-5 h-5 bg-dxn-green rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <FiCheck className="text-white" size={12} />
                  </div>
                  <span className="text-gray-600">{item}</span>
                </li>
              ))}
            </ul>
            <div className="flex flex-wrap gap-3">
              <Link to="/join" className="btn-primary inline-flex items-center gap-2">
                {lang === 'ar' ? 'انضم كموزع' : 'Join as Distributor'} <FiArrowRight />
              </Link>
              <WhatsAppButton label={lang === 'ar' ? 'اسألني الآن' : 'Ask Me Now'} />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-4">
            {[
              { tE: 'Health', tA: 'الصحة', dE: 'Transform health with Ganoderma', dA: 'حوّل صحتك بالغانودرما', c: 'bg-green-50 border-green-200' },
              { tE: 'Wealth', tA: 'الثروة', dE: 'Build passive income', dA: 'ابنِ دخلاً سلبياً', c: 'bg-yellow-50 border-yellow-200' },
              { tE: 'Network', tA: 'الشبكة', dE: 'Global distributor community', dA: 'مجتمع موزعين عالمي', c: 'bg-blue-50 border-blue-200' },
              { tE: 'Freedom', tA: 'الحرية', dE: 'Work on your schedule', dA: 'اعمل وفق جدولك', c: 'bg-purple-50 border-purple-200' },
            ].map(({ tE, tA, dE, dA, c }) => (
              <div key={tE} className={`p-6 rounded-xl border-2 ${c}`}>
                <h3 className="font-bold text-dxn-darkgreen text-xl mb-2">{lang === 'ar' ? tA : tE}</h3>
                <p className="text-gray-600 text-sm">{lang === 'ar' ? dA : dE}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">{t('successStories')}</h2>
          <p className="section-subtitle">{lang === 'ar' ? 'أشخاص حقيقيون. نتائج حقيقية.' : 'Real people. Real results.'}</p>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {testi.map(({ name, role, text, avatar }) => (
              <div key={name} className="card p-6">
                <div className="flex items-center gap-1 mb-4">
                  {[...Array(5)].map((_, i) => <FiStar key={i} className="text-yellow-400 fill-yellow-400" size={16} />)}
                </div>
                <p className="text-gray-600 italic mb-6">"{text}"</p>
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-dxn-green rounded-full flex items-center justify-center text-white font-bold">{avatar}</div>
                  <div>
                    <p className="font-semibold text-gray-800">{name}</p>
                    <p className="text-sm text-dxn-gold">{role}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Banner */}
      <section className="bg-hero py-20">
        <div className="max-w-4xl mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">{t('readyTitle')}</h2>
          <p className="text-gray-300 text-lg mb-8">{t('readySub')}</p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/join" className="btn-gold">{lang === 'ar' ? 'انضم مجاناً' : 'Join For Free'}</Link>
            <WhatsAppButton />
            <Link to="/zoom" className="inline-flex items-center justify-center gap-2 border-2 border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
              <FiVideo size={16} /> {lang === 'ar' ? 'احضر زووم' : 'Free Zoom'}
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
