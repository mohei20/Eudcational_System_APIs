<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Requests\Dashboard\Product\ProductStoreRequest;
use App\Http\Requests\Dashboard\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResources;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        
        $allproducts= Product::all();

        // $carts=Cart::where('student_id', Auth::user()->id)->get();
        // $status=0;
        // if ($carts) {
        //     foreach($carts as $cart){
        //         $total=$total+$cart->price;
        //     }
        // }
       
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => ProductResources::collection($allproducts)
        ]);
    }
}
