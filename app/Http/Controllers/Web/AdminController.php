<?php

namespace App\Http\Controllers\Web;

use App\Repositories\ReportRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController
{
    protected $userService;
    protected $response;
    protected $reportRepository;

    public function __construct(UserService $userService, ReportRepository $reportRepository)
    {
        $this->userService = $userService;
        $this->reportRepository = $reportRepository;
    }
    public function index()
    {

        $report = $this->reportRepository->countAll();
        $docter = $this->userService->countDocter();

        return view('admin.dashboard.index', compact('report', 'docter'));
    }
}
