<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{

  public function attemptLogin(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->where('is_deleted', 0)->first();
    if (!$user) {
      return response()->json(['errors' => ['user' => 'User doesn\'t exist']], 422);
    }
    
    if ($request->password != Crypt::decrypt($user->password)) {
      return response()->json(['errors' => ['password' => 'Password incorrect!']], 422);
    }

    $api_token = sha1($request->email.Carbon::now());
    

    $user->api_token = $api_token;
    $user->update();
    
    return response()->json(['token' => $api_token], 200);
  }
 
  public function logout(Request $request)
  {
    $this->guard()->logout();

    return $this->loggedOut($request);
  }

}