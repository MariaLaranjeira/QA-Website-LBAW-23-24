<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\MailModel;
use TransportException;
use Exception;
use App\Models\User; 

use DB; 
use Carbon\Carbon; 
use Hash;
use Illuminate\Support\Str;

class MailController extends Controller
{
    function send(Request $request) {

        $missingVariables = [];
        $requiredEnvVariables = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $temp_pass = Str::random(64);
    
        foreach ($requiredEnvVariables as $envVar) {
            if (empty(env($envVar))) {
                $missingVariables[] = $envVar;
            }
        }
    
        if (empty($missingVariables)) {

            $user = User::where('email', $request->email)->first();

            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'pass' => $temp_pass
            ];

            try {
                Mail::to($request->email)->send(new MailModel($mailData));
                $status = 'Success!';
                $message = $request->name . ', an email has been sent to ' . $request->email;
            } catch (TransportException $e) {
                $status = 'Error!';
                $message = 'SMTP connection error occurred during the email sending process to ' . $request->email;
            } catch (Exception $e) {
                $status = 'Error!';
                $message = 'An unhandled exception occurred during the email sending process to ' . $request->email;
            }

        } else {
            $status = 'Error!';
            $message = 'The SMTP server cannot be reached due to missing environment variables:';
        }

        $user->password = bcrypt($temp_pass);
        $user->save();

        $request->session()->flash('status', $status);
        $request->session()->flash('message', $message);
        $request->session()->flash('details', $missingVariables);
        return redirect()->route('home');
    }
}