<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedbackService;
use App\Services\ReportService;
use Illuminate\Http\Request;

class LeaderController
{
    protected $feedbackService;
    protected $reportService;

    public function __construct(
        FeedbackService $feedbackService,
        ReportService $reportService,
    ) {
        $this->feedbackService = $feedbackService;
        $this->reportService = $reportService;
    }

    public function dashboard()
    {
        $feedbackCount = $this->feedbackService->countAll();
        $reportCount = $this->reportService->countAll();

        return view('leader.dashboard', compact('feedbackCount', 'reportCount'));
    }

    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\View\View
     */
    public function report()
    {
        $reports = $this->reportService->getAll();
        return view('leader.reports.index', compact('reports'));
    }

    /**
     * Display the specified report.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function detailReport($id)
    {
        $report = $this->reportService->getById($id);

        if (!$report) {
            return redirect()->route('leader.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('leader.reports.show', compact('report'));
    }
}
