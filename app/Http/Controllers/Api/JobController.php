<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JobFilterService;
use App\Http\Resources\JobResource;


class JobController extends Controller
{
    protected $jobFilterService;

    public function __construct(JobFilterService $jobFilterService)
    {
        $this->jobFilterService = $jobFilterService;
    }

    public function index(Request $request)
    {
        $query = $this->jobFilterService->filter($request);
        $jobs = $query->paginate(10); 

        return JobResource::collection($jobs);
    }
}
