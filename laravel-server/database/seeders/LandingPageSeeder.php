<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\LandingPage;
use Illuminate\Support\Str;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        $qnaByCategory = [
            'coffee' => [
                ['q' => 'Is this coffee suitable for people with caffeine sensitivity?', 'a' => 'This coffee contains regular caffeine levels. However, the Ganoderma extract helps balance the effects of caffeine, making it smoother than regular coffee. If you are very sensitive, we recommend starting with half a sachet.'],
                ['q' => 'How many sachets are in one box?', 'a' => 'Each box contains 20 individually wrapped sachets, making it convenient for daily use at home or on the go.'],
                ['q' => 'Can I drink this coffee while pregnant?', 'a' => 'We recommend consulting your doctor before consuming any supplement or health product during pregnancy. The product contains caffeine and Ganoderma extract.'],
                ['q' => 'Does it taste like regular coffee?', 'a' => 'Yes, it tastes very similar to regular instant coffee with a smooth, slightly earthy undertone from the Ganoderma. Most people cannot tell the difference and actually prefer the taste.'],
            ],
            'beverages' => [
                ['q' => 'Does this need to be refrigerated?', 'a' => 'Unopened bottles can be stored at room temperature. Once opened, please refrigerate and consume within 7 days for best quality.'],
                ['q' => 'Is this suitable for children?', 'a' => 'Yes, most DXN beverages are suitable for children. However, we recommend smaller servings for children under 12. Always check the specific product label.'],
                ['q' => 'Can I mix it with other drinks?', 'a' => 'Absolutely! Many customers mix it with juice, smoothies, or even plain water. It is very versatile and tastes great in different combinations.'],
            ],
            'supplements' => [
                ['q' => 'When is the best time to take this supplement?', 'a' => 'For best results, take it 30 minutes before meals on an empty stomach. This allows for optimal absorption. Take with a full glass of water.'],
                ['q' => 'Are there any side effects?', 'a' => 'DXN supplements are made from 100% natural ingredients. Most people experience no side effects. Some may notice mild detox symptoms in the first few days, which is normal and temporary.'],
                ['q' => 'Can I take this with my medication?', 'a' => 'While DXN products are natural, we always recommend consulting with your healthcare provider before combining supplements with prescription medications.'],
                ['q' => 'How long before I see results?', 'a' => 'Results vary from person to person. Most customers report noticeable improvements within 2-4 weeks of consistent daily use. For best results, use for at least 90 days.'],
            ],
            'personal-care' => [
                ['q' => 'Is this product suitable for sensitive skin?', 'a' => 'Yes, DXN personal care products are formulated with natural ingredients including Ganoderma extract, which is known for its gentle properties. However, we recommend doing a patch test first.'],
                ['q' => 'Is this product cruelty-free?', 'a' => 'DXN does not test on animals. Their products are made with plant-based and mushroom-derived ingredients.'],
                ['q' => 'Can the whole family use this?', 'a' => 'Yes! DXN personal care products are suitable for all family members. They are gentle enough for daily use by adults and children alike.'],
            ],
            'skincare' => [
                ['q' => 'Is this suitable for oily skin?', 'a' => 'Yes, this product is lightweight and non-comedogenic. It works well for all skin types including oily and combination skin. It absorbs quickly without leaving a greasy residue.'],
                ['q' => 'Can I use this with other skincare brands?', 'a' => 'Yes, DXN skincare products can be used alongside other brands. However, for best results, we recommend using the complete DXN skincare line together.'],
                ['q' => 'Does this contain parabens or sulfates?', 'a' => 'DXN skincare products are formulated to be as gentle as possible. The newer formulations (Plus and Aloe.V lines) are free from parabens and sulfates.'],
                ['q' => 'What is the shelf life?', 'a' => 'Unopened products have a shelf life of 2-3 years. Once opened, we recommend using within 12 months. Check the packaging for the exact expiry date.'],
            ],
        ];

        $products = Product::all();
        $created = 0;

        foreach ($products as $product) {
            // Skip if landing page already exists for this product
            if (LandingPage::where('product_id', $product->id)->exists()) {
                continue;
            }

            $slug = Str::slug($product->name);
            $originalSlug = $slug;
            $counter = 1;
            while (LandingPage::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $benefits = is_array($product->benefits) ? $product->benefits : (json_decode($product->benefits, true) ?: []);
            $qna = $qnaByCategory[$product->category] ?? $qnaByCategory['coffee'];

            $landing = LandingPage::create([
                'title'            => $product->name,
                'slug'             => $slug,
                'product_id'       => $product->id,
                'hero_title'       => $product->name,
                'hero_subtitle'    => Str::limit($product->description, 150),
                'hero_image'       => $product->image ?? '',
                'hero_bg_color'    => '#452aa8',
                'description'      => $product->description ?? '',
                'description_ar'   => $product->description_ar ?? '',
                'ingredients'      => $product->ingredients ?? '',
                'usage_directions' => $product->usage ?? '',
                'usage_directions_ar' => $product->usage_ar ?? '',
                'features'         => $benefits,
                'benefits'         => $benefits,
                'qna'              => $qna,
                'gallery'          => is_array($product->images) ? $product->images : [],
                'cta_text'         => 'Order via WhatsApp',
                'cta_link'         => 'https://wa.me/971555574958?text=' . urlencode('Hi, I want to order: ' . $product->name . ' (SKU: ' . $product->sku . ')'),
                'custom_css'       => '',
                'custom_html'      => '',
                'published'        => true,
            ]);

            // Link product to this landing page
            $product->update(['landing_page' => '/landing/' . $landing->slug]);

            $created++;
        }

        $this->command->info("Created {$created} landing pages.");
    }
}
