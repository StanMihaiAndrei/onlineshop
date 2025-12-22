<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Numele este obligatoriu.',
            'email.required' => 'Email-ul este obligatoriu.',
            'email.email' => 'Adresa de email nu este validă.',
            'subject.required' => 'Subiectul este obligatoriu.',
            'message.required' => 'Mesajul este obligatoriu.',
            'message.min' => 'Mesajul trebuie să conțină cel puțin 10 caractere.',
        ]);

        try {
            // Trimite email către admin
            Mail::to(env('ADMIN_EMAIL'))->send(new ContactFormMail($validated));

            return back()->with('success', 'Mesajul tău a fost trimis cu succes! Vom reveni în cel mai scurt timp.');
        } catch (\Exception $e) {
            return back()->with('error', 'A apărut o eroare la trimiterea mesajului. Te rugăm să încerci din nou.');
        }
    }
}