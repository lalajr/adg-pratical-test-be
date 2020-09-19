<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\JobResource;
use App\Repositories\JobRepository;
use Illuminate\Http\Request;

class JobController extends ApiController
{
    public function __construct(
        JobRepository $jobRepository
    )
    {
        $this->jobRepo = $jobRepository;
    }

    public function getJobs(Request $request)
    {
        if(!$this->validateToken($request->token)) {
            return $this->errorResponse('Error Response: request is not permitted');
        };

        $jobs = $this->jobRepo->fetchJobs($request);

        return JobResource::collection($jobs);
    }

    public function getJob(Request $request)
    {
        if(!$this->validateToken($request->token)) {
            return $this->errorResponse('Error Response: request is not permitted');
        };

        $job = $this->jobRepo->fetchJob($request);

        return new JobResource($job);
    }
}
