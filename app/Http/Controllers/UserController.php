<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
 class UserController
{
    private $response;
    private $userService;

    public function __construct(Response $response, UserService $userService) {
        $this->response = $response;
        $this->userService = $userService;
    }

    public function createUser(Request $request){

        $validate = Validator::make($request->all(), [
            'name' =>'required',
            'nik' => 'required|integer',
            'phone_number' =>'required',
            'gender' =>'required',
            'role' =>'required',
        ]);

        if ($validate->fails()) {
            return $this->response->responseError($validate->errors(), 400);
        }

        $result = $this->userService->createUser($request->all());
        if (!$result['success']) {
            return $this->response->responseError($result['message'], 400);
        }
        return $this->response->responseSuccess($result['data'], 'User created successfully', 201);
    }

    public function getAllUsers(Request $request){
        $users = $this->userService->getAllUsers($request);

        return $this->response->responseSuccess($users, 'User fetched successfully', 201);
    }


    public function deleteUser($id){
        $user = $this->userService->deleteUser($id);
        if (!$user) {
            return $this->response->responseError('User not found', 404);
        } else {
            return $this->response->responseSuccess($user, 'User deleted successfully', 200);
        }
    }

    public function updateUser($id, Request $request){
        $user = $this->userService->updateUser($id, $request->all());
        if (!$user) {
            return $this->response->responseError('User not found', 404);
        } else {
            return $this->response->responseSuccess($user, 'User updated successfully', 200);
        }
    }

    public function getUser($id){
        $user = $this->userService->getUser($id);
        if (!$user) {
            return $this->response->responseError('User not found', 404);
        } else {
            return $this->response->responseSuccess($user, 'User fetched successfully', 200);
        }
    }


    public function resetPassword($id)
    {
        $user = $this->userService->resetPassword($id);
        if (!$user) {
            return $this->response->responseError('User not found', 404);
        }

        return $this->response->responseSuccess($user, 'Password reset successfully', 200);
    }
}