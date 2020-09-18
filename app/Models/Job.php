<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(Applicant::class, 'job_applicants', 'job_id', 'applicant_id');
    }
}
