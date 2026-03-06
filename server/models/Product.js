const mongoose = require('mongoose');

const productSchema = new mongoose.Schema(
  {
    name: { type: String, required: true, trim: true },
    description: { type: String, required: true },
    price: { type: Number, required: true },
    category: {
      type: String,
      enum: ['coffee', 'ganoderma', 'supplements', 'skincare', 'beverages', 'other'],
      required: true,
    },
    image: { type: String, default: '' },
    images: [{ type: String }],
    inStock: { type: Boolean, default: true },
    stockCount: { type: Number, default: 0 },
    sku: { type: String, unique: true },
    benefits: [{ type: String }],
    ingredients: { type: String },
    usage: { type: String },
    featured: { type: Boolean, default: false },
    rating: { type: Number, default: 0 },
    reviews: [
      {
        user: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
        name: String,
        rating: Number,
        comment: String,
        createdAt: { type: Date, default: Date.now },
      },
    ],
  },
  { timestamps: true }
);

module.exports = mongoose.model('Product', productSchema);
