@extends('layouts.app')
@section('title', 'DXN Leads - Admin')

@section('content')
<div class="bg-dxn-darkgreen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-white">DXN Leads</h1>
        <p class="text-gray-300 mt-1">Landing page submissions and Klaviyo sync status</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.leads') }}" class="px-4 py-2 rounded-lg border {{ !$status ? 'bg-dxn-darkgreen text-white' : 'bg-white text-gray-700' }}">
            All {{ $leads->total() }}
        </a>
        @foreach(['queued', 'syncing', 'retrying', 'synced', 'failed', 'pending'] as $syncStatus)
            <a href="{{ route('admin.leads', ['status' => $syncStatus]) }}" class="px-4 py-2 rounded-lg border {{ $status === $syncStatus ? 'bg-dxn-darkgreen text-white' : 'bg-white text-gray-700' }}">
                {{ ucfirst($syncStatus) }} {{ $counts[$syncStatus] ?? 0 }}
            </a>
        @endforeach
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Lead</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Interest</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Score</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Klaviyo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Submitted</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($leads as $lead)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-900">{{ $lead->name }}</div>
                                <div class="text-sm text-gray-600">{{ $lead->email }}</div>
                                <div class="text-sm text-gray-600">{{ $lead->whatsapp }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm text-gray-900">{{ $lead->interest }}</div>
                                <div class="text-sm text-gray-600">{{ $lead->goal }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800">{{ $lead->score }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ ucfirst($lead->klaviyo_sync_status) }}</div>
                                @if($lead->klaviyo_error)
                                    <div class="mt-1 max-w-xs truncate text-xs text-red-600" title="{{ $lead->klaviyo_error }}">{{ $lead->klaviyo_error }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ optional($lead->submitted_at ?? $lead->created_at)->format('M j, Y g:i A') }}
                            </td>
                            <td class="px-4 py-4 text-right">
                                @if($lead->klaviyo_sync_status !== \App\Models\DxnLead::KLAVIYO_STATUS_SYNCED)
                                    <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="retry">
                                        <button class="text-sm font-semibold text-dxn-darkgreen hover:underline" type="submit">Retry</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" class="inline ml-4" onsubmit="return confirm('Delete this lead?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm font-semibold text-red-600 hover:underline" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-8 text-center text-gray-500" colspan="6">No leads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $leads->links() }}
    </div>
</div>
@endsection
