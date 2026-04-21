@php
    $lang = session('lang', 'en');
    $nb = $settings->navbar ?? [];
    $navLinks = collect([
        ['url' => route('home'),     'label' => $lang === 'ar' ? 'الرئيسية' : 'Home',        'show' => $nb['showHome'] ?? true],
        ['url' => route('about'),    'label' => $lang === 'ar' ? 'من نحن' : 'About',          'show' => $nb['showAbout'] ?? true],
        ['url' => route('products'), 'label' => $lang === 'ar' ? 'المنتجات' : 'Products',     'show' => $nb['showProducts'] ?? true],
        ['url' => route('join'),     'label' => $lang === 'ar' ? 'انضم لـ DXN' : 'Join DXN',  'show' => $nb['showJoin'] ?? true],
        ['url' => route('blog'),     'label' => $lang === 'ar' ? 'المدونة' : 'Blog',          'show' => $nb['showBlog'] ?? true],
        ['url' => route('contact'),  'label' => $lang === 'ar' ? 'اتصل بنا' : 'Contact',     'show' => $nb['showContact'] ?? true],
    ])->where('show', true);
    $cartCount = count(session('cart', []));
@endphp

@push('styles')
<style>
    /* Cart count badge — daisyUI indicator-item style */
    .cart-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 16px;
        height: 16px;
        padding: 0 4px;
        border-radius: 999px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        line-height: 16px;
        text-align: center;
        box-shadow: 0 0 0 2px #fff;
        box-sizing: border-box;
        display: inline-block;
        pointer-events: none;
        -webkit-font-smoothing: antialiased;
    }
</style>
@endpush

<nav class="relative bg-white z-50 transition-shadow duration-300 shadow-sm" aria-label="{{ $lang === 'ar' ? 'التنقل الرئيسي' : 'Main navigation' }}"
     x-data="{ menuOpen: false, dropdownOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-lg' : 'shadow-sm'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20 lg:h-28">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <img src="/footer-lg.png" alt="Grow with DXN - Home" width="200" height="96" class="h-12 sm:h-16 lg:h-24 w-auto object-contain">
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-6">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}"
                       @if(request()->url() === $link['url']) aria-current="page" @endif
                       class="text-base font-medium transition-colors whitespace-nowrap relative {{ request()->url() === $link['url'] ? 'text-brand-green font-bold' : 'text-brand-violet hover:text-brand-green' }}">
                        {{ $link['label'] }}
                        @if(request()->url() === $link['url'])
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-brand-green rounded-full" aria-hidden="true"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Right side --}}
            <div class="h-full flex items-center gap-3 shrink-0">
                {{-- Language Dropdown --}}
                <div class="relative" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                    <button @click="langOpen = !langOpen" aria-expanded="false" :aria-expanded="langOpen.toString()" aria-haspopup="true" aria-label="{{ $lang === 'ar' ? 'تغيير اللغة' : 'Change language' }}" class="flex items-center gap-2 border border-brand-violet/30 text-brand-violet text-sm font-bold px-3 py-1.5 rounded-lg hover:bg-brand-violet/5 transition-colors">
                        @if($lang === 'en')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" class="w-5 h-3.5 rounded-sm overflow-hidden shrink-0" aria-hidden="true"><clipPath id="gb-btn"><rect width="60" height="30" rx="2"/></clipPath><g clip-path="url(#gb-btn)"><rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4" clip-path="url(#gb-btn)"/><path d="M30,0V30M0,15H60" stroke="#fff" stroke-width="10"/><path d="M30,0V30M0,15H60" stroke="#C8102E" stroke-width="6"/></g></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" class="w-5 h-3.5 rounded-sm overflow-hidden shrink-0" aria-hidden="true"><rect width="60" height="30" fill="#fff"/><rect width="60" height="10" fill="#00732f"/><rect y="20" width="60" height="10" fill="#000"/><rect width="15" height="30" fill="#ff0000"/></svg>
                        @endif
                        <span>{{ $lang === 'en' ? 'ENGLISH' : 'العربية' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform" :class="langOpen ? 'rotate-180' : ''" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div x-show="langOpen" x-transition class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50" role="menu">
                        <a href="{{ route('lang.switch', 'en') }}" role="menuitem" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ $lang === 'en' ? 'text-brand-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" class="w-5 h-3.5 rounded-sm overflow-hidden shrink-0" aria-hidden="true"><clipPath id="gb-en"><rect width="60" height="30" rx="2"/></clipPath><g clip-path="url(#gb-en)"><rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4"/><path d="M30,0V30M0,15H60" stroke="#fff" stroke-width="10"/><path d="M30,0V30M0,15H60" stroke="#C8102E" stroke-width="6"/></g></svg>
                            ENGLISH
                        </a>
                        <a href="{{ route('lang.switch', 'ar') }}" role="menuitem" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ $lang === 'ar' ? 'text-brand-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" class="w-5 h-3.5 rounded-sm overflow-hidden shrink-0" aria-hidden="true"><rect width="60" height="30" fill="#fff"/><rect width="60" height="10" fill="#00732f"/><rect y="20" width="60" height="10" fill="#000"/><rect width="15" height="30" fill="#ff0000"/></svg>
                            العربية
                        </a>
                    </div>
                </div>

                {{-- Cart --}}
                <div class="h-full flex items-center" @click.outside="$store.cart.open = false">
                    <button type="button"
                            @click="$store.cart.open = !$store.cart.open; if ($store.cart.open) $store.cart.refresh()"
                            aria-label="{{ $lang === 'ar' ? 'عربة التسوق' : 'Shopping cart' }}"
                            :aria-expanded="$store.cart.open.toString()"
                            class="w-10 h-10 rounded-full flex items-center justify-center text-brand-violet hover:text-brand-green hover:bg-brand-violet/10 transition-colors">
                        <div class="relative inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            <span x-show="$store.cart.count > 0"
                                  x-text="$store.cart.count > 99 ? '99+' : $store.cart.count"
                                  x-transition:enter="transition ease-out duration-200"
                                  x-transition:enter-start="opacity-0 scale-50"
                                  x-transition:enter-end="opacity-100 scale-100"
                                  class="cart-badge tabular-nums"></span>
                        </div>
                    </button>
                    @include('partials.cart-drawer')
                </div>

                {{-- Auth --}}
                @auth
                    <div class="relative" @click.outside="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" aria-label="{{ $lang === 'ar' ? 'قائمة المستخدم' : 'User menu' }}" aria-expanded="false" :aria-expanded="dropdownOpen.toString()" aria-haspopup="true"
                                class="flex items-center gap-2 text-brand-violet hover:text-brand-green transition-colors">
                            <div class="w-8 h-8 bg-brand-violet rounded-full flex items-center justify-center text-white font-bold text-sm" aria-hidden="true">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100" role="menu">
                            <div class="px-4 py-2 border-b">
                                <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-gray-600 text-xs">{{ auth()->user()->role }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" role="menuitem" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                {{ $lang === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                            </a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.index') }}" role="menuitem" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $lang === 'ar' ? 'لوحة الإدارة' : 'Admin Panel' }}
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" role="menuitem" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    {{ $lang === 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-brand-violet hover:text-brand-green text-sm font-medium transition-colors">
                            {{ $lang === 'ar' ? 'تسجيل الدخول' : 'Login' }}
                        </a>
                        <a href="{{ route('join') }}" class="bg-brand-red text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-brand-red-dark transition-colors whitespace-nowrap">
                            {{ $lang === 'ar' ? 'انضم الآن' : 'Join Now' }}
                        </a>
                    </div>
                @endauth

                {{-- Mobile menu button --}}
                <button @click="menuOpen = !menuOpen" class="lg:hidden text-brand-violet hover:text-brand-green" aria-label="{{ $lang === 'ar' ? 'فتح القائمة' : 'Toggle menu' }}" aria-expanded="false" :aria-expanded="menuOpen.toString()" aria-controls="mobile-menu">
                    <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="menuOpen" x-transition class="lg:hidden pb-4 border-t border-gray-100 mt-2" id="mobile-menu" role="navigation" aria-label="{{ $lang === 'ar' ? 'قائمة الهاتف' : 'Mobile menu' }}">
            <div class="flex flex-col gap-1 pt-3">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}" @if(request()->url() === $link['url']) aria-current="page" @endif class="{{ request()->url() === $link['url'] ? 'text-brand-green font-bold' : 'text-brand-violet hover:text-brand-green' }} px-2 py-2 text-sm font-medium">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                @guest
                    <a href="{{ route('login') }}" class="text-brand-violet hover:text-brand-green px-2 py-2 text-sm">
                        {{ $lang === 'ar' ? 'تسجيل الدخول' : 'Login' }}
                    </a>
                    <a href="{{ route('join') }}" class="bg-brand-red text-white px-4 py-2 rounded-full text-sm font-semibold text-center mt-2">
                        {{ $lang === 'ar' ? 'انضم الآن' : 'Join Now' }}
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>
