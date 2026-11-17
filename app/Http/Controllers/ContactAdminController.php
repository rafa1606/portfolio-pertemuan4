<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactAdminController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', [
            'contacts' => Contact::latest()->orderByDesc('id')->paginate(10),
        ]);
    }

    public function show(Contact $contact)
    {
        // membuka pesan menandainya sudah dibaca
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }
}