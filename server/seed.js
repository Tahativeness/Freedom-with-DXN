const mongoose = require('mongoose');
const dotenv = require('dotenv');
dotenv.config();

const Product = require('./models/Product');

const products = [
  // COFFEE
  { name: 'Lingzhi Coffee 3 in 1', sku: 'DXN-COF-001', category: 'coffee', price: 24.99, rating: 4.8, featured: true, inStock: true, description: 'A perfect blend of finest quality instant coffee, creamer, sugar and Ganoderma Lucidum extract. Enjoy the smooth, rich taste with health benefits of Reishi mushroom.', benefits: ['Boosts energy naturally', 'Supports immune system', 'Rich antioxidant content', 'Smooth taste without jitters'] },
  { name: 'Lingzhi Black Coffee', sku: 'DXN-COF-002', category: 'coffee', price: 21.99, rating: 4.7, featured: false, inStock: true, description: 'Premium black coffee enriched with Ganoderma Lucidum extract. Zero sugar, zero creamer — just pure coffee goodness with the power of Reishi mushroom.', benefits: ['Zero sugar and creamer', 'Rich in antioxidants', 'Supports metabolism', 'Pure coffee taste'] },
  { name: 'Lingzhi Coffee 2 in 1', sku: 'DXN-COF-003', category: 'coffee', price: 22.99, rating: 4.6, featured: false, inStock: true, description: 'Instant coffee with creamer and Ganoderma Lucidum extract. Sugar-free option for health-conscious coffee lovers.', benefits: ['Sugar-free formula', 'Smooth creamy taste', 'Ganoderma enriched', 'Convenient sachets'] },
  { name: 'White Coffee Zhino', sku: 'DXN-COF-004', category: 'coffee', price: 26.99, rating: 4.5, featured: false, inStock: true, description: 'DXN White Coffee Zhino combines premium white coffee beans with Ganoderma extract for a smooth, aromatic cup with health benefits.', benefits: ['Premium white coffee beans', 'Smooth aromatic flavor', 'Ganoderma enriched', 'Lower acidity'] },
  { name: 'Lingzhi Coffee 3 in 1 Lite', sku: 'DXN-COF-005', category: 'coffee', price: 23.99, rating: 4.6, featured: false, inStock: true, description: 'A lighter version of the classic Lingzhi Coffee 3 in 1 with less sugar, enriched with Ganoderma Lucidum extract.', benefits: ['Less sugar formula', 'Great taste maintained', 'Ganoderma benefits', 'Perfect daily coffee'] },

  // GANODERMA
  { name: 'Reishi Gano (RG)', sku: 'DXN-GAN-001', category: 'ganoderma', price: 38.99, rating: 4.9, featured: true, inStock: true, description: 'Premium Ganoderma Lucidum extract from the 90-day old red mushroom. RG contains a high concentration of polysaccharides and triterpenes for maximum health benefits.', benefits: ['Boosts immune system', 'Powerful antioxidant', 'Supports liver health', 'Promotes overall wellness'] },
  { name: 'Ganocelium (GL)', sku: 'DXN-GAN-002', category: 'ganoderma', price: 36.99, rating: 4.8, featured: true, inStock: true, description: 'Ganocelium is derived from the 18-day old mycelium of Ganoderma Lucidum. Rich in organic germanium and polysaccharides for cellular health.', benefits: ['Rich in organic germanium', 'Supports cellular health', 'Enhances nutrient absorption', 'Complements RG capsules'] },
  { name: 'RG-GL Pack', sku: 'DXN-GAN-003', category: 'ganoderma', price: 68.99, rating: 4.9, featured: true, inStock: true, description: 'The complete Ganoderma supplement pack combining Reishi Gano (RG) and Ganocelium (GL) for comprehensive health support.', benefits: ['Complete Ganoderma nutrition', 'Synergistic formula', 'Maximum health benefits', 'Best value combo'] },
  { name: 'Ganoderma Lucidum Powder', sku: 'DXN-GAN-004', category: 'ganoderma', price: 42.99, rating: 4.7, featured: false, inStock: true, description: 'Pure Ganoderma Lucidum in powder form. Versatile supplement that can be mixed with water, juice, or added to food.', benefits: ['Pure Ganoderma powder', 'Versatile usage', 'Easy to mix', 'High potency'] },

  // SUPPLEMENTS
  { name: 'Spirulina Tablet', sku: 'DXN-SUP-001', category: 'supplements', price: 29.99, rating: 4.6, featured: true, inStock: true, description: 'DXN Spirulina tablets made from 100% pure Spirulina. Rich in protein, vitamins, minerals and essential amino acids for complete nutrition.', benefits: ['Complete protein source', 'Rich in vitamins & minerals', '100% pure Spirulina', 'Supports energy levels'] },
  { name: 'Spirulina Capsule', sku: 'DXN-SUP-002', category: 'supplements', price: 32.99, rating: 4.7, featured: false, inStock: true, description: 'Convenient capsule form of DXN pure Spirulina. Easy to swallow with all the nutritional benefits of Spirulina.', benefits: ['Easy to swallow capsules', 'Complete nutrition', 'Rich in chlorophyll', 'Boosts immunity'] },
  { name: 'Myco Vege', sku: 'DXN-SUP-003', category: 'supplements', price: 34.99, rating: 4.8, featured: false, inStock: true, description: 'A unique blend of mushroom and vegetable extracts. Contains a variety of beneficial mushrooms combined with nutrient-rich vegetables.', benefits: ['Mushroom & vegetable blend', 'Rich in nutrients', 'Supports digestive health', 'Plant-based nutrition'] },
  { name: 'Lion Mane Tablet', sku: 'DXN-SUP-004', category: 'supplements', price: 35.99, rating: 4.7, featured: false, inStock: true, description: 'DXN Lion Mane tablet made from Hericium Erinaceus mushroom. Known for supporting brain function and cognitive health.', benefits: ['Supports brain function', 'Enhances memory', 'Nerve growth support', 'Cognitive health'] },
  { name: 'Cordyceps Tablet', sku: 'DXN-SUP-005', category: 'supplements', price: 39.99, rating: 4.8, featured: false, inStock: true, description: 'Premium Cordyceps sinensis supplement. Traditionally used to boost energy, stamina, and respiratory health.', benefits: ['Boosts energy & stamina', 'Supports respiratory health', 'Enhances athletic performance', 'Traditional Chinese remedy'] },
  { name: 'Roselle Tablet', sku: 'DXN-SUP-006', category: 'supplements', price: 24.99, rating: 4.5, featured: false, inStock: true, description: 'Made from Hibiscus sabdariffa (Roselle). Rich in vitamin C and antioxidants, supports healthy blood pressure.', benefits: ['Rich in Vitamin C', 'Powerful antioxidant', 'Supports heart health', 'Natural and pure'] },
  { name: 'Bee Pollen', sku: 'DXN-SUP-007', category: 'supplements', price: 27.99, rating: 4.6, featured: false, inStock: true, description: 'Natural bee pollen collected from pristine environments. A superfood packed with vitamins, minerals, and amino acids.', benefits: ['Natural superfood', 'Rich in B vitamins', 'Supports energy', 'Boosts immunity'] },

  // SKINCARE
  { name: 'Ganozhi Shampoo', sku: 'DXN-SKN-001', category: 'skincare', price: 16.99, rating: 4.5, featured: false, inStock: true, description: 'Gentle shampoo enriched with Ganoderma extract. Cleanses and nourishes hair while promoting scalp health.', benefits: ['Ganoderma enriched', 'Gentle cleansing', 'Promotes scalp health', 'Silky smooth hair'] },
  { name: 'Ganozhi Body Foam', sku: 'DXN-SKN-002', category: 'skincare', price: 14.99, rating: 4.4, featured: false, inStock: true, description: 'Luxurious body foam with Ganoderma extract. Gently cleanses while moisturizing and nourishing the skin.', benefits: ['Moisturizing formula', 'Ganoderma enriched', 'Gentle on skin', 'Fresh fragrance'] },
  { name: 'Gano Massage Oil', sku: 'DXN-SKN-003', category: 'skincare', price: 19.99, rating: 4.7, featured: false, inStock: true, description: 'Relaxing massage oil infused with Ganoderma extract. Perfect for soothing tired muscles and nourishing the skin.', benefits: ['Ganoderma infused', 'Soothes tired muscles', 'Nourishes skin', 'Relaxing aromatherapy'] },
  { name: 'Ganozhi Soap', sku: 'DXN-SKN-004', category: 'skincare', price: 8.99, rating: 4.3, featured: false, inStock: true, description: 'Natural soap bar enriched with Ganoderma Lucidum extract. Gentle daily cleansing with health benefits for your skin.', benefits: ['Natural ingredients', 'Ganoderma enriched', 'Gentle cleansing', 'Suitable for all skin types'] },
  { name: 'Aloe V Moisturizing Cream', sku: 'DXN-SKN-005', category: 'skincare', price: 22.99, rating: 4.6, featured: false, inStock: true, description: 'Moisturizing cream combining Aloe Vera and Ganoderma extract. Deeply hydrates and protects the skin.', benefits: ['Deep hydration', 'Aloe Vera + Ganoderma', 'Protects skin barrier', 'Non-greasy formula'] },

  // BEVERAGES
  { name: 'DXN Cocozhi', sku: 'DXN-BEV-001', category: 'beverages', price: 22.99, rating: 4.5, featured: false, inStock: true, description: 'Delicious chocolate drink enriched with Ganoderma Lucidum extract. A healthy alternative to regular cocoa drinks.', benefits: ['Rich chocolate taste', 'Ganoderma enriched', 'Great for kids & adults', 'Healthy alternative'] },
  { name: 'Spica Tea', sku: 'DXN-BEV-002', category: 'beverages', price: 18.99, rating: 4.4, featured: false, inStock: true, description: 'Herbal tea blend with a refreshing taste. A caffeine-free option for those who prefer tea over coffee.', benefits: ['Caffeine-free herbal tea', 'Refreshing taste', 'Natural ingredients', 'Relaxing beverage'] },
  { name: 'Vinaigrette', sku: 'DXN-BEV-003', category: 'beverages', price: 15.99, rating: 4.3, featured: false, inStock: true, description: 'DXN fruit vinegar drink made from natural fruits. A refreshing health drink rich in natural enzymes.', benefits: ['Natural fruit vinegar', 'Rich in enzymes', 'Supports digestion', 'Refreshing taste'] },
  { name: 'Morinzhi Juice', sku: 'DXN-BEV-004', category: 'beverages', price: 28.99, rating: 4.6, featured: false, inStock: true, description: 'Premium Noni (Morinda citrifolia) juice enriched with Roselle. A powerful antioxidant health drink.', benefits: ['Noni fruit juice', 'Rich in antioxidants', 'Supports immune system', 'Natural health tonic'] },
  { name: 'Zhi Mocha', sku: 'DXN-BEV-005', category: 'beverages', price: 25.99, rating: 4.5, featured: false, inStock: true, description: 'A perfect blend of coffee, chocolate and Ganoderma Lucidum extract. The best of both worlds for mocha lovers.', benefits: ['Coffee meets chocolate', 'Ganoderma enriched', 'Rich mocha flavor', 'Convenient sachets'] },

  // OTHER
  { name: 'Ganozhi Toothpaste', sku: 'DXN-OTH-001', category: 'other', price: 12.99, rating: 4.4, featured: false, inStock: true, description: 'Toothpaste enriched with Ganoderma Lucidum extract and food grade gel. Provides complete oral care with natural ingredients.', benefits: ['Ganoderma enriched', 'No harmful chemicals', 'Freshens breath', 'Strengthens gums'] },
  { name: 'DXN Potenzhi', sku: 'DXN-OTH-002', category: 'other', price: 45.99, rating: 4.7, featured: false, inStock: true, description: 'DXN Potenzhi is a health supplement for men, combining Tongkat Ali with Ganoderma for vitality and energy.', benefits: ['Tongkat Ali + Ganoderma', 'Supports male vitality', 'Boosts energy', 'Natural formula'] },
  { name: 'Reishi Mushroom Powder', sku: 'DXN-OTH-003', category: 'other', price: 32.99, rating: 4.6, featured: false, inStock: true, description: 'Finely ground Reishi mushroom powder for versatile use. Add to smoothies, teas, soups or any recipe for a health boost.', benefits: ['Versatile usage', 'Pure Reishi powder', 'Easy to add to recipes', 'Premium quality'] },
  { name: 'DXN Cream', sku: 'DXN-OTH-004', category: 'other', price: 18.99, rating: 4.5, featured: false, inStock: true, description: 'Multi-purpose cream with Ganoderma extract. Suitable for various skin conditions and daily moisturizing needs.', benefits: ['Multi-purpose cream', 'Ganoderma enriched', 'Daily moisturizer', 'Soothes skin'] },
];

async function seed() {
  try {
    await mongoose.connect(process.env.MONGODB_URI);
    console.log('Connected to MongoDB');

    // Clear existing products
    await Product.deleteMany({});
    console.log('Cleared existing products');

    // Insert all products
    const result = await Product.insertMany(products);
    console.log(`Seeded ${result.length} products successfully!`);

    // Show summary
    const categories = {};
    result.forEach((p) => {
      categories[p.category] = (categories[p.category] || 0) + 1;
    });
    console.log('\nProducts by category:');
    Object.entries(categories).forEach(([cat, count]) => {
      console.log(`  ${cat}: ${count}`);
    });

    process.exit(0);
  } catch (err) {
    console.error('Seed error:', err.message);
    process.exit(1);
  }
}

seed();
