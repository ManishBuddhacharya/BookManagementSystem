<?php
 
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repository\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{

    public function register(Request $request, UserRepo $user_repo)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_no' => ['required','string'],
        ]);
        
        $data = $request->except('token', 'password_confirmation', 'password');
        $data['is_admin'] = 0;
        $data['password'] = Crypt::encrypt($request->password);
        
        DB::beginTransaction();

        try {
            $user = $user_repo->saveUpdate($data);
            DB::commit();
            return  response()->json(['message' => 'User Created Succesfully', 'data' => $user], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 500);
        }
    }
}
