@extends('layouts.app')
@section('title', 'DXN Business Landing page - Admin')

@php
    $value = fn (string $key) => old($key, data_get($landingSettings, $key, ''));
    $leadTotal = $recentLeads->count();
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">DXN Business Landing page</h1>
            <p class="text-gray-300 mt-1">Edit content, form fields, and review landing page leads.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('landing.dxn-business-opportunity') }}" target="_blank" class="bg-white text-dxn-darkgreen px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100">View landing page</a>
            <a href="{{ route('admin.index') }}" class="border border-white/40 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10">Back to Admin</a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="#edit-content" class="card p-5 hover:shadow-lg transition-shadow">
            <h2 class="font-bold text-dxn-darkgreen">Edit content</h2>
            <p class="text-sm text-gray-500 mt-1">Hero, video, offer, SEO, and WhatsApp text.</p>
        </a>
        <a href="{{ route('admin.leads') }}" class="card p-5 hover:shadow-lg transition-shadow">
            <h2 class="font-bold text-dxn-darkgreen">View leads</h2>
            <p class="text-sm text-gray-500 mt-1">Hot {{ $leadCounts['Hot'] ?? 0 }} / Warm {{ $leadCounts['Warm'] ?? 0 }} / Cold {{ $leadCounts['Cold'] ?? 0 }}</p>
        </a>
        <a href="#form-fields" class="card p-5 hover:shadow-lg transition-shadow">
            <h2 class="font-bold text-dxn-darkgreen">Settings/form fields</h2>
            <p class="text-sm text-gray-500 mt-1">Question labels, placeholders, privacy, success text.</p>
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <form method="POST" action="{{ route('admin.dxn-business-landing.update') }}" class="xl:col-span-2 space-y-6">
            @csrf
            @method('PUT')

            <div class="card p-6" id="edit-content">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Edit content</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SEO title</label>
                        <input name="content[seo_title]" class="input-field" value="{{ $value('content.seo_title') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta description</label>
                        <textarea name="content[meta_description]" rows="2" class="input-field" required>{{ $value('content.meta_description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero trust line</label>
                        <input name="content[hero_trust]" class="input-field" value="{{ $value('content.hero_trust') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero title</label>
                        <textarea name="content[hero_title]" rows="2" class="input-field" required>{{ $value('content.hero_title') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero subtitle</label>
                        <textarea name="content[hero_subtitle]" rows="3" class="input-field" required>{{ $value('content.hero_subtitle') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Main button text</label>
                            <input name="content[primary_cta_text]" class="input-field" value="{{ $value('content.primary_cta_text') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reassurance text</label>
                            <input name="content[reassurance]" class="input-field" value="{{ $value('content.reassurance') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero chips (one per line)</label>
                        <textarea name="content[chips_text]" rows="4" class="input-field">{{ $value('content.chips_text') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Overview card title</label>
                            <input name="content[overview_card_title]" class="input-field" value="{{ $value('content.overview_card_title') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Overview card text</label>
                            <input name="content[overview_card_text]" class="input-field" value="{{ $value('content.overview_card_text') }}" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stats</label>
                            <textarea name="content[stats_text]" rows="4" class="input-field" placeholder="35+|years">{{ $value('content.stats_text') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Format: number|label, one per line.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trust strip items</label>
                            <textarea name="content[trust_items_text]" rows="4" class="input-field">{{ $value('content.trust_items_text') }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Video section title</label>
                        <input name="content[overview_title]" class="input-field" value="{{ $value('content.overview_title') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Video section description</label>
                        <textarea name="content[overview_description]" rows="2" class="input-field" required>{{ $value('content.overview_description') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Video poster path</label>
                            <input name="content[video_poster]" class="input-field" value="{{ $value('content.video_poster') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Video source path</label>
                            <input name="content[video_source]" class="input-field" value="{{ $value('content.video_source') }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gift kicker</label>
                            <input name="content[gift_kicker]" class="input-field" value="{{ $value('content.gift_kicker') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gift title</label>
                            <input name="content[gift_title]" class="input-field" value="{{ $value('content.gift_title') }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gift description</label>
                        <textarea name="content[gift_description]" rows="2" class="input-field">{{ $value('content.gift_description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Offer/gift list (one per line)</label>
                        <textarea name="content[gift_items_text]" rows="5" class="input-field">{{ $value('content.gift_items_text') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gift button text</label>
                            <input name="content[gift_cta_text]" class="input-field" value="{{ $value('content.gift_cta_text') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Qualifier eyebrow</label>
                            <input name="content[qualifier_eyebrow]" class="input-field" value="{{ $value('content.qualifier_eyebrow') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qualifier title</label>
                        <input name="content[qualifier_title]" class="input-field" value="{{ $value('content.qualifier_title') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qualifier description</label>
                        <textarea name="content[qualifier_description]" rows="2" class="input-field" required>{{ $value('content.qualifier_description') }}</textarea>
                    </div>
                    <div class="border-t pt-5 mt-5 space-y-4">
                        <h3 class="font-bold text-dxn-darkgreen">Middle page sections</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Why eyebrow</label><input name="content[why_eyebrow]" class="input-field" value="{{ $value('content.why_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Why title</label><input name="content[why_title]" class="input-field" value="{{ $value('content.why_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Why description</label><textarea name="content[why_description]" rows="2" class="input-field">{{ $value('content.why_description') }}</textarea></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Why cards</label><textarea name="content[why_cards_text]" rows="5" class="input-field">{{ $value('content.why_cards_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: title|description, one card per line.</p></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Why note</label><input name="content[why_note]" class="input-field" value="{{ $value('content.why_note') }}"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Problem eyebrow</label><input name="content[problem_eyebrow]" class="input-field" value="{{ $value('content.problem_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Problem title</label><input name="content[problem_title]" class="input-field" value="{{ $value('content.problem_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Problem cards</label><textarea name="content[problem_cards_text]" rows="4" class="input-field">{{ $value('content.problem_cards_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: title|description, one card per line.</p></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Problem bridge</label><textarea name="content[problem_bridge]" rows="2" class="input-field">{{ $value('content.problem_bridge') }}</textarea></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Opportunity eyebrow</label><input name="content[opportunity_eyebrow]" class="input-field" value="{{ $value('content.opportunity_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Opportunity title</label><input name="content[opportunity_title]" class="input-field" value="{{ $value('content.opportunity_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Opportunity description</label><input name="content[opportunity_description]" class="input-field" value="{{ $value('content.opportunity_description') }}"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Opportunity steps</label><textarea name="content[opportunity_steps_text]" rows="4" class="input-field">{{ $value('content.opportunity_steps_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: badge|title|description, one step per line.</p></div>
                    </div>

                    <div class="border-t pt-5 mt-5 space-y-4">
                        <h3 class="font-bold text-dxn-darkgreen">Testimonials, FAQ, and final CTA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Stories eyebrow</label><input name="content[stories_eyebrow]" class="input-field" value="{{ $value('content.stories_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Stories title</label><input name="content[stories_title]" class="input-field" value="{{ $value('content.stories_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Testimonials</label><textarea name="content[testimonials_text]" rows="5" class="input-field">{{ $value('content.testimonials_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: quote|name|location/status|initials, one testimonial per line.</p></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Proof note</label><input name="content[proof_note]" class="input-field" value="{{ $value('content.proof_note') }}"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Journey eyebrow</label><input name="content[journey_eyebrow]" class="input-field" value="{{ $value('content.journey_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Journey title</label><input name="content[journey_title]" class="input-field" value="{{ $value('content.journey_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Journey steps</label><textarea name="content[journey_steps_text]" rows="4" class="input-field">{{ $value('content.journey_steps_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: number|title|description, one step per line.</p></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">FAQ eyebrow</label><input name="content[faq_eyebrow]" class="input-field" value="{{ $value('content.faq_eyebrow') }}"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">FAQ title</label><input name="content[faq_title]" class="input-field" value="{{ $value('content.faq_title') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">FAQ items</label><textarea name="content[faq_items_text]" rows="6" class="input-field">{{ $value('content.faq_items_text') }}</textarea><p class="text-xs text-gray-400 mt-1">Format: question|answer 1|answer 2, one FAQ per line.</p></div>

                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Final urgency</label><input name="content[final_urgency]" class="input-field" value="{{ $value('content.final_urgency') }}"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Final title</label><input name="content[final_title]" class="input-field" value="{{ $value('content.final_title') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Final description</label><textarea name="content[final_description]" rows="2" class="input-field">{{ $value('content.final_description') }}</textarea></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Final button text</label><input name="content[final_button_text]" class="input-field" value="{{ $value('content.final_button_text') }}" required></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Mobile CTA text</label><input name="content[mobile_cta_text]" class="input-field" value="{{ $value('content.mobile_cta_text') }}" required></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Final trust line</label><input name="content[final_trust_line]" class="input-field" value="{{ $value('content.final_trust_line') }}"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp URL</label>
                            <input name="content[whatsapp_url]" class="input-field" value="{{ $value('content.whatsapp_url') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp message</label>
                            <input name="content[whatsapp_message]" class="input-field" value="{{ $value('content.whatsapp_message') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-6" id="form-fields">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Settings/form fields</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Step 1 title</label>
                            <input name="form[step_one_title]" class="input-field" value="{{ $value('form.step_one_title') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Step 1 subtitle</label>
                            <input name="form[step_one_subtitle]" class="input-field" value="{{ $value('form.step_one_subtitle') }}" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Health option</label><input name="form[interest_health_label]" class="input-field" value="{{ $value('form.interest_health_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Income option</label><input name="form[interest_income_label]" class="input-field" value="{{ $value('form.interest_income_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Both option</label><input name="form[interest_both_label]" class="input-field" value="{{ $value('form.interest_both_label') }}" required></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Step 4 title</label><input name="form[step_four_title]" class="input-field" value="{{ $value('form.step_four_title') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Step 4 subtitle</label><input name="form[step_four_subtitle]" class="input-field" value="{{ $value('form.step_four_subtitle') }}" required></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Learn yes option</label><input name="form[learn_yes_label]" class="input-field" value="{{ $value('form.learn_yes_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Learn maybe option</label><input name="form[learn_maybe_label]" class="input-field" value="{{ $value('form.learn_maybe_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Learn no option</label><input name="form[learn_no_label]" class="input-field" value="{{ $value('form.learn_no_label') }}" required></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Contact step title</label><input name="form[contact_title]" class="input-field" value="{{ $value('form.contact_title') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Contact step subtitle</label><input name="form[contact_subtitle]" class="input-field" value="{{ $value('form.contact_subtitle') }}" required></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Name label</label><input name="form[name_label]" class="input-field" value="{{ $value('form.name_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Name placeholder</label><input name="form[name_placeholder]" class="input-field" value="{{ $value('form.name_placeholder') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Email label</label><input name="form[email_label]" class="input-field" value="{{ $value('form.email_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Email placeholder</label><input name="form[email_placeholder]" class="input-field" value="{{ $value('form.email_placeholder') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp label</label><input name="form[whatsapp_label]" class="input-field" value="{{ $value('form.whatsapp_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone placeholder</label><input name="form[phone_placeholder]" class="input-field" value="{{ $value('form.phone_placeholder') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Address label</label><input name="form[address_label]" class="input-field" value="{{ $value('form.address_label') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Address placeholder</label><input name="form[address_placeholder]" class="input-field" value="{{ $value('form.address_placeholder') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Country search placeholder</label><input name="form[country_search_placeholder]" class="input-field" value="{{ $value('form.country_search_placeholder') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Country empty text</label><input name="form[country_empty_text]" class="input-field" value="{{ $value('form.country_empty_text') }}" required></div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone help text</label><input name="form[phone_help]" class="input-field" value="{{ $value('form.phone_help') }}"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Validation error</label><input name="form[validation_error]" class="input-field" value="{{ $value('form.validation_error') }}" required></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Submit button text</label><input name="form[submit_text]" class="input-field" value="{{ $value('form.submit_text') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Privacy text</label><input name="form[privacy_text]" class="input-field" value="{{ $value('form.privacy_text') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Success title</label><input name="form[success_title]" class="input-field" value="{{ $value('form.success_title') }}" required></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Success badge</label><input name="form[success_badge]" class="input-field" value="{{ $value('form.success_badge') }}" required></div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Success message</label><input name="form[success_message]" class="input-field" value="{{ $value('form.success_message') }}" required></div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">Save DXN Business Landing page</button>
                <a href="{{ route('landing.dxn-business-opportunity') }}" target="_blank" class="text-dxn-green hover:underline">Preview page</a>
            </div>
        </form>

        <aside class="space-y-6">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-dxn-darkgreen">View leads</h2>
                    <a href="{{ route('admin.leads') }}" class="text-dxn-green hover:underline text-sm">All leads</a>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-red-50 text-red-700 rounded-lg p-3 text-center"><div class="text-xl font-bold">{{ $leadCounts['Hot'] ?? 0 }}</div><div class="text-xs">Hot</div></div>
                    <div class="bg-yellow-50 text-yellow-700 rounded-lg p-3 text-center"><div class="text-xl font-bold">{{ $leadCounts['Warm'] ?? 0 }}</div><div class="text-xs">Warm</div></div>
                    <div class="bg-blue-50 text-blue-700 rounded-lg p-3 text-center"><div class="text-xl font-bold">{{ $leadCounts['Cold'] ?? 0 }}</div><div class="text-xs">Cold</div></div>
                </div>
                <div class="space-y-3">
                    @forelse($recentLeads as $lead)
                        <a href="{{ route('admin.leads.show', $lead) }}" class="block border border-gray-100 rounded-lg p-3 hover:border-dxn-green hover:shadow-sm transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $lead->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $lead->email }}</div>
                                </div>
                                <span class="text-xs font-semibold rounded-full bg-gray-100 px-2 py-1">{{ $lead->score }}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">{{ optional($lead->submitted_at ?? $lead->created_at)->format('M j, Y g:i A') }}</div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">No leads yet.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
