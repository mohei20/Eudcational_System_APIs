<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Shop;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Shop\ShopStoreRequest;
use App\Http\Requests\Dashboard\Shop\ShopUpdateRequest;
use App\Http\Resources\ShopResource;

class ShopController extends Controller
{

    public function index($branch_id){
        $shops=Shop::where('branche_id',$branch_id)->first();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => new ShopResource($shops),
        ]);
    }



    public function store(ShopStoreRequest $request)
    {
        $shop = Shop::create($request->all());

        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new ShopResource($shop)
        ]);
    }


    public function show($id)
    {
        $shop = Shop::whereId($id)->first();
        if ($shop) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new ShopResource($shop)
            ]);

        }else {

            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }



    public function update(ShopUpdateRequest $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }


    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

}
