<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Create reviewer users if they don't exist
        $reviewers = [
            ['name' => 'Ahmed Al Mansouri', 'email' => 'ahmed.m@example.com'],
            ['name' => 'Fatima Hassan', 'email' => 'fatima.h@example.com'],
            ['name' => 'Sarah Johnson', 'email' => 'sarah.j@example.com'],
            ['name' => 'Mohammed Ali', 'email' => 'mohammed.a@example.com'],
            ['name' => 'Priya Sharma', 'email' => 'priya.s@example.com'],
            ['name' => 'James Wilson', 'email' => 'james.w@example.com'],
            ['name' => 'Aisha Rahman', 'email' => 'aisha.r@example.com'],
            ['name' => 'David Chen', 'email' => 'david.c@example.com'],
            ['name' => 'Noor Al Hashimi', 'email' => 'noor.h@example.com'],
            ['name' => 'Maria Santos', 'email' => 'maria.s@example.com'],
            ['name' => 'Omar Khalil', 'email' => 'omar.k@example.com'],
            ['name' => 'Emily Parker', 'email' => 'emily.p@example.com'],
            ['name' => 'Rashid Abdullah', 'email' => 'rashid.a@example.com'],
            ['name' => 'Lisa Thompson', 'email' => 'lisa.t@example.com'],
            ['name' => 'Hassan Youssef', 'email' => 'hassan.y@example.com'],
            ['name' => 'Anna Müller', 'email' => 'anna.m@example.com'],
            ['name' => 'Khalid Saeed', 'email' => 'khalid.s@example.com'],
            ['name' => 'Jennifer Lee', 'email' => 'jennifer.l@example.com'],
            ['name' => 'Tariq Bin Zayed', 'email' => 'tariq.z@example.com'],
            ['name' => 'Sophie Williams', 'email' => 'sophie.w@example.com'],
        ];

        $userIds = [];
        foreach ($reviewers as $r) {
            $user = User::firstOrCreate(
                ['email' => $r['email']],
                ['name' => $r['name'], 'password' => bcrypt('password123'), 'role' => 'user']
            );
            $userIds[] = $user->id;
        }

        // Review templates by category
        $coffeeReviews = [
            [5, 'Amazing coffee! The Ganoderma gives it a smooth, rich taste without the usual bitterness. I drink it every morning and feel more energized throughout the day.', '2025-11-15'],
            [5, 'Best instant coffee I have ever tried. My whole family loves it. We order it every month now. The health benefits are a great bonus!', '2025-12-02'],
            [4, 'Really good flavor and easy to prepare. I wish the sachets were a bit bigger but overall great product. Will buy again.', '2026-01-10'],
            [5, 'I switched from regular coffee to this and noticed a huge difference in my energy levels. No more afternoon crashes!', '2025-10-20'],
            [4, 'Tastes great and dissolves well in hot water. The packaging is convenient for office use. Slightly sweet for my taste but still enjoyable.', '2026-02-05'],
            [5, 'My friend recommended this coffee and I am so glad she did. It is now a staple in my kitchen. Love the smooth texture.', '2025-09-18'],
            [3, 'Decent coffee. The taste is good but I expected it to be stronger. It is a bit mild for my preference, but the health benefits keep me buying.', '2026-01-28'],
            [5, 'Outstanding product! I have been drinking DXN coffee for 3 years now. It helps with my digestion and I feel healthier overall.', '2025-08-12'],
        ];

        $beverageReviews = [
            [5, 'Refreshing and healthy! I love that it has Ganoderma extract. My kids enjoy it too. Perfect alternative to sugary drinks.', '2025-11-22'],
            [4, 'Good taste and very convenient. I take it to work every day. Would recommend to anyone looking for a healthy beverage option.', '2026-01-15'],
            [5, 'This has become my daily health drink. I noticed improvements in my overall well-being after just two weeks of regular consumption.', '2025-10-08'],
            [4, 'Nice flavor and good quality. Shipping was fast. Will definitely order again. My whole family enjoys this product.', '2026-02-20'],
            [5, 'Love this product! It tastes amazing and the health benefits are incredible. I have recommended it to all my friends and colleagues.', '2025-12-10'],
            [3, 'The taste took some getting used to, but now I quite enjoy it. The nutritional value makes it worth it.', '2026-01-05'],
        ];

        $supplementReviews = [
            [5, 'I have been taking this for 6 months and my energy levels have significantly improved. I feel more alert and focused during the day. Highly recommend!', '2025-10-15'],
            [5, 'Excellent quality supplement. I trust DXN products because they use natural ingredients. This has become part of my daily health routine.', '2025-11-28'],
            [4, 'Good results so far. I started taking this on my doctors recommendation. Easy to swallow and no side effects.', '2026-01-20'],
            [5, 'The best Ganoderma supplement on the market. I have tried many brands but DXN consistently delivers the highest quality.', '2025-09-05'],
            [4, 'Very effective product. I noticed a difference in my immune system after about 3 weeks. Will continue using this.', '2026-02-12'],
            [5, 'Life-changing supplement! My cholesterol levels improved and I have more stamina. My doctor was impressed with my results.', '2025-12-18'],
            [4, 'Quality product as expected from DXN. The tablets are easy to take and I appreciate the natural ingredients.', '2026-01-30'],
        ];

        $personalCareReviews = [
            [5, 'My hair has never felt softer! This shampoo is gentle yet effective. The Ganoderma extract makes a real difference.', '2025-11-10'],
            [4, 'Good quality personal care product. My skin feels clean and refreshed after using it. Will purchase again.', '2026-01-08'],
            [5, 'I love that it is made with natural ingredients. No harsh chemicals. My sensitive skin handles it perfectly.', '2025-12-22'],
            [4, 'Great product for the whole family. We have been using DXN personal care products for over a year now. Very satisfied.', '2026-02-01'],
            [5, 'Excellent! My skin condition has improved noticeably. I am a loyal DXN customer now. The quality is unmatched.', '2025-10-30'],
            [3, 'Good product but the scent is a bit strong for me. Otherwise, it works well and leaves my skin feeling clean.', '2026-01-25'],
        ];

        $skincareReviews = [
            [5, 'My skin has never looked better! The Ganoderma extract really makes a difference. I get compliments on my complexion all the time now.', '2025-11-05'],
            [5, 'This is the best skincare product I have used in years. It absorbed quickly and left my skin feeling hydrated all day.', '2025-12-15'],
            [4, 'Very good product. Lightweight and non-greasy. My skin feels nourished without any heaviness. Would recommend!', '2026-01-18'],
            [5, 'I switched my entire skincare routine to DXN products and the results are amazing. My skin is clearer and more radiant.', '2025-10-25'],
            [4, 'Nice product with pleasant scent. Works well under makeup. A little goes a long way which makes it good value.', '2026-02-08'],
            [5, 'After trying countless skincare brands, I finally found one that works. The natural ingredients make all the difference.', '2025-09-20'],
            [4, 'Good moisturizer that does not clog pores. I have combination skin and this works perfectly for me.', '2026-01-12'],
        ];

        // Clear existing reviews
        Review::truncate();

        $products = Product::all();

        foreach ($products as $product) {
            $reviews = match($product->category) {
                'coffee' => $coffeeReviews,
                'beverages' => $beverageReviews,
                'supplements' => $supplementReviews,
                'personal-care' => $personalCareReviews,
                'skincare' => $skincareReviews,
                default => $coffeeReviews,
            };

            // Each product gets 4-7 random reviews
            $numReviews = rand(4, 7);
            $selectedReviews = collect($reviews)->shuffle()->take($numReviews);
            $usedUserIds = collect($userIds)->shuffle()->take($numReviews)->values();

            foreach ($selectedReviews as $i => $review) {
                $reviewer = User::find($usedUserIds[$i]);
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $usedUserIds[$i],
                    'name' => $reviewer->name ?? 'Customer',
                    'rating' => $review[0],
                    'comment' => $review[1],
                    'created_at' => $review[2],
                    'updated_at' => $review[2],
                ]);
            }
        }

        $this->command->info('Added reviews for ' . $products->count() . ' products.');
    }
}
