<?php

namespace App\Http\Controllers\Web;

use App\Repositories\VisitRepository;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController
{
    protected $reportService;
    protected $visitRepository;

    public function __construct(ReportService $reportService, VisitRepository $visitRepository)
    {
        $this->reportService = $reportService;
        $this->visitRepository = $visitRepository;
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

        $view = match ($role) {
            'leader' => 'leader.reports.index',
            'staff' => 'staff.reports.index',
        };

        return view($view, compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countPatient = $this->visitRepository->countPatientToday();
        return view('staff.reports.create', compact('countPatient'));
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
            'period' => 'required|date',
            'patient_counts' => 'required|integer',
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
            'patient_counts' => $request->patient_counts,
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
        $role = Auth::user()->role;
        $report = $this->reportService->getById($id);

        $view = match ($role) {
            'leader' => 'leader.reports.show',
            'staff' => 'staff.reports.show',
        };

        if (!$report) {
            return redirect()->back()
                ->with('error', 'Laporan tidak ditemukan');
        }

        return view($view, compact('report'));
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
            return redirect()->back()
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
            'period' => 'required|date',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui laporan')
                ->withInput();
        }

        // Mendapatkan data laporan yang ada untuk mempertahankan patient_counts
        $existingReport = $this->reportService->getById($id);
        if (!$existingReport) {
            return redirect()->route('staff.reports.index')
                ->with('error', 'Laporan tidak ditemukan');
        }

        $report = $this->reportService->update($id, [
            'report_type' => $request->title,
            'period' => $request->period,
            'report_content' => $request->content,
            // patient_counts tidak diubah, tetap menggunakan nilai yang sudah ada
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
