<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'event_type' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:4000'],
            'company' => ['nullable', 'string', 'max:120'],
        ]);

        if (filled($data['company'] ?? null)) {
            return back()->with('contact_status', 'Grazie, il messaggio è stato inviato.')->withInput();
        }

        $recipient = config('mail.contact_to') ?: config('mail.from.address');

        if (blank($recipient)) {
            report(new \RuntimeException('CONTACT_MAIL_TO or MAIL_FROM_ADDRESS is not configured.'));

            return back()
                ->withErrors(['email' => 'Il servizio contatti non è configurato. Riprova più tardi.'])
                ->withInput();
        }

        $subject = 'Richiesta dal sito RingAnnouncer - '.$data['name'];
        $body = view('emails.contact-request', ['data' => $data])->render();

        Mail::html($body, function ($message) use ($recipient, $subject, $data): void {
            $message->to($recipient)
                ->replyTo($data['email'], $data['name'])
                ->subject($subject);
        });

        return back()->with('contact_status', 'Grazie, il messaggio è stato inviato.');
    }
}