<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function contact(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('contact', compact('departments'));
    }

    public function ContactList(): View
    {
        $contacts = Contact::latest()->paginate(10);

        return view('contact-list', compact('contacts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'campus_email' => ['required', 'string', 'email', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Contact::create($validated);

        return back()->with('success', 'Your inquiry has been submitted to the academic office. We will reply promptly.');
    }
}
