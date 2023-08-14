<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Resources\ShopResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResources;


class Homecontroller extends Controller
{
    public function get_shops_by_branch($branch_id){
        $shops=Shop::where('branche_id',$branch_id)->first();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => new ShopResource($shops),
        ]);
    }

    public function get_category_by_shop($shop_id){

        $categories=category::where('shop_id',$shop_id)->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
           'data' => CategoryResource::collection($categories)
        ]);

    }
    
    public function get_product_by_category($category_id){
        $peoducts= Product::where('category_id',$category_id)->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => ProductResources::collection($peoducts)
        ]);

    }
}
