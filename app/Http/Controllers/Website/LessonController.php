<?php

namespace App\Http\Controllers\Website;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;

class LessonController extends Controller
{
    public function index($classroomId)
    {
        $lessons = Lesson::Status()->where('class_room_id',$classroomId)->get();
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


    public function show($classroomId, $lessonId)
    {
        $lessons = Lesson::Status()->where('id',$lessonId)->first();
        if($lessons){
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => new LessonResource($lessons)
            ]);
        }
        return response()->json([
            'message' => 'Not Found',
            'status' => Response::HTTP_NOT_FOUND
        ]);
    }
}
