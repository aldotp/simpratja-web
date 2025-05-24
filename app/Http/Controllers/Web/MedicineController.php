<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\MedicineService;
use Illuminate\Support\Facades\Validator;

class MedicineController
{
    protected $medicineService;

    /**
     * Create a new controller instance.
     *
     * @param MedicineService $medicineService
     */
    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $medicines = $this->medicineService->getAll();
        return view('doctor.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('doctor.medicines.create');
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
            'name' => 'required|string|max:100',
            'stock' => 'required|integer',
            'unit' => 'required|string|max:100',
            'price' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->medicineService->store($request->all());
            return redirect()->route('doctor.medicines.index')
                ->with('success', 'Obat berhasil ditambahkan');
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
        $medicine = $this->medicineService->show($id);
        if (!$medicine) {
            return redirect()->route('doctor.medicines.index')
                ->with('error', 'Obat tidak ditemukan');
        }
        return view('doctor.medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $medicine = $this->medicineService->show($id);
        if (!$medicine) {
            return redirect()->route('doctor.medicines.index')
                ->with('error', 'Obat tidak ditemukan');
        }
        return view('doctor.medicines.edit', compact('medicine'));
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
            'name' => 'required|string|max:100',
            'stock' => 'required|integer',
            'unit' => 'required|string|max:100',
            'price' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $medicine = $this->medicineService->update($id, $request->all());
            if (!$medicine) {
                return redirect()->route('doctor.medicines.index')
                    ->with('error', 'Obat tidak ditemukan');
            }
            return redirect()->route('doctor.medicines.index')
                ->with('success', 'Obat berhasil diperbarui');
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
            $medicine = $this->medicineService->destroy($id);
            if (!$medicine) {
                return redirect()->route('doctor.medicines.index')
                    ->with('error', 'Obat tidak ditemukan');
            }
            return redirect()->route('doctor.medicines.index')
                ->with('success', 'Obat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('doctor.medicines.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
