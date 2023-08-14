<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Requests\Dashboard\Exam\ExamStoreRequest;
use App\Http\Requests\Dashboard\Exam\ExamUpdateRequest;

class ExamController extends Controller
{

    public function getExamsByClassroomId($classroomId)
    {
        $exams = Exam::with('classroom')->where('class_room_id', $classroomId)->get();

        if ($exams) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' =>  ExamResource::collection($exams)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(ExamStoreRequest $request)
    {
        $exam =  Exam::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new ExamResource($exam)
        ]);
    }

    public function show($id)
    {
        $exam = Exam::whereId($id)->first();

        if ($exam) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new ExamResource($exam)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(ExamUpdateRequest $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
