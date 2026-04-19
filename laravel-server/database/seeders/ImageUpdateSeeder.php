<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\LandingPage;
use Illuminate\Support\Str;

class ImageUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $imageMap = [
            'FB369' => '1. DXN Ootea Lingzhi Coffee Mix 3 in 1.jpeg',
            'FB370' => '2. DXN Ootea Lingzhi Coffee Mix 3 in 1 Lite.jpeg',
            'FB371' => '3. DXN Ootea Lingzhi Coffee Mix 2 in 1.png',
            'FB372' => '4. DXN Ootea Cordyceps Coffee Mix 3 in 1.jpeg',
            'FB373' => '5. DXN Ootea Zhi Mocha Mix.jpeg',
            'FB374' => '6. DXN Ootea White Coffee Zhino Mix.jpeg',
            'FB375' => '7. DXN Ootea Lingzhi Black Coffee Mix.jpeg',
            'FB376' => '8. DXN Ootea Vita Cafe Mix.jpeg',
            'FB002' => '9. DXN Lingzhi Coffee 3 in 1.png',
            'FB054' => '10. DXN Lingzhi Black Coffee.avif',
            'FB066' => '11. DXN Lingzhi Coffee 3 in 1.jpg',
            'FB129' => '12. DXN Cordyceps Coffee 3 in 1.jpeg',
            'FB130' => '13. DXN Cream Coffee.jpg',
            'FB025' => '14. DXN Cocozhi.png',
            'FB007' => '15. DXN Morinzhi 285ml.jpeg',
            'FB065' => '16. DXN Morinzhi 700ml.jpeg',
            'FB005' => '17. DXN Roselle Juice.jpeg',
            'FB053' => '18. DXN Cordypine.jpeg',
            'FB155' => '19. DXN Lemonzhi.jpeg',
            'FB301' => '20. DXN Lingzhi Tea Latte.png',
            'FB032' => '21. DXN Spirulina Cereal.jpg',
            'FB050' => '22. DXN Vinaigrette.jpeg',
            'FB143' => '23. DXN Zhi Mint Plus.png',
            'FB033' => '24. Gano Pineapple Mix.jpeg',
            'FB173' => '25. DXN Spirudle.png',
            'FB360' => '26. DXN Sugar Sachets.png',
            'HF029' => '27. DXN Lion\'s Mane Tablet.png',
            'HF030' => '28. DXN Cordyceps Tablet.png',
            'HF041' => '29. Reishi Mushroom Powder.png',
            'HF031' => '30. DXN Spirulina 120 Tablets.png',
            'HF038' => '31. DXN Spirulina 500 Tablets.png',
            'HF082' => '32. DXN Bee Pollen Granule.png',
            'HF039' => '33. DXN MycoVeggie.png',
            'HF044' => '34. DXN Potenzhi 90.png',
            'PC004' => '35. Ganozhi Shampoo.png',
            'PC005' => '36. Ganozhi Body Foam.png',
            'PC006' => '37. Ganozhi Toothpaste.png',
            'PC007' => '38. Gano Massage Oil.png',
            'PC015' => '39. Talcum Powder.png',
            'PC020' => '40. Ganozhi Plus Toothpaste.png',
            'PC039' => '41. Ganozhi Plus Shampoo.png',
            'PC041' => '42. DXN Toothbrush (Adults).png',
            'PC042' => '43. DXN Toothbrush (Children).png',
            'PC045' => '44. DXN Zhimeko.png',
            'PC074' => '45. DXN Oocha Trans Soap.png',
            'PC120' => '46. Ganozhi Soap.png',
            'PC014' => '47. Tea Tree Cream.jpg',
            'SC009N' => '48. Ganozhi Toner.jpeg',
            'SC010N' => '49. Ganozhi Moisturizing Micro Emulsion.jpeg',
            'SC011N' => '50. Ganozhi Liquid Cleanser.jpeg',
            'SC012' => '51. DXN Chubby Baby Oil 200ml.jpg',
            'SC014' => '52. Ganozhi Lipstick - Coco Red.jpeg',
            'SC015' => '53. Ganozhi Lipstick - Pearly Red.jpeg',
            'SC016' => '54. Ganozhi Lipstick - Pearly Pink.jpeg',
            'SC017' => '55. Ganozhi Lipstick - Pearly Grape.jpeg',
            'SC020' => '56. DXN Aloe.V Cleansing Gel.jpeg',
            'SC021' => '57. DXN Aloe.V Hydrating Toner.jpeg',
            'SC022' => '58. DXN Aloe.V Aqua Gel.jpeg',
            'SC023' => '59. DXN Aloe.V Nutricare Cream.jpeg',
            'SC024' => '60. DXN Aloe.V Hand & Body Lotion.jpeg',
            'SC073' => '61. DXN Chubby Baby Oil 40ml.jpeg',
        ];

        $basePath = '/images/products/Watermark free images/';
        $updated = 0;

        foreach ($imageMap as $sku => $filename) {
            $count = Product::where('sku', $sku)->update(['image' => $basePath . $filename]);
            $updated += $count;
        }

        $this->command->info("Updated images for {$updated} products.");

        // Create product #62: DXN Lingzhi Coffee 2 in 1
        if (!Product::where('sku', 'FB001')->exists()) {
            $product = Product::create([
                'name' => 'DXN Lingzhi Coffee 2 in 1',
                'sku' => 'FB001',
                'category' => 'coffee',
                'price' => 21.99,
                'rating' => 4.6,
                'featured' => false,
                'in_stock' => true,
                'image' => $basePath . '62. DXN Lingzhi Coffee 2 in 1.png',
                'description' => 'A smooth blend of premium instant coffee and Ganoderma extract, without sugar or creamer. Perfect for those who prefer their coffee black with a creamy twist from the non-dairy creamer. 20 sachets x 14g.',
                'benefits' => ['Sugar-free coffee with creamer', 'Ganoderma lucidum enriched', 'Smooth and aromatic', 'Convenient 20-sachet box'],
                'ingredients' => 'Instant coffee powder, non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, stabilizers), Ganoderma lucidum extract. No added sugar. 20 sachets x 14g.',
                'usage' => 'Mix one sachet with 150ml of hot water. Stir well and enjoy. Can be served hot or iced.',
            ]);

            // Create landing page for product #62
            $slug = Str::slug($product->name);
            $originalSlug = $slug;
            $counter = 1;
            while (LandingPage::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $qna = [
                ['q' => 'Is this coffee suitable for people with caffeine sensitivity?', 'a' => 'This coffee contains regular caffeine levels. However, the Ganoderma extract helps balance the effects of caffeine, making it smoother than regular coffee. If you are very sensitive, we recommend starting with half a sachet.'],
                ['q' => 'How many sachets are in one box?', 'a' => 'Each box contains 20 individually wrapped sachets, making it convenient for daily use at home or on the go.'],
                ['q' => 'Can I drink this coffee while pregnant?', 'a' => 'We recommend consulting your doctor before consuming any supplement or health product during pregnancy. The product contains caffeine and Ganoderma extract.'],
                ['q' => 'Does it taste like regular coffee?', 'a' => 'Yes, it tastes very similar to regular instant coffee with a smooth, slightly earthy undertone from the Ganoderma. Most people cannot tell the difference and actually prefer the taste.'],
            ];

            LandingPage::create([
                'title' => $product->name,
                'slug' => $slug,
                'product_id' => $product->id,
                'hero_title' => $product->name,
                'hero_subtitle' => Str::limit($product->description, 150),
                'hero_image' => $product->image,
                'hero_bg_color' => '#452aa8',
                'description' => $product->description,
                'ingredients' => $product->ingredients,
                'usage_directions' => $product->usage,
                'features' => $product->benefits,
                'benefits' => $product->benefits,
                'qna' => $qna,
                'gallery' => [],
                'cta_text' => 'Order via WhatsApp',
                'cta_link' => 'https://wa.me/971555574958?text=' . urlencode('Hi, I want to order: ' . $product->name . ' (SKU: ' . $product->sku . ')'),
                'custom_css' => '',
                'custom_html' => '',
                'published' => true,
            ]);

            $this->command->info("Created product #62: DXN Lingzhi Coffee 2 in 1 with landing page.");
        } else {
            $this->command->info("Product #62 already exists, skipping.");
        }
    }
}
