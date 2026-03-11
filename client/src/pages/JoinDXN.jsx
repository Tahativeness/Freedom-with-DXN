import { Link } from 'react-router-dom';
import { FiCheck, FiArrowRight, FiDollarSign, FiUsers, FiGlobe, FiTrendingUp } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';
import { WhatsAppButton } from '../components/WhatsAppFloat';

const STEPS_EN = [
  {
    num: '01', title: 'Contact Me',
    desc: 'Send me a WhatsApp message or fill out the contact form. Tell me your name, country, and that you want to join DXN. I\'ll guide you through the entire process.',
    tip: 'It only takes 2 minutes to get started.',
  },
  {
    num: '02', title: 'Register as a Member',
    desc: 'I\'ll send you a personal referral link. Register through it on the DXN website. The registration fee is very low (typically $10–$25 depending on your country).',
    tip: 'One-time fee. No annual renewals.',
  },
  {
    num: '03', title: 'Try the Products',
    desc: 'Start with DXN\'s Lingzhi Coffee or Reishi Gano capsules. Use them daily for at least 30 days. Your personal experience will be your best tool for sharing.',
    tip: 'No minimum purchase required.',
  },
  {
    num: '04', title: 'Attend Zoom Training',
    desc: 'Join our free weekly Zoom sessions to learn about the products, the compensation plan, and how to build your team. All sessions are available in Arabic and English.',
    tip: 'Free. Every week. No experience needed.',
  },
  {
    num: '05', title: 'Share & Earn',
    desc: 'Start sharing your experience with friends and family. When they order or register through your link, you earn commissions. The more you share, the more you earn.',
    tip: 'No pressure. Share naturally.',
  },
  {
    num: '06', title: 'Build Your Team',
    desc: 'Invite others to register as distributors under you. As your team grows, so does your passive income. I\'ll support you every step of the way with training and advice.',
    tip: 'Your success is our success.',
  },
];

const STEPS_AR = [
  {
    num: '01', title: 'تواصل معي',
    desc: 'أرسل لي رسالة واتساب أو أكمل نموذج الاتصال. أخبرني باسمك ودولتك وأنك تريد الانضمام إلى DXN. سأرشدك خلال العملية بأكملها.',
    tip: 'يستغرق البدء دقيقتين فقط.',
  },
  {
    num: '02', title: 'سجل كعضو',
    desc: 'سأرسل لك رابط إحالة شخصي. سجل من خلاله على موقع DXN. رسوم التسجيل منخفضة جداً (عادةً 10-25 دولار حسب بلدك).',
    tip: 'رسوم لمرة واحدة. لا تجديدات سنوية.',
  },
  {
    num: '03', title: 'جرّب المنتجات',
    desc: 'ابدأ بقهوة ليندزهي أو كبسولات ريشي غانو من DXN. استخدمها يومياً لمدة 30 يوماً على الأقل. تجربتك الشخصية ستكون أفضل أداة لك في المشاركة.',
    tip: 'لا حد أدنى للشراء مطلوب.',
  },
  {
    num: '04', title: 'احضر تدريب زووم',
    desc: 'انضم إلى جلسات زووم الأسبوعية المجانية لتتعلم عن المنتجات وخطة التعويض وكيفية بناء فريقك. جميع الجلسات متاحة بالعربية والإنجليزية.',
    tip: 'مجاني. كل أسبوع. لا يلزم خبرة.',
  },
  {
    num: '05', title: 'شارك واكسب',
    desc: 'ابدأ بمشاركة تجربتك مع الأصدقاء والعائلة. عندما يطلبون أو يسجلون من خلال رابطك، تكسب عمولات. كلما شاركت أكثر، كسبت أكثر.',
    tip: 'بدون ضغط. شارك بشكل طبيعي.',
  },
  {
    num: '06', title: 'ابنِ فريقك',
    desc: 'ادعُ الآخرين للتسجيل كموزعين تحتك. مع نمو فريقك، يتزايد دخلك السلبي. سأدعمك في كل خطوة بالتدريب والنصيحة.',
    tip: 'نجاحك هو نجاحنا.',
  },
];

const FAQ_EN = [
  { q: 'Is DXN legit?', a: 'Yes. DXN was founded in 1993 by Dr. Lim Siow Jin in Malaysia and operates in 180+ countries. It is a legitimate direct-selling company listed on international stock exchanges and has millions of members worldwide.' },
  { q: 'How much does it cost to start?', a: 'The registration fee is typically $10–$25 (varies by country). There is NO monthly purchase quota — you only buy what you need or want. This is one of DXN\'s biggest advantages.' },
  { q: 'Is DXN halal?', a: 'Yes. DXN products are halal-certified. The Ganoderma mushroom is a plant-based ingredient. DXN has official halal certifications from recognized Islamic authorities, making it suitable for Muslim consumers.' },
  { q: 'Do I need any experience?', a: 'No experience needed at all. DXN provides free training through Zoom sessions, online resources, and support from your upline. If you can share a product recommendation with a friend, you can succeed in DXN.' },
  { q: 'How do I earn money?', a: 'You earn through retail profit (selling products at retail price), group bonus (commissions based on your team\'s total sales), and various leadership bonuses as you advance in rank. Many distributors also qualify for travel incentives.' },
  { q: 'Can I do this part-time?', a: 'Absolutely. Most successful DXN distributors started part-time while keeping their regular jobs. There\'s no schedule, no quota, and no pressure. You work at your own pace.' },
];

const FAQ_AR = [
  { q: 'هل DXN شرعية؟', a: 'نعم. تأسست DXN عام 1993 على يد الدكتور ليم سيو جين في ماليزيا وتعمل في أكثر من 180 دولة. إنها شركة بيع مباشر شرعية مدرجة في البورصات الدولية ولديها ملايين الأعضاء حول العالم.' },
  { q: 'كم يكلف البدء؟', a: 'رسوم التسجيل عادةً 10-25 دولار (تختلف حسب الدولة). لا يوجد حصة شراء شهرية — تشتري فقط ما تحتاجه أو تريده. هذه إحدى أكبر مزايا DXN.' },
  { q: 'هل DXN حلال؟', a: 'نعم. منتجات DXN حاصلة على شهادة حلال. فطر الغانودرما مكوّن نباتي. تحتل DXN شهادات حلال رسمية من هيئات إسلامية معترف بها، مما يجعلها مناسبة للمستهلكين المسلمين.' },
  { q: 'هل أحتاج إلى خبرة؟', a: 'لا تحتاج إلى أي خبرة على الإطلاق. توفر DXN تدريباً مجانياً من خلال جلسات زووم والموارد الإلكترونية ودعم من قائدك. إذا كنت تستطيع مشاركة توصية منتج مع صديق، يمكنك النجاح في DXN.' },
  { q: 'كيف أكسب المال؟', a: 'تكسب من خلال ربح التجزئة (بيع المنتجات بسعر التجزئة) والمكافأة الجماعية (عمولات بناءً على إجمالي مبيعات فريقك) ومكافآت قيادية متنوعة مع تقدمك في الرتبة. يحصل كثير من الموزعين أيضاً على حوافز سفر.' },
  { q: 'هل يمكنني القيام بهذا بدوام جزئي؟', a: 'بالتأكيد. بدأ معظم موزعي DXN الناجحين بدوام جزئي مع الحفاظ على وظائفهم العادية. لا يوجد جدول زمني ولا حصة ولا ضغط. تعمل بوتيرتك الخاصة.' },
];

const PERKS_EN = [
  { icon: FiDollarSign, title: 'Low Startup Cost', desc: 'One of the lowest entry costs in the industry. No expensive starter kits required.' },
  { icon: FiGlobe, title: 'Global Business', desc: 'Your DXN membership works in 180+ countries. Build a truly global team.' },
  { icon: FiUsers, title: 'No Monthly Quota', desc: 'Zero monthly purchase requirements. Buy only when you want to.' },
  { icon: FiTrendingUp, title: 'Lifetime Membership', desc: 'Register once, stay a member forever. No annual renewal fees.' },
];

const PERKS_AR = [
  { icon: FiDollarSign, title: 'تكلفة بدء منخفضة', desc: 'من أدنى تكاليف الدخول في الصناعة. لا حاجة لمجموعات بداية مكلفة.' },
  { icon: FiGlobe, title: 'عمل عالمي', desc: 'عضويتك في DXN تعمل في أكثر من 180 دولة. ابنِ فريقاً عالمياً حقيقياً.' },
  { icon: FiUsers, title: 'لا حصة شهرية', desc: 'صفر متطلبات شراء شهرية. اشترِ فقط عندما تريد.' },
  { icon: FiTrendingUp, title: 'عضوية مدى الحياة', desc: 'سجّل مرة واحدة، ابقَ عضواً للأبد. لا رسوم تجديد سنوية.' },
];

export default function JoinDXN() {
  const { t, lang } = useLang();
  const steps = lang === 'ar' ? STEPS_AR : STEPS_EN;
  const faqs = lang === 'ar' ? FAQ_AR : FAQ_EN;
  const perks = lang === 'ar' ? PERKS_AR : PERKS_EN;

  return (
    <div>
      {/* Header */}
      <div className="bg-dxn-darkgreen py-20 px-4 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 30% 50%, #dfc378 0%, transparent 60%)' }} />
        <div className="relative max-w-4xl mx-auto text-center">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
            {lang === 'ar' ? 'انضم إلى DXN' : 'Join DXN'}
          </span>
          <h1 className="text-4xl md:text-5xl font-bold text-white mb-4">{t('joinTitle')}</h1>
          <p className="text-gray-300 text-lg max-w-2xl mx-auto">{t('joinSub')}</p>
          <div className="flex flex-wrap gap-4 justify-center mt-8">
            <WhatsAppButton label={lang === 'ar' ? 'ابدأ الآن عبر واتساب' : 'Get Started on WhatsApp'} />
            <Link to="/zoom" className="btn-outline border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
              {lang === 'ar' ? 'احضر زووم مجاني أولاً' : 'Attend Free Zoom First'}
            </Link>
          </div>
        </div>
      </div>

      {/* Perks */}
      <section className="py-16 bg-dxn-gold/10 border-b border-dxn-gold/20">
        <div className="max-w-6xl mx-auto px-4">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {perks.map(({ icon: Icon, title, desc }) => (
              <div key={title} className="text-center">
                <div className="w-12 h-12 bg-dxn-gold/20 rounded-full flex items-center justify-center mx-auto mb-3">
                  <Icon className="text-dxn-darkgreen" size={22} />
                </div>
                <h3 className="font-bold text-dxn-darkgreen text-sm mb-1">{title}</h3>
                <p className="text-gray-600 text-xs leading-relaxed">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Steps */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-4xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-dxn-darkgreen">
              {lang === 'ar' ? 'كيف تبدأ — خطوة بخطوة' : 'How to Get Started — Step by Step'}
            </h2>
            <p className="text-gray-500 mt-2">
              {lang === 'ar' ? 'بسيط وسريع وبدون مفاجآت.' : 'Simple, fast, and no surprises.'}
            </p>
          </div>
          <div className="space-y-6">
            {steps.map(({ num, title, desc, tip }) => (
              <div key={num} className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex gap-6 items-start hover:shadow-md transition-shadow">
                <div className="w-14 h-14 bg-dxn-green rounded-2xl flex items-center justify-center shrink-0">
                  <span className="text-dxn-gold font-bold text-lg">{num}</span>
                </div>
                <div className="flex-1">
                  <h3 className="font-bold text-dxn-darkgreen text-lg mb-2">{title}</h3>
                  <p className="text-gray-600 leading-relaxed text-sm mb-3">{desc}</p>
                  <div className="inline-flex items-center gap-2 bg-green-50 text-dxn-green text-xs font-medium px-3 py-1 rounded-full">
                    <FiCheck size={12} /> {tip}
                  </div>
                </div>
              </div>
            ))}
          </div>
          <div className="text-center mt-10">
            <WhatsAppButton label={lang === 'ar' ? 'أنا مستعد للانضمام — تواصل معي' : "I'm Ready to Join — Contact Me"} />
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-20 bg-white">
        <div className="max-w-3xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-dxn-darkgreen">{t('faqTitle')}</h2>
            <p className="text-gray-500 mt-2">{t('faqSub')}</p>
          </div>
          <div className="space-y-4">
            {faqs.map(({ q, a }) => (
              <details key={q} className="group bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                <summary className="flex items-center justify-between p-5 cursor-pointer font-semibold text-dxn-darkgreen hover:bg-gray-100 transition-colors list-none">
                  <span>{q}</span>
                  <FiArrowRight className="shrink-0 group-open:rotate-90 transition-transform" size={16} />
                </summary>
                <div className="px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-200 pt-4">{a}</div>
              </details>
            ))}
          </div>
        </div>
      </section>

      {/* Final CTA */}
      <section className="bg-hero py-20">
        <div className="max-w-3xl mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">
            {lang === 'ar' ? 'خطوتك الأولى تبدأ هنا' : 'Your First Step Starts Here'}
          </h2>
          <p className="text-gray-300 mb-8">
            {lang === 'ar'
              ? 'لا تنتظر اللحظة المثالية. ابدأ اليوم وأنا سأكون معك في كل خطوة.'
              : "Don't wait for the perfect moment. Start today and I'll be with you every step of the way."}
          </p>
          <div className="flex flex-wrap gap-4 justify-center">
            <WhatsAppButton />
            <Link to="/zoom" className="btn-outline border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
              {lang === 'ar' ? 'احضر زووم أولاً' : 'Attend Zoom First'}
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
