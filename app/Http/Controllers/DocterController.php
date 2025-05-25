<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\DocterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocterController
{
    protected $docterService;
    protected $response;

    public function __construct(DocterService $docterService, Response $response)
    {
        $this->docterService = $docterService;
        $this->response = $response;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $docters = $this->docterService->getAll($filters);
        return $this->response->responseSuccess($docters, 'All doctors retrieved');
    }

    public function show($id)
    {
        $docter = $this->docterService->getById($id);
        if (!$docter) {
            return $this->response->responseError('Doctor not found', 404);
        }
        return $this->response->responseSuccess($docter, 'Doctor found');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|string|max:50',
                'nik' => 'required|string|max:20|unique:users,nik',
                'gender' => 'required|integer',
                'phone_number' => 'required|string|max:20',
                'quota' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->response->responseError(
                    $validator->errors()->first(),
                    422
                );
            }

            $doctor = $this->docterService->createDocter($data);
            return $this->response->responseSuccess($doctor, 'Doctor created successfully');

        } catch (\App\Exceptions\CustomException $e) {
            return $this->response->responseError(
                $e->getMessage(),
                (int) $e->getCode()
            );
        } catch (\Exception $e) {
            return $this->response->responseError(
                'Internal server error',
                500
            );
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:50',
            'nik' => 'sometimes|required|string|max:20|unique:users,nik,' . $id,
            'gender' => 'sometimes|required|integer',
            'phone_number' => 'sometimes|required|string|max:20',
            'quota' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $docter = $this->docterService->update($id, $data);
        if (!$docter) {
            return $this->response->responseError('Doctor not found', 404);
        }
        return $this->response->responseSuccess($docter, 'Doctor updated successfully');
    }

    public function delete($id)
    {
        $docter = $this->docterService->deleteUser($id);
        if (!$docter) {
            return $this->response->responseError('Doctor not found', 404);
        }
        return $this->response->responseSuccess($docter, 'Doctor deleted successfully');
    }

    public function getPatientCountByDocterID(Request $request)
    {
        $userId = Auth::id();
        $patientCount = $this->docterService->getPatientCount($userId);

        return $this->response->responseSuccess([
            'patient_count' => $patientCount
        ], 'Patient count retrieved successfully');
    }


    public function dropdownDocter(Request $request) {
        $docters = $this->docterService->getAll();
        return $this->response->responseSuccess($docters, 'All doctors retrieved');
    }


    public function checkUpPatient($id,Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'medicine_id' => 'required',
            'diagnosis' => 'required|string',
            'complaint' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $result = $this->docterService->checkUpPatient($id,$data);
        return $this->response->responseSuccess($result, 'Patient checked up successfully');
    }
}