@extends('layouts.app')
@section('title', 'Contact Us – Freedom With DXN')
@section('description', 'Get in touch with Freedom With DXN. Ask about DXN products, distributor signup, or business opportunities. We are here to help you on your wellness journey.')

@php
    $lang = session('lang', 'en');
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/971555574958';
@endphp

@section('keywords', 'contact DXN distributor, DXN UAE contact, freedom with DXN contact, WhatsApp DXN')

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact Freedom with DXN",
    "description": "Get in touch with Freedom With DXN for products, distributor signup, or business opportunities.",
    "url": "{{ url('/contact') }}",
    "mainEntity": {
        "@type": "LocalBusiness",
        "name": "Freedom with DXN",
        "telephone": "{{ $settings->contact['phone'] ?? '+971 55 557 4958' }}",
        "email": "{{ $settings->contact['email'] ?? 'info@freedomwithdxn.com' }}",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "AE",
            "addressRegion": "{{ $settings->contact['location'] ?? 'United Arab Emirates' }}"
        },
        "url": "https://freedomwithdxn.com"
    }
}
</script>
@endpush

@section('content')
{{-- Header --}}
<div class="bg-dxn-darkgreen py-16 px-4 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 70% 50%, #dfc378 0%, transparent 60%)"></div>
    <div class="relative">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $lang === 'ar' ? 'اتصل بنا' : 'Contact Us' }}</h1>
        <p class="text-gray-300">{{ $lang === 'ar' ? 'نحن هنا لمساعدتك' : "We're here to help" }}</p>
    </div>
</div>

{{-- WhatsApp CTA --}}
<div class="bg-[#25D366]/10 border-b border-[#25D366]/20 py-5">
    <div style="max-width: 56rem; margin: 0 auto; padding: 0 1rem; display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap;">
        <span style="font-weight: 700; color: #1f2937; white-space: nowrap;">{{ $lang === 'ar' ? 'تفضّل الحديث المباشر؟' : 'Prefer to chat directly?' }}</span>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-gold" style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            {{ $lang === 'ar' ? 'واتساب مباشر' : 'WhatsApp Direct' }}
        </a>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Contact Info --}}
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-dxn-darkgreen mb-4">{{ $lang === 'ar' ? 'معلومات التواصل' : 'Contact Information' }}</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $lang === 'ar' ? 'سواء أردت تجربة منتجات DXN أو معرفة المزيد عن فرصة العمل أو الانضمام لفريقي — أنا على بعد رسالة!' : "Whether you want to try DXN products, learn about the business opportunity, or join my team — I'm just a message away!" }}
                </p>
            </div>
            @foreach([
                ['label' => $lang === 'ar' ? 'هاتف / واتساب' : 'Phone / WhatsApp', 'value' => $settings->contact['phone'] ?? '+971 55 557 4958'],
                ['label' => $lang === 'ar' ? 'البريد الإلكتروني' : 'Email', 'value' => $settings->contact['email'] ?? 'info@freedomwithdxn.com'],
            ] as $item)
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-dxn-green/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $item['label'] }}</p>
                        <p class="text-sm text-gray-600">{{ $item['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Form --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-xl font-bold text-dxn-darkgreen mb-6">{{ $lang === 'ar' ? 'أرسل رسالة' : 'Send a Message' }}</h2>
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}</label>
                        <input type="text" id="contact-name" name="name" required value="{{ old('name') }}" class="input-field" placeholder="{{ $lang === 'ar' ? 'أدخل اسمك' : 'John Doe' }}" autocomplete="name">
                    </div>
                    <div>
                        <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'البريد الإلكتروني *' : 'Email Address *' }}</label>
                        <input type="email" id="contact-email" name="email" required value="{{ old('email') }}" class="input-field" placeholder="you@example.com" autocomplete="email">
                    </div>
                </div>
                <div>
                    <label for="contact-subject" class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'الموضوع' : 'Subject' }}</label>
                    <input type="text" id="contact-subject" name="subject" value="{{ old('subject') }}" class="input-field" placeholder="{{ $lang === 'ar' ? 'كيف يمكنني مساعدتك؟' : 'How can I help you?' }}">
                </div>
                <div>
                    <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'الرسالة *' : 'Message *' }}</label>
                    <textarea id="contact-message" name="message" required rows="5" class="input-field resize-none" placeholder="{{ $lang === 'ar' ? 'أخبرني المزيد...' : 'Tell me more...' }}">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full">{{ $lang === 'ar' ? 'إرسال الرسالة' : 'Send Message' }}</button>
            </form>
        </div>
    </div>
</div>

{{-- DXN UAE Offices — HIDDEN from visitors (data preserved below) --}}
@if(false)
<section class="bg-gray-50 py-16" aria-labelledby="offices-heading">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 id="offices-heading" class="text-2xl md:text-3xl font-bold" style="color: #46387b;">
                {{ $lang === 'ar' ? 'مكاتب DXN في الإمارات' : 'DXN Offices in UAE' }}
            </h2>
            <p class="text-gray-600 mt-2">{{ $lang === 'ar' ? '10 فروع في جميع أنحاء الإمارات' : '10 branches across the UAE' }}</p>
            <div class="w-16 h-1 mx-auto mt-3 rounded-full" style="background: linear-gradient(90deg, #43af73, #5bc48a);"></div>
        </div>

        @php
            $offices = [
                [
                    'city' => $lang === 'ar' ? 'أبوظبي' : 'Abu Dhabi',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع المصفح' : 'Mussaffah Branch',
                            'address' => $lang === 'ar' ? 'أبوظبي - بناية النيل - بالقرب من سبينيز القديم - الطابق الأرضي 126' : 'Nile Building, near old Spinneys, Ground Floor 126, Mussaffah, Abu Dhabi',
                            'phone' => '024497900',
                            'hours' => $lang === 'ar' ? '10 صباحاً - 9 مساءً' : '10:00 AM – 9:00 PM',
                        ],
                        [
                            'name' => $lang === 'ar' ? 'فرع مدينة أبوظبي' : 'Abu Dhabi City Branch',
                            'address' => $lang === 'ar' ? 'أبوظبي - مركز ماركس آند سبنسر - الطابق الأول - مكتب رقم 16' : 'Marks & Spencer Center, First Floor, Office 16, Abu Dhabi',
                            'phone' => '024441445',
                            'hours' => $lang === 'ar' ? '10 صباحاً - 10 مساءً' : '10:00 AM – 10:00 PM',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'العين' : 'Al Ain',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع العين' : 'Al Ain Branch',
                            'address' => $lang === 'ar' ? 'مقابل العين مول - بناية بنك الإمارات دبي الوطني - الميزانين 1' : 'Opposite Al Ain Mall, Emirates NBD Bank Building, Mezzanine Floor 1',
                            'phone' => '037660049',
                            'hours' => $lang === 'ar' ? '10 صباحاً - 10 مساءً' : '10:00 AM – 10:00 PM',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'دبي' : 'Dubai',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع الكرامة' : 'Karama Branch',
                            'address' => $lang === 'ar' ? 'دبي - بجانب البريد المركزي - بناية الحبايب (بنك الإمارات دبي الوطني) - الميزانين M - مكتب رقم 5' : 'Al Habayi Building (Emirates NBD), Mezzanine Floor M, Office 5, next to Central Post Office, Karama, Dubai',
                            'phone' => '043342107',
                            'hours' => $lang === 'ar' ? '9 صباحاً - 11 مساءً' : '9:00 AM – 11:00 PM',
                        ],
                        [
                            'name' => $lang === 'ar' ? 'فرع ديرة' : 'Deira Branch',
                            'address' => $lang === 'ar' ? 'دبي - منطقة ديرة - برج التوأم (برج رولكس) - شارع بني ياس - الطابق الأرضي - مكتب رقم 25' : 'Twin Tower (Rolex Tower), Bani Yas Street, Ground Floor, Office 25, Deira, Dubai',
                            'phone' => '043234257',
                            'hours' => $lang === 'ar' ? '9 صباحاً - 10 مساءً' : '9:00 AM – 10:00 PM',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'الشارقة' : 'Sharjah',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع كريستال بلازا' : 'Crystal Plaza Branch',
                            'address' => $lang === 'ar' ? 'كريستال بلازا - الميزانين M' : 'Crystal Plaza, Mezzanine Floor M, Sharjah',
                            'phone' => '065748827',
                            'hours' => $lang === 'ar' ? '9 صباحاً - 11 مساءً' : '9:00 AM – 11:00 PM',
                        ],
                        [
                            'name' => $lang === 'ar' ? 'فرع صحارى مول' : 'Sahara Medical City Branch',
                            'address' => $lang === 'ar' ? 'الشارقة - النهدة - صحارى ميديكال سيتي في صحارى مول - الطابق السادس - مكتب رقم 2' : 'Sahara Medical City, Sahara Mall, Al Nahda, 6th Floor, Office 2, Sharjah',
                            'phone' => '067152504',
                            'hours' => $lang === 'ar' ? '9:30 صباحاً - 11 مساءً' : '9:30 AM – 11:00 PM',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'عجمان' : 'Ajman',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع عجمان' : 'Ajman Branch',
                            'address' => $lang === 'ar' ? 'شارع بيروت - بجانب مسجد الصناعية - مقابل محل ماي ديزاين فاشن' : 'Beirut Street, next to Industrial Mosque, opposite My Design Fashion, Ajman',
                            'phone' => '067471010',
                            'hours' => $lang === 'ar' ? '9 صباحاً - 10 مساءً (الجمعة: 2 ظهراً - 10 مساءً)' : '9:00 AM – 10:00 PM (Fri: 2:00 PM – 10:00 PM)',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'رأس الخيمة' : 'Ras Al Khaimah',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع رأس الخيمة' : 'RAK Branch',
                            'address' => $lang === 'ar' ? 'المعمورة - شارع المنتصر - كيرلا هايبر ماركت - الطابق الأرضي' : 'Al Mamoura, Al Muntasir Street, Kerala Hypermarket, Ground Floor, Ras Al Khaimah',
                            'phone' => '072272763',
                            'hours' => $lang === 'ar' ? '10 صباحاً - 1 ظهراً و 5 مساءً - 10 مساءً' : '10:00 AM – 1:00 PM & 5:00 PM – 10:00 PM',
                        ],
                    ],
                ],
                [
                    'city' => $lang === 'ar' ? 'الفجيرة' : 'Fujairah',
                    'branches' => [
                        [
                            'name' => $lang === 'ar' ? 'فرع الفجيرة' : 'Fujairah Branch',
                            'address' => $lang === 'ar' ? 'بناية MUC للهندسة - شارع الشيخ حمد بن عبدالله الشرقي - الطابق الثاني - مكتب 202' : 'MUC Engineering Building, Sheikh Hamad bin Abdullah Al Sharqi Street, 2nd Floor, Office 202, Fujairah',
                            'phone' => '092221355',
                            'hours' => $lang === 'ar' ? '10 صباحاً - 1 ظهراً و 5 مساءً - 10 مساءً' : '10:00 AM – 1:00 PM & 5:00 PM – 10:00 PM',
                        ],
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($offices as $city)
                @foreach($city['branches'] as $branch)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-block text-white text-xs font-bold px-3 py-1 rounded-full" style="background-color: #43af73;">{{ $city['city'] }}</span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-3">{{ $branch['name'] }}</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <span style="color: #43af73; font-size: 16px; line-height: 1; flex-shrink: 0; margin-top: 2px;" aria-hidden="true">&#x1F4CD;</span>
                                <span class="text-gray-600"><span class="sr-only">{{ $lang === 'ar' ? 'العنوان:' : 'Address:' }} </span>{{ $branch['address'] }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span style="color: #43af73; font-size: 16px; line-height: 1; flex-shrink: 0;" aria-hidden="true">&#x1F552;</span>
                                <span class="text-gray-600"><span class="sr-only">{{ $lang === 'ar' ? 'الأوقات:' : 'Hours:' }} </span>{{ $branch['hours'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
