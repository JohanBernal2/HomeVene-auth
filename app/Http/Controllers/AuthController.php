<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use Illuminate\Support\Str;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;



class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     // $credentials = $request->only('nombre', 'correo', 'clave');

    //     // $rules = [
    //     //     'nombre' => 'required|max:255',
    //     //     'correo' => 'required|email|max:255|unique:users'
    //     // ];

    //     // $validator = Validator::make($credentials, $rules);
    //     // if($validator->fails()) {
    //     //     return response()->json(['success'=> false, 'error'=> $validator->messages()]);
    //     // }

    //     $nombre = $request->nombre;
    //     $apellido = $request->apellido;
    //     $documento_identificacion = $request->documento_identificacion;
    //     $user = $request->user;
    //     $correo = $request->correo;
    //     $clave = $request->clave;
    //     $direccion = $request->direccion;
    //     $telefono = $request->telefono;

    //     // $user = new User;
    //     // dd($user);
    //      $users = User::create(['nombre' => $nombre,
    //                            'apellido' => $apellido,
    //                            'documento_identificacion'=> $documento_identificacion,
    //                            'user' => $user,
    //                            'correo' => $correo,
    //                            'clave' => Hash::make($clave),
    //                            'direccion' => $direccion,
    //                            'telefono' => $telefono
    //                          ]);

    //     // $verification_code = str::random(30); //Generate verification code
    //     // DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);


    //     // $subject = "Verificar el registro";


    //     // Mail::send('email.verify', compact('name','verification_code' ),
    //     //     function($mail) use ($email, $name, $subject){
    //     //         $mail->from(getenv('FROM_EMAIL_ADDRESS'), "USTA");
    //     //         $mail->to($email, $name);
    //     //         $mail->subject($subject);
    //     //     });

    //     return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    // }






     public function register(Request $request)
     {
         $credentials = $request->only('nombre', 'email', 'password');

         $rules = [
             'nombre' => 'required|max:255',
             'email' => 'required|email|max:255|unique:users'
         ];

         $validator = Validator::make($credentials, $rules);
         if($validator->fails()) {
             return response()->json(['success'=> false, 'error'=> $validator->messages()]);
         }

        $rol_id = $request->rol_id;
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $documento_identificacion = $request->documento_identificacion;
        $email = $request->email;
        $password = $request->password;
        $direccion = $request->direccion;

         $user = User::create(['rol_id'=>$rol_id,'nombre' => $nombre, 'apellido' => $apellido,
          'documento_identificacion' => $documento_identificacion,
         'email' => $email,
         'password' => Hash::make($password),
         'direccion' => $direccion,
        ]);

         $verification_code = str::random(30); //Generate verification code
         DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);


         $subject = "Verificar el registro";


         Mail::send('email.verify', compact('nombre','verification_code' ),
             function($mail) use ($email, $nombre, $subject){
                 $mail->from(getenv('FROM_EMAIL_ADDRESS'), "USTA");
                 $mail->to($email, $nombre);
                 $mail->subject($subject);
             });

         return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
     }



    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();

        if(!is_null($check)){
            $user = User::find($check->user_id);

            if($user->is_verified == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }

            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();

            return response()->json([
                'success'=> true,
                'message'=> 'You have successfully verified your email address.'
            ]);
        }

        return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);

    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
        }



        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false,
                'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false,
            'error' => 'Failed to login, please try again.'], 500);
        }

        // all good so return the token
        return response()->json(['success' => true, 'data'=> ['token' => $token ]], 200);
    }


    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }

        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });

        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }

        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset emaidfl has be s  been sent! Please check your email.']
        ]);
    }
}
