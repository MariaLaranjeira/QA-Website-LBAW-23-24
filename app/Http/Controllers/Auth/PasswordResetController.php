<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

use DB; 
use Carbon\Carbon; 
use Mail; 
use Hash;
use Illuminate\Support\Str;


class PasswordResetController extends Controller
{
       /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgot-password');
      }
   
}
