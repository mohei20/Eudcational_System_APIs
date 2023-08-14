<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Lesson\storeRequest;
use App\Http\Requests\Dashboard\Lesson\UpdateRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Response;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($classroomId)
    {
        $lessons = Lesson::where('class_room_id',$classroomId)->get();
        if($lessons){
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => LessonResource::collection($lessons)
            ]);
        }
        return response()->json([
            'message' => 'Not Found',
            'status' => Response::HTTP_NOT_FOUND
        ]);
    }

    public function store(storeRequest $request)
    {
        $lesson = Lesson::create($request->all());

        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new LessonResource($lesson)
        ]);
    }

    public function update($lessonId, UpdateRequest $request)
    {

        $lesson = Lesson::find($lessonId);
        if($lesson){
            $lesson->update($request->all());
            return response()->json([
                'message' => 'Update',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }
        return response()->json([
            'message' => 'Not Found',
            'status' => Response::HTTP_NOT_FOUND
        ],Response::HTTP_NOT_FOUND);

    }

    public function destory($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if($lesson){
            $lesson->delete();
            return response()->json([
                'message' => 'Deleted..!',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }
        return response()->json([
            'message' => 'Not Found',
            'status' => Response::HTTP_NOT_FOUND
        ],Response::HTTP_NOT_FOUND);

    }
}
