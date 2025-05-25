<?php

namespace App\Services;

use App\Repositories\UserDetailRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitRepository;
use App\Repositories\MedicalRecordDetailRepository;
use App\Repositories\MedicalRecordRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\DB;

class DocterService
{
    protected $userDetailRepository;
    protected $userService;
    protected $userRepository;
    protected $visitRepository;
    protected $medicalRecordDetailRepository;
    protected $medicalRecordRepository;
    protected $patientRepository;

    public function __construct(
        UserDetailRepository $userDetailRepository,
        UserService $userService, UserRepository $userRepository,
        VisitRepository $visitRepository,
        MedicalRecordDetailRepository $medicalRecordDetailRepository,
        MedicalRecordRepository $medicalRecordRepository,
        PatientRepository $patientRepository,
        )
    {
        $this->userDetailRepository = $userDetailRepository;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->visitRepository = $visitRepository;
        $this->medicalRecordDetailRepository = $medicalRecordDetailRepository;
        $this->medicalRecordRepository = $medicalRecordRepository;
        $this->patientRepository = $patientRepository;
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

        return $this->patientRepository->countAll();
    }


    public function checkUpPatient($id,$data)
    {

        return DB::transaction(function () use ($id,$data) {

            $visit = $this->visitRepository->getById($id);
            if (!$visit) {
                return [null, 'Visit not found'];
            }


           $medicalRecord = $this->medicalRecordRepository->query()
                            ->where('patient_id', $visit->patient_id)->first();
            if(!$medicalRecord) {
                return null;
            }


            $detailData = [
                'patient_id'        => $visit->patient_id,
                'docter_id'         => $visit->docter_id,
                'visit_id'          => $visit->id,
                'examination_date'  => $visit->examination_date,
                'medical_record_id' => $medicalRecord->id,
                'medicine_id'       => $data['medicine_id'],
                'diagnosis'         => $data['diagnosis'],
                'complaint'         => $data['complaint'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            $detail = $this->medicalRecordDetailRepository->store($detailData);
            if (!$detail) {
                return null;
            }

          $updateData =  $this->visitRepository->update($visit->id, ['visit_status' => 'done']);
          if ($updateData) {
              return null;
          }

            $response = [
                'detail_id' => $detail->id,
                'visit_id' => $detail->visit_id,
                'medicine_id' => $detail->medicine_id,
                'examination_date' => $detail->examination_date,
                'complaint' => $detail->complaint,
                'diagnosis' => $detail->diagnosis,
            ];

            return $response;
        });
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }
}