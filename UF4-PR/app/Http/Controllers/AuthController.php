<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

//añadimos Hash para criptar la contraseña
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/**
 * @OA\Info(
 *     title="Mi API",
 *     version="1.0.0",
 *     description="Documentación de mi API",
 *     @OA\Contact(
 *         email="contacto@midominio.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer token"
 * )
 */



class AuthController extends Controller
{

    //SWAGGER PARA REGISTRO USUARIO
       /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Crea un nou usuari",
     *     description="Creem un nou usuari",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password","rol"},
     *             @OA\Property(property="name", type="string", example="Natalia"),
     *             @OA\Property(property="email", type="string", example="natalia@gmail.com"),
     *             @OA\Property(property="password", type="string", example="natalia1234"),
     *             @OA\Property(property="rol", type="string", example="administrador")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuari creat correctament",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuari registrat correctament"),
     *             @OA\Property(property="usuari", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="rol", type="string", example="usuari")
     *          )
     *     )
     * ),
     * @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Els camps introduïts no són vàlids")
     *         )
     *     )
     * )
     * 
     */
    
    //Funcion para registrar un nuevo usuario
    public function register(Request $request) {

        //validamos que la información sea correcta
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Creamos el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'usuari'
        ]);

        return response()->json($user);
    }

    //SWAGGER PARA LOGIN
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login amb un usuari",
     *     description="Inicia sessió usuari",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inici de sessió correcta",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login correcte"),
     *             @OA\Property(property="token", type="string", example="1|abc123token"),
     *             @OA\Property(property="usuari", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Admin"),
     *                 @OA\Property(property="email", type="string", example="admin@example.com"),
     *                 @OA\Property(property="rol", type="string", example="administrador")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciales incorrectas")
     *         )
     *     )
     * )
     */
    public function login(Request $request) {
        //validamos que la información sea correcta
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Buscamos el usuario en BBDD 
        $user = User::where('email', $request->email)->first();

        //Confirmamos que la contraseña sea correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas'],
            ]);
        }

        //Creamos el token
        $token = $user->createToken('api-token')->plainTextToken;

        //En la respuesta devolveremos tanto el token como el rol
        return response()->json([
            'token' => $token,
            'role' => $user->role
        ]);
    }

    //SWAGGER PARA LOGOUT
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Procés tancar sessió",
     *     description="Tanca la sessió de l'usuari autenticat",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sessió tancada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sessió tancada correctament")
     *         )
     *     )
     * )
     */

    //Funcion para cerrar sessión
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }

}
