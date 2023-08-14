<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Order\OrderStoreRequest;
use App\Http\Requests\Dashboard\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResourses;

class OrderController extends Controller
{
    public function index()
    {
        
        $allorders= Order::all();
       
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => OrderResourses::collection($allorders)
        ]);
    }

   
    
    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->all());
        
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new OrderResourses($order)
        ]);
    }

    public function show($id)
    {
        $order = Order::whereId($id)->first();
        if ($order) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new OrderResourses($order)
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }


   
    public function update(OrderUpdateRequest $request,$id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

   
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

}
