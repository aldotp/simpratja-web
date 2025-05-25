<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function loginV3($request)
    {
        $user = $this->userRepository->findByNIK($request->nik);

        if (!$user || !password_verify($request->password, $user->password)) {
             throw new \Exception('Invalid credentials');
        }

        auth('web')->login($user);

        return $user;
    }


    public function loginV2($request)
    {
        $nik = $request->nik;
        $password = $request->password;

        $user = $this->userRepository->findByNIK($nik);

        if(!$user || !password_verify($password, $user->password)) {
            return null;
        }

        $cookie = cookie(
            'user_session',
            json_encode([
                'id' => $user->id,
                'role' => $user->role,
                'status' => $user->status
            ]),
            60 * 60,
            '/',
            null,
            true,
            true
        );

        return [
            'user' => $user,
            'cookie' => $cookie
        ];
    }

    public function login($request){
        $nik = $request->nik;
        $password = $request->password;

        $user = $this->userRepository->findByNIK($nik);

        if(!$user || !password_verify($password, $user->password)) {
            return null;
        }


        $accessTokenPayload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ];

        $refreshTokenPayload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (30 * 24 * 60 * 60)
        ];


        $accessSecret = config('jwt.access_secret');
        $refreshSecret = config('jwt.refresh_secret');

        $accessToken = JWT::encode($accessTokenPayload, $accessSecret, 'HS256');
        $refreshToken = JWT::encode($refreshTokenPayload, $refreshSecret, 'HS256');

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => 3600,
        ];
    }

    public function register($request){
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = $this->userRepository->findByEmail($email);
        if($user) {
            return [null, 'Email already exists'];
        }

        return [$this->userRepository->createUser([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => 2,
        ]), null];
    }

    public function refreshToken($request) {
        $refreshToken = $request->refresh_token;


        $decoded = JWT::decode($refreshToken,   new Key(env('JWT_SECRET_REFRESH_TOKEN'), 'HS256'),);
        $userId = $decoded->sub;
        $expiredAt = $decoded->exp;

        if ($expiredAt < time()) {
            return response()->json(['error' => 'Refresh token expired'], 401);
        }

        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $accessTokenPayload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ];

        $refreshTokenPayload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (30 * 24 * 60 * 60)
        ];

        $accessSecret = config('jwt.access_secret');
        $refreshSecret = config('jwt.refresh_secret');

        $accessToken = JWT::encode($accessTokenPayload, $accessSecret, 'HS256');
        $refreshToken = JWT::encode($refreshTokenPayload, $refreshSecret, 'HS256');

      
        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => 3600,
        ];
    }

    public function getUserAuhenticate($request) {
        $payload = $request->attributes->get('user_auth');

        $userId = $payload['sub'];

        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function getUserAuhenticatev2($request) {
        $cookie = $request->cookie('user_session');

        if (!$cookie) {
            return null;
        }

        $sessionData = json_decode($cookie, true);

        if (!isset($sessionData['id'])) {
            return null;
        }

        $userId = $sessionData['id'];
        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function getUserAuhenticatev3($request) {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function forgotPassword($email)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return ['success' => false, 'message' => 'Email tidak ditemukan'];
        }

        $token = bin2hex(random_bytes(32));

        $user->remember_token = $token;
        $user->reset_password_expired_at = now()->addMinutes(30);
        $user->save();

        return ['success' => true, 'message' => 'Link reset password telah dikirim ke email'];
    }

    public function resetPassword($data)
    {
        $user = $this->userRepository->findByNIK($data['nik']);

        $user->password = bcrypt("12345678a");
        $user->save();

        return ['success' => true, 'message' => 'Password berhasil direset'];
    }
}