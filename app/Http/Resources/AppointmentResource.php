<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day' => $this->dayNameFormate($this->day),
            'from' => $this->formatHoursAndMinutes($this->from),
            'to' => $this->formatHoursAndMinutes($this->to),
            'classroom_name' => $this->classRoom->name
        ];
    }
}
