<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAll()
    {
        return $this->reportRepository->getAll();
    }

    public function getById($id)
    {
        return $this->reportRepository->getById($id);
    }

    public function store($data)
    {
        return $this->reportRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->reportRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->reportRepository->delete($id);
    }

    public function countAll()
    {
        return $this->reportRepository->countAll();
    }
}
