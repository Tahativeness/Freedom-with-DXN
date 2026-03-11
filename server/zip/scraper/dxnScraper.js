const axios = require('axios');
const cheerio = require('cheerio');

const BASE_URL = 'https://www.dxn2u.com';
const IMAGE_BASE = `${BASE_URL}/product/images`;

// Category pages to scrape
const CATEGORY_PAGES = [
  { url: `${BASE_URL}/product/products.php?cat_id=HDS`, dxnCat: 'HDS', label: 'Health & Dietary Supplements' },
  { url: `${BASE_URL}/product/products.php?cat_id=FFB`, dxnCat: 'FFB', label: 'Food & Beverages' },
  { url: `${BASE_URL}/product/products.php?cat_id=PCC`, dxnCat: 'PCC', label: 'Personal Care & Cosmetics' },
  { url: `${BASE_URL}/product/products.php?cat_id=OTH`, dxnCat: 'OTH', label: 'Others' },
];

// Map DXN categories + image sub-paths to our app categories
function mapCategory(dxnCat, imagePath) {
  if (dxnCat === 'HDS') {
    if (imagePath.includes('/GN/')) return 'ganoderma';
    return 'supplements';
  }
  if (dxnCat === 'FFB') {
    if (imagePath.includes('/CF/')) return 'coffee';
    if (imagePath.includes('/TE/')) return 'beverages';
    return 'beverages';
  }
  if (dxnCat === 'PCC') return 'skincare';
  return 'other';
}

// Generate a description based on product name and category
function generateDescription(name, category) {
  const descriptions = {
    coffee: `${name} — a premium DXN coffee infused with Ganoderma extract. Enjoy the rich taste and health benefits of this carefully crafted blend.`,
    ganoderma: `${name} — a premium Ganoderma-based health supplement from DXN. Harness the power of the King of Herbs for your daily wellness.`,
    supplements: `${name} — a high-quality DXN health supplement designed to support your overall well-being with natural ingredients.`,
    skincare: `${name} — part of DXN's personal care range, formulated with Ganoderma extracts for healthy, radiant skin and body care.`,
    beverages: `${name} — a refreshing DXN beverage enriched with natural ingredients for taste and health benefits.`,
    other: `${name} — a quality DXN product designed to enhance your daily life with innovation and natural goodness.`,
  };
  return descriptions[category] || descriptions.other;
}

// Generate benefits based on category
function generateBenefits(category) {
  const benefits = {
    coffee: ['Infused with Ganoderma extract', 'Rich smooth flavor', 'Supports daily wellness', 'Convenient sachet packaging'],
    ganoderma: ['Pure Ganoderma extract', 'Supports immune system', 'Rich in antioxidants', 'Traditional herbal wellness'],
    supplements: ['Natural ingredients', 'Supports overall health', 'Easy daily supplementation', 'Quality assured by DXN'],
    skincare: ['Ganoderma-enriched formula', 'Gentle on skin', 'Natural ingredients', 'Suitable for daily use'],
    beverages: ['Natural ingredients', 'Refreshing taste', 'Health-promoting properties', 'Convenient preparation'],
    other: ['Quality DXN product', 'Innovative design', 'Durable and reliable', 'Great value'],
  };
  return benefits[category] || benefits.other;
}

// Scrape a single category page
async function scrapeCategory(catPage) {
  try {
    const { data } = await axios.get(catPage.url, {
      headers: {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
      },
      timeout: 30000,
    });

    const $ = cheerio.load(data);
    const products = [];

    // Find all product images and their associated names
    // The site uses various structures, so we look for common patterns
    $('img').each((_, el) => {
      const src = $(el).attr('src') || '';
      const alt = $(el).attr('alt') || '';

      // Only process product images (they contain /images/ path with category subfolder)
      if (!src.includes('/images/') || !src.includes(`/${catPage.dxnCat}/`)) return;
      // Skip tiny icons and non-product images
      if (src.includes('noimg') || src.includes('icon') || src.includes('logo')) return;

      // Get the product name from alt text, parent heading, or nearby text
      let name = alt.trim();
      if (!name) {
        const parent = $(el).closest('div, a, li');
        name = parent.find('h3, h4, h5, h6, .product-name, strong').first().text().trim();
      }
      if (!name || name.length < 3) return;

      // Build full image URL
      let imageUrl = src;
      if (!imageUrl.startsWith('http')) {
        imageUrl = imageUrl.startsWith('/') ? `${BASE_URL}${imageUrl}` : `${BASE_URL}/product/${imageUrl}`;
      }

      // Extract product ID from nearby link
      let dxnId = '';
      const parentLink = $(el).closest('a, [onclick]');
      const href = parentLink.attr('href') || parentLink.attr('onclick') || '';
      const idMatch = href.match(/prd(\d+)/);
      if (idMatch) dxnId = `prd${idMatch[1]}`;

      // Also check if there's a modal link nearby
      if (!dxnId) {
        const wrapper = $(el).closest('div').parent();
        const link = wrapper.find('a[href*="modal=prd"]').first();
        const linkHref = link.attr('href') || '';
        const linkMatch = linkHref.match(/prd(\d+)/);
        if (linkMatch) dxnId = `prd${linkMatch[1]}`;
      }

      const category = mapCategory(catPage.dxnCat, src);

      products.push({
        name: name.replace(/\s+/g, ' ').trim(),
        image: imageUrl,
        category,
        dxnCategory: catPage.label,
        dxnId,
        sourceUrl: `${catPage.url}${dxnId ? `&modal=${dxnId}` : ''}`,
      });
    });

    // Deduplicate by name
    const seen = new Set();
    return products.filter((p) => {
      const key = p.name.toLowerCase();
      if (seen.has(key)) return false;
      seen.add(key);
      return true;
    });
  } catch (err) {
    console.error(`Error scraping ${catPage.label}:`, err.message);
    return [];
  }
}

// Main scrape function - scrapes all categories
async function scrapeAllProducts() {
  console.log('Starting DXN product scrape...');
  let allProducts = [];

  for (const catPage of CATEGORY_PAGES) {
    console.log(`Scraping: ${catPage.label}...`);
    const products = await scrapeCategory(catPage);
    console.log(`  Found ${products.length} products`);
    allProducts = allProducts.concat(products);
  }

  // If live scraping got very few results, use the fallback dataset
  if (allProducts.length < 20) {
    console.log('Live scraping returned few results, using built-in product catalog...');
    allProducts = getFallbackProducts();
  }

  // Add descriptions, benefits, pricing, and SKUs
  allProducts = allProducts.map((p, idx) => ({
    ...p,
    description: p.description || generateDescription(p.name, p.category),
    benefits: p.benefits || generateBenefits(p.category),
    price: p.price || generatePrice(p.category),
    sku: p.dxnId || `DXN-${String(idx + 1).padStart(4, '0')}`,
    inStock: true,
    featured: idx < 8,
    rating: +(3.5 + Math.random() * 1.5).toFixed(1),
  }));

  console.log(`Total products scraped: ${allProducts.length}`);
  return allProducts;
}

function generatePrice(category) {
  const ranges = {
    coffee: [15, 35],
    ganoderma: [25, 60],
    supplements: [18, 50],
    skincare: [12, 45],
    beverages: [10, 30],
    other: [8, 55],
  };
  const [min, max] = ranges[category] || [10, 40];
  return +(min + Math.random() * (max - min)).toFixed(2);
}

// Comprehensive fallback product catalog from dxn2u.com
function getFallbackProducts() {
  const products = [
    // ===== COFFEE (FFB/CF) =====
    { name: 'DXN Lingzhi Coffee 3 in 1', image: `${IMAGE_BASE}/FFB/CF/3in1.jpg`, category: 'coffee', dxnId: 'prd00019' },
    { name: 'DXN Lingzhi Coffee 2 in 1', image: `${IMAGE_BASE}/FFB/CF/2in1.jpg`, category: 'coffee', dxnId: 'prd00020' },
    { name: 'DXN Lingzhi Black Coffee', image: `${IMAGE_BASE}/FFB/CF/black_coffee.jpg`, category: 'coffee', dxnId: 'prd00021' },
    { name: 'DXN Zhi Mocha', image: `${IMAGE_BASE}/FFB/CF/zhimocha.jpg`, category: 'coffee', dxnId: 'prd00022' },
    { name: 'DXN Cordyceps Coffee 3 in 1', image: `${IMAGE_BASE}/FFB/CF/cordyceps.jpg`, category: 'coffee', dxnId: 'prd00023' },
    { name: 'DXN Eucafe', image: `${IMAGE_BASE}/FFB/CF/FB127_EuCafe_Bag.jpg`, category: 'coffee', dxnId: 'prd00024' },
    { name: 'DXN Vita Cafe', image: `${IMAGE_BASE}/FFB/CF/FB128_VitaCafe_Bag.jpg`, category: 'coffee', dxnId: 'prd00025' },
    { name: 'DXN White Coffee Zhino', image: `${IMAGE_BASE}/FFB/CF/whitecoffee.jpg`, category: 'coffee', dxnId: 'prd00041' },
    { name: 'DXN Zhi Cafe Classic', image: `${IMAGE_BASE}/FFB/CF/zhicafe.jpg`, category: 'coffee', dxnId: 'prd00040' },
    { name: 'DXN Cream Coffee', image: `${IMAGE_BASE}/FFB/CF/cream_coffee.jpg`, category: 'coffee', dxnId: 'prd00095' },
    { name: 'DXN Lingzhi Coffee 3 in 1 Lite', image: `${IMAGE_BASE}/FFB/CF/lite.jpg`, category: 'coffee', dxnId: 'prd00038' },
    { name: 'DXN Civattino Coffee', image: `${IMAGE_BASE}/FFB/CF/civattino.jpg`, category: 'coffee', dxnId: 'prd00045' },
    { name: 'DXN Lingzhi Coffee 3 in 1 Neo', image: `${IMAGE_BASE}/FFB/CF/FB500_DXN_Lingzhi_3in1_NEO_BOX_1.jpg`, category: 'coffee', dxnId: 'prd00150' },
    { name: 'DXN Lingzhi Coffee 3 in 1 Lite Neo', image: `${IMAGE_BASE}/FFB/CF/FB501_DXN_Lingzhi_Coffee_3in1_Lite_NEO_1.jpg`, category: 'coffee', dxnId: 'prd00151' },
    { name: 'DXN Cordyceps Coffee 3 in 1 Neo', image: `${IMAGE_BASE}/FFB/CF/FB502_DXN_Cordyceps_Coffee_3in1_NEO_BOX_1.jpg`, category: 'coffee', dxnId: 'prd00152' },
    { name: 'DXN Truffle Coffee 3 in 1', image: `${IMAGE_BASE}/FFB/CF/FB587_DXN_Truffle_Coffee_3in1_1_BOX_MYS.jpg`, category: 'coffee', dxnId: 'prd00153' },
    { name: 'DXN Truffle Coffee 2 in 1', image: `${IMAGE_BASE}/FFB/CF/FB589_DXN_Truffle_Coffee_2in1_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00154' },
    { name: 'DXN Truffle Black Coffee', image: `${IMAGE_BASE}/FFB/CF/FB590_DXN_Truffle_Black_Coffee_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00155' },
    { name: 'DXN Truffle Cream Coffee', image: `${IMAGE_BASE}/FFB/CF/FB591_DXN_Truffle_Cream_Coffee_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00156' },
    { name: 'DXN Truffle Mocha', image: `${IMAGE_BASE}/FFB/CF/FB592_DXN_Truffle_Mocha_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00157' },
    { name: 'DXN Truffle Latte', image: `${IMAGE_BASE}/FFB/CF/FB593_DXN_Truffle_Latte_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00158' },
    { name: 'DXN Truffle Coffee 3 in 1 Lite', image: `${IMAGE_BASE}/FFB/CF/FB588_DXN_Truffle_Coffee_3in1_LITE_Box_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00159' },
    { name: "DXN Lion's Mane Coffee", image: `${IMAGE_BASE}/FFB/CF/FB215_LionsManeCoffee_Box.jpg`, category: 'coffee', dxnId: 'prd00160' },
    { name: "DXN Lion's Mane Coffee Latte", image: `${IMAGE_BASE}/FFB/CF/FB395_DXN_Lion'sManeCoffee_Latte_BOX_1_MYS.jpg`, category: 'coffee', dxnId: 'prd00161' },
    { name: 'DXN Spirulina Coffee', image: `${IMAGE_BASE}/FFB/CF/FB397_Spirulina_Coffee_1.jpg`, category: 'coffee', dxnId: 'prd00162' },
    { name: 'DXN Zhi Roasted Coffee', image: `${IMAGE_BASE}/FFB/CF/FB364_DXN_ZhiRoastCoffee.jpg`, category: 'coffee', dxnId: 'prd00163' },

    // ===== BEVERAGES (FFB/TE, FFB/ND, FFB/FJ) =====
    { name: 'DXN Reishi Gano Tea', image: `${IMAGE_BASE}/FFB/TE/reishi_tea.jpg`, category: 'beverages', dxnId: 'prd00030' },
    { name: 'DXN Spica Tea', image: `${IMAGE_BASE}/FFB/TE/spica_tea.jpg`, category: 'beverages', dxnId: 'prd00029' },
    { name: 'DXN Lemonzhi', image: `${IMAGE_BASE}/FFB/TE/lemonzhi.jpg`, category: 'beverages', dxnId: 'prd00047' },
    { name: 'DXN Lingzhi Tea Latte', image: `${IMAGE_BASE}/FFB/TE/tealatte.jpg`, category: 'beverages', dxnId: 'prd00042' },
    { name: 'DXN Cocozhi', image: `${IMAGE_BASE}/FFB/ND/cocozhi.jpg`, category: 'beverages', dxnId: 'prd00026' },
    { name: 'DXN Cocozhi Neo', image: `${IMAGE_BASE}/FFB/ND/FB335_DXN_Cocozhi_NEO_BOX_1_MYS.jpg`, category: 'beverages', dxnId: 'prd00164' },
    { name: 'DXN Cordyceps Cereal', image: `${IMAGE_BASE}/FFB/ND/FB069_Cordyceps_Cereal_Box.jpg`, category: 'beverages', dxnId: 'prd00039' },
    { name: 'DXN Cordypine', image: `${IMAGE_BASE}/FFB/ND/cordypine_combine.jpg`, category: 'beverages', dxnId: 'prd00031' },
    { name: 'DXN NutriZhi', image: `${IMAGE_BASE}/FFB/ND/nutrizhi.jpg`, category: 'beverages', dxnId: 'prd00027' },
    { name: 'DXN Spirulina Cereal', image: `${IMAGE_BASE}/FFB/ND/spirulina_cereal.jpg`, category: 'beverages', dxnId: 'prd00028' },
    { name: 'DXN Morinzhi', image: `${IMAGE_BASE}/FFB/FJ/morinzhi.jpg`, category: 'beverages', dxnId: 'prd00032' },
    { name: 'DXN Morinzyme', image: `${IMAGE_BASE}/FFB/FJ/morinzyme_combine.jpg`, category: 'beverages', dxnId: 'prd00033' },
    { name: 'DXN Roselle Juice', image: `${IMAGE_BASE}/FFB/FJ/rosellejuice_combine.jpg`, category: 'beverages', dxnId: 'prd00034' },
    { name: 'DXN Kiwi Fruit Drink Base', image: `${IMAGE_BASE}/FFB/FJ/kiwi.jpg`, category: 'beverages', dxnId: 'prd00035' },
    { name: 'DXN Fruzim', image: `${IMAGE_BASE}/FFB/ND/fruzim.jpg`, category: 'beverages', dxnId: 'prd00037' },
    { name: 'DXN Lignopine', image: `${IMAGE_BASE}/FFB/ND/lignopine-700ml.jpg`, category: 'beverages', dxnId: 'prd00052' },
    { name: 'DXN Vinaigrette', image: `${IMAGE_BASE}/FFB/ND/vinaigrette.jpg`, category: 'beverages', dxnId: 'prd00050' },
    { name: 'DXN Oocha', image: `${IMAGE_BASE}/FFB/TE/oocha_front.jpg`, category: 'beverages', dxnId: 'prd00165' },
    { name: "DXN Lion's Mane Oocha", image: `${IMAGE_BASE}/FFB/TE/FB250_LionsManeOocha.jpg`, category: 'beverages', dxnId: 'prd00166' },
    { name: 'DXN Florathemum', image: `${IMAGE_BASE}/FFB/TE/FB307_DXN_Florathemum.jpg`, category: 'beverages', dxnId: 'prd00167' },
    { name: 'DXN Komb-B', image: `${IMAGE_BASE}/FFB/TE/Komb-B.jpg`, category: 'beverages', dxnId: 'prd00168' },
    { name: 'DXN Lemontruff', image: `${IMAGE_BASE}/FFB/TE/FB594_DXN_Lemontruff_1_Box_MYS.jpg`, category: 'beverages', dxnId: 'prd00169' },
    { name: 'DXN Cocotruff', image: `${IMAGE_BASE}/FFB/ND/FB595_DXN_Cocotruff_BOX_1_MYS.jpg`, category: 'beverages', dxnId: 'prd00170' },
    { name: 'DXN Ginpine', image: `${IMAGE_BASE}/FFB/ND/FB492_DXN_Ginpine_285ml_1.jpg`, category: 'beverages', dxnId: 'prd00171' },
    { name: 'DXN Zhi Ca Plus', image: `${IMAGE_BASE}/FFB/FD/zhica.jpg`, category: 'beverages', dxnId: 'prd00012' },
    { name: 'DXN Zhi Mint Plus', image: `${IMAGE_BASE}/FFB/FD/zhimint_box.jpg`, category: 'beverages', dxnId: 'prd00036' },
    { name: 'DXN Flora Tea', image: `${IMAGE_BASE}/FFB/TE/fb_floratea_front.jpg`, category: 'beverages', dxnId: 'prd00101' },
    { name: 'DXN D\'Latte Neo', image: `${IMAGE_BASE}/FFB/TE/DXN_DLatte_NEO_Box_front.jpg`, category: 'beverages', dxnId: 'prd00172' },
    { name: 'DXN Zhitea', image: `${IMAGE_BASE}/FFB/TE/DXN-ZhiTea.jpg`, category: 'beverages', dxnId: 'prd00173' },
    { name: 'DXN Aloe Vita', image: `${IMAGE_BASE}/FFB/FJ/aloeVita_front.jpg`, category: 'beverages', dxnId: 'prd00174' },
    { name: 'DXN Moricinia', image: `${IMAGE_BASE}/FFB/FJ/Moricinia_285ml.jpg`, category: 'beverages', dxnId: 'prd00175' },
    { name: 'DXN Ganoderma Mushroom', image: `${IMAGE_BASE}/FFB/FD/gano_mushroom.jpg`, category: 'beverages', dxnId: 'prd00044' },
    { name: 'DXN L-Vegmix', image: `${IMAGE_BASE}/FFB/FD/vegmix.jpg`, category: 'beverages', dxnId: 'prd00046' },

    // ===== GANODERMA (HDS/GN) =====
    { name: 'Reishi Gano (RG)', image: `${IMAGE_BASE}/HDS/GN/rg.jpg`, category: 'ganoderma', dxnId: 'prd00001',
      description: 'Reishi Gano (RG) is made from the body of the Ganoderma Lucidum mushroom. It is rich in polysaccharides and triterpenoids that support immune function and overall wellness.',
      benefits: ['Rich in polysaccharides', 'Supports immune system', 'Antioxidant properties', 'Traditional wellness herb'] },
    { name: 'Ganocelium (GL)', image: `${IMAGE_BASE}/HDS/GN/gl.jpg`, category: 'ganoderma', dxnId: 'prd00007',
      description: 'Ganocelium (GL) is derived from the mycelium of Ganoderma Lucidum, harvested at just 18 days. Rich in organic germanium and minerals for cellular health.',
      benefits: ['Rich in organic germanium', 'Supports cellular health', 'High mineral content', 'Complements RG supplementation'] },
    { name: 'DXN Reishilium Powder', image: `${IMAGE_BASE}/HDS/GN/reishilium.jpg`, category: 'ganoderma', dxnId: 'prd00002' },
    { name: 'DXN MycoVita', image: `${IMAGE_BASE}/HDS/GN/mycovita.jpg`, category: 'ganoderma', dxnId: 'prd00004' },

    // ===== SUPPLEMENTS (HDS/MF, HDS/SH, HDS/PP) =====
    { name: 'DXN Spirulina', image: `${IMAGE_BASE}/HDS/SH/spirulina_capsule_front.jpg`, category: 'supplements', dxnId: 'prd00013',
      description: 'DXN Spirulina is a natural superfood containing over 50 nutrients. This blue-green algae is one of the most nutrient-dense foods on earth.',
      benefits: ['Over 50 nutrients', 'Rich in protein', 'Contains essential vitamins', 'Supports energy and vitality'] },
    { name: 'DXN Cordyceps', image: `${IMAGE_BASE}/HDS/MF/cordyceps.jpg`, category: 'supplements', dxnId: 'prd00015' },
    { name: 'DXN Andro-G', image: `${IMAGE_BASE}/HDS/SH/androg1.jpg`, category: 'supplements', dxnId: 'prd00008' },
    { name: 'DXN Poria S', image: `${IMAGE_BASE}/HDS/MF/poria-s.jpg`, category: 'supplements', dxnId: 'prd00018' },
    { name: 'DXN Lignosus Plus Syrup', image: `${IMAGE_BASE}/HDS/MF/lignosus_bottle.jpg`, category: 'supplements', dxnId: 'prd00087' },
    { name: 'DXN Ligno-L Powder', image: `${IMAGE_BASE}/HDS/MF/HF126_Ligno-L_Powder_40g.jpg`, category: 'supplements', dxnId: 'prd00127' },
    { name: 'DXN Zhicurcu Capsule', image: `${IMAGE_BASE}/HDS/PP/HF231_DXN_Zhicurcu_Capsule_30.jpg`, category: 'supplements', dxnId: 'prd00190' },
    { name: 'DXN Fuling Plus Pill', image: `${IMAGE_BASE}/HDS/PP/HF262_DXN_FulingPlus_Pill.jpg`, category: 'supplements', dxnId: 'prd00191' },

    // ===== SKINCARE (PCC) =====
    { name: 'DXN Ganozhi Soap', image: `${IMAGE_BASE}/PCC/PC/soap_front.jpg`, category: 'skincare', dxnId: 'prd00071' },
    { name: 'Gano Massage Oil', image: `${IMAGE_BASE}/PCC/PC/massage_oil.jpg`, category: 'skincare', dxnId: 'prd00072' },
    { name: 'DXN Ganozhi Toothpaste', image: `${IMAGE_BASE}/PCC/PC/toothpaste_150g.jpg`, category: 'skincare', dxnId: 'prd00073' },
    { name: 'DXN Ganozhi Body Foam', image: `${IMAGE_BASE}/PCC/PC/bodyfoam.jpg`, category: 'skincare', dxnId: 'prd00074' },
    { name: 'DXN Ganozhi Shampoo', image: `${IMAGE_BASE}/PCC/PC/shampoo.jpg`, category: 'skincare', dxnId: 'prd00075' },
    { name: 'DXN Talcum Powder', image: `${IMAGE_BASE}/PCC/PC/talcum.jpg`, category: 'skincare', dxnId: 'prd00076' },
    { name: 'DXN Fresh Eau de Toilette Perfume', image: `${IMAGE_BASE}/PCC/PC/perfume-male.jpg`, category: 'skincare', dxnId: 'prd00077' },
    { name: 'DXN Ganozhi Plus Series', image: `${IMAGE_BASE}/PCC/PC/ganozhiplus-bodyfoam_plus.jpg`, category: 'skincare', dxnId: 'prd00078' },
    { name: 'Tea Tree Cream', image: `${IMAGE_BASE}/PCC/PC/teatree.jpg`, category: 'skincare', dxnId: 'prd00070' },
    { name: 'DXN Aloe.V Series', image: `${IMAGE_BASE}/PCC/SC/aloev-aqua_gel.jpg`, category: 'skincare', dxnId: 'prd00080' },
    { name: 'DXN Ganozhi Complete Skin Care Series', image: `${IMAGE_BASE}/PCC/SC/complete-cleanser.jpg`, category: 'skincare', dxnId: 'prd00083' },
    { name: 'DXN Ganozhi E Series', image: `${IMAGE_BASE}/PCC/SC/eseries-cleansing.jpg`, category: 'skincare', dxnId: 'prd00085' },
    { name: 'DXN Ganozhi Lipstick', image: `${IMAGE_BASE}/PCC/SC/lipstick-coco_red.jpg`, category: 'skincare', dxnId: 'prd00082' },
    { name: 'DXN Chubby Baby Oil', image: `${IMAGE_BASE}/PCC/SC/babyoil.jpg`, category: 'skincare', dxnId: 'prd00084' },
    { name: 'DXN Spiru Face Mask', image: `${IMAGE_BASE}/PCC/SC/SC131_DXN_Spiru_Face_Mask_1.jpg`, category: 'skincare', dxnId: 'prd00131' },
    { name: 'DXN Papaya Facial Scrub', image: `${IMAGE_BASE}/PCC/SC/SC072_DXN_Papaya_Facial_Scrub.jpg`, category: 'skincare', dxnId: 'prd00183' },
    { name: 'DXN Anti-Aging Face Mask', image: `${IMAGE_BASE}/PCC/SC/SC129_DXN_Anti-Aging_Face_Mask_1.jpg`, category: 'skincare', dxnId: 'prd00129' },
    { name: 'DXN Oolong Tea Mask', image: `${IMAGE_BASE}/PCC/SC/SC130_DXN_Oolong_Tea_Mask_1.jpg`, category: 'skincare', dxnId: 'prd00130' },
    { name: 'DXN Gempyuri', image: `${IMAGE_BASE}/PCC/SC/SC107_Gempyuri-set.jpg`, category: 'skincare', dxnId: 'prd00185' },
    { name: 'DXN Evelyn Blurring Finish Powder', image: `${IMAGE_BASE}/PCC/SC/SC142_EVELYN_Blurring_Finish_Powder_Collections_1.jpg`, category: 'skincare', dxnId: 'prd00142' },
    { name: 'DXN Evelyn Sheer Velvet Matte Lipstick', image: `${IMAGE_BASE}/PCC/SC/SC143_EVELYN_Sheer_Velvet_Matte_Lipstick_Collections_1.jpg`, category: 'skincare', dxnId: 'prd00143' },
    { name: 'DXN Bomsalt Toothpaste', image: `${IMAGE_BASE}/PCC/PC/PC123_DXN_Bomsalt_Toothpaste_150g_1_MYS.jpg`, category: 'skincare', dxnId: 'prd00123' },
    { name: 'DXN Zhicare Toothpaste', image: `${IMAGE_BASE}/PCC/PC/PC057_ZhiCare_Toothpaste.jpg`, category: 'skincare', dxnId: 'prd00141' },
    { name: 'DXN Oocha Toothpaste', image: `${IMAGE_BASE}/PCC/PC/PC062_DXN_Oocha_ToothPaste.jpg`, category: 'skincare', dxnId: 'prd00182' },
    { name: 'Zhimeko', image: `${IMAGE_BASE}/PCC/PC/Zhimeko_Front.jpg`, category: 'skincare', dxnId: 'prd00069' },
    { name: 'DXN Toiletries Travel Kit', image: `${IMAGE_BASE}/PCC/PC/travelkit.jpg`, category: 'skincare', dxnId: 'prd00067' },
    { name: 'DXN Ootea Bomsalt Scrub', image: `${IMAGE_BASE}/PCC/SC/SC132_DXN_Ootea_Bomsalt_Scrub.jpg`, category: 'skincare', dxnId: 'prd00132' },

    // ===== OTHER (OTH) =====
    { name: 'DXN Dish Cleen', image: `${IMAGE_BASE}/OTH/HP/dish_cleen.jpg`, category: 'other', dxnId: 'prd00058' },
    { name: 'DXN Dyna Cleen', image: `${IMAGE_BASE}/OTH/HP/dyna_cleen.jpg`, category: 'other', dxnId: 'prd00063' },
    { name: 'DXN Pine Cleen', image: `${IMAGE_BASE}/OTH/HP/pine_cleen.jpg`, category: 'other', dxnId: 'prd00059' },
    { name: 'DXN Sheen', image: `${IMAGE_BASE}/OTH/HP/sheen.jpg`, category: 'other', dxnId: 'prd00060' },
    { name: 'DXN Vegi Cleen', image: `${IMAGE_BASE}/OTH/HP/vegi-cleen.jpg`, category: 'other', dxnId: 'prd00066' },
    { name: 'DXN Smart Pot', image: `${IMAGE_BASE}/OTH/HA/smartpot.jpg`, category: 'other', dxnId: 'prd00053' },
    { name: 'DXN Espresso Kettle', image: `${IMAGE_BASE}/OTH/HA/espresso.jpg`, category: 'other', dxnId: 'prd00054' },
    { name: 'DXN Yogurt Maker', image: `${IMAGE_BASE}/OTH/HA/yogurt_maker.jpg`, category: 'other', dxnId: 'prd00093' },
    { name: 'DXN Coffee Distiller', image: `${IMAGE_BASE}/OTH/HA/coffee_distiller.jpg`, category: 'other', dxnId: 'prd00096' },
    { name: 'DXN Tea Infuser', image: `${IMAGE_BASE}/OTH/HA/HA012_Tea_Infuser_Front.jpg`, category: 'other', dxnId: 'prd00146' },
    { name: 'DXN Energy Plus Water System', image: `${IMAGE_BASE}/OTH/WT/epws_side.jpg`, category: 'other', dxnId: 'prd00086' },
  ];

  return products.map((p) => ({
    ...p,
    dxnCategory: getCategoryLabel(p.category),
    sourceUrl: `https://www.dxn2u.com/product/products.php?cat_id=${getCatId(p.category)}&modal=${p.dxnId}`,
  }));
}

function getCategoryLabel(cat) {
  const labels = { coffee: 'Food & Beverages', ganoderma: 'Health & Dietary Supplements', supplements: 'Health & Dietary Supplements', skincare: 'Personal Care & Cosmetics', beverages: 'Food & Beverages', other: 'Others' };
  return labels[cat] || 'Others';
}

function getCatId(cat) {
  const ids = { coffee: 'FFB', ganoderma: 'HDS', supplements: 'HDS', skincare: 'PCC', beverages: 'FFB', other: 'OTH' };
  return ids[cat] || 'OTH';
}

module.exports = { scrapeAllProducts };
