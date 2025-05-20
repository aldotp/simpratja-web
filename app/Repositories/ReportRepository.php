<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository
{
    public function getAll()
    {
        return Report::all();
    }

    public function getById($id)
    {
        return Report::find($id);
    }

    public function store($data)
    {
        return Report::create($data);
    }

    public function update($id, $data)
    {
        $report = Report::find($id);
        if (!$report) {
            return null;
        }
        $report->update($data);
        return $report;
    }

    public function delete($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return false;
        }
        return $report->delete();
    }

    public function countAll()
    {
        return Report::count();
    }

}
