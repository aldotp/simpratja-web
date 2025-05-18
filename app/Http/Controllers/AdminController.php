<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Repositories\ReportRepository;
use App\Response\Response;

class AdminController
{

    protected $userService;
    protected $response;
    protected $reportRepository;

    public function __construct(UserService $userService, Response $response, ReportRepository $reportRepository)
    {
        $this->userService = $userService;
        $this->response = $response;
        $this->reportRepository = $reportRepository;
    }

    public function dashboard()
    {

        $report = $this->reportRepository->countAll();
        $docter = $this->userService->countDocter();

        return $this->response->responseSuccess([
            'report_count' => $report,
            'docter_count' => $docter,
        ], 'Counts retrieved successfully');
    }
}
