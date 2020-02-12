<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;

class USERController extends Controller
{
    public $loginAfterSignUp = true;

    public function Login(Request $request)
    {
        $input = $request->only('username', 'password');

        $roluser = User::where('username', $request->username)->first()->roles()->value('name');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'status' => 'invalido',
                'message' => 'Invalido usuario o contraseña',
            ], 401);
        }

        return response()->json([
            'status' => 'valido',
            'token' => $token,
            'rol' => $roluser
        ]);
    }

    public function Register(RegistrationFormRequest $request)
    {


        $rol_user = Role::where('name', $request->rolname)->first();


        $user = new User();

        if ($user->where('fullname', $request->fullname)->first()) {
            return response()->json([
                'status' =>  'existe',
            ]);
        } else {
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();
            $user->roles()->attach($rol_user);


            return response()->json([
                'status' =>  'ok',
                'data'  =>  $user,
            ], 200);
        }


        // $role = $roluser->roles()->value('name');
        //$role = $user->where('username', $request->username)->first()->roles()->value('name');


        /*if ($this->loginAfterSignUp) {
            return $this->login($request);
        }*/
    }


    public function Logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'status' => 'ok',
                'message' => 'Cerrando Sesión'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'Error#02',
                'message' => 'Lo siento, no se pudo cerrar sesión'
            ], 500);
        }
    }

    public function Conexion()
    {
        return response()->json([
            'message' =>  'conectado'
        ], 200);
    }

}
