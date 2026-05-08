<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\MetaConversionsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function joinDxn()
    {
        return view('pages.join');
    }

    public function zoomTraining()
    {
        return view('pages.zoom');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function termsOfService()
    {
        return view('pages.terms-of-service');
    }

    public function contactStore(Request $request, MetaConversionsApi $capi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'event_id' => 'nullable|string|max:64',
        ]);

        ContactMessage::create($request->only('name', 'email', 'subject', 'message'));

        $eventId = $request->input('event_id') ?: (string) Str::uuid();
        $parts   = preg_split('/\s+/', trim($request->name), 2);

        $capi->send('Lead', [
            'content_name' => 'Contact Form',
        ], array_filter([
            'em' => $capi->hash($request->email) ? [$capi->hash($request->email)] : null,
            'fn' => ! empty($parts[0]) && $capi->hash($parts[0]) ? [$capi->hash($parts[0])] : null,
            'ln' => ! empty($parts[1]) && $capi->hash($parts[1]) ? [$capi->hash($parts[1])] : null,
        ]), $eventId);

        return back()->with('success', 'Message sent successfully! We\'ll get back to you soon.');
    }
}
