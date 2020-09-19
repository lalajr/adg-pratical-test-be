<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'date'             => $this->date,
            'location'         => $this->location ? $this->location->name : '--',
            'applicants'       => $this->applicants->map(function ($item) {
                                        return $item->name;
                                    })->toArray(),
        ];
    }
}
