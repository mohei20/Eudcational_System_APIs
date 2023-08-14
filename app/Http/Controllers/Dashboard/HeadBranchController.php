<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\HeadOfManager\HeadStoreRequest;
use App\Http\Requests\Dashboard\HeadOfManager\HeadUpdateRequest;

class HeadBranchController extends Controller
{

    public function index()
    {
        $headOfBranch = User::role('head_of_branch')->with('headBranch')->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => UserResource::collection($headOfBranch)
        ]);
    }

    public function store(HeadStoreRequest $request)
    {
        $headOfBranch = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $headOfBranch->assignRole('head_of_branch');
        return response()->json([
            'message' => 'Created',
            'status' => Response::HTTP_CREATED,
            'data' => new UserResource($headOfBranch)
        ]);
    }

    public function show($id)
    {
        $headOfBranch = User::role('head_of_branch')->whereId($id)->first();

        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => new UserResource($headOfBranch)
        ]);
    }

    public function update(HeadUpdateRequest $request, $id)
    {
        $headOfBranch = User::role('head_of_branch')->whereId($id)->first();
        $headOfBranch->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Updated',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    public function destory($id)
    {
        if ($headOfBranch = User::role('head_of_branch')->whereId($id)->first()) {
            $headOfBranch->delete();
            return response()->json([
                'message' => 'Deleted',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }


}