<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
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
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'image' => "Product_image/".$this->image,
            'subject' => $this->subject_id,
            'teacher' => $this->teacher_id,
            'category' => $this->category_id,
            'status' => $this->status ? 'on' : 'off',
        ];
    }
}
