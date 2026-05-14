<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SyncDxnLeadToKlaviyo;
use App\Models\DxnLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function show(): RedirectResponse
    {
        return redirect()->route('landing.dxn-business-opportunity');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('landing.dxn-business-opportunity');
    }

    public function adminIndex(Request $request): View
    {
        $status = $request->query('status');

        $leads = DxnLead::query()
            ->when($status, fn ($query) => $query->where('klaviyo_sync_status', $status))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $counts = DxnLead::query()
            ->selectRaw('klaviyo_sync_status, count(*) as total')
            ->groupBy('klaviyo_sync_status')
            ->pluck('total', 'klaviyo_sync_status');

        return view('admin.leads', compact('leads', 'counts', 'status'));
    }

    public function adminUpdate(Request $request, DxnLead $lead): RedirectResponse
    {
        $action = $request->input('action');

        if ($action === 'retry') {
            $lead->forceFill([
                'klaviyo_synced' => false,
                'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_QUEUED,
                'klaviyo_error' => null,
                'klaviyo_next_retry_at' => null,
            ])->save();

            SyncDxnLeadToKlaviyo::dispatch($lead->id)
                ->onQueue(config('services.klaviyo.queue', 'klaviyo'));

            return back()->with('success', 'Lead queued for Klaviyo sync.');
        }

        return back()->with('error', 'Unknown lead action.');
    }

    public function adminDestroy(DxnLead $lead): RedirectResponse
    {
        $lead->delete();

        return back()->with('success', 'Lead deleted.');
    }
}
