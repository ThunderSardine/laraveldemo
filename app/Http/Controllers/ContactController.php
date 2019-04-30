<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return Contact::latest()->orderBy('created_at', 'desc')->get();
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        return Contact::create($data);
    }



    public function show(Contact $contact, $id)
    {
        return Contact::findOrFail($id);
    }


    public function update(Request $request, Contact $contact, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        Contact::findOrFail($id)->update($data);
    }


    public function destroy(Contact $contact, $id)
    {
        return Contact::destroy($id);
    }
}
