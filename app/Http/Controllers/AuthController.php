<?php
/**
 * ***Importante***
 *  Este archivo contiene errores, los cuales no afectan al resultado directo de las api, así mismo
 *  este codigo fue creado en base al que se propone en la documentación de jwt para laravel
 *  https://jwt-auth.readthedocs.io/en/develop/quick-start/
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'msg' => 'Unauthorized'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    /**
     * Api que crea un usuario
     */
    public function register(Request $request){
        $Validator = Validator::make($request->all(),[
            'password' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
        if($Validator->fails()){
            return response()->json([
                'success' => false,
                'msg' => $Validator->errors()->toJson(),400
            ]);
        }
        $user = User::create(array_merge(
            $Validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'success' => true,
            'response' => $user
        ],201);
    }

    public function update(Request $request){
        try {
            $user = auth()->user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->birthdate = $request->birthdate;
            $user->city = $request->city;
            $user->save();
            return response()->json([
                'success' => true,
                'response' => $user
            ],201);
        } catch (Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e
            ],400);
        }
        
    }
}