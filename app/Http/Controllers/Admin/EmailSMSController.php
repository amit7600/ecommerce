<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Auth;

class EmailSMSController extends Controller
{
    public function send_email($body,$data){
        
        try{
            //sender name get from env file
            $name = env('MAIL_FROM_NAME', ' Example');
            //initilize mail send
            Mail::send(array(),array('name' => $name),function($message) use ($body,$data){
                //email subject and email sender mail id
                $message->to($data['to'])->subject($data['subject']);
                //send a email body get from template.
                $message->setBody($body,'text/html');
            });
        }catch(\Throwable $th){
            dd($th);    
        }
    }
}
