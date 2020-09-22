<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    // Contact
    public function showContact()
    {
        return Contact::all();
    }

    public function addContact(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $title = $request->title;
        $content = $request->content;
        $status = $request->status;

        $contact = new Contact;
        $contact->name = $name;
        $contact->email = $email;
        $contact->title = $title;
        $contact->content = $content;
        $contact->status = $status;
        $contact->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $contact->save();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function updateContact(Request $request){
        $id = $request->id;  

        $contact = Contact::find($id);
        $contact->status = 1;
        $contact->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $contact->save();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function deleteContact(Request $request){
        $id = $request->id;  

        $contact = Contact::find($id);

        $contact->delete();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }
    
}
