<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'colors', 'fonts', 'hero', 'contact', 'social', 'seo', 'footer', 'navbar', 'charts',
    ];

    protected $casts = [
        'colors'  => 'array',
        'fonts'   => 'array',
        'hero'    => 'array',
        'contact' => 'array',
        'social'  => 'array',
        'seo'     => 'array',
        'footer'  => 'array',
        'navbar'  => 'array',
        'charts'  => 'array',
    ];

    /**
     * Return the singleton global settings row, creating it with defaults if absent.
     */
    public static function global(): self
    {
        return self::firstOrCreate(['id' => 1], [
            'colors' => [
                'primary'    => '#dfc378',
                'accent'     => '#1a3a2e',
                'background' => '#ffffff',
                'text'       => '#1a2e25',
                'heroBg'     => '#0c3935',
            ],
            'fonts' => [
                'headingFont' => 'Playfair Display',
                'bodyFont'    => 'Inter',
                'baseSize'    => '16px',
                'headingSize' => '2.5rem',
            ],
            'hero' => [
                'badge'    => 'Independent DXN Distributor',
                'title'    => 'Grow Your Health & Wealth with DXN',
                'subtitle' => 'Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life.',
                'btn1Text' => 'Shop Products',
                'btn1Link' => '/products',
                'btn2Text' => 'Join as a Distributor',
                'btn2Link' => '/join',
            ],
            'contact' => [
                'phone'    => '+971 50 666 2875',
                'email'    => 'info@freedomwithdxn.com',
                'whatsapp' => 'https://wa.me/message/EFSQ2IDNVG3YB1',
                'location' => 'United Arab Emirates',
            ],
            'social' => [
                'facebook'  => '',
                'instagram' => '',
                'youtube'   => '',
            ],
            'seo' => [
                'pageTitle'   => 'Freedom with DXN - Health & Business Opportunity',
                'description' => 'Your trusted DXN distributor. Premium Ganoderma products and business opportunity.',
                'keywords'    => 'DXN, Ganoderma, health products, distributor, coffee, supplements',
            ],
            'footer' => [
                'description' => 'Your trusted DXN distributor. We help you achieve health and financial freedom through DXN\'s world-class products.',
                'copyright'   => 'Freedom with DXN. All rights reserved.',
            ],
            'navbar' => [
                'showHome'     => true,
                'showAbout'    => true,
                'showProducts' => true,
                'showJoin'     => true,
                'showZoom'     => true,
                'showBlog'     => true,
                'showContact'  => true,
            ],
            'charts' => [
                'salesChartType'    => 'line',
                'categoryChartType' => 'pie',
                'revenueChartType'  => 'bar',
            ],
        ]);
    }
}
