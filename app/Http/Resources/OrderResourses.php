<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResourses extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $all_status=["payment_compelete" ,
         "out of delivery" ,
         "cancel_order" ,
         "done" ,
         "refund_requested" ,
         "returned_order" ,
         "refunded" ];

        $order_staus='';
        $i=0;
        foreach ($all_status as $staus){
            $i++;
            if($this->status == $i){
                $order_staus=$staus;
            }
        }

        return [
            'id' => $this->id,
            'status' => $order_staus,
            'sub_total'  =>$this->sub_total,
            'discount'  =>$this->discount,
            'shipping'  =>$this->shipping,
            'tax'  =>$this->tax,
            'total'  =>$this->total,
            'student_id' => $this->student_id,
            'expire_month'=>$this->expire_month,
            'expire_year'=>$this->expire_year,
            'cvc'=>$this->cvc,
            'name_on_card'=>$this->name_on_card,
            'number_on_card'=>$this->number_on_card,
            
        ];
    }
}
