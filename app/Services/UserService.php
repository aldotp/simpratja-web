<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\UserDetailRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class UserService {

    private $userRepository;
    protected $userDetailRepository;

    public function __construct(UserRepository $userRepository, UserDetailRepository $userDetailRepository) {
        $this->userRepository = $userRepository;
        $this->userDetailRepository = $userDetailRepository;
    }

    public function getAllUsers($request)
    {
        $users = $this->userRepository->getAllUsersDetail($request);

      return $users->map(function ($data) {
        return [
            "id" => $data->id,
            "name" => $data->name,
            "nik" => $data->nik,
            "role" => $data->role,
            "phone_number" => $data->phone_number,
            "gender" => $data->gender,
            "quota" => $data->quota,
            "created_at" => $data->created_at,
            "updated_at" => $data->updated_at,
        ];
    });
    }

    public function getUser($id)
    {
        $user = $this->userRepository->getAllUsersDetailByID($id);

        return $user;
    }

     public function createUser($data)
    {
        DB::beginTransaction();

        try {
            $existingUser = $this->userRepository->findByNik($data['nik']);
            if ($existingUser) {
                return [
                    'success' => false,
                    'message' => 'User with this NIK already exists'
                ];
            }

            $user = $this->userRepository->createUser([
                'nik' => $data['nik'],
                'status' => 1,
                'password' => bcrypt("12345678a"),
                'role' => $data['role'],
            ]);

            $userId = is_object($user) ? $user->id : $user['data']->id;

            $userDetail = [
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'gender' => $data['gender'],
                'quota' => 0,
                'user_id' => $userId,
            ];

            $userDetail = $this->userDetailRepository->store($userDetail);

            DB::commit();
            return [
                'success' => true,
                'data' => [
                    "id" => $user->id,
                    "name" => $userDetail->name,
                    "nik" => $user->nik,
                    "role" => $data["role"],
                    "phone_number" => $userDetail->phone_number,
                    "gender" => $userDetail->gender,
                    "quota" => $userDetail->quota,
                    "created_at" => $user->created_at,
                    "updated_at" => $user->updated_at,
                ],
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function create($request)
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
                'nik' => $request['nik'],
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
        $userDetail = $this->userDetailRepository->getByUserId($id);

        if (!$user) {
            return null;
        }

        if (!$userDetail) {
            return null;
        }

        if (isset($data['name']) && $data['name'] != "") {
            $userDetail->name = $data["name"];
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
            $userDetail->gender = $data["gender"];
        }

        if (isset($data['phone_number']) && $data['phone_number'] != "") {
            $userDetail->phone_number = $data["phone_number"];
        }

        if (isset($data['role']) && $data['role'] != "") {
            $user->role = $data["role"];
        }


        $user->save();
        $userDetail->save();

       return [
            "id" => $user->id,
            "name" => $userDetail->name ?? null,
            "nik" => $user->nik,
            "role" => $user->role,
            "phone_number" => $userDetail->phone_number,
            "gender" => $userDetail->gender,
            "quota" => $user->quota,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at,
        ];
    }

    public function deleteUser($id) {
        $user = $this->userRepository->getUser($id);

        if (!$user) {
            return null;
        }

        $userDetail = $this->userDetailRepository->getByUserId($id);
        if (!$userDetail) {
            return null;
        }

        $userDetail->delete();
        $user->delete();

        return $user;

        // $user =  $this->userRepository->deleteUser($id);

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

    public function countDocter() {
      $count = $this->userRepository->query()->where('role', 'docter')->count();
      return $count;
    }
}