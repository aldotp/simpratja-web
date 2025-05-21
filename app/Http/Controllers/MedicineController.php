<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\MedicineService;
use Illuminate\Support\Facades\Validator;

class MedicineController
{
    protected $medicineService;
    protected $response;

    public function __construct(MedicineService $medicineService, Response $response)
    {
        $this->medicineService = $medicineService;
        $this->response = $response;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string|max:100',
            'stock' => 'required|integer',
            'unit' =>'required|string|max:100',
            'price' =>'required',
            'expiry_date' =>'required|date',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $medicine = $this->medicineService->store($data);
        return $this->response->responseSuccess($medicine, 'Medicine created successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:100',
            'stock' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $medicine = $this->medicineService->update($id, $data);
        if (!$medicine) {
            return $this->response->responseError('Medicine not found', 404);
        }
        return $this->response->responseSuccess($medicine, 'Medicine updated successfully');
    }

    public function destroy($id)
    {
        $medicine = $this->medicineService->deleteMedicines($id);
        if (!$medicine) {
            return $this->response->responseError('Medicine not found', 404);
        }
        return $this->response->responseSuccess($medicine, 'Medicine deleted successfully');
    }

    public function show($id)
    {
        $medicine = $this->medicineService->show($id);
        if (!$medicine) {
            return $this->response->responseError('Medicine not found', 404);
        }
        return $this->response->responseSuccess($medicine, 'Medicine found');
    }

    public function index()
    {
        $medicines = $this->medicineService->getAll();
        return $this->response->responseSuccess($medicines, 'All medicines retrieved');
    }


    public function dropdownMedicine(Request $request) {
        $medicines = $this->medicineService->getAll();
        return $this->response->responseSuccess($medicines, 'All medicines retrieved');
    }

}
