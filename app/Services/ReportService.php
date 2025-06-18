<?php

namespace App\Services;

use App\Repositories\ReportRepository;
use App\Models\Visit;
use Carbon\Carbon;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * Get all reports
     *
     * @return array
     */
    public function getAll()
    {
        return $this->reportRepository->getAll();
    }

    /**
     * Get report by ID
     *
     * @param int $id
     * @return array
     */
    public function getById($id)
    {
        return $this->reportRepository->getById($id);
    }

    /**
     * Store new report
     *
     * @param array $data
     * @return array
     */
    public function store($data)
    {
        return $this->reportRepository->store($data);
    }

    /**
     * Update report by ID
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data)
    {
        return $this->reportRepository->update($id, $data);
    }

    /**
     * Delete report by ID
     *
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        return $this->reportRepository->delete($id);
    }

    /**
     * Count all reports
     *
     * @return int
     */
    public function countAll()
    {
        return $this->reportRepository->countAll();
    }
}
