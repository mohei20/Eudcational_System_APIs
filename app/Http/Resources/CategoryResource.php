<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;


class CategoryResource extends JsonResource
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
            'shop' => $this->shop_id,
            'status' => $this->status ? 'on' : 'off',
        ];
    }
}
