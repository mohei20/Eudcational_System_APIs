<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'hot_line' => $this->hot_line,
            'map_location' => $this->map_location,
            'status' => $this->status ? 'on' : 'off',
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
            'HeadOfBranch' => new UserResource($this->user)
        ];
    }
}
