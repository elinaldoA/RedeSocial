<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;

class AuthController extends BaseController
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
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $success = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return $this->sendResponse($success, 'User register successfully.');
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
            return $this->createNewToken($token);
     // return $this->sendResponse($success, 'User login successfully.');
    }
    public function sendResetLink(Request $request)
    {
        $input = $request->only('email');

        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);

        if($validator->fails()){
            return response(['erros'=>$validator->errors()->all()], 422);
        }

        $response = Password::sendResetLink($input);

        if($response == Password::RESET_LINK_SENT){
            $message = "E-mail enviado com sucesso!";
        }else{
            $message = "Não foi possivel enviar e-mail para essa conta de e-mail, não consta em nossos registros!";
        }

        //$message = $response == Password::RESET_LINK_SENT ? 'Email enviado com sucesso' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>'','message' => $message];
        return response($response, 200);
    
    }
    public function sendReset(Request $request)
    {
        $input = $request->only(
            'email',
            'token',
            'password'
        );

        $validator = Validator::make($input, [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response(['erros' => $validator->errors()->all()], 422);
        }

        $response =  Password::sendResetLink($input);
        if ($response == Password::RESET_LINK_SENT) {
            $message = "E-mail enviado com sucesso!";
        } else {
            $message = "Não foi possível enviar o e-mail para este endereço de e-mail";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'E-mail enviado com sucesso!' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data' => '', 'message' => $message];
        return response($response, 200);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Usuário deslogado com sucesso!'], 200);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
