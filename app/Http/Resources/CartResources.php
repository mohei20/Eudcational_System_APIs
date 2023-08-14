<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $id=$this->product_id;
        $product=Product::where('id',$id)->first();
        $subject=Subject::where('id',$product->subject_id)->first();
        $teacher=Teacher::where('id',$product->teacher_id)->first();
        return [
            'product_name'=>$product->name,
            'product_id'=>$product->id,
            'product_image'=>"Product_image/".$product->image,
            'product_subject'=>$subject->name,
            'product_teacher'=>$teacher->name,
            'product_price'=>$product->price,
            'quantity_in_cart' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}
