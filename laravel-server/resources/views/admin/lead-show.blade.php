@extends('layouts.app')
@section('title', 'Lead Details - Admin')

@php
    $submittedAt = $lead->submitted_at ?? $lead->created_at;
    $payload = is_array($lead->payload) ? $lead->payload : [];
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Lead Details</h1>
            <p class="text-gray-300 mt-1">{{ $lead->name }} submitted the DXN Business Landing page form.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.leads') }}" class="bg-white text-dxn-darkgreen px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100">Back to Leads</a>
            <a href="{{ route('admin.dxn-business-landing') }}" class="border border-white/40 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10">Landing CMS</a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Contact Information</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-semibold text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Email Address</dt>
                        <dd class="mt-1 text-gray-900"><a class="text-dxn-green hover:underline" href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Phone/WhatsApp Number</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->whatsapp }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Country Code</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->country_code ?: 'Not available' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Country</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->country_name ?: 'Not available' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Address</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->address ?: 'Not available' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Form Submission Date & Time</dt>
                        <dd class="mt-1 text-gray-900">{{ optional($submittedAt)->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Source</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->source ?: 'Not available' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Form Answers</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-semibold text-gray-500">Interest</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->interest }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Seriousness</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->seriousness }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Goal</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->goal }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Follow-up Timing</dt>
                        <dd class="mt-1 text-gray-900">{{ $lead->learn }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-500">Score</dt>
                        <dd class="mt-1"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800">{{ $lead->score }}</span></dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Raw Submitted Payload</h2>
                @if($payload)
                    <pre class="overflow-x-auto rounded-lg bg-gray-900 text-gray-100 p-4 text-xs">{{ json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                @else
                    <p class="text-sm text-gray-500">No raw payload stored for this lead.</p>
                @endif
            </div>
        </div>

        <aside class="space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Klaviyo Status</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><span class="text-gray-500">Status</span><strong>{{ ucfirst($lead->klaviyo_sync_status) }}</strong></div>
                    <div class="flex justify-between gap-4"><span class="text-gray-500">Synced</span><strong>{{ $lead->klaviyo_synced ? 'Yes' : 'No' }}</strong></div>
                    <div class="flex justify-between gap-4"><span class="text-gray-500">Retry Count</span><strong>{{ $lead->klaviyo_retry_count }}</strong></div>
                    <div class="flex justify-between gap-4"><span class="text-gray-500">Synced At</span><strong>{{ optional($lead->klaviyo_synced_at)->format('M j, Y g:i A') ?: 'Not available' }}</strong></div>
                </div>
                @if($lead->klaviyo_error)
                    <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $lead->klaviyo_error }}</div>
                @endif
            </div>

            <div class="card p-6">
                <h2 class="text-lg font-bold text-dxn-darkgreen mb-4">Actions</h2>
                <div class="flex flex-col gap-3">
                    @if($lead->klaviyo_sync_status !== \App\Models\DxnLead::KLAVIYO_STATUS_SYNCED)
                        <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="retry">
                            <button class="btn-primary w-full" type="submit">Retry Klaviyo Sync</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Delete this lead?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50" type="submit">Delete Lead</button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
