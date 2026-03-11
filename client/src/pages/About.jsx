import { Link } from 'react-router-dom';
import { FiCheck, FiAward, FiUsers, FiGlobe, FiHeart } from 'react-icons/fi';
import { useLang } from '../context/LanguageContext';
import { WhatsAppButton } from '../components/WhatsAppFloat';

const VALUES_EN = [
  { icon: FiHeart, title: 'Health First', desc: 'We believe optimal health is everyone\'s right. DXN\'s Ganoderma products have helped millions worldwide live healthier, more energetic lives.' },
  { icon: FiUsers, title: 'Community & Support', desc: 'You\'re never alone in this journey. Our team supports every distributor from day one with training, mentorship, and community.' },
  { icon: FiGlobe, title: 'Global Opportunity', desc: 'DXN operates in 180+ countries. Your business has no borders — build a global team from the comfort of your home.' },
  { icon: FiAward, title: 'Proven Results', desc: '35+ years of excellence. DXN is one of the world\'s most trusted health and wellness companies, founded by Dr. Lim Siow Jin.' },
];

const VALUES_AR = [
  { icon: FiHeart, title: 'الصحة أولاً', desc: 'نؤمن بأن الصحة المثلى حق للجميع. ساعدت منتجات الغانودرما من DXN الملايين حول العالم على عيش حياة أكثر صحة ونشاطاً.' },
  { icon: FiUsers, title: 'المجتمع والدعم', desc: 'لست وحدك في هذه الرحلة. يدعم فريقنا كل موزع منذ اليوم الأول بالتدريب والإرشاد والمجتمع.' },
  { icon: FiGlobe, title: 'فرصة عالمية', desc: 'تعمل DXN في أكثر من 180 دولة. عملك لا حدود له — ابنِ فريقاً عالمياً من راحة منزلك.' },
  { icon: FiAward, title: 'نتائج مثبتة', desc: 'أكثر من 35 عاماً من التميز. DXN واحدة من أكثر شركات الصحة والعافية ثقةً في العالم، أسسها الدكتور ليم سيو جين.' },
];

const STORY_EN = [
  'I discovered DXN during a difficult time in my health journey. A friend recommended the Lingzhi Coffee, and within weeks, I felt a noticeable difference in my energy levels and overall wellbeing.',
  'What started as a personal health decision quickly became a passion for sharing. I registered as a distributor and began recommending DXN products to friends and family — not as a salesperson, but as someone who genuinely experienced the benefits.',
  'Over time, I built a team of like-minded people who wanted the same thing: better health and a smarter way to earn income. Today, I have team members across multiple countries, and the journey continues.',
  'My mission with this platform is simple: to help you discover the best of DXN — whether you\'re looking for premium health products, a flexible business opportunity, or both.',
];

const STORY_AR = [
  'اكتشفت DXN خلال فترة صعبة في رحلتي الصحية. أوصى بي صديق بقهوة ليندزهي، وفي غضون أسابيع، شعرت بفرق ملحوظ في مستويات طاقتي وصحتي العامة.',
  'ما بدأ كقرار صحي شخصي تحول بسرعة إلى شغف بالمشاركة. سجلت كموزع وبدأت أوصي بمنتجات DXN للأصدقاء والعائلة — ليس كبائع، بل كشخص يؤمن حقاً بفوائدها.',
  'مع مرور الوقت، بنيت فريقاً من الأشخاص المتشابهين في التفكير الذين يريدون نفس الشيء: صحة أفضل وطريقة أذكى لكسب الدخل. اليوم، لديّ أعضاء في فريقي في دول متعددة، والرحلة تتواصل.',
  'مهمتي من خلال هذه المنصة بسيطة: مساعدتك على اكتشاف أفضل ما تقدمه DXN — سواء كنت تبحث عن منتجات صحية متميزة أو فرصة عمل مرنة أو كليهما.',
];

const CREDENTIALS_EN = ['Certified DXN Independent Distributor', 'UAE-based, serving the Gulf region', 'Bilingual support — Arabic & English', 'Free Zoom training sessions every week', 'Personal guidance from registration to success'];
const CREDENTIALS_AR = ['موزع مستقل معتمد من DXN', 'مقيم في الإمارات، نخدم منطقة الخليج', 'دعم ثنائي اللغة — عربي وإنجليزي', 'جلسات تدريب زووم مجانية كل أسبوع', 'إرشاد شخصي من التسجيل حتى النجاح'];

export default function About() {
  const { t, lang } = useLang();
  const values = lang === 'ar' ? VALUES_AR : VALUES_EN;
  const story = lang === 'ar' ? STORY_AR : STORY_EN;
  const credentials = lang === 'ar' ? CREDENTIALS_AR : CREDENTIALS_EN;

  return (
    <div>
      {/* Header */}
      <div className="bg-dxn-darkgreen py-20 px-4 text-center relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: 'radial-gradient(circle at 70% 50%, #dfc378 0%, transparent 60%)' }} />
        <div className="relative max-w-3xl mx-auto">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
            {lang === 'ar' ? 'قصتنا' : 'Our Story'}
          </span>
          <h1 className="text-4xl md:text-5xl font-bold text-white mb-4">{t('aboutTitle')}</h1>
          <p className="text-gray-300 text-lg">{t('aboutSub')}</p>
        </div>
      </div>

      {/* Personal Story */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          {/* Avatar/Visual */}
          <div className="flex flex-col items-center gap-6">
            <div className="w-48 h-48 bg-gradient-to-br from-dxn-green to-dxn-darkgreen rounded-full flex items-center justify-center shadow-2xl">
              <div className="text-center text-white">
                <div className="text-5xl font-bold text-dxn-gold">DXN</div>
                <div className="text-sm text-green-200 mt-1">{lang === 'ar' ? 'موزع مستقل' : 'Independent Distributor'}</div>
              </div>
            </div>
            <div className="bg-gray-50 rounded-2xl p-6 w-full">
              <h3 className="font-bold text-dxn-darkgreen mb-4 text-lg">{lang === 'ar' ? 'بيانات الاعتماد' : 'Credentials'}</h3>
              <ul className="space-y-3">
                {credentials.map((c, i) => (
                  <li key={i} className="flex items-start gap-3">
                    <div className="w-5 h-5 bg-dxn-green rounded-full flex items-center justify-center shrink-0 mt-0.5">
                      <FiCheck className="text-white" size={11} />
                    </div>
                    <span className="text-gray-600 text-sm">{c}</span>
                  </li>
                ))}
              </ul>
            </div>
          </div>

          {/* Story Text */}
          <div>
            <span className="text-dxn-gold font-semibold text-sm uppercase tracking-widest">
              {lang === 'ar' ? 'كيف بدأ كل شيء' : 'How It All Started'}
            </span>
            <h2 className="text-3xl font-bold text-dxn-darkgreen mt-2 mb-6">
              {lang === 'ar' ? 'من تجربة شخصية إلى مهمة مشتركة' : 'From a Personal Experience to a Shared Mission'}
            </h2>
            <div className="space-y-4">
              {story.map((para, i) => (
                <p key={i} className="text-gray-600 leading-relaxed">{para}</p>
              ))}
            </div>
            <div className="flex flex-wrap gap-3 mt-8">
              <WhatsAppButton />
              <Link to="/join" className="btn-primary">{t('joinDistributor')}</Link>
            </div>
          </div>
        </div>
      </section>

      {/* Values */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-dxn-darkgreen">{lang === 'ar' ? 'ما الذي يميزنا' : 'What Sets Us Apart'}</h2>
            <p className="text-gray-500 mt-2">{lang === 'ar' ? 'نؤمن بالصحة والثروة والحرية للجميع.' : 'We believe in health, wealth, and freedom for everyone.'}</p>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {values.map(({ icon: Icon, title, desc }) => (
              <div key={title} className="card p-6 text-center hover:shadow-lg transition-shadow">
                <div className="w-14 h-14 bg-dxn-green/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                  <Icon className="text-dxn-green" size={26} />
                </div>
                <h3 className="font-bold text-dxn-darkgreen mb-2">{title}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* DXN Company Facts */}
      <section className="py-20 bg-dxn-green">
        <div className="max-w-6xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-white">{lang === 'ar' ? 'DXN بالأرقام' : 'DXN by the Numbers'}</h2>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {[
              { value: '1993', label: lang === 'ar' ? 'تأسست عام' : 'Founded' },
              { value: '180+', label: lang === 'ar' ? 'دولة' : 'Countries' },
              { value: '9M+', label: lang === 'ar' ? 'عضو' : 'Members' },
              { value: '1000+', label: lang === 'ar' ? 'منتج' : 'Products' },
            ].map(({ value, label }) => (
              <div key={label} className="text-center text-white">
                <div className="text-4xl font-bold text-dxn-gold mb-1">{value}</div>
                <div className="text-gray-300 text-sm">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-20 bg-white">
        <div className="max-w-3xl mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-dxn-darkgreen mb-4">
            {lang === 'ar' ? 'هل أنت مستعد للانضمام إلى عائلتنا؟' : 'Ready to Join Our Family?'}
          </h2>
          <p className="text-gray-600 mb-8">
            {lang === 'ar'
              ? 'سواء كنت تريد منتجات صحية أو فرصة عمل — أنا هنا لمساعدتك في كل خطوة.'
              : "Whether you want health products or a business opportunity — I'm here to help you every step of the way."}
          </p>
          <div className="flex flex-wrap gap-4 justify-center">
            <WhatsAppButton />
            <Link to="/zoom" className="btn-primary">{lang === 'ar' ? 'احضر زووم مجاني' : 'Attend Free Zoom'}</Link>
            <Link to="/join" className="btn-outline">{t('joinDistributor')}</Link>
          </div>
        </div>
      </section>
    </div>
  );
}
