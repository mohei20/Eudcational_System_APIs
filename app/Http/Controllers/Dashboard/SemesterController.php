<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Semester;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SemesterResource;
use App\Http\Requests\Dashboard\Semester\SemesterStoreRequest;
use App\Http\Requests\Dashboard\Semester\SemesterUpdateRequest;




class SemesterController extends Controller
{
    public function index()
    {
        $allSemesters = Semester::latest()->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => SemesterResource::collection($allSemesters)
        ]);
    }

    public function store(SemesterStoreRequest $request)
    {
        $semester =  Semester::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new SemesterResource($semester)
        ]);
    }

    public function show($id)
    {
        $semester = Semester::whereId($id)->first();
        if ($semester) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new SemesterResource($semester)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(SemesterUpdateRequest $request, $id)
    {
        $semester = Semester::findOrFail($id);
        $semester->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
