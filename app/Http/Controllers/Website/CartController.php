<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Http\Response;
use App\Http\Requests\Website\Cart\CartStoreRequest;
use App\Http\Requests\Website\Cart\CartUpdateRequest;
use App\Http\Resources\CartResources;
use Illuminate\Support\Facades\Auth;
use App\Http\trait\Orderdata;

class CartController extends Controller
{
 
   use Orderdata;

    public function store(CartStoreRequest $request){

            //select product
        $product = Product::find($request->product_id);
        if($product){
            //select cart if exist
            $cart=Cart::where('student_id', Auth::user()->id)->where('status',1)->where('product_id',$product->id)->first();

            //if in wish list
            $whish_lisT_item=Cart::where('student_id', Auth::user()->id)->where('status',2)->where('product_id',$product->id)->first();

            //from wish list to cart
            if($whish_lisT_item){
                $price=$request->quantity * $product->price; 
                $student_id= Auth::user()->id;   
                $product_id=$product->id;
                $quantity=$request->quantity;
                $whish_lisT_item->update(['student_id'=>$student_id,'product_id'=>$product_id,'quantity'=>$quantity,'price' => $price,'status'=>1]);
                return response()->json([
                    'message' => 'Update',
                    'status' => Response::HTTP_CREATED,
                    'data' => new CartResources($whish_lisT_item)
                ]);
            }

            //check if there such product and quantity and if this cart is exist 
            elseif($product && ($product->quantity >=$request->quantity) && !$cart){
                $price=$request->quantity * $product->price;
                $student_id= Auth::user()->id;
                $cart=Cart::create(array_merge($request->all(),['student_id'=>$student_id,'price' => $price]));

                return response()->json([
                    'message' => 'Created Successfully',
                    'status' => Response::HTTP_CREATED,
                    'data' => new CartResources($cart)

                ]);
            }
           
            elseif(!($product->quantity >=$request->quantity)){
                return response()->json([
                    'message' => 'this quantity is too much '
                    
                ]);
            }
            elseif ($cart){
                return response()->json([
                    'message' => 'you already select this product'
                    
                ]);
            }
        }
        elseif(!$product){
            return response()->json([
                    'message' => 'this product dosent exist'
                    
                ]);
        }

}
    public function show()
    {
        $carts=Cart::where('student_id', Auth::user()->id)->where('status',1)->get();
        $sub_total=0;
        if ($carts) {
            foreach($carts as $cart){
                $sub_total=$sub_total+$cart->price;
            }

        $order_data=$this->create_order_atrribute($sub_total);

        return response()->json([
            'message' => 'ok',
            'status' => Response::HTTP_OK,
            'data' =>  CartResources::collection($carts),
            'sub_total'=>$sub_total,
            'tax'=>$order_data['tax'],
            'shipping'=>$order_data ['shipping'],
            'discount'=>$order_data ['discount'],
            'total'=>$order_data ['total'],
        ]);
        
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    
    }

    public function update(CartUpdateRequest $request)
    {
        //select the product id and the price for update
        $product = Product::find($request->product_id);
        

        //check if there is such product and quantity
        if($product && ($product->quantity >=$request->quantity)){
            //select the cart to update
            $cart=Cart::where('student_id', Auth::user()->id)->where('product_id',$product->id)->where('status',1)->latest()->first();

            //check if there is such product in his cart
            if($cart){
                $price=$request->quantity * $product->price;    
                $cart->update(array_merge($request->all(),['price' => $price]));
                return response()->json([
                    'message' => 'Update',
                    'status' => Response::HTTP_NO_CONTENT
                ]);
            }
            else{
                return response()->json([
                    'message' => 'you dont have this product in your cart',
                ]);
            }
        }
        elseif(!$product){
            return response()->json([
                'message' => 'this product dosent exist'
                
            ]);
        }
        elseif(!($product->quantity >=$request->quantity)){
            return response()->json([
                'message' => 'this quantity is too much '
                
            ]);
        }
    }

   
    public function destroy()
    {
        $carts=Cart::where('student_id', Auth::user()->id)->where('status',1)->get();
        foreach($carts as $cart){
            $cart->delete();
        }
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    public function delete_product_in_cart($product_id){
        //select the product delete
        $product = Product::find($product_id);
        if($product){
           //select the cart to update
           $cart=Cart::where('student_id', Auth::user()->id)->where('status',1)->where('product_id',$product->id)->latest()->first();

           //check if there is such product in his cart
           if($cart){
               $cart->delete();
               return response()->json([
                   'message' => 'deleted',
                   'status' => Response::HTTP_NO_CONTENT
               ]);
           }
           else{
               return response()->json([
                   'message' => 'you dont have this product in your cart',
               ]);
           }
       }
       elseif(!$product){
           return response()->json([
               'message' => 'this product dosent exist'
               
           ]);
       }

   }


   public function show_wish_list()
    {
        $carts=Cart::where('student_id', Auth::user()->id)->where('status',2)->get();
        $total=0;
        if ($carts) {
            foreach($carts as $cart){
                $total=$total+$cart->price;
            }
        return response()->json([
            'message' => 'ok',
            'status' => Response::HTTP_OK,
            'data' =>  CartResources::collection($carts),
            'total'=>$total,
        ]);
        
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    
    }

    public function delete_whish_list()
    {
        $carts=Cart::where('student_id', Auth::user()->id)->where('status',2)->get();
        foreach($carts as $cart){
            $cart->delete();
        }
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }


    public function store_in_wish_list(CartStoreRequest $request){

        //select product
        $product = Product::find($request->product_id);
        if( $product){

            //select cart if exist
            $cart=Cart::where('student_id', Auth::user()->id)->where('status',1)->where('product_id',$product->id)->first();

            //check wish list items
            $whish_lisT_item=Cart::where('student_id', Auth::user()->id)->where('status',2)->where('product_id',$product->id)->first();

            //check if there such product and quantity and if this cart is exist 
            if($product && ($product->quantity >=$request->quantity) && !$cart && !$whish_lisT_item){
                $price=$product->price; 
                $student_id= Auth::user()->id;   
                $product_id=$product->id;
                $quantity=1;
                $whish_lisT_item=Cart::create(['student_id'=>$student_id,'product_id'=>$product_id,'quantity'=>$quantity,'price' => $price,'status'=>2]);
                return response()->json([
                    'message' => 'Created Successfully',
                    'status' => Response::HTTP_CREATED,
                    'data' => new CartResources($whish_lisT_item)

                ]);
            }
        
            elseif(!($product->quantity >=$request->quantity)){
                return response()->json([
                    'message' => 'this quantity is too much '
                    
                ]);
            }
            elseif ($cart){
                return response()->json([
                    'message' => 'this product already in your cart'
                    
                ]);
            }
            elseif ($whish_lisT_item){
                return response()->json([
                    'message' => 'this product already in your wish list '
                    
                ]);
            }
    }
    elseif(!$product){
        return response()->json([
            'message' => 'this product dosent exist'
            
        ]);
    }
}

public function delete_product_in_wish_list($product_id){
    //select the product delete
    $product = Product::find($product_id);
    if($product){
       //select the cart to update
       $cart=Cart::where('student_id', Auth::user()->id)->where('status',2)->where('product_id',$product->id)->latest()->first();

       //check if there is such product in his cart
       if($cart){
           $cart->delete();
           return response()->json([
               'message' => 'deleted',
               'status' => Response::HTTP_NO_CONTENT
           ]);
       }
       else{
           return response()->json([
               'message' => 'you dont have this product in your cart',
           ]);
       }
   }
   elseif(!$product){
       return response()->json([
           'message' => 'this product dosent exist'
           
       ]);
   }

}

public function forward_to_cart($product_id)
{
    //select the product id and the price for update
    $product = Product::find($product_id);
    

    //check if there is such product 
    if($product ){
        //select the cart to update
        $cart=Cart::where('student_id', Auth::user()->id)->where('product_id',$product->id)->where('status',2)->latest()->first();

        //check if there is such product in his cart
        if($cart){    
            $price=$product->price; 
            $student_id= Auth::user()->id;   
            $product_id=$product->id;
            $quantity=1;
            $cart->update(['student_id'=>$student_id,'product_id'=>$product_id,'quantity'=>$quantity,'price' => $price,'status'=>1]);
            return response()->json([
                'message' => 'Update',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }
        else{
            return response()->json([
                'message' => 'you dont have this product in your cart',
            ]);
        }
    }
    elseif(!$product){
        return response()->json([
            'message' => 'this product dosent exist'
            
        ]);
    }
}
   
}
