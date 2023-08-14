<?php

namespace  App\Http\trait;

use Carbon\Carbon;

trait Orderdata
{
    public function create_order_atrribute($sub_total)
    {
        $tax=($sub_total*10)/100;
        $shipping=10;
        $discount=10;
        $total=$sub_total+$shipping+$tax-$discount;
       
        return ( ['tax'=>$tax,'shipping'=>$shipping,'discount'=>$discount,'total'=>$total]);
    }
}