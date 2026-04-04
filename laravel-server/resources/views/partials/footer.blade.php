@php
    $lang = session('lang', 'en');
    $contact = $settings->contact ?? [];
    $social = $settings->social ?? [];
    $footer = $settings->footer ?? [];
@endphp

<footer style="background-color: #ffffff; color: #452aa8;">
    <div class="w-full h-px" style="background-color: rgba(69,42,168,0.1);"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        {{-- Brand --}}
        <div>
            <img src="/footer-lg.png" alt="Grow with DXN" loading="lazy" width="200" height="56" class="h-14 w-auto object-contain mb-2">
            <p class="text-sm text-[#452aa8]/60 mb-2">
                {{ $lang === 'ar' ? 'موزع DXN الموثوق. نساعدك على تحقيق الصحة والحرية المالية من خلال منتجات DXN العالمية.' : ($footer['description'] ?? "Your trusted DXN distributor. We help you achieve health and financial freedom through DXN's world-class products.") }}
            </p>
            {{-- Social Media Icons --}}
            <div style="display: flex; flex-wrap: nowrap; gap: 12px; margin-top: 4px;">
                @if(!empty($social['facebook']))
                    <a href="{{ $social['facebook'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                @endif
                @if(!empty($social['instagram']))
                    <a href="{{ $social['instagram'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                @endif
                @if(!empty($social['tiktok']))
                    <a href="{{ $social['tiktok'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 0 0-.79-.05A6.34 6.34 0 0 0 3.15 15.2a6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.98a8.2 8.2 0 0 0 4.76 1.52V7.05a4.84 4.84 0 0 1-1-.36z"/></svg>
                    </a>
                @endif
                @if(!empty($social['threads']))
                    <a href="{{ $social['threads'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="Threads">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 512 512" fill="currentColor" shape-rendering="geometricPrecision"><path d="M105 0h302c57.75 0 105 47.25 105 105v302c0 57.75-47.25 105-105 105H105C47.25 512 0 464.75 0 407V105C0 47.25 47.25 0 105 0z"/><path fill="#ffffff" fill-rule="nonzero" d="M337.36 243.58c-1.46-.7-2.95-1.38-4.46-2.02-2.62-48.36-29.04-76.05-73.41-76.33-25.6-.17-48.52 10.27-62.8 31.94l24.4 16.74c10.15-15.4 26.08-18.68 37.81-18.68h.4c14.61.09 25.64 4.34 32.77 12.62 5.19 6.04 8.67 14.37 10.39 24.89-12.96-2.2-26.96-2.88-41.94-2.02-42.18 2.43-69.3 27.03-67.48 61.21.92 17.35 9.56 32.26 24.32 42.01 12.48 8.24 28.56 12.27 45.26 11.35 22.07-1.2 39.37-9.62 51.45-25.01 9.17-11.69 14.97-26.84 17.53-45.92 10.51 6.34 18.3 14.69 22.61 24.73 7.31 17.06 7.74 45.1-15.14 67.96-20.04 20.03-44.14 28.69-80.55 28.96-40.4-.3-70.95-13.26-90.81-38.51-18.6-23.64-28.21-57.79-28.57-101.5.36-43.71 9.97-77.86 28.57-101.5 19.86-25.25 50.41-38.21 90.81-38.51 40.68.3 71.76 13.32 92.39 38.69 10.11 12.44 17.73 28.09 22.76 46.33l28.59-7.63c-6.09-22.45-15.67-41.8-28.72-57.85-26.44-32.53-65.1-49.19-114.92-49.54h-.2c-49.72.35-87.96 17.08-113.64 49.73-22.86 29.05-34.65 69.48-35.04 120.16v.24c.39 50.68 12.18 91.11 35.04 120.16 25.68 32.65 63.92 49.39 113.64 49.73h.2c44.2-.31 75.36-11.88 101.03-37.53 33.58-33.55 32.57-75.6 21.5-101.42-7.94-18.51-23.08-33.55-43.79-43.48zm-76.32 71.76c-18.48 1.04-37.69-7.26-38.64-25.03-.7-13.18 9.38-27.89 39.78-29.64 3.48-.2 6.9-.3 10.25-.3 11.04 0 21.37 1.07 30.76 3.13-3.5 43.74-24.04 50.84-42.15 51.84z"/></svg>
                    </a>
                @endif
                @if(!empty($social['linkedin']))
                    <a href="{{ $social['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                @endif
                @if(!empty($social['quora']))
                    <a href="{{ $social['quora'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="Quora">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12.73 19.35c-.84-1.52-1.86-2.96-3.6-2.96-.52 0-1.05.15-1.42.46l-.72-1.41c.81-.69 1.9-1.09 3.09-1.09 2.07 0 3.33 1.04 4.27 2.47.43-1.07.66-2.36.66-3.82 0-4.86-1.78-7.95-5.01-7.95S4.99 8.14 4.99 13c0 4.86 1.78 7.95 5.01 7.95.99 0 1.88-.32 2.73-.95v-.65zM10 24C4.48 24 0 18.63 0 13S4.48 2 10 2s10 5.37 10 11c0 2.32-.6 4.45-1.63 6.15.56.93 1.18 1.56 1.95 1.56.62 0 1-.31 1.22-.72l1.16 1.41C22.08 22.36 21.07 24 19.14 24c-1.56 0-2.71-.93-3.58-2.18C14.24 23.2 12.22 24 10 24z"/></svg>
                    </a>
                @endif
                @if(!empty($social['youtube']))
                    <a href="{{ $social['youtube'] }}" target="_blank" rel="noopener noreferrer" class="footer-social" title="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19.13C5.12 19.56 12 19.56 12 19.56s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.43z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Quick Links --}}
        <div>
            <h3 class="text-brand-green font-semibold mb-4">{{ $lang === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="footer-link">{{ $lang === 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                <li><a href="{{ route('products') }}" class="footer-link">{{ $lang === 'ar' ? 'المنتجات' : 'Products' }}</a></li>
                <li><a href="{{ route('business') }}" class="footer-link">{{ $lang === 'ar' ? 'فرصة العمل' : 'Business Opportunity' }}</a></li>
                <li><a href="{{ route('blog') }}" class="footer-link">{{ $lang === 'ar' ? 'المدونة' : 'Blog' }}</a></li>
                <li><a href="{{ route('contact') }}" class="footer-link">{{ $lang === 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a></li>
            </ul>
        </div>

        {{-- Products --}}
        <div>
            <h3 class="text-brand-green font-semibold mb-4">{{ $lang === 'ar' ? 'المنتجات' : 'Products' }}</h3>
            <ul class="space-y-2 text-sm">
                @foreach([
                    ['label' => 'Ganoderma', 'labelAr' => 'غانوديرما', 'cat' => 'ganoderma'],
                    ['label' => 'DXN Coffee', 'labelAr' => 'قهوة DXN', 'cat' => 'coffee'],
                    ['label' => 'Health Supplements', 'labelAr' => 'مكملات صحية', 'cat' => 'supplements'],
                    ['label' => 'Skincare', 'labelAr' => 'العناية بالبشرة', 'cat' => 'skincare'],
                    ['label' => 'Beverages', 'labelAr' => 'مشروبات', 'cat' => 'beverages'],
                ] as $item)
                    <li><a href="{{ route('products', ['category' => $item['cat']]) }}" class="footer-link">{{ $lang === 'ar' ? $item['labelAr'] : $item['label'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="text-brand-green font-semibold mb-4">{{ $lang === 'ar' ? 'اتصل بنا' : 'Contact' }}</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-green mt-0.5 shrink-0"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="text-[#452aa8]/70">{{ $contact['location'] ?? 'United Arab Emirates' }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-green shrink-0"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span class="text-[#452aa8]/70">{{ $contact['phone'] ?? '+971 50 666 2875' }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-green shrink-0"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span class="text-[#452aa8]/70">{{ $contact['email'] ?? 'info@freedomwithdxn.com' }}</span>
                </li>
            </ul>

        </div>
    </div>

    <div class="border-t py-4 text-center text-sm px-4" style="border-color: rgba(69,42,168,0.1); background-color: #f9f9f9; color: #452aa8;">
        <p>&copy; {{ date('Y') }} {{ $lang === 'ar' ? 'Freedom with DXN. جميع الحقوق محفوظة.' : ($footer['copyright'] ?? 'Freedom with DXN. All rights reserved.') }}</p>
        <p class="text-xs mt-1" style="color: rgba(69,42,168,0.7);">{{ $lang === 'ar' ? 'موزع DXN مستقل. DXN علامة تجارية مسجلة لشركة DXN Holdings Berhad.' : 'Independent DXN Distributor. DXN is a registered trademark of DXN Holdings Berhad.' }}</p>
    </div>
</footer>
