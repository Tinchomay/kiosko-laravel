<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegistroRequest $request)
    {
        //Validamos con el metodo validated()
        $data = $request->validated();

        //Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        //Retornamos un token que se crea con la api de api de laravel
        return  [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        //Validar credenciales
        //Si las credenciales son incorrectas retornamos una respuesta con un codigo de error
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['error' => ['Credenciales incorrectas']]
                //Asignamos el error 422 para que obtenga los datos el catch
            ], 422);
        }

        //Autenticando
        $user = Auth::user();
        return  [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        //Identificamos el request por que laravel identifica quien es por el token
        $user = $request->user();
        //Con estos metodos eliminamos el token del usuario de la BD
        $user->currentAccessToken()->delete();
        return [
            'user' => null
        ];
    }
}
