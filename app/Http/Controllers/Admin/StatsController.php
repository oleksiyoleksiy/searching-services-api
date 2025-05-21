<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Service\StatsService;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct(private StatsService $service) {
    }

    public function index()
    {
        return response()->json($this->service->index());
    }
}
