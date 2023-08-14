<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResources extends JsonResource
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
           
            'order_id'=>$this->order_id,
            'created_at'=>$this->created_at,
            'status' => $order_staus 
            
        ];
    }
}
