<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Branch;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Branch\BranchStoreRequest;
use App\Http\Requests\Dashboard\Branch\BranchUpdateRequest;
use App\Http\Resources\BranchResource;

class BranchController extends Controller
{
    public function index()
    {
        $allBranches = Branch::status()->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => BranchResource::collection($allBranches)
        ]);
    }

    public function store(BranchStoreRequest $request)
    {
        $branch =  Branch::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new BranchResource($branch)
        ]);
    }

    public function show($id)
    {
        $branch = Branch::with('user')->whereId($id)->first();
        if ($branch) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new BranchResource($branch)
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }

    }

    public function update(BranchUpdateRequest $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
