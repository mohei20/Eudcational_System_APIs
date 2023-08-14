<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\HeadOfManager\HeadStoreRequest;
use App\Http\Requests\Dashboard\HeadOfManager\HeadUpdateRequest;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    public function index()
    {
        $user = User::with('headBranch')->where('id', Auth::user()->id)->first();
        $assistants = User::whereHas('branch', function ($q) use ($user) {
            $q->where('branches.id', $user->headBranch[0]->id);
        })->role('assistant')->get();

        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => UserResource::collection($assistants)
        ]);
    }


    public function store(HeadStoreRequest $request)
    {


        $assistant = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $assistant->assignRole('assistant');
        $branch = Branch::where('user_id', Auth::user()->id)->first();
        $assistant->branch()->attach([$branch->id], [
            'from' => $request->from,
            'to' => $request->to,
            'salary' =>$request->salary
        ]);
        return response()->json([
            'message' => 'Created',
            'status' => Response::HTTP_CREATED,
            'data' => new UserResource($assistant)
        ]);
    }

    public function show($id)
    {
        $assistant = User::role('assistant')->whereId($id)->first();

        if ($assistant) {
            return response()->json([
                'message' => 'Ok',
                'status' => Response::HTTP_OK,
                'data' => new UserResource($assistant)
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }

    }

    public function update(HeadUpdateRequest $request, $id)
    {
        $assistant = User::role('assistant')->whereId($id)->first();
        $assistant->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $branch = Branch::where('user_id', Auth::user()->id)->first();
        $assistant->branch()->detach();
        $assistant->branch()->attach([$branch->id], [
            'from' => $request->from,
            'to' => $request->to,
            'salary' =>$request->salary
        ]);
        return response()->json([
            'message' => 'Updated',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    public function destory($id)
    {
        if ($assistant = User::role('assistant')->whereId($id)->first()) {
            $assistant->delete();

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