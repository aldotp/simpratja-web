<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($request)
    {
        return $this->userRepository->getAllUsers($request);
    }

    public function getUser($id)
    {
        return $this->userRepository->getUser($id);
    }

    public function createUser($request)
    {
        $existingUser = $this->userRepository->findByNik($request['nik']);
        if ($existingUser) {
            return [
                'success' => false,
                'message' => 'User with this NIK already exists'
            ];
        }

        try {
            $user = $this->userRepository->createUser([
                'name' => $request['name'],
                'nik' => $request['nik'],
                'phone_number' => $request['phone_number'],
                'gender' => $request['gender'],
                'status' => 1,
                'password' => bcrypt("12345678a"),
            ]);
            return [
                'success' => true,
                'data' => $user
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ];
        }
    }

    public function updateUser($id, $data) {
        $user = $this->userRepository->getUser($id);

        if (!$user) {
            return null;
        }

        if (isset($data['name']) && $data['name'] != "") {
            $user->name = $data["name"];
        }

        if (isset($data['nik']) && $data['nik'] != "") {
            if ($user->nik != $data['nik']) {
                $existingUser = $this->userRepository->findByNik($data['nik']);
                if ($existingUser) {
                    return [
                    'success' => false,
                    'message' => 'User with this NIK already exists'
                    ];
                }

                $user->nik = $data["nik"];
            }
        }

        if (isset($data['password']) && $data["password"] != "") {
            $user->password = bcrypt($data["password"]);
        }

        if (isset($data['status']) && $data['status'] != "") {
            $user->status = $data['status'];
        }

        if (isset($data['gender']) && $data['gender'] != "") {
            $user->gender = $data["gender"];
        }

        if (isset($data['phone_number']) && $data['phone_number'] != "") {
            $user->phone_number = $data["phone_number"];
        }

        if (isset($data['role']) && $data['role'] != "") {
            $user->role = $data["role"];
        }


        $user->save();

        return $user;
    }

    public function deleteUser($id) {
        $user = $this->userRepository->getUser($id);

        if (!$user) {
            return null;
        }

        return $this->userRepository->deleteUser($id);
    }


    public function resetPassword($id){
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            return null;
        }

        $user->password = bcrypt("12345678a");
        $user->save();
        return $user;
    }

}