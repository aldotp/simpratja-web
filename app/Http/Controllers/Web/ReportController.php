<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    private function viewByRole($role, $data = [])
    {
        // Get the view name based on the role
        $view = match ($role) {
            'leader' => 'leader.reports.index',
            'staff' => 'staff.reports.index',
            default => 'reports.index',
        };

        // Return the view with the data (just like the view() function)
        return view($view, $data);
    }

    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = Auth::user()->role;
        $reports = $this->reportService->getAll();
        return $this->viewByRole($role, compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('staff.reports.create');
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

        return redirect()->route('staff.reports.index')
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
            return redirect()->route('staff.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('staff.reports.show', compact('report'));
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
            return redirect()->route('staff.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view('staff.reports.edit', compact('report'));
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
            return redirect()->route('staff.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        return redirect()->route('staff.reports.index')
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
            return redirect()->route('staff.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        $this->reportService->delete($id);

        return redirect()->route('staff.reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    public function exportReportPDF($id)
    {
        // Validasi ID laporan
        if (!$id){
            return redirect()->back()->with('error', 'Laporan tidak ditemukan');
        }

        // Ambil data laporan berdasarkan ID
        $data = $this->reportService->getById($id);

        // Jika data tidak ditemukan, kembalikan response error
        if (!$data) {
            return redirect()->back()->with('error', 'Data laporan tidak ditemukan');
        }

        // Siapkan data untuk view PDF
        $viewData = [
            'period' => $data->period,
            'reportType' => $data->report_type,
            'reportContent' => $data->report_content,
            'createdAt' => Carbon::parse($data->created_at)->translatedFormat('l, d F Y'),
            'updatedAt' => Carbon::parse($data->updated_at)->translatedFormat('l, d F Y'),
        ];

        // Generate PDF dari view
        $pdf = Pdf::loadView('leader.reports.pdf', data: $viewData);

        // Buat nama file yang lebih deskriptif berdasarkan jenis laporan dan periode
        $filename = 'Laporan_' . str_replace(' ', '_', $data->report_type) . '_' . $data->period . '.pdf';

        // Download PDF dengan nama file yang sesuai
        return $pdf->download($filename);
    }
}
