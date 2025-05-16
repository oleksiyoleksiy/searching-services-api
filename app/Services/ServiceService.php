<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Service;

class ServiceService
{
    public function index(int $company)
    {
        $query = Service::where('company_id', $company);

        if ($limit = request('limit')) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
