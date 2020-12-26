<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();
                $token = $user->createToken('api-token')->accessToken;
                return response(['message' => 'success', 'token' => $token, 'user' => $user,]);
            }
        } catch (\Exception $exception) {
            return response(['messgae' => $exception->getMessage()], 400);
        }


        return response(['message' => 'invalid username or password'], 401);
    }




    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $user->sendEmailVerificationNotification();
    
            return response(['message' => 'success', 'user' => $user], 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }
       
    }


    /**
     * THis logs the user out of the application
     */
    
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * return authenticated user
     */
    public function user()
    {
        return Auth::user();
    }
}
