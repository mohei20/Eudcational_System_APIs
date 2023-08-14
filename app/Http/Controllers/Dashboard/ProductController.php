<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Product\ProductStoreRequest;
use App\Http\Requests\Dashboard\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResources;
use App\Http\trait\Imageable;


class ProductController extends Controller
{
   
    use Imageable;

    public function index($category_id){
        $products= Product::where('category_id',$category_id)->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => ProductResources::collection($products)
        ]);

    }

   
    
    public function store(ProductStoreRequest $request)
    {

        $newImage = $this->insertImage($request->name,$request->image, 'Product_image/');
        $product = Product::create(array_merge($request->all(),['image' => $newImage]));
        
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new ProductResources($product)
        ]);
    }

    public function show($id)
    {
        $product = Product::whereId($id)->first();
        if ($product) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new ProductResources($product)
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }


   
    public function update(ProductUpdateRequest $request,$id)
    {
        $newImage = $this->insertImage($request->name,$request->image, 'Product_image/');

        $product = Product::findOrFail($id);

        $product->update(array_merge($request->all(),['image' => $newImage]));
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

   
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

}
