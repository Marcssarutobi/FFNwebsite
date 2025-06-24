<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'is_read' => 'required|boolean',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_read' => $request->is_read,
            'message' => $request->message,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Mail::to('contact@fungifornature.com')->send(new ContactMail($data));

        return response()->json([
            'status' => 200,
            'message' => 'Contact created successfully',
            'data' => $contact
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
