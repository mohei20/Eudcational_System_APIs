<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;




class CategoryController extends Controller
{

    public function index($shop_id){

        $categories=category::where('shop_id',$shop_id)->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
           'data' => CategoryResource::collection($categories)
        ]);

    }
   
    
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->all());
        

        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new CategoryResource($category)
        ]);
    }

    public function show($id)
    {
        $category = Category::whereId($id)->first();
        if ($category) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new CategoryResource($category)
            ]);

        }else {

            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

   
    public function update(CategoryUpdateRequest $request,$id)

    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
