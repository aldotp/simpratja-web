<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController
{
    protected $reportService;
    protected $response;

    public function __construct(ReportService $reportService, Response $response)
    {
        $this->reportService = $reportService;
        $this->response = $response;
    }

    public function index()
    {
        $reports = $this->reportService->getAll();
        return $this->response->responseSuccess($reports, 'Data laporan berhasil diambil');
    }

    public function show($id)
    {
        $report = $this->reportService->getById($id);
        if (!$report) {
            return $this->response->responseError('Laporan tidak ditemukan', 404);
        }
        return $this->response->responseSuccess($report, 'Laporan ditemukan');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            "period" =>"required|string",
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $report = $this->reportService->store([
            'report_type' => $data['title'],
            'period' => $data['period'],
            'report_content' => $data['content'],
        ]);
        return $this->response->responseSuccess($report, 'Laporan berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'sometimes|required|string|max:255',
            'period' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $report = $this->reportService->update($id, [
            'report_type' => $data['title'],
            'period' => $data['period'],
            'report_content' => $data['content'],
        ]);
        if (!$report) {
            return $this->response->responseError('Laporan tidak ditemukan', 404);
        }
        return $this->response->responseSuccess($report, 'Laporan berhasil diupdate');
    }

    public function exportReportPDF($id)
    {

        if (!$id){
            return $this->response->responseError('',404);
        }

        $data = $this->reportService->getById($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $viewData = [
            'period' => $data->period,
            'reportType' => $data->report_type,
            'reportContent' => $data->report_content,
            'createdAt' => Carbon::parse($data->created_at)->translatedFormat('l, d F Y'),
            'updatedAt' => Carbon::parse($data->updated_at)->translatedFormat('l, d F Y'),
        ];


        $pdf = Pdf::loadView('leader.reports.pdf', data: $viewData);

        return $pdf->download('report.pdf');
    }
}
