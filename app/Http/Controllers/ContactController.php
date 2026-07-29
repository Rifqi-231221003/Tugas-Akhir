<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact-us');
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'user_message' => $request->message,
            ];

            // Kirim email ke admin@exachanger.com
            Mail::send('emails.contact-form', $data, function ($message) use ($data) {
                $message->to('admin@exachanger.com')
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->subject('New Contact Message: ' . $data['subject']);
            });

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');

        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again later.')->withInput();
        }
    }
}