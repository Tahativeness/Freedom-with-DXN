const Product = require('../models/Product');
const { scrapeAllProducts } = require('../scraper/dxnScraper');

// GET /api/products
const getProducts = async (req, res) => {
  try {
    const { category, featured, search, page = 1, limit = 12 } = req.query;
    const query = {};
    if (category) query.category = category;
    if (featured) query.featured = true;
    if (search) query.name = { $regex: search, $options: 'i' };

    const skip = (page - 1) * limit;
    const [products, total] = await Promise.all([
      Product.find(query).skip(skip).limit(Number(limit)).sort({ createdAt: -1 }),
      Product.countDocuments(query),
    ]);

    res.json({ products, total, pages: Math.ceil(total / limit), currentPage: Number(page) });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// GET /api/products/:id
const getProduct = async (req, res) => {
  try {
    const product = await Product.findById(req.params.id);
    if (!product) return res.status(404).json({ message: 'Product not found' });
    res.json(product);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// POST /api/products (admin)
const createProduct = async (req, res) => {
  try {
    const product = await Product.create(req.body);
    res.status(201).json(product);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// PUT /api/products/:id (admin)
const updateProduct = async (req, res) => {
  try {
    const product = await Product.findByIdAndUpdate(req.params.id, req.body, { new: true });
    if (!product) return res.status(404).json({ message: 'Product not found' });
    res.json(product);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// DELETE /api/products/:id (admin)
const deleteProduct = async (req, res) => {
  try {
    await Product.findByIdAndDelete(req.params.id);
    res.json({ message: 'Product deleted' });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// POST /api/products/:id/review
const addReview = async (req, res) => {
  try {
    const { rating, comment } = req.body;
    const product = await Product.findById(req.params.id);
    if (!product) return res.status(404).json({ message: 'Product not found' });

    product.reviews.push({ user: req.user.id, name: req.body.name, rating, comment });
    product.rating = product.reviews.reduce((acc, r) => acc + r.rating, 0) / product.reviews.length;
    await product.save();
    res.json(product);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// GET /api/products/scrape (admin) - Scrape DXN products and save to DB
const scrapeProducts = async (req, res) => {
  try {
    const scrapedProducts = await scrapeAllProducts();

    let created = 0;
    let updated = 0;

    for (const p of scrapedProducts) {
      const existing = await Product.findOne({ sku: p.sku });
      if (existing) {
        // Update image and name but keep any manual edits to price/description
        existing.name = p.name;
        existing.image = p.image;
        existing.category = p.category;
        existing.dxnId = p.dxnId || '';
        existing.sourceUrl = p.sourceUrl || '';
        existing.dxnCategory = p.dxnCategory || '';
        if (!existing.description || existing.description.includes('premium DXN')) {
          existing.description = p.description;
        }
        await existing.save();
        updated++;
      } else {
        await Product.create({
          name: p.name,
          description: p.description,
          price: p.price,
          category: p.category,
          image: p.image,
          sku: p.sku,
          benefits: p.benefits,
          inStock: p.inStock,
          featured: p.featured,
          rating: p.rating,
          dxnId: p.dxnId || '',
          sourceUrl: p.sourceUrl || '',
          dxnCategory: p.dxnCategory || '',
        });
        created++;
      }
    }

    res.json({
      message: `Scrape complete! ${created} new products added, ${updated} existing products updated.`,
      total: scrapedProducts.length,
      created,
      updated,
    });
  } catch (err) {
    console.error('Scrape error:', err);
    res.status(500).json({ message: 'Scrape failed: ' + err.message });
  }
};

module.exports = { getProducts, getProduct, createProduct, updateProduct, deleteProduct, addReview, scrapeProducts };
