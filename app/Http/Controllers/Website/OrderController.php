<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Date;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\TransactionController;
use Illuminate\Http\Request;
use App\Http\Requests\Website\Order\OrderStoreRequest;
use App\Http\Requests\Website\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResourses;
use App\Http\Resources\TransactionResources;
use Illuminate\Support\Facades\Auth;
use App\Http\trait\Orderdata;
class OrderController extends Controller
{

    use Orderdata;
    public function index()
    {
        
        $allorders= Order::where('student_id', Auth::user()->id)->get();
       
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => OrderResourses::collection($allorders)
        ]);
    }

   
    
    public function store(OrderStoreRequest $request)
    {
       

        //get student cart
        $carts=Cart::where('student_id', Auth::user()->id)->where('status',1)->get();
        $cart=Cart::where('student_id', Auth::user()->id)->where('status',1)->first();
        if($cart){
            $sup_total=0;
                foreach($carts as $cart){
                    $sup_total=$sup_total+$cart->price;
                }
                
            //order attribute    
            $order_data=$this->create_order_atrribute($sup_total);
            

            //create order
            Order::create(array_merge($request->all(),['student_id'=>Auth::user()->id,'sub_total'=>$sup_total,'discount'=>$order_data['discount'],'shipping'=>$order_data['shipping'],'tax'=>$order_data['tax'],'total'=>$order_data['total']]));
            $order =Order::where('student_id', Auth::user()->id)->latest()->first();
            $order_id=$order->id;
            $order_stauts= $order->status;
    
            //in relation 
            foreach($carts as $cart){
                $product_id=$cart->product_id;
                $quantity=$cart->quantity;
                $order->product()->attach($product_id,['quantity'=>$quantity]);
            }

            //delete cart
            foreach($carts as $cart){
                $cart->delete();
            }

            //transaction has order statues
            $transaction = Transaction::create(["order_id"=>$order_id,"status"=>$order_stauts]);
            
            return response()->json([
                'message' => 'Created Successfully',
                'status' => Response::HTTP_CREATED,
                'data' => new OrderResourses($order)
            ]);

        }
        else{
            return response()->json([
                'message' => 'you dont have any product in your cart',
                
            ]);
        }

    }

    public function update(OrderUpdateRequest $request,$id)
    {
        $order = Order::findOrFail($id);

        //get order date
        $order_date=$order->created_at;
        $date = new \DateTime($order_date);
        $date->modify('+14 day'); // P1D means a period of 1 day
        $date2=$date->format('Y-m-d');

         if( (date("Y-m-d")<$date2)  && ($order->status!=3)){
                  
                $order->update(['status'=>$request->status]);

                //get new attribeute
                $order_id=$order->id;
                $order_stauts=$order->status;

                //transaction has order statues
                $transaction = Transaction::create(["order_id"=>$order_id,"status"=>$order_stauts]);

                return response()->json([
                    'message' => 'Update',
                    'status' => Response::HTTP_NO_CONTENT
                ]);
    }
        elseif(!(date("Y-m-d")<$date2)){
            return response()->json([
                'message' => 'cant update this order now'
            ]);

        }

        elseif(($order->status ==3)){
            return response()->json([
                'message' => 'this order is canceld'
            ]);

        }
    }

    public function show_order_with_details($id){

        //show all transaction for this order
        $order = Order::where('student_id', Auth::user()->id)->whereId($id)->first();
        
        if($order){
            $alltransaction= Transaction::where('order_id', $order->id)->get();
            return response()->json([
                'message' => 'Ok',
                'status' => Response::HTTP_OK,
                'data' => TransactionResources::collection($alltransaction)
            ]);
        }
        else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }

    }
}
