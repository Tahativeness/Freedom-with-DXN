<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class IngredientsSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            // COFFEE
            'FB369' => 'Non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, stabilizers, emulsifiers), sugar, instant coffee powder, Ganoderma lucidum extract. 20 sachets x 21g.',
            'FB370' => 'Non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, stabilizers, emulsifiers), reduced sugar, instant coffee powder, Ganoderma lucidum extract. 20 sachets x 21g.',
            'FB371' => 'Instant coffee powder, non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, stabilizers), Ganoderma lucidum extract. No added sugar. 20 sachets x 14g.',
            'FB372' => 'Non-dairy creamer, sugar, instant coffee powder, Cordyceps sinensis extract. 20 sachets x 21g.',
            'FB373' => 'Non-dairy creamer, sugar, instant coffee powder, cocoa powder, Ganoderma lucidum extract. 20 sachets x 21g.',
            'FB374' => 'Non-dairy creamer, sugar, white coffee powder (lightly roasted), Ganoderma lucidum extract. 20 sachets x 28g.',
            'FB375' => 'Instant coffee powder (freeze-dried Arabica/Robusta blend), Ganoderma lucidum extract. No sugar, no creamer. 20 sachets x 4.5g.',
            'FB376' => 'Non-dairy creamer, sugar, instant coffee powder, Ganoderma lucidum extract, Tongkat Ali (Eurycoma longifolia) extract, Panax ginseng extract. 20 sachets x 21g.',
            'FB002' => 'Non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, dipotassium phosphate, mono- and diglycerides of fatty acids, silicon dioxide), sugar, instant coffee powder, Ganoderma lucidum extract. 20 sachets x 21g (420g total).',
            'FB054' => 'Instant coffee powder, Ganoderma lucidum extract. No sugar, no creamer. 20 sachets x 4.5g (90g total).',
            'FB066' => 'Non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate, stabilizers, emulsifiers), sugar (reduced amount), instant coffee powder, Ganoderma lucidum extract. 20 sachets x 21g.',
            'FB129' => 'Non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate), sugar, instant coffee powder, Cordyceps sinensis (Ophiocordyceps) extract. 20 sachets x 21g.',
            'FB130' => 'Non-dairy creamer (higher ratio), sugar, instant coffee powder, Ganoderma lucidum extract. 20 sachets x 14g.',

            // BEVERAGES
            'FB025' => 'Cocoa powder, sugar, non-dairy creamer (glucose syrup, hydrogenated palm kernel oil, sodium caseinate), Ganoderma lucidum extract, malt extract. 20 sachets x 32g (640g total).',
            'FB007' => 'Morinda citrifolia (Noni) fruit juice, Ganoderma lucidum extract, roselle (Hibiscus sabdariffa) extract, purified water, permitted food flavoring. 285ml bottle.',
            'FB065' => 'Morinda citrifolia (Noni) fruit juice, Ganoderma lucidum extract, roselle (Hibiscus sabdariffa) extract, purified water, permitted food flavoring. 700ml bottle.',
            'FB005' => 'Roselle (Hibiscus sabdariffa) extract, sugar, citric acid, purified water, permitted flavoring, vitamin C. 285ml bottle.',
            'FB053' => 'Pineapple (Ananas comosus) juice, Cordyceps sinensis extract, enzyme (bromelain from pineapple), purified water, permitted flavoring. 700ml bottle.',
            'FB155' => 'Lemon juice concentrate, honey, Ganoderma lucidum extract, purified water, citric acid. 20 sachets.',
            'FB301' => 'Non-dairy creamer, sugar, tea powder, Ganoderma lucidum extract. 20 sachets x 25g.',
            'FB032' => 'Cereal grains (oat, wheat, rice, corn), soy protein, Spirulina platensis, sugar, non-dairy creamer, permitted flavoring. 20 sachets x 30g.',
            'FB050' => 'Apple cider vinegar, honey, Ganoderma lucidum extract, purified water. 285ml bottle.',
            'FB143' => 'Sugar, mint powder (peppermint), Ganoderma lucidum extract, citric acid, permitted flavoring, menthol.',
            'FB033' => 'Pineapple powder, sugar, citric acid, Ganoderma lucidum extract, permitted flavoring.',
            'FB173' => 'Noodles: wheat flour, salt, Spirulina platensis. Seasoning: salt, sugar, spices, flavor enhancers, soy sauce powder, vegetable powder, Spirulina. Tom Yam flavor.',
            'FB360' => 'Sugar (sucrose), Ganoderma lucidum extract. Individual sachets.',

            // SUPPLEMENTS
            'HF029' => 'Hericium erinaceus (Lion\'s Mane mushroom) mycelium powder, microcrystalline cellulose (binder), stearic acid, magnesium stearate, silicon dioxide. 300mg x 120 tablets.',
            'HF030' => 'Cordyceps sinensis mycelium powder, microcrystalline cellulose, stearic acid, magnesium stearate, silicon dioxide. 300mg x 120 tablets.',
            'HF041' => '100% Ganoderma lucidum (Red Reishi) fruiting body powder — crushed and micronized. No fillers, no binders. 90-day old Ganoderma. 70g powder.',
            'HF031' => 'Spirulina platensis (DXN-farm cultivated), microcrystalline cellulose, stearic acid, silicon dioxide. 250mg x 120 tablets. Rich in protein, B-vitamins, iron, beta-carotene.',
            'HF038' => 'Spirulina platensis, microcrystalline cellulose, stearic acid, silicon dioxide. 250mg x 500 tablets. Economy size.',
            'HF082' => '100% natural bee pollen granules (multi-floral). Contains proteins, amino acids, lipids, vitamins (B-complex, C, E), minerals (calcium, magnesium, zinc, iron, potassium), enzymes, flavonoids. 40g.',
            'HF039' => 'Ganoderma lucidum, Lion\'s Mane (Hericium erinaceus), Spirulina, nori seaweed, green tea, ginger, vegetable powders (broccoli, spinach, celery), oat fiber, soy protein isolate, fructo-oligosaccharides (prebiotic fiber). 20 sachets x 25g.',
            'HF044' => 'Ganoderma lucidum extract, Eurycoma longifolia (Tongkat Ali) extract, Cordyceps sinensis extract, green tea extract. 370mg x 90 capsules. 9 pure herb extracts.',

            // PERSONAL CARE
            'PC004' => 'Aqua, sodium laureth sulfate, cocamidopropyl betaine, Ganoderma lucidum extract, panthenol (pro-vitamin B5), glycerin, sodium chloride, citric acid, preservatives, parfum. 250ml.',
            'PC005' => 'Aqua, sodium laureth sulfate, cocamidopropyl betaine, Ganoderma lucidum extract, glycerin, parfum, sodium chloride, citric acid, preservatives, colorant. 250ml.',
            'PC006' => 'Calcium carbonate (mild abrasive), aqua, sorbitol, sodium lauryl sulfate, Ganoderma lucidum extract, menthol, peppermint oil, cellulose gum, sodium saccharin, sodium benzoate. No fluoride. 150g.',
            'PC007' => 'Mineral oil (paraffinum liquidum), Ganoderma lucidum extract, tocopheryl acetate (vitamin E), parfum, essential oil blend (lavender, eucalyptus). 75ml.',
            'PC015' => 'Talc, Ganoderma lucidum extract, fragrance, magnesium carbonate, zinc stearate.',
            'PC020' => 'Calcium carbonate, aqua, sorbitol, glycerin, Ganoderma lucidum extract (enhanced concentration), sodium lauryl sulfate, menthol, peppermint oil, tea tree oil, cellulose gum. SLS & Paraben free. No fluoride. 150g.',
            'PC039' => 'Aqua, sodium laureth sulfate, cocamidopropyl betaine, Ganoderma lucidum extract (enhanced concentration), panthenol, glycerin, polyquaternium-7 (conditioning agent), sodium chloride, citric acid, preservatives, parfum. SLES & SLS free. 250ml.',
            'PC041' => 'Nylon bristles (soft/medium), ergonomic plastic handle with built-in tongue cleaner. Available in 4 colors.',
            'PC042' => 'Nylon bristles (extra soft), child-friendly small plastic handle with tongue cleaner. For ages 3+. Available in 4 colors.',
            'PC045' => 'Aqua, cetearyl alcohol, mineral oil, Ganoderma lucidum extract, nutmeg oil, glycerin, stearic acid, dimethicone, parfum. Fast-absorption cream.',
            'PC074' => 'Sodium palmate, sodium palm kernelate, aqua, Camellia sinensis (green tea) extract, Ganoderma lucidum extract, glycerin, parfum, sodium chloride. 120g bar.',
            'PC120' => 'Sodium palmate, sodium palm kernelate, aqua, Ganoderma lucidum extract, glycerin, parfum, sodium chloride, titanium dioxide. 80g bar.',
            'PC014' => 'Aqua, Melaleuca alternifolia (tea tree) oil, cetearyl alcohol, mineral oil, Ganoderma lucidum extract, glycerin, stearic acid, tocopheryl acetate (vitamin E), parfum.',

            // SKINCARE
            'SC009N' => 'Aqua, butylene glycol, Ganoderma lucidum extract, hamamelis virginiana (witch hazel) water, glycerin, niacinamide, allantoin, sodium hyaluronate, panthenol, citric acid, phenoxyethanol, parfum. 150ml.',
            'SC010N' => 'Aqua, cyclopentasiloxane, glycerin, Ganoderma lucidum extract, butylene glycol, cetearyl alcohol, dimethicone, niacinamide, tocopheryl acetate (vitamin E), sodium hyaluronate, ceteareth-20, carbomer, phenoxyethanol, parfum. 50ml.',
            'SC011N' => 'Aqua, sodium laureth sulfate, cocamidopropyl betaine, Ganoderma lucidum extract, glycerin, PEG-7 glyceryl cocoate, sodium chloride, citric acid, phenoxyethanol, parfum. 150ml.',
            'SC012' => 'Mineral oil (paraffinum liquidum), isopropyl myristate, Ganoderma lucidum extract, tocopheryl acetate (vitamin E), hypoallergenic parfum. Dermatologically tested. 200ml.',
            'SC014' => 'Ricinus communis (castor) seed oil, candelilla cera, cera alba (beeswax), Ganoderma lucidum extract, aloe vera extract, shea butter, cetyl alcohol, tocopheryl acetate (vitamin E), parfum. Shade: Coco Red.',
            'SC015' => 'Ricinus communis seed oil, candelilla cera, cera alba, Ganoderma lucidum extract, aloe vera extract, shea butter, mica (pearl effect), cetyl alcohol, tocopheryl acetate, parfum. Shade: Pearly Red.',
            'SC016' => 'Ricinus communis seed oil, candelilla cera, cera alba, Ganoderma lucidum extract, aloe vera extract, shea butter, mica (pearl effect), cetyl alcohol, tocopheryl acetate, parfum. Shade: Pearly Pink.',
            'SC017' => 'Ricinus communis seed oil, candelilla cera, cera alba, Ganoderma lucidum extract, aloe vera extract, shea butter, mica (pearl effect), cetyl alcohol, tocopheryl acetate, parfum. Shade: Pearly Grape.',
            'SC020' => 'Aqua, aloe barbadensis leaf juice, sodium laureth sulfate, cocamidopropyl betaine, glycerin, Ganoderma lucidum extract, sodium chloride, citric acid, phenoxyethanol, parfum. Soap-free formula.',
            'SC021' => 'Aqua, aloe barbadensis leaf juice, butylene glycol, glycerin, Ganoderma lucidum extract, sodium hyaluronate, allantoin, panthenol, citric acid, phenoxyethanol, parfum.',
            'SC022' => 'Aqua, aloe barbadensis leaf juice, glycerin, Ganoderma lucidum extract, carbomer, sodium hyaluronate, allantoin, phenoxyethanol, parfum. Lightweight gel formula.',
            'SC023' => 'Aqua, aloe barbadensis leaf juice, glycerin, cetearyl alcohol, Ganoderma lucidum extract, dimethicone, shea butter (butyrospermum parkii), tocopheryl acetate (vitamin E), sodium hyaluronate, carbomer, phenoxyethanol, parfum. Night cream.',
            'SC024' => 'Aqua, aloe barbadensis leaf juice, mineral oil, glycerin, cetearyl alcohol, Ganoderma lucidum extract, stearic acid, dimethicone, tocopheryl acetate, parfum. Non-greasy formula.',
            'SC073' => 'Mineral oil (paraffinum liquidum), isopropyl myristate, Ganoderma lucidum extract, tocopheryl acetate (vitamin E), hypoallergenic parfum. Travel size. 40ml.',
        ];

        foreach ($ingredients as $sku => $ingredientText) {
            Product::where('sku', $sku)->update(['ingredients' => $ingredientText]);
        }

        $this->command->info('Updated ingredients for ' . count($ingredients) . ' products.');
    }
}
