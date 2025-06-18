<?php

namespace App\Repositories;

use App\Models\Medicine;

class MedicineRepository
{
    /**
     * Retrieve all medicines.
     * @returns {Array<Medicine>} List of all medicines.
     */
    public function getAll()
    {
       return Medicine::all();
    }
    /**
     * Retrieve all medicines with stock.
     * @returns {Array<Medicine>} List of medicines with stock available.
     */
    public function getAllWithStock()
    {
       return Medicine::where('stock', '>', 0)->get();
    }

    /**
     * Retrieve a medicine by its ID.
     * @param {number} id - The ID of the medicine.
     * @returns {Medicine|null} The medicine with the given ID, or null if not found.
     */
    public function show($id)
    {
        return Medicine::find($id);
    }
    /**
     * Create a new medicine.
     * @param {Object} data - The data for creating the medicine.
     * @returns {Medicine} The newly created medicine.
     */
    public function store($data)
    {
        return Medicine::create($data);
    }

    /**
     * Update a medicine by its ID.
     * @param {number} id - The ID of the medicine.
     * @param {Object} data - The data for updating the medicine.
     * @returns {Medicine|null} The updated medicine, or null if not found.
     */
    public function update($id, $data)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return null;
        }
        $medicine->update($data);
        return $medicine;
    }

    /**
     * Delete a medicine by its ID.
     * @param {number} id - The ID of the medicine.
     * @returns {Medicine|null} The deleted medicine, or null if not found.
     */
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
