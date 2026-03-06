import { Link } from 'react-router-dom';
import { FiCheck, FiArrowRight, FiDollarSign, FiUsers, FiTrendingUp, FiGlobe } from 'react-icons/fi';

const INCOME_LEVELS = [
  { rank: 'Distributor', requirement: 'Registration', bonus: 'Retail Profit', color: 'bg-gray-100 border-gray-300' },
  { rank: 'Star Agent', requirement: 'Group PV 100+', bonus: '10% Bonus', color: 'bg-blue-50 border-blue-300' },
  { rank: 'Agent', requirement: 'Group PV 300+', bonus: '15% Bonus', color: 'bg-green-50 border-green-300' },
  { rank: 'Star Ruby', requirement: 'Group PV 1000+', bonus: '18% Bonus', color: 'bg-red-50 border-red-300' },
  { rank: 'Ruby', requirement: 'Group PV 2000+', bonus: '21% Bonus', color: 'bg-red-100 border-red-400' },
  { rank: 'Diamond', requirement: 'Group PV 5000+', bonus: '25% Bonus + Royalty', color: 'bg-yellow-50 border-yellow-400' },
];

const HOW_IT_WORKS = [
  { step: '01', title: 'Register', desc: 'Sign up as a DXN member with a minimal one-time registration fee.' },
  { step: '02', title: 'Use Products', desc: 'Try the products yourself. Your experience is your best selling story.' },
  { step: '03', title: 'Share & Sell', desc: 'Share products with friends and family. Earn retail profits on every sale.' },
  { step: '04', title: 'Build a Team', desc: 'Refer others to join DXN using your referral link. Earn group bonuses.' },
  { step: '05', title: 'Grow & Earn', desc: 'As your network grows, your passive income grows with it. Work once, earn forever.' },
];

export default function Business() {
  return (
    <div>
      {/* Hero */}
      <section className="bg-hero py-20 px-4">
        <div className="max-w-4xl mx-auto text-center">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">Business Opportunity</span>
          <h1 className="text-4xl md:text-5xl font-bold text-white mb-6">Build Your Dream Business with DXN</h1>
          <p className="text-gray-300 text-lg mb-8">
            Join one of the world's fastest-growing network marketing companies. DXN offers a unique one-world, one-market business model that lets you earn globally.
          </p>
          <Link to="/register" className="btn-gold inline-flex items-center gap-2 text-lg">
            Start for Free <FiArrowRight />
          </Link>
        </div>
      </section>

      {/* Why DXN */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">Why DXN Business?</h2>
          <p className="section-subtitle">DXN is different from ordinary MLM companies. Here's why thousands choose DXN.</p>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { icon: FiDollarSign, title: 'Low Startup Cost', desc: 'Start with minimal investment. No expensive kits or inventory required.' },
              { icon: FiGlobe, title: 'Global Business', desc: 'One membership works in 180+ countries. Travel and earn anywhere.' },
              { icon: FiUsers, title: 'Strong Community', desc: 'Join a supportive network of 9 million+ distributors worldwide.' },
              { icon: FiTrendingUp, title: 'Multiple Income Streams', desc: 'Earn from retail profits, group bonuses, royalty income, and more.' },
            ].map(({ icon: Icon, title, desc }) => (
              <div key={title} className="card p-6 text-center">
                <div className="w-14 h-14 bg-dxn-green/10 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Icon className="text-dxn-green" size={24} />
                </div>
                <h3 className="font-bold text-dxn-darkgreen text-lg mb-2">{title}</h3>
                <p className="text-gray-600 text-sm">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-5xl mx-auto px-4">
          <h2 className="section-title">How It Works</h2>
          <p className="section-subtitle">5 simple steps to start your DXN business journey</p>
          <div className="relative">
            <div className="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-dxn-green/20 -translate-x-1/2" />
            {HOW_IT_WORKS.map((item, i) => (
              <div key={item.step} className={`flex items-start gap-6 mb-10 ${i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'}`}>
                <div className="flex-1 hidden md:block" />
                <div className="w-14 h-14 bg-dxn-green rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0 z-10 shadow-lg">
                  {item.step}
                </div>
                <div className="flex-1 card p-6">
                  <h3 className="font-bold text-dxn-darkgreen text-lg mb-2">{item.title}</h3>
                  <p className="text-gray-600">{item.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Income Plan */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4">
          <h2 className="section-title">Income & Rank Structure</h2>
          <p className="section-subtitle">The more you grow, the more you earn. DXN's compensation plan rewards your hard work.</p>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {INCOME_LEVELS.map(({ rank, requirement, bonus, color }) => (
              <div key={rank} className={`border-2 rounded-xl p-5 ${color}`}>
                <h3 className="font-bold text-dxn-darkgreen text-lg mb-1">{rank}</h3>
                <p className="text-sm text-gray-500 mb-2">{requirement}</p>
                <div className="flex items-center gap-2">
                  <FiCheck className="text-dxn-green" />
                  <span className="text-dxn-green font-semibold">{bonus}</span>
                </div>
              </div>
            ))}
          </div>
          <p className="text-center text-sm text-gray-400 mt-6">*PV = Point Value based on product purchases. Actual earnings may vary.</p>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-3xl mx-auto px-4">
          <h2 className="section-title">Frequently Asked Questions</h2>
          <div className="space-y-4 mt-8">
            {[
              { q: 'How much does it cost to join DXN?', a: 'DXN membership is very affordable. Registration is a one-time fee, typically under $20 in most countries. There are no monthly fees required.' },
              { q: 'Do I need to maintain a monthly quota?', a: 'No! DXN does not require monthly purchase quotas. You can work at your own pace, which makes it very flexible and low-risk.' },
              { q: 'Can I join DXN online?', a: 'Yes! You can register using your upline\'s referral link. After registration with DXN directly, contact us and we\'ll guide you through the process.' },
              { q: 'How do I get paid?', a: 'DXN pays bonuses monthly based on your group\'s total point value (PV). Payments are made directly to your bank account or through DXN\'s payment system.' },
              { q: 'Is this a scam or pyramid scheme?', a: 'No. DXN is a legitimate direct selling company with 35+ years of history, operating in 180+ countries. DXN focuses on real product sales, not recruitment fees.' },
            ].map(({ q, a }) => (
              <details key={q} className="card p-5 cursor-pointer group">
                <summary className="font-semibold text-dxn-darkgreen list-none flex justify-between items-center">
                  {q}
                  <span className="text-dxn-green group-open:rotate-180 transition-transform text-xl">+</span>
                </summary>
                <p className="text-gray-600 mt-3 text-sm leading-relaxed">{a}</p>
              </details>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="bg-hero py-16 px-4">
        <div className="max-w-2xl mx-auto text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Ready to Change Your Life?</h2>
          <p className="text-gray-300 mb-8">Sign up today and I'll personally guide you through your first steps as a DXN distributor.</p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/register" className="btn-gold">Join Now — It's Free</Link>
            <Link to="/contact" className="btn-outline border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all">
              Ask Me Anything
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
