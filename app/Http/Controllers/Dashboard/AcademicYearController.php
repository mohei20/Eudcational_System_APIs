<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\AcademicYear;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicYearResource;
use App\Http\Requests\Dashboard\AcademicYear\AcademicYearStoreRequest;
use App\Http\Requests\Dashboard\AcademicYear\AcademicYearUpdateRequest;



class AcademicYearController extends Controller
{
    public function index()
    {
        $allAcademicYears = AcademicYear::latest()->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => AcademicYearResource::collection($allAcademicYears)
        ]);
    }


    public function getAcademicYearByBranchId($branchId)
    {
        $academicYears = AcademicYear::with('branch')->where('branch_id', $branchId)->get();

        if ($academicYears) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' =>  AcademicYearResource::collection($academicYears)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(AcademicYearStoreRequest $request)
    {
        $academicYear =  AcademicYear::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new AcademicYearResource($academicYear)
        ]);
    }

    public function show($id)
    {
        $academicYear = AcademicYear::whereId($id)->first();

        if ($academicYear) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new AcademicYearResource($academicYear)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(AcademicYearUpdateRequest $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
