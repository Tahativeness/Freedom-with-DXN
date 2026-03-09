import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { FiClock, FiEye, FiArrowRight } from 'react-icons/fi';

const CATEGORIES = ['all', 'health', 'business', 'products', 'success-stories', 'tips'];

const DEMO_POSTS = [
  {
    _id: 'p1', title: '10 Amazing Benefits of Ganoderma Lucidum', slug: '10-benefits-ganoderma',
    excerpt: 'Discover why Ganoderma (Lingzhi) has been called the "King of Herbs" for over 2000 years. From boosting immunity to improving sleep, the benefits are remarkable.',
    image: '', category: 'health', author: 'Grow with DXN', views: 1240,
    tags: ['ganoderma', 'health', 'wellness'], createdAt: '2026-02-15T10:00:00Z',
    content: 'Ganoderma Lucidum, also known as Lingzhi or Reishi mushroom, has been used in traditional Chinese medicine for over 2,000 years...',
  },
  {
    _id: 'p2', title: 'How to Start Your DXN Business in 2026', slug: 'start-dxn-business-2026',
    excerpt: 'A complete guide for beginners who want to start earning with DXN. Learn the steps, strategies, and tips to build a successful network marketing business.',
    image: '', category: 'business', author: 'Grow with DXN', views: 890,
    tags: ['business', 'mlm', 'guide'], createdAt: '2026-02-20T10:00:00Z',
    content: 'Starting a DXN business is one of the most accessible ways to build a global income stream...',
  },
  {
    _id: 'p3', title: 'DXN Lingzhi Coffee vs Regular Coffee', slug: 'lingzhi-coffee-vs-regular',
    excerpt: 'What makes DXN\'s Lingzhi Coffee different from your regular cup? Learn about the health benefits of Ganoderma-infused coffee and why millions have switched.',
    image: '', category: 'products', author: 'Grow with DXN', views: 2100,
    tags: ['coffee', 'ganoderma', 'comparison'], createdAt: '2026-03-01T10:00:00Z',
    content: 'When it comes to your daily cup of coffee, DXN offers a healthier alternative...',
  },
  {
    _id: 'p4', title: 'From Zero to Diamond: My DXN Journey', slug: 'zero-to-diamond-journey',
    excerpt: 'Read how one distributor went from zero network to Diamond rank in just 3 years. Real story, real results, real inspiration for your DXN business.',
    image: '', category: 'success-stories', author: 'Grow with DXN', views: 3200,
    tags: ['success', 'motivation', 'diamond'], createdAt: '2026-03-05T10:00:00Z',
    content: 'Three years ago, I had no experience in network marketing...',
  },
  {
    _id: 'p5', title: '5 Tips to Grow Your DXN Downline Fast', slug: '5-tips-grow-downline',
    excerpt: 'Struggling to recruit new members? These 5 proven strategies will help you build your DXN downline faster using social media, referrals, and personal branding.',
    image: '', category: 'tips', author: 'Grow with DXN', views: 1750,
    tags: ['tips', 'recruitment', 'downline'], createdAt: '2026-03-08T10:00:00Z',
    content: 'Building a strong downline is the key to long-term passive income in DXN...',
  },
  {
    _id: 'p6', title: 'Why Spirulina is a Superfood You Need', slug: 'spirulina-superfood',
    excerpt: 'Spirulina is packed with protein, vitamins, and antioxidants. Learn why DXN\'s Spirulina tablets are one of the most popular health supplements in the world.',
    image: '', category: 'health', author: 'Grow with DXN', views: 980,
    tags: ['spirulina', 'supplements', 'health'], createdAt: '2026-02-28T10:00:00Z',
    content: 'Spirulina is a blue-green algae that has been consumed for centuries...',
  },
];

export default function Blog() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [category, setCategory] = useState('all');

  useEffect(() => {
    fetchPosts();
  }, [category]);

  const fetchPosts = async () => {
    setLoading(true);
    try {
      const params = {};
      if (category !== 'all') params.category = category;
      const { data } = await axios.get('/api/blog', { params });
      setPosts(data.posts?.length > 0 ? data.posts : filterDemoPosts());
    } catch {
      setPosts(filterDemoPosts());
    } finally {
      setLoading(false);
    }
  };

  const filterDemoPosts = () =>
    category === 'all' ? DEMO_POSTS : DEMO_POSTS.filter((p) => p.category === category);

  const formatDate = (date) => new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-dxn-darkgreen py-16 px-4">
        <div className="max-w-4xl mx-auto text-center">
          <span className="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">Blog & Articles</span>
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-3">Health & Business Insights</h1>
          <p className="text-gray-300 max-w-2xl mx-auto">Tips, guides, and stories to help you grow your health and your DXN business</p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-10">
        {/* Category Filter */}
        <div className="flex items-center gap-2 overflow-x-auto pb-2 mb-8">
          {CATEGORIES.map((cat) => (
            <button
              key={cat}
              onClick={() => setCategory(cat)}
              className={`px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors capitalize ${
                category === cat ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border'
              }`}
            >
              {cat.replace('-', ' ')}
            </button>
          ))}
        </div>

        {/* Posts Grid */}
        {loading ? (
          <div className="flex justify-center py-20">
            <div className="w-12 h-12 border-4 border-dxn-green border-t-transparent rounded-full animate-spin" />
          </div>
        ) : posts.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {posts.map((post) => (
              <Link to={`/blog/${post.slug}`} key={post._id} className="card group overflow-hidden flex flex-col">
                {/* Image */}
                <div className="bg-gradient-to-br from-dxn-green to-dxn-darkgreen h-48 flex items-center justify-center relative overflow-hidden">
                  {post.image ? (
                    <img src={post.image} alt={post.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                  ) : (
                    <div className="text-center p-6">
                      <div className="text-dxn-gold text-4xl font-bold mb-1">DXN</div>
                      <div className="text-green-200 text-xs uppercase tracking-widest">{post.category.replace('-', ' ')}</div>
                    </div>
                  )}
                  <span className="absolute top-3 left-3 bg-dxn-gold text-white text-xs px-2 py-1 rounded-full font-medium capitalize">
                    {post.category.replace('-', ' ')}
                  </span>
                </div>

                {/* Content */}
                <div className="p-5 flex flex-col flex-1">
                  <div className="flex items-center gap-3 text-xs text-gray-400 mb-3">
                    <span className="flex items-center gap-1"><FiClock size={12} /> {formatDate(post.createdAt)}</span>
                    <span className="flex items-center gap-1"><FiEye size={12} /> {post.views} views</span>
                  </div>
                  <h2 className="font-bold text-dxn-darkgreen text-lg mb-2 group-hover:text-dxn-green transition-colors line-clamp-2">
                    {post.title}
                  </h2>
                  <p className="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">{post.excerpt}</p>
                  <div className="flex items-center gap-1 text-dxn-green text-sm font-semibold group-hover:gap-2 transition-all">
                    Read More <FiArrowRight size={14} />
                  </div>
                </div>
              </Link>
            ))}
          </div>
        ) : (
          <div className="text-center py-20 text-gray-500">
            <p className="text-xl">No articles found in this category</p>
          </div>
        )}
      </div>

      {/* CTA */}
      <section className="bg-hero py-16 px-4">
        <div className="max-w-2xl mx-auto text-center">
          <h2 className="text-2xl font-bold text-white mb-4">Want to Write for Us?</h2>
          <p className="text-gray-300 mb-6">Share your DXN success story or health tips with our growing community.</p>
          <Link to="/contact" className="btn-gold">Contact Us</Link>
        </div>
      </section>
    </div>
  );
}
