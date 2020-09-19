<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Http\Request;

class JobRepository
{
    public function __construct(
        Job $job
    )
    {
        $this->model = $job;
    }

    public function fetchJob(Request $request)
    {
        $obj = $this->model->findOrFail($request->id);

        return $obj;
    }

    public function fetchJobs(Request $request)
    {
        $query = $this->model
            ->select('id', 'title', 'description', 'date', 'location_id')
            ->with([
                'applicants' => function($query) {
                    $query->select('name');
                },
                'location' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->orderBy('title', 'ASC');

        if ( $request->isNotFilled('per_page') || $request->per_page == 'all' ) {
            return $query->get();
        } else {
            return $query->paginate($request->per_page);
        }
    }
}
