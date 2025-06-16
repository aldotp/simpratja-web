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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $docter = $this->userService->countDocter();
        $user = $this->userService->countUser();

        return view('admin.dashboard', compact('docter', 'user'));
    }
}
