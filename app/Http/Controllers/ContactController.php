<?php

namespace App\Http\Controllers;

use App\Mail\ContactAcknowledgementMail;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function index (){
        $data = Contact::orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 200,
            'contacts' => $data
        ]);
    }

    public function show($id){
        $data = Contact::find($id);
        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found'
            ]);
        }
    }

    public function store(Request $request){
        // Champ piège invisible : rempli uniquement par les robots, on fait semblant d'avoir enregistré
        if (filled($request->input('website'))) {
            return response()->json(['status' => 200, 'message' => 'Contact created successfully']);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        $contact = Contact::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'is_read' => false,
            'message' => trim($request->message),
        ]);

        $data = [
            'name' => $contact->name,
            'email' => $contact->email,
            'message' => $contact->message,
        ];

        // Le message est enregistré : un souci d'envoi de mail ne doit pas faire échouer la demande
        try {
            Mail::to('contact@fungifornature.com')->send(new ContactMail($data));
            Mail::to($contact->email)->send(new ContactAcknowledgementMail($data));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Contact created successfully',
        ]);
    }

    public function update(Request $request, $id){
        $contact = Contact::find($id);

        $contact->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Contact updated successfully',
            'data' => $contact
        ]);
    }

    public function destroy($id){
        $contact = Contact::find($id);

        if ($contact) {
            $contact->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Contact deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found'
            ]);
        }
    }
    
    public function markAsRead($id){
        $contact = Contact::find($id);

        if ($contact) {
            $contact->is_read = true;
            $contact->save();
            return response()->json([
                'status' => 200,
                'message' => 'Contact marked as read successfully',
                'data' => $contact
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found',
                'data'=>$contact
            ]);
        }
    }

}
