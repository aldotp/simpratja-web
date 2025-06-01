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

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('login');
    }

    /**
     * Redirect to the appropriate dashboard based on the user's role.
     *
     * @param string $role The user's role.
     * @return RedirectResponse The redirect response.
     */
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
        }
    }

    /**
     * Handle user login.
     *
     * @param Request $request The HTTP request.
     * @return RedirectResponse The redirect response.
     */
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
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle user logout.
     *
     * @return RedirectResponse The redirect response.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
