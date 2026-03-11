const mongoose = require('mongoose');

const blogSchema = new mongoose.Schema(
  {
    title: { type: String, required: true, trim: true },
    slug: { type: String, required: true, unique: true, lowercase: true },
    content: { type: String, required: true },
    excerpt: { type: String, required: true },
    image: { type: String, default: '' },
    category: {
      type: String,
      enum: ['health', 'business', 'products', 'success-stories', 'tips'],
      default: 'health',
    },
    author: { type: String, default: 'Grow with DXN' },
    tags: [{ type: String }],
    published: { type: Boolean, default: true },
    views: { type: Number, default: 0 },
  },
  { timestamps: true }
);

module.exports = mongoose.model('Blog', blogSchema);
