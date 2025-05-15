<?php

namespace App\Services;

use App\Repositories\DocterRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class DocterService
{
    protected $docterRepository;
    protected $userService;

    public function __construct(DocterRepository $docterRepository, UserService $userService)
    {
        $this->docterRepository = $docterRepository;
        $this->userService = $userService;
    }

    public function getAll($filters = [])
    {
        return $this->docterRepository->getAll($filters);
    }

    public function getById($id)
    {
        return $this->docterRepository->getById($id);
    }

    public function createDocter($data)
    {
        DB::beginTransaction();
        
        try {
            $userData = [
                'name' => $data['name'],
                'password' => bcrypt('12345678a'),
                'phone_number' => $data['phone_number'],
                'role' => 'docter',
                'nik' => $data['nik'],
                'gender' => $data['gender'],
            ];
            
            $user = $this->userService->createUser($userData);

            if (!$user['success']) {
                throw new CustomException(
                    $user['message'], 
                    422 
                );
            }

            $userId = is_object($user) ? $user->id : $user['data']->id;

            $doctorData = [
                'name' => $data['name'],
                'nik' => $data['nik'],
                'phone_number' => $data['phone_number'],
                'gender' => $data['gender'],
                'quota' => $data['quota'],
                'user_id' => $userId,
            ];

            $doctor = $this->docterRepository->store($doctorData);
            
            DB::commit();
            return $doctor;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, $data)
    {
        return $this->docterRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->docterRepository->delete($id);
    }

    public function getPatientCount($doctorId)
    {
        $doctor = $this->docterRepository->getByUserId($doctorId);
        
        if (!$doctor) {
            return 0;
        }

        return $this->docterRepository->countPatientsByDoctor($doctor->id);
    }
}