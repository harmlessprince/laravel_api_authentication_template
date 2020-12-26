<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use App\Notifications\Forgotpassword;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotController extends Controller
{
    //


    public function forgot(ForgotRequest $request)
    {
        $token = Str::random(10);
        $email = $request->input('email');
        if (User::where('email', $email)->doesntExist()) {
            return response(['message' => 'The supplied email does not exist'], 400);
        }
        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);
            $user = User::firstWhere('email', $email);
            $user->notify(new Forgotpassword());
            return response(['message' => 'Please check your email address'], 200);
        } catch (Exception  $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }
    }


    public function reset(ResetRequest $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');
        /**
         * Check if token is on password reset table
         */
        $isTokenValid = DB::table('password_resets')->where('token', $token)->first();
        if (!$isTokenValid) {
            return response(['message' => 'Token supplied is invalid!'], 400);
        }

        /**
         *@var User $user
         * Get the corresponding email for the supplied token
         */
        $user = User::where('email', $isTokenValid->email)->first();
        if (!$user) {
            return response(['message' => 'User does\'t exist'], 404);
        }
        //prepare password for saving into the dataas
        $user->password = Hash::make($password);

        //Save user password into the user table
        $user->save();
        
        return response(['message' => 'success', 'user' => $user]);
    }
}
