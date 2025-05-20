<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Illuminate\Support\Facades\Validator;

class ReportController
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reports = $this->reportService->getAll();
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.reports.create');
    }

    /**
     * Store a newly created report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'period' => 'required|string',
            'content' =>'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Gagal membuat laporan')
                ->withInput();
        }

        $this->reportService->store([
            'report_type' => $request->title,
            'period' => $request->period,
            'report_content' => $request->content,
        ]);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dibuat');
    }

    /**
     * Display the specified report.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $report = $this->reportService->getById($id);

        if (!$report) {
            return redirect()->route('admin.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $report = $this->reportService->getById($id);

        if (!$report) {
            return redirect()->route('admin.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'period' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui laporan')
                ->withInput();
        }

        $report = $this->reportService->update($id, [
            'report_type' => $request->title,
            'period' => $request->period,
            'report_content' => $request->content,
        ]);

        if (!$report) {
            return redirect()->route('admin.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Remove the specified report from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $report = $this->reportService->getById($id);

        if (!$report) {
            return redirect()->route('admin.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        // Assuming there's a delete method in the service
        // If not, you'll need to add it to both service and repository
        $this->reportService->delete($id);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
