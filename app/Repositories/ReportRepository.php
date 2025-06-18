<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository
{
    /**
     * Retrieve all reports.
     * @returns {Array<Report>} List of all reports.
     */
    public function getAll()
    {
        return Report::all();
    }

    /**
     * Retrieve report by ID.
     * @param {number} id - The ID of the report.
     * @returns {Report|null} The report instance or null if not found.
     */
    public function getById($id)
    {
        return Report::find($id);
    }

    /**
     * Store report data.
     * @param {Object} data - The report data to store.
     * @returns {Report} The created report instance.
     */
    public function store($data)
    {
        return Report::create($data);
    }

    /**
     * Update report by ID.
     * @param {number} id - The ID of the report.
     * @param {Object} data - The data to update.
     * @returns {Report|null} The updated report instance or null if not found.
     */
    public function update($id, $data)
    {
        $report = Report::find($id);
        if (!$report) {
            return null;
        }
        $report->update($data);
        return $report;
    }

    /**
     * Delete report by ID.
     * @param {number} id - The ID of the report.
     * @returns {boolean} True if the report was deleted, false otherwise.
     */
    public function delete($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return false;
        }
        return $report->delete();
    }

    /**
     * Count all reports.
     * @returns {number} The total number of reports.
     */
    public function countAll()
    {
        return Report::count();
    }

}
