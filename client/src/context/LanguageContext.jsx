import { createContext, useContext, useState, useEffect } from 'react';

const translations = {
  en: {
    // Nav
    home: 'Home', about: 'About', products: 'Products', business: 'Business',
    joinDxn: 'Join DXN', zoom: 'Zoom Training', blog: 'Blog', contact: 'Contact',
    login: 'Login', joinNow: 'Join Now',
    // Common
    shopProducts: 'Shop Products', learnMore: 'Learn More', contactUs: 'Contact Us',
    readMore: 'Read More', viewAll: 'View All Products',
    whatsappUs: 'WhatsApp Us', joinDistributor: 'Join as Distributor',
    // Home hero
    heroTitle: 'Grow Your Health & Wealth with DXN',
    heroSub: 'Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life.',
    heroBtn1: 'Shop Products', heroBtn2: 'Attend Free Zoom',
    // Sections
    whyJoinTitle: 'Why Join DXN as a Distributor?',
    successStories: 'Success Stories', latestBlog: 'Latest from Our Blog',
    readyTitle: 'Ready to Start Your DXN Journey?',
    readySub: 'Join our growing family of distributors and start building your health and wealth today.',
    // About
    aboutTitle: 'About Us', aboutSub: 'Real people, real health, real income.',
    // Join
    joinTitle: 'Join DXN Today', joinSub: 'Start your journey to health and financial freedom.',
    // Zoom
    zoomTitle: 'Free Zoom Training Sessions', zoomSub: 'Learn about DXN products, the business opportunity, and how to get started — live, every week.',
    // Contact
    contactTitle: 'Get In Touch', contactSub: "I'm here to answer your questions about DXN products or the business opportunity.",
    whatsappDirect: 'Chat on WhatsApp',
    // FAQ
    faqTitle: 'Frequently Asked Questions', faqSub: 'Honest answers to common questions about DXN.',
  },
  ar: {
    // Nav
    home: 'الرئيسية', about: 'من نحن', products: 'المنتجات', business: 'الأعمال',
    joinDxn: 'انضم إلى DXN', zoom: 'تدريب زووم', blog: 'المدونة', contact: 'تواصل معنا',
    login: 'تسجيل الدخول', joinNow: 'انضم الآن',
    // Common
    shopProducts: 'تسوق الآن', learnMore: 'اعرف المزيد', contactUs: 'تواصل معنا',
    readMore: 'اقرأ المزيد', viewAll: 'عرض جميع المنتجات',
    whatsappUs: 'تواصل عبر واتساب', joinDistributor: 'انضم كموزع',
    // Home hero
    heroTitle: 'نمّ صحتك وثروتك مع DXN',
    heroSub: 'اكتشف منتجات الغانودرما المتميزة التي تحوّل صحتك، وفرصة عمل تحوّل حياتك.',
    heroBtn1: 'تسوق الآن', heroBtn2: 'احضر زووم مجاني',
    // Sections
    whyJoinTitle: 'لماذا تنضم إلى DXN كموزع؟',
    successStories: 'قصص النجاح', latestBlog: 'أحدث المقالات',
    readyTitle: 'هل أنت مستعد لبدء رحلتك مع DXN؟',
    readySub: 'انضم إلى عائلتنا المتنامية من الموزعين وابدأ في بناء صحتك وثروتك اليوم.',
    // About
    aboutTitle: 'من نحن', aboutSub: 'أشخاص حقيقيون، صحة حقيقية، دخل حقيقي.',
    // Join
    joinTitle: 'انضم إلى DXN اليوم', joinSub: 'ابدأ رحلتك نحو الصحة والحرية المالية.',
    // Zoom
    zoomTitle: 'جلسات تدريب زووم المجانية', zoomSub: 'تعرف على منتجات DXN وفرصة العمل وكيفية البدء — مباشرةً، كل أسبوع.',
    // Contact
    contactTitle: 'تواصل معنا', contactSub: 'أنا هنا للإجابة على أسئلتك حول منتجات DXN أو فرصة العمل.',
    whatsappDirect: 'تحدث عبر واتساب',
    // FAQ
    faqTitle: 'الأسئلة الشائعة', faqSub: 'إجابات صادقة على الأسئلة الشائعة حول DXN.',
  },
};

const LanguageContext = createContext(null);

export function LanguageProvider({ children }) {
  const [lang, setLang] = useState(() => localStorage.getItem('dxn-lang') || 'en');

  useEffect(() => {
    localStorage.setItem('dxn-lang', lang);
    document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
    document.documentElement.lang = lang;
  }, [lang]);

  const t = (key) => translations[lang][key] || translations['en'][key] || key;
  const isRtl = lang === 'ar';

  return (
    <LanguageContext.Provider value={{ lang, setLang, t, isRtl }}>
      {children}
    </LanguageContext.Provider>
  );
}

export const useLang = () => useContext(LanguageContext);
