const express = require('express');
const router = express.Router();
const Blog = require('../models/Blog');
const { authMiddleware, adminMiddleware } = require('../middleware/auth');

// GET /api/blog - get all published posts
router.get('/', async (req, res) => {
  try {
    const { category, page = 1, limit = 9 } = req.query;
    const query = { published: true };
    if (category) query.category = category;

    const skip = (page - 1) * limit;
    const [posts, total] = await Promise.all([
      Blog.find(query).skip(skip).limit(Number(limit)).sort({ createdAt: -1 }),
      Blog.countDocuments(query),
    ]);

    res.json({ posts, total, pages: Math.ceil(total / limit), currentPage: Number(page) });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// GET /api/blog/:slug - get single post
router.get('/:slug', async (req, res) => {
  try {
    const post = await Blog.findOneAndUpdate(
      { slug: req.params.slug, published: true },
      { $inc: { views: 1 } },
      { new: true }
    );
    if (!post) return res.status(404).json({ message: 'Post not found' });
    res.json(post);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// POST /api/blog (admin)
router.post('/', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    const slug = req.body.title
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
    const post = await Blog.create({ ...req.body, slug });
    res.status(201).json(post);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// PUT /api/blog/:id (admin)
router.put('/:id', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    const post = await Blog.findByIdAndUpdate(req.params.id, req.body, { new: true });
    res.json(post);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// DELETE /api/blog/:id (admin)
router.delete('/:id', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    await Blog.findByIdAndDelete(req.params.id);
    res.json({ message: 'Post deleted' });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

module.exports = router;
