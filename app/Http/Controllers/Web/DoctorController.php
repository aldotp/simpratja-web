<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\DocterService;
use Illuminate\Support\Facades\Validator;

class DoctorController
{
    protected $docterService;

    /**
     * Create a new controller instance.
     *
     * @param DocterService $docterService
     */
    public function __construct(DocterService $docterService)
    {
        $this->docterService = $docterService;
    }

    /**
     * Display a dashboard role doctor.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('doctor.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $doctors = $this->docterService->getAll([]);
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'nik' => 'required|string|max:20|unique:users,nik',
            'gender' => 'required|integer',
            'phone_number' => 'required|string|max:20',
            'quota' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->docterService->createDocter($request->all());
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Dokter berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $doctor = $this->docterService->getById($id);
        if (!$doctor) {
            return redirect()->route('admin.doctors.index')
                ->with('error', 'Dokter tidak ditemukan');
        }
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $doctor = $this->docterService->getById($id);
        if (!$doctor) {
            return redirect()->route('admin.doctors.index')
                ->with('error', 'Dokter tidak ditemukan');
        }
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'nik' => 'required|string|max:20|unique:users,nik,' . $id,
            'gender' => 'required|integer',
            'phone_number' => 'required|string|max:20',
            'quota' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $doctor = $this->docterService->update($id, $request->all());
            if (!$doctor) {
                return redirect()->route('admin.doctors.index')
                    ->with('error', 'Dokter tidak ditemukan');
            }
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Dokter berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $doctor = $this->docterService->delete($id);
            if (!$doctor) {
                return redirect()->route('admin.doctors.index')
                    ->with('error', 'Dokter tidak ditemukan');
            }
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Dokter berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
