import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { FiArrowLeft, FiClock, FiEye, FiUser } from 'react-icons/fi';

const DEMO_POSTS = {
  '10-benefits-ganoderma': {
    title: '10 Amazing Benefits of Ganoderma Lucidum',
    category: 'health', author: 'Grow with DXN', views: 1240,
    createdAt: '2026-02-15T10:00:00Z',
    tags: ['ganoderma', 'health', 'wellness'],
    content: `Ganoderma Lucidum, also known as Lingzhi or Reishi mushroom, has been used in traditional Chinese medicine for over 2,000 years. Here are 10 amazing benefits:

**1. Boosts Immune System**
Ganoderma contains beta-glucans that strengthen the immune system, helping your body fight infections and diseases more effectively.

**2. Reduces Fatigue & Stress**
Studies show that Ganoderma can reduce fatigue and improve quality of life. It acts as an adaptogen, helping the body cope with stress.

**3. Supports Heart Health**
Regular consumption may help lower blood pressure and cholesterol levels, supporting overall cardiovascular health.

**4. Anti-Inflammatory Properties**
The triterpenes in Ganoderma have powerful anti-inflammatory effects, which can help with joint pain and other inflammatory conditions.

**5. Improves Sleep Quality**
Traditional use of Ganoderma for insomnia is backed by modern research showing it can improve sleep duration and quality.

**6. Supports Liver Function**
Ganoderma has hepatoprotective properties that help detoxify and protect the liver from damage.

**7. Rich in Antioxidants**
The antioxidants in Ganoderma help fight free radicals, slowing down the aging process and protecting cells from damage.

**8. May Help Regulate Blood Sugar**
Some studies suggest Ganoderma can help maintain healthy blood sugar levels, beneficial for those managing diabetes.

**9. Enhances Brain Function**
Ganoderma may have neuroprotective effects, supporting cognitive function and memory.

**10. Promotes Overall Wellness**
As a whole-body tonic, Ganoderma supports multiple organ systems, promoting balance and vitality.

DXN's Reishi Gano (RG) capsules are one of the purest forms of Ganoderma extract available. Combined with DXN's Ganocelium (GL), you get a complete Ganoderma supplement for optimal health.`,
  },
  'start-dxn-business-2026': {
    title: 'How to Start Your DXN Business in 2026',
    category: 'business', author: 'Grow with DXN', views: 890,
    createdAt: '2026-02-20T10:00:00Z',
    tags: ['business', 'mlm', 'guide'],
    content: `Starting a DXN business is one of the most accessible ways to build a global income stream. Here's your complete guide:

**Step 1: Register as a DXN Member**
Visit your local DXN office or register online through your sponsor's referral link. The registration fee is minimal — typically under $20.

**Step 2: Try the Products**
Your personal experience is your best selling tool. Start using DXN products — especially the Lingzhi Coffee and Reishi Gano capsules. When you feel the benefits, sharing becomes natural.

**Step 3: Make a List of Contacts**
Write down everyone you know — friends, family, colleagues, social media contacts. These are your potential customers and team members.

**Step 4: Share, Don't Sell**
The key to DXN success is sharing your story. Tell people how the products helped you. Invite them to try. Don't pressure — let the products speak for themselves.

**Step 5: Build Your Online Presence**
Create social media accounts dedicated to your DXN business. Share health tips, product reviews, and success stories. Consistency is key.

**Step 6: Recruit & Train Your Team**
When people join through your referral link, support them. Help them get started, train them, and celebrate their wins. Your success depends on their success.

**Step 7: Stay Consistent**
The biggest secret to DXN success is consistency. Show up every day, share products, follow up with prospects, and never give up.

Remember: DXN has NO monthly purchase quota, so there's zero pressure. Work at your own pace and enjoy the journey!`,
  },
  'lingzhi-coffee-vs-regular': {
    title: 'DXN Lingzhi Coffee vs Regular Coffee',
    category: 'products', author: 'Grow with DXN', views: 2100,
    createdAt: '2026-03-01T10:00:00Z',
    tags: ['coffee', 'ganoderma', 'comparison'],
    content: `When it comes to your daily cup of coffee, DXN offers a healthier alternative. Let's compare:

**Regular Coffee:**
- Contains caffeine that can cause jitters
- May increase acidity in the stomach
- Can disrupt sleep patterns
- No added health benefits

**DXN Lingzhi Coffee:**
- Infused with Ganoderma extract
- Smoother caffeine effect — energy without jitters
- Alkaline properties balance stomach acidity
- Antioxidant-rich
- Supports immune system
- Available in multiple varieties (3-in-1, Black, Cappuccino)

**Why Millions Have Switched:**
DXN's Lingzhi Coffee gives you the best of both worlds — the taste and energy of coffee with the health benefits of Ganoderma. It's not just a beverage; it's a daily health supplement.

**Our Top Picks:**
1. Lingzhi Coffee 3-in-1 — Perfect for those who like creamy coffee
2. Lingzhi Black Coffee — For purists who want zero sugar and cream
3. Lingzhi Coffee 2-in-1 — With creamer but no sugar

Start your morning the healthy way with DXN Lingzhi Coffee!`,
  },
  'zero-to-diamond-journey': {
    title: 'From Zero to Diamond: My DXN Journey',
    category: 'success-stories', author: 'Grow with DXN', views: 3200,
    createdAt: '2026-03-05T10:00:00Z',
    tags: ['success', 'motivation', 'diamond'],
    content: `Three years ago, I had no experience in network marketing. Today, I'm a DXN Diamond distributor with a global team. Here's my story:

**The Beginning:**
I was introduced to DXN by a friend who offered me a cup of Lingzhi Coffee. I was skeptical at first, but after trying the products for a month, I noticed real improvements in my energy and health.

**The Decision:**
I realized that if the products worked this well for me, others would love them too. I registered as a distributor with just a small investment.

**The Struggle:**
The first 6 months were tough. I faced rejection, doubts, and slow progress. Many people said no. But I kept sharing, kept learning, and kept believing.

**The Breakthrough:**
After 8 months, something clicked. My consistent social media posts started attracting people. My first team member joined, then another, then another. Word of mouth spread.

**The Growth:**
By year two, I had over 100 people in my team across 5 countries. The beauty of DXN's one-world-one-market concept meant my business had no borders.

**Today:**
I earn a full-time passive income from DXN. My team continues to grow. I travel, I'm healthy, and I'm free. That's the DXN promise — health and wealth.

**My Advice to You:**
Start today. Don't wait for the perfect moment. Use the products, share your story, and be patient. Success in DXN is not a sprint — it's a marathon. But the finish line is worth every step.`,
  },
  '5-tips-grow-downline': {
    title: '5 Tips to Grow Your DXN Downline Fast',
    category: 'tips', author: 'Grow with DXN', views: 1750,
    createdAt: '2026-03-08T10:00:00Z',
    tags: ['tips', 'recruitment', 'downline'],
    content: `Building a strong downline is the key to long-term passive income in DXN. Here are 5 proven strategies:

**1. Use Social Media Daily**
Post about DXN products, health tips, and your personal results every day. Use Instagram Reels, Facebook Stories, and WhatsApp Status to reach more people.

**2. Share Your Personal Story**
People connect with stories, not sales pitches. Share how DXN products helped you or changed your life. Authenticity builds trust.

**3. Leverage Your Referral Link**
Your unique referral link is your most powerful tool. Share it in your bio, emails, WhatsApp messages, and everywhere you can.

**4. Host Online Presentations**
Organize Zoom or Google Meet sessions to present the DXN business opportunity. A 30-minute presentation can bring in multiple new members at once.

**5. Support Your Team**
The secret to a growing downline is helping your existing members succeed. When they grow, you grow. Train them, motivate them, and celebrate their achievements.

**Bonus Tip:** Focus on 3 people at a time. Help them get started, see their first results, and then move to the next 3. This focused approach creates momentum.

Remember — in DXN, your network is your net worth!`,
  },
  'spirulina-superfood': {
    title: 'Why Spirulina is a Superfood You Need',
    category: 'health', author: 'Grow with DXN', views: 980,
    createdAt: '2026-02-28T10:00:00Z',
    tags: ['spirulina', 'supplements', 'health'],
    content: `Spirulina is a blue-green algae that has been consumed for centuries and is now recognized as one of the most nutrient-dense foods on the planet.

**What Makes Spirulina Special?**
- 60-70% protein (more than meat, fish, or eggs)
- Rich in iron, calcium, and magnesium
- Contains all essential amino acids
- Loaded with antioxidants (phycocyanin)
- Excellent source of vitamins B1, B2, B3, and B6

**Health Benefits:**
1. Boosts energy levels naturally
2. Supports healthy immune function
3. Helps detoxify heavy metals from the body
4. May lower cholesterol and triglycerides
5. Anti-inflammatory and antioxidant effects
6. Supports gut health and digestion

**Why DXN Spirulina?**
DXN grows its own Spirulina on a 10-acre farm, ensuring the highest quality and purity. No chemical fertilizers, no artificial colors — just pure, organic Spirulina.

**How to Take It:**
Start with 2-3 tablets per day and gradually increase to 5-10 tablets. Take with meals for best absorption. Many people combine DXN Spirulina with Reishi Gano capsules for a complete health supplement regimen.

Add DXN Spirulina to your daily routine and feel the difference!`,
  },
  'cordyceps-energy-mushroom': {
    title: 'DXN Cordyceps: The Energy Mushroom Explained',
    category: 'health', author: 'Grow with DXN', views: 720,
    createdAt: '2026-03-02T10:00:00Z',
    tags: ['cordyceps', 'energy', 'supplements'],
    content: `Cordyceps is a unique medicinal mushroom that has been used in traditional Chinese and Tibetan medicine for centuries. Known as the "energy mushroom," it has gained worldwide attention for its incredible health benefits.

**What is Cordyceps?**
Cordyceps is a genus of parasitic fungi that grows on insect larvae in the wild. DXN cultivates Cordyceps in a controlled, hygienic environment — no insects involved — ensuring purity and potency.

**Top Benefits of Cordyceps:**

**1. Boosts Energy & Stamina**
Cordyceps increases the body's production of ATP (adenosine triphosphate), which is essential for delivering energy to muscles. Athletes around the world use it to enhance performance.

**2. Improves Respiratory Health**
Studies show Cordyceps can increase oxygen utilization, making it beneficial for people with asthma, bronchitis, or those who exercise at high altitudes.

**3. Supports Kidney Health**
In traditional Chinese medicine, Cordyceps is considered one of the best herbs for kidney health. Modern research supports its nephroprotective properties.

**4. Anti-Aging Properties**
Cordyceps contains powerful antioxidants that combat cellular aging. Elderly patients in studies showed improvements in energy, sleep, and memory after taking Cordyceps.

**5. Enhances Libido**
Cordyceps has been traditionally used as a natural aphrodisiac. Research suggests it may support reproductive health in both men and women.

**6. Supports Heart Health**
Cordyceps has been approved in China for treating arrhythmia (irregular heartbeat) and has shown promise in lowering LDL (bad) cholesterol.

**DXN Cordyceps Products:**
- DXN Cordyceps Capsules — Pure Cordyceps militaris extract
- DXN Cordyceps Coffee 3-in-1 — Your daily coffee with Cordyceps boost
- DXN Cordypine — Cordyceps with fermented pineapple juice

Add Cordyceps to your daily routine alongside Reishi Gano for a powerful health combination!`,
  },
  'passive-income-dxn': {
    title: 'How to Earn Passive Income with DXN',
    category: 'business', author: 'Grow with DXN', views: 1580,
    createdAt: '2026-02-25T10:00:00Z',
    tags: ['income', 'compensation', 'passive'],
    content: `One of the biggest attractions of the DXN business model is the potential for passive income. Here's how the DXN compensation plan works and how you can build wealth over time.

**Understanding the DXN Compensation Plan:**

**1. Direct Sales Profit (25-30%)**
Buy DXN products at distributor price and sell at retail price. The margin is typically 25-30%, giving you immediate profit on every sale.

**2. Group Bonus**
As your team grows, you earn bonuses based on the total sales volume (SV) of your entire group. The deeper and wider your network, the bigger this bonus becomes.

**3. Star Agent Bonus**
When you reach Star Agent rank, you qualify for additional bonuses — a percentage of the company's total sales in your country. This is where the real passive income begins.

**4. Leadership Bonus**
Diamond and above ranks earn leadership bonuses from multiple levels of their organization. This creates a truly passive income stream.

**5. Travel Incentives**
DXN offers luxury travel incentives for top performers — all-expenses-paid trips to international destinations.

**Why DXN's Plan is Different:**

**No Monthly Purchase Quota**
Unlike most MLM companies, DXN does NOT require you to buy products every month to stay active. This means zero pressure and zero wasted money.

**One World, One Market**
Your DXN business is global from day one. When someone joins through your link in another country, they're still in your team. No need for separate registrations.

**Lifetime Membership**
Once you register with DXN, you're a member for life. No annual renewals, no maintenance fees.

**How to Get Started:**
1. Register as a DXN distributor (small one-time fee)
2. Start using and sharing the products
3. Invite others to join your team
4. Train and support your team members
5. Watch your passive income grow month after month

The key is patience and consistency. Most successful DXN leaders took 2-3 years to build significant passive income. But once built, it keeps flowing.`,
  },
  'ganozhi-skincare-review': {
    title: 'DXN Ganozhi Skincare: A Complete Review',
    category: 'products', author: 'Grow with DXN', views: 1120,
    createdAt: '2026-02-18T10:00:00Z',
    tags: ['skincare', 'ganozhi', 'review'],
    content: `DXN's Ganozhi line brings the power of Ganoderma to your daily personal care routine. But are these products really worth it? Let's do an honest, comprehensive review.

**DXN Ganozhi Toothpaste**
- Contains Ganoderma extract and food gel base
- No saccharin, no artificial coloring
- Leaves mouth feeling clean and fresh
- Rating: 4.5/5 — A genuinely great toothpaste

**DXN Ganozhi Shampoo**
- Enriched with Ganoderma extract and Vitamin B5
- Gentle enough for daily use
- Helps with dandruff and itchy scalp
- Makes hair soft and manageable
- Rating: 4.3/5 — Noticeable difference after 2 weeks

**DXN Ganozhi Body Foam**
- Mild cleansing formula with Ganoderma
- Suitable for all skin types
- Pleasant, subtle fragrance
- Available in bottle or sachets (great for travel)
- Rating: 4.2/5 — Gentle and effective

**DXN Ganozhi Soap**
- Enriched with Ganoderma extract and palm oil
- Gentle on sensitive skin
- Helps with minor skin irritations
- Rating: 4.4/5 — Great value for quality

**DXN Ganozhi Plus Series (New!)**
The upgraded Ganozhi Plus line takes it further:
- Plus Shampoo — No SLES/SLS/Paraben, extra gentle
- Plus Body Foam — Added Vitamin E for skin nourishment
- Plus Toothpaste — Enhanced with Xylitol for oral health

**DXN Tea Tree Cream**
- Formulated with tea tree oil
- Great for pimples and mild skin irritation
- A small tube lasts a long time
- Rating: 4.6/5 — A must-have in your skincare kit

**The Verdict:**
DXN's personal care products are genuinely good. They're free from harsh chemicals, enriched with Ganoderma, and competitively priced. The Ganozhi Toothpaste and Tea Tree Cream are standout products that many users swear by.

If you're looking to switch to cleaner, mushroom-powered personal care, DXN's Ganozhi line is a solid choice.`,
  },
  'housewife-to-star-diamond': {
    title: 'From Housewife to Star Diamond: Aminah\'s Story',
    category: 'success-stories', author: 'Grow with DXN', views: 2450,
    createdAt: '2026-03-06T10:00:00Z',
    tags: ['success', 'women', 'inspiration'],
    content: `Aminah never imagined she would build an international business from her living room. As a stay-at-home mother of three in Malaysia, her world revolved around her family. Here's her inspiring journey from zero to Star Diamond.

**The Spark:**
In 2019, a neighbor invited Aminah to a DXN health talk. She was skeptical about "network marketing" but went for the free Lingzhi Coffee. That one cup changed everything.

**First Steps:**
After experiencing improved energy and better sleep from DXN products, Aminah registered as a distributor. Her husband was doubtful. "Just don't spend too much," he said.

**The Kitchen Table Strategy:**
Aminah didn't have a fancy office. She invited friends over for coffee — DXN Lingzhi Coffee. She'd share her health improvements while they sipped. One by one, friends started ordering products.

**Going Digital:**
When the pandemic hit in 2020, Aminah pivoted to social media. She started posting daily on Facebook and WhatsApp. Short videos about DXN products, her morning routine, health tips. Her audience grew from friends to strangers.

**Building the Team:**
By 2021, Aminah had 50 team members across Malaysia and Indonesia. She hosted weekly Zoom training sessions, always in her warm, motherly style. People loved her authenticity.

**The Breakthrough:**
In 2022, Aminah's team exploded to 500+ members across 8 countries. She reached Diamond rank and qualified for DXN's luxury travel incentive — an all-expenses-paid trip to Turkey.

**Star Diamond:**
By 2024, Aminah had over 2,000 members in her global network. She achieved Star Diamond rank, the highest tier in DXN. Her monthly passive income exceeded her husband's corporate salary.

**Her Advice:**
"I'm not special. I'm just a mother who believed in the products and never gave up. DXN gave me health, income, and freedom. If I can do it from my kitchen table, anyone can."

**Today:**
Aminah travels the world as a DXN speaker, inspiring thousands of women to start their own businesses. Her husband retired early to join her DXN journey full-time.`,
  },
  'morning-routine-dxn': {
    title: 'Morning Routine: Start Your Day the DXN Way',
    category: 'tips', author: 'Grow with DXN', views: 1340,
    createdAt: '2026-03-04T10:00:00Z',
    tags: ['routine', 'health', 'coffee'],
    content: `How you start your morning sets the tone for your entire day. Here's the perfect morning routine using DXN products to maximize your health, energy, and productivity.

**6:00 AM — Wake Up & Hydrate**
Start with a glass of warm water. Add a few drops of DXN Morinzhi (noni juice) for an alkalizing, detoxifying boost. This kickstarts your metabolism and flushes out toxins.

**6:15 AM — Supplements**
Take your daily DXN supplements on an empty stomach:
- 2 capsules of Reishi Gano (RG) — for immunity and overall wellness
- 2 capsules of Ganocelium (GL) — for cellular nourishment
- 3-5 Spirulina tablets — for vitamins, minerals, and energy

**6:30 AM — Morning Coffee**
Brew your DXN Lingzhi Coffee (choose your favorite variant):
- Lingzhi Black Coffee — if you like it strong and sugar-free
- Lingzhi 3-in-1 — if you prefer creamy and sweet
- Cordyceps Coffee — if you need extra energy for the day

Enjoy it mindfully. This is your daily dose of Ganoderma through a delicious cup of coffee.

**7:00 AM — Personal Care**
Shower with DXN Ganozhi Plus Body Foam and Shampoo. Brush your teeth with Ganozhi Toothpaste. These small switches replace chemical-laden products with Ganoderma-enriched alternatives.

**7:15 AM — Skincare**
Apply DXN Aloe V Moisturizer or Ganozhi E Series UV Defense Cream to protect your skin for the day.

**7:30 AM — Breakfast**
Have DXN Spirulina Cereal or Cordyceps Cereal for a nutritious, fiber-rich breakfast.

**Why This Routine Works:**
- You're nourishing your body with natural supplements
- Ganoderma supports your immune system all day
- No harsh chemicals touching your skin
- Sustained energy without the crash of regular coffee

**Pro Tips:**
- Keep your RG, GL, and Spirulina by your bedside so you never forget
- Prepare your Lingzhi Coffee the night before if you're short on time
- Share your routine on social media — it's great content for your DXN business!

Start tomorrow morning. Within a week, you'll feel the difference. Within a month, you won't go back.`,
  },
  'dxn-vs-other-mlm': {
    title: 'DXN vs Other MLM Companies: Why DXN Wins',
    category: 'business', author: 'Grow with DXN', views: 1890,
    createdAt: '2026-02-22T10:00:00Z',
    tags: ['mlm', 'comparison', 'business'],
    content: `With thousands of MLM companies out there, what makes DXN different? Let's do a fair, honest comparison.

**1. No Monthly Purchase Quota**
Most MLM companies require you to buy $100-$300 worth of products every month to stay "active" and earn commissions. DXN has ZERO monthly quota. Buy when you want, what you want. This alone saves distributors thousands of dollars per year.

**2. One World, One Market**
In most MLMs, if you want to operate in another country, you need a separate registration and separate business. With DXN, your one membership works globally. Sign up someone in Germany, Japan, or Nigeria — they're all in your team under one account.

**3. Lifetime Membership**
Many MLMs charge annual renewal fees or deactivate your account after inactivity. DXN membership is for life. Even if you take a break for years, your position and downline remain intact.

**4. Product Quality**
DXN owns its own farms, factories, and research facilities. From Ganoderma cultivation to final packaging, everything is done in-house. This vertical integration ensures quality control and keeps prices affordable. Most MLMs outsource manufacturing.

**5. Affordable Entry**
DXN registration typically costs $10-$25 (varies by country). Many MLMs require starter kits costing $100-$500+. Lower barrier means more people can join, which means faster team growth.

**6. Real, Consumable Products**
DXN's products are daily consumables — coffee, supplements, toothpaste, soap. People use them every day and reorder naturally. You're not selling luxury items people buy once and forget.

**7. 30+ Years in Business**
Founded in 1993 by Dato' Dr. Lim Siow Jin, DXN has been operating for over 30 years across 180+ countries. This stability gives you confidence that the company will be here for the long run.

**8. Simple Compensation Plan**
DXN's plan is straightforward — accumulate points (SV/PV) through personal sales and team sales, climb the ranks, earn bonuses. No confusing binary matrices or forced legs.

**The Honest Truth:**
No MLM is perfect, and success requires real effort. But DXN removes the financial pressure that causes most people to fail in network marketing. No quotas means no wasted money. Global membership means unlimited potential.

If you're going to choose an MLM, choose one that doesn't punish you for taking a month off. Choose DXN.`,
  },
};

export default function BlogPost() {
  const { slug } = useParams();
  const [post, setPost] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get(`/api/blog/${slug}`)
      .then((r) => setPost(r.data))
      .catch(() => {
        if (DEMO_POSTS[slug]) setPost({ slug, ...DEMO_POSTS[slug] });
      })
      .finally(() => setLoading(false));
  }, [slug]);

  const formatDate = (date) => new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

  if (loading) return (
    <div className="flex justify-center items-center min-h-screen">
      <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!post) return (
    <div className="flex flex-col items-center justify-center min-h-screen gap-4">
      <p className="text-xl text-gray-500">Article not found.</p>
      <Link to="/blog" className="btn-primary">Back to Blog</Link>
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-dxn-darkgreen py-16 px-4">
        <div className="max-w-3xl mx-auto">
          <div className="flex items-center gap-4 mb-6">
            <Link to="/blog" className="inline-flex items-center gap-2 text-green-300 hover:text-white text-sm">
              <FiArrowLeft /> Back to Blog
            </Link>
            <span className="inline-block bg-dxn-gold text-white text-xs px-3 py-1 rounded-full font-medium capitalize">
              {post.category?.replace('-', ' ')}
            </span>
          </div>
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">{post.title}</h1>
          <div className="flex flex-wrap items-center gap-4 text-gray-300 text-sm">
            <span className="flex items-center gap-1"><FiUser size={14} /> {post.author}</span>
            <span className="flex items-center gap-1"><FiClock size={14} /> {formatDate(post.createdAt)}</span>
            <span className="flex items-center gap-1"><FiEye size={14} /> {post.views} views</span>
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="max-w-3xl mx-auto px-4 py-12">
        <div className="bg-white rounded-2xl shadow-lg p-8 md:p-12">
          <div className="prose prose-lg max-w-none">
            {post.content?.split('\n\n').map((para, i) => {
              if (para.startsWith('**') && para.endsWith('**')) {
                return <h2 key={i} className="text-xl font-bold text-dxn-darkgreen mt-8 mb-3">{para.replace(/\*\*/g, '')}</h2>;
              }
              if (para.startsWith('**')) {
                const parts = para.split('**');
                return (
                  <div key={i} className="mb-4">
                    {parts.map((part, j) =>
                      j % 2 === 1 ? <strong key={j} className="text-dxn-darkgreen">{part}</strong> : <span key={j} className="text-gray-600 leading-relaxed">{part}</span>
                    )}
                  </div>
                );
              }
              if (para.match(/^\d+\./)) {
                return <p key={i} className="text-gray-600 leading-relaxed mb-3 pl-4">{para}</p>;
              }
              return <p key={i} className="text-gray-600 leading-relaxed mb-4">{para}</p>;
            })}
          </div>

          {/* Tags */}
          {post.tags?.length > 0 && (
            <div className="flex flex-wrap gap-2 mt-10 pt-6 border-t">
              {post.tags.map((tag) => (
                <span key={tag} className="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full">
                  #{tag}
                </span>
              ))}
            </div>
          )}
        </div>

        {/* CTA */}
        <div className="bg-dxn-green/10 border-2 border-dxn-green/20 rounded-2xl p-8 mt-8 text-center">
          <h3 className="text-xl font-bold text-dxn-darkgreen mb-2">Interested in DXN Products?</h3>
          <p className="text-gray-600 mb-4">Browse our product catalog or contact us to learn more.</p>
          <div className="flex gap-3 justify-center flex-wrap">
            <Link to="/products" className="btn-primary text-sm">Shop Products</Link>
            <Link to="/contact" className="btn-outline text-sm">Contact Us</Link>
          </div>
        </div>
      </div>
    </div>
  );
}
