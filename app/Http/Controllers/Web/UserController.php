<?php

namespace App\Http\Controllers\Web;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' =>'required',
            'nik' => 'required|integer',
            'phone_number' =>'required',
            'gender' =>'required',
            'role' =>'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $result = $this->userService->createUser($request->all());
        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->getUser($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->userService->updateUser($id, $request->all());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function resetPassword(Request $request)
    {
        $user = $this->userService->resetPassword($request->nik);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return redirect()->back()->with('success', 'Password reset successfully');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $result = $this->userService->updateUser($id, $request->all());

        if (isset($result['success']) && !$result['success']) {
            return redirect()->route('profile')->with('error', $result['message']);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
