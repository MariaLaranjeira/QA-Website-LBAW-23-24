<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
//use App\Http\Controllers\ImageController;
//use App\Http\Controllers\TagController;

use App\Models\User;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\UserAnswerRating;
use App\Models\UserQuestionRating;
use App\Models\UserQuestionFollow;
use App\Models\UserTagFollow;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function editUser()
    {
        $this->authorize('editUser', Auth::user());
        return view('pages.editUser', ['user' => Auth::user(),
            'old' => ['name' => Auth::user()->name,
                'username' => Auth::user()->username,
                'email' => Auth::user()->email ] ]);
    }

    public function editProfilePicture()
    {
        //$this->authorize('editUser', Auth::user());
        return view('pages.editProfilePicture', ['user' => Auth::user(),
            'old' => ['name' => Auth::user()->name,
                'username' => Auth::user()->username,
                'email' => Auth::user()->email ] ]);
    }

    /**
     * Shows the profile for authenticated user.
     */
    public function profile($id){
        if (!Auth::check()) return redirect('/login');
        $user = User::findOrFail($id);
        //$this->authorize('profile', $user);
        return view('pages.profile', ['user' => $user]);
    }


    public function updateUser(Request $request)
    {
        $user= Auth::user();
        if($request->input('name')!=NULL){$user->name = $request->input('name');}
        if($request->input('username')!=NULL){$user->username = $request->input('username');}
        if($request->input('email')!=NULL){$user->email = $request->input('email');}
        if($request->input('password')!=NULL){$user->password = bcrypt($request->input('password'));}

        $user->save();
        return redirect('/home')->withSuccess('You have successfully updated your profile!');
    }

    /**
     * List all users
     */

    public function list()
    {
      if (!Auth::check()) return redirect('/login');

      $users = User::query()->where('email', 'NOT LIKE', '%@deleted.com')->get();
      //$this->authorize('list', User::Class);
      return view('pages.users', ['users' => $users]);
    }

    /**
     * Delete user account
     */

    public function deleteProfile(Request $request){
        if (!Auth::check()) return redirect('/login');

        $user = User::find($request->input('user_id'));
        $this->authorize('deleteProfile', $user);

        $deleted_account=DB::transaction(function() use ($request)
        {
        $user = User::find($request->input('user_id'));
        $dnumber=rand(1,1000000); //create random number to replace private information
        $randpass= Str::random(24); //generate random password so account can't be accessed again by same user

        //replace all emlements with deleted user + our generated random number
        $user->name ="deleteduser".$dnumber;
        $user->username = "deleteduser".$dnumber;
        $user->email = "deleteduser".$dnumber."@deleted.com";
        $user->password = bcrypt($randpass);

        $user->save();

        return $user;

      });

      return redirect()->route('users');

      }

      public function deleteAccount(Request $request)
      {
          if (!Auth::check()) return redirect('/login');

          $user = User::find($request->input('user_id'));
          //$this->authorize('deleteAccount', $user);

          $deleted_account=DB::transaction(function() use ($request) {
              $user = User::find($request->input('user_id'));
              $dnumber = rand(1, 1000000); //create random number to replace private information
              $randpass = Str::random(24); //generate random password so account can't be accessed again by same user

              //replace all emlements with deleted user + our generated random number
              $user->name = "deleteduser" . $dnumber;
              $user->username = "deleteduser" . $dnumber;
              $user->email = "deleteduser" . $dnumber . "@deleted.com";
              $user->password = bcrypt($randpass);

              $user->save();

              return $user;
          });

          Auth::logout();

          return redirect()->route('home');
      }

      public function uploadPicture(Request $request) {
        $user = Auth::user();
        if($request->file('avatar')){
            if ($user->picture != 'default.jpg'){
              $deletepath = public_path().'/images/profile/'.$user->picture;
              File::delete($deletepath);
            }
            $filename = Str::slug(Carbon::now(), '_').'.jpg';

            $request->file('avatar')->move(public_path('images/profile'), $filename);
            $user->picture = $filename;
            $user->save();
        }

        $user->save();
        return view('pages.profile', ['user' => $user]);
      }

      public function deletePicture(){
        $user = Auth::user();
        if ($user->picture != 'default.jpg'){
          $deletepath = public_path().'images/profile/'.$user->picture;
          File::delete($deletepath);
          $user->picture = 'default.jpg';
          $user->save();
        }
        return redirect()->back();
      }

}
