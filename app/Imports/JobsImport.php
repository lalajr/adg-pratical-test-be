<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\Job;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class JobsImport implements OnEachRow, WithHeadingRow, WithProgressBar, WithValidation
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $row = (object) $row->toArray();

        if(isset($row->job_title)) {

            $location = null;
            $job = null;

            if ($row->location) {
                $location = Location::where('name', $row->location)->first() ?: new Location();
                if (!$location->exists) {
                    $location->name = $row->location;
                    $location->save();
                }
            }

            $job = Job::where('job_title', $row->job_title)
                    ->where('location_id', $location->id)->first() ?: new Job();
            if (!$job->exists) {
                $job->job_title = $row->job_title;
                $job->job_description = $row->job_description;
                $date = \DateTime::createFromFormat('d/m/Y', $row->date);
                if ($date) {
                    $job->date = $date;
                }
                $job->location_id = $location->id;
                $job->save();
            }

            if ($row->applicants) {
                $exploded = explode(', ', $row->applicants);

                $toInsert = [];
                foreach($exploded as $item) {
                    $toInsert[] = ['name' => $item];
                }
                $res = DB::table('applicants')->insertOrIgnore($toInsert);
                $existingApplicants = Applicant::select('id','name')->whereIn('name', $exploded)->get();
                if ($existingApplicants->count() > 0) {
                    $job->applicants()->sync($existingApplicants->pluck('id'));
                }
            }

            return true;
        }
    }

    public function rules(): array
    {
        return [
            'job_title' => Rule::notIn(['', null])
        ];
    }

    public function customValidationMessages()
    {
        return [
            'job_title.notIn' => 'Role cannot be empty',
        ];
    }
}
