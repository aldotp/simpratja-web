<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



 class AuthController
{
    private $authService;
    private $response;

    public function __construct(Response $response, AuthService $authService) {
        $this->response = $response;
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->response->responseError($validate->errors()->first(), 400);
        }

        [$data, $message] = $this->authService->register($request);
        if ($message) {
            return $this->response->responseError($message, 400);
        }

        return $this->response->responseSuccess($data, 'Register successfully', 200);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nik' => 'required|integer',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->response->responseError($validate->errors(), 400);
        }

        $data = $this->authService->login($request);
        if (!$data) {
            return $this->response->responseError('Invalid email or password', 400);
        }
        return $this->response->responseSuccess($data, 'Login successfully', 200);
    }

    public function loginV2(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nik' => 'required|integer',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->response->responseError($validate->errors(), 400);
        }

        $loginResult = $this->authService->loginV2($request);

        if (!$loginResult) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()
            ->json(['user' => $loginResult['user']])
            ->cookie($loginResult['cookie']);
    }

    public function loginV3(Request $request)
    {
        $request->validate([
            'nik' => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('nik', $request->nik)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Auth::guard('web')->login($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
    }

    public function profile(Request $request) {
        $user = $this->authService->getUserAuhenticate($request);

        if (!$user) {
            return $this->response->responseError('User not found', 404);
        }

        return $this->response->responseSuccess($user, 'Profile retrieved successfully', 200);
    }

    public function profilev2(Request $request) {
        $user = $this->authService->getUserAuhenticatev2($request);

        if (!$user) {
            return $this->response->responseError('User not found', 404);
        }

        return $this->response->responseSuccess($user, 'Profile retrieved successfully', 200);
    }

    public function profilev3(Request $request) {
        $user = $this->authService->getUserAuhenticatev3($request);

        if (!$user) {
            return $this->response->responseError('User not found', 404);
        }

        return $this->response->responseSuccess($user, 'Profile retrieved successfully', 200);
    }



    public function logout()
    {
        auth()->logout();

        $response = $this->response->responseSuccess(null, 'Successfully Logout successfully', 200);

        if (method_exists($response, 'header')) {
            $response->headers->remove('Authorization');
        }

        $cookie = cookie()->forget('user_session');

        return $response->withCookie($cookie);
    }

    public function refreshToken(Request $request) {
        $data =  $this->authService->refreshToken($request);
        if (!$data) {
            return $this->response->responseError('Refresh token expired', 401);
        }
        return $this->response->responseSuccess($data, 'Refresh token successfully', 200);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $result = $this->authService->forgotPassword($request->email);

        if (!$result['success']) {
            return $this->response->responseError(['error' => $result['message']], 404);
        }

        return $this->response->responseSuccess(null, 'Forget Password Success', 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return $this->response->responseError(['error' => $validator->errors()], 401);
        }

        $result =  $this->authService->resetPassword($request->only('email', 'password', 'token'));

        if (!$result['success']) {
            return $this->response->responseError($result['message'], 400);
        }

        return $this->response->responseSuccess(null, 'Reset Password Success', 200);
    }
}
