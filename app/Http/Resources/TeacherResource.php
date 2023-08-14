<?php

namespace App\Http\Resources;

use App\Models\ClassRoom;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $classroom_count = ClassRoom::whereHas('teacher', function ($query) {
            $query->where('id', $this->id);
        })->count();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nick_name' => $this->nick_name,
            'phone_number' => $this->phone_number,
            'avatar' => 'Teacher_image/' . $this->avatar,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
            'classroom_count' => $classroom_count
        ];
    }
}
