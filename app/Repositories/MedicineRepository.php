<?php

namespace App\Repositories;

use App\Models\Medicine;

class MedicineRepository
{
    public function getAll()
    {
       return Medicine::all();
    }
    public function getAllWithStock()
    {
       return Medicine::where('stock', '>', 0)->get();
    }

    public function getByID($id)
    {
        return Medicine::find($id);
    }

    public function show($id)
    {
        return Medicine::find($id);
    }

    public function store($data)
    {
        return Medicine::create($data);
    }

    public function update($id, $data)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return null;
        }
        $medicine->update($data);
        return $medicine;
    }

    public function delete($id)
    {
        $medicine = Medicine::find($id);
        if ($medicine) {
            $medicine->delete();
            return $medicine;
        }
        return null;
    }
}
