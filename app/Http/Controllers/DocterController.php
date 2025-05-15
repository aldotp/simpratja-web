<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\DocterService;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomException;

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
                'nik' => 'required|string|max:20|unique:docters,nik',
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
            
        } catch (CustomException $e) {
            return $this->response->responseError(
                $e->getMessage(),
                $e->getCode()
            );
        } catch (\Exception $e) {
            return $this->response->responseError(
                $e->getMessage(),
                500
            );
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:50',
            'nik' => 'sometimes|required|string|max:20|unique:docters,nik,' . $id,
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
        $docter = $this->docterService->delete($id);
        if (!$docter) {
            return $this->response->responseError('Doctor not found', 404);
        }
        return $this->response->responseSuccess($docter, 'Doctor deleted successfully');
    }

    public function getPatientCountByDocterID(Request $request)
    {
       $payload = $request->attributes->get('user_auth');
        $userId = $payload['id'];
        $patientCount = $this->docterService->getPatientCount($userId);

        return $this->response->responseSuccess([
            'patient_count' => $patientCount
        ], 'Patient count retrieved successfully');
    }
}