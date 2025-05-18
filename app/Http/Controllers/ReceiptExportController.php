<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Response\Response;
use Illuminate\Support\Facades\Validator;


class ReceiptExportController
{
    protected $patientService;
    protected $response;
    public function __construct(PatientService $patientService, Response $response)
    {
        $this->patientService = $patientService;
        $this->response = $response;
    }

    public function exportQueueToPDF(Request $request)
    {
        $data = [
            'nik' => $request->query('nik'),
            'registration_number' => $request->query('registration_number'),
        ];

        $validator = Validator::make($data, [
            'nik' => 'required',
            'registration_number'=> 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }


        $data = $this->patientService->getRegisByRegistrationIDandNIK($data);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $viewData = [
            'regNumber'    => $data['visit_registration_number'] ?? '',
            'patientName'  => $data['patient_name'] ?? '',
            'rmNumber'     => $data['patient_nik'] ?? '',
            'address'      => $data['patient_address'] ?? '',
            'registerDate' => $data['visit_examination_date'] ?? '',
            'examDate'     => $data['visit_examination_date'] ?? '',
            'queueNumber'  => $data['visit_queue_number'] ?? '',
        ];

        $pdf = Pdf::loadView('receipt', $viewData);

        return $pdf->download('receipt.pdf');
    }
}