<?php

namespace App\Services;

use App\Repositories\UserDetailRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class DocterService
{
    protected $userDetailRepository;
    protected $userService;
    protected $userRepository;

    public function __construct(UserDetailRepository $userDetailRepository, UserService $userService, UserRepository $userRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function getAll($filters = [])
    {
        $filters["role"] = "docter";
        return $this->userRepository->getAllDocterDetail($filters);
    }

    public function getById($id)
    {
        return $this->userRepository->getAllDocterDetailByID($id);
    }

    public function createDocter($data)
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
                'role' => 'docter',
                'password' => bcrypt("12345678a"),
            ]);

            $userId = is_object($user) ? $user->id : $user['data']->id;

            $userDetail = [
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'gender' => $data['gender'],
                'quota' => $data['quota'],
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
                    "role" => $user->role,
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

    public function update($id, $data)
    {

        DB::beginTransaction();

        try {
            $userData = [];

            if (isset($data['nik']) && $data['nik'] != null) {
                $userData['nik'] = $data['nik'];
            }

            if (isset($data['password']) && $data['password'] != null) {
                $userData['password'] = bcrypt($data['password']);
            }

            if (isset($data['status']) && $data['status'] != null) {
                $userData['status'] = $data['status'];
            }

            $this->userRepository->updateUser($id, $userData);

            $dataDetail = [];

            if (isset($data['name']) && $data['name'] != null) {
                $dataDetail['name'] = $data['name'];
            }

            if (isset($data['phone_number']) && $data['phone_number'] != null) {
                $dataDetail['phone_number'] = $data['phone_number'];
            }
            if (isset($data['gender']) && $data['gender'] != null) {
                $dataDetail['gender'] = $data['gender'];
            }

            if (isset($data['quota']) && $data['quota'] != null) {
                $dataDetail['quota'] = $data['quota'];
            }

            $this->userDetailRepository->update($id, $dataDetail);
            DB::commit();

            return [
               'success' => true,
                'data' => $this->userRepository->getAllDocterDetailByID($id),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        return $this->userDetailRepository->delete($id);
    }

    public function getPatientCount($userId)
    {
        $doctor = $this->userRepository->getAllUsersDetailByID($userId);

        if (!$doctor) {
            return 0;
        }

        return $this->userDetailRepository->countPatientsByDoctor($doctor->id);
    }
}
