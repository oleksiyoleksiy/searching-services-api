<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\Provider\StatsService;
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
