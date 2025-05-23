<?php

namespace App\Http\Controllers\Web;

use App\Response\Response;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function index() {
        return view('login');
    }

    private function redirectRoute($role) {
        switch($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            case 'docter':
                return redirect()->route('doctor.dashboard');
            case 'leader':
                return redirect()->route('leader.dashboard');
            default:
                return redirect()->route('login');
        }
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'nik' => 'required|integer',
            'password' => 'required|string',
        ]);
        try {
            $user = $this->authService->loginV3($request);
            return $this->redirectRoute($user->role);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Invalid Credentials')->withErrors($e->getMessage());
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
