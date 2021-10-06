<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Http\Controllers\Controller;


use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;




class UserController extends Controller
{

    // public function register(Request $request)
    // {
    //     $credentials = $request->only('name', 'email', 'password');

    //     $rules = [
    //         'name' => 'required|max:255',
    //         'email' => 'required|email|max:255|unique:users'
    //     ];

    //     $validator = Validator::make($credentials, $rules);
    //     if($validator->fails()) {
    //         return response()->json(['success'=> false, 'error'=> $validator->messages()]);
    //     }

    //     $name = $request->name;
    //     $email = $request->email;
    //     $password = $request->password;

    //     $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);

    //     $verification_code = str::random(30); //Generate verification code
    //     DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);


    //     $subject = "Verificar el registro";


    //     Mail::send('email.verify', compact('name','verification_code' ),
    //         function($mail) use ($email, $name, $subject){
    //             $mail->from(getenv('FROM_EMAIL_ADDRESS'), "USTA");
    //             $mail->to($email, $name);
    //             $mail->subject($subject);
    //         });

    //     return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    // }


    public function index()
    {
        $users = User::all();
        return $users;

    }



    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return $user;

    }

     public function destroy(Request $request)
     {
         //$users = Users::destroy($request->id);
         $user = User::findOrFail($request->id);
         $user ->delete();
         return $user;

     }


}
