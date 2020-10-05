<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

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

        $mail = new Contact;
        $mail->name = $name;
        $mail->email = $email;
        $mail->title = $title;
        $mail->content = $content;
        $mail->status = 0;
        $mail->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $mail->save();

        // Mail::send('layouts.mail', ['email'=>$request], function ($message) use ($data) {
        //     $message->from('thanhbtpc00329@fpt.edu.vn', 'weTech');
        //     $message->sender('thanhbtpc00329@fpt.edu.vn', 'weTech');
        //     $message->to($email,$name);
        //     $message->subject('Mail phản hồi của weTech');
        //     $message->priority(1);
        // });
       
        if ($mail) {
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
