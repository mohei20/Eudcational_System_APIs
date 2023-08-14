<?php

namespace App\Http\Controllers\Website;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ClassRoomResource;
use App\Http\Requests\Website\ClassRoom\RegisterRequest;
use Illuminate\Http\Request;

class ClassRoomStudentController extends Controller
{
    private function getStudentObject($userId)
    {
        return  Student::find($userId);
    }

    public function registerNow(RegisterRequest $request)
    {
        $found = $this->getStudentObject(Auth('student')->user()->id)->classRoom->contains($request->classroom_id);
        if ($found) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'You Already Register in this classRoom'
            ]);
        } else {
            $classRoom = ClassRoom::find($request->classroom_id)->withCount('student')->first();

            if ($classRoom->max_capacity > $classRoom->student_count) {
                $this->getStudentObject(Auth('student')->user()->id)->classRoom()->attach([$request->classroom_id], [
                    'status' => ClassRoom::WAITING,
                ]);
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'تم الاشتراك فى الفصل بنجاح'
                ]);
            }
        }
    }

    public function subscribedClassrooms($studentId)
    {
        $student = Student::findOrFail($studentId);

        $subscribedClassroomIds = $student->classroom()->pluck('class_rooms.id')->toArray();

        $classrooms = Classroom::whereIn('id', $subscribedClassroomIds)->get();

        return response()->json([
            'message' => 'The student subscribed to these classrooms',
            'status' => Response::HTTP_OK,
            'data' => ClassRoomResource::collection($classrooms)
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $found = $this->getStudentObject(Auth('student')->user()->id)->classRoom->contains($request->classroom_id);

        if ($found) {
            $this->getStudentObject(Auth('student')->user()->id)->classRoom()->detach($request->classroom_id);
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'تم الغاء الاشتراك فى الفصل بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'You Already unsubscribe in this classRoom'
            ]);
        }
    }


    public function remainingStudents($classroomId)
    {
        $classRoom = ClassRoom::withCount('student')->find($classroomId);
        if ($classRoom) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => [
                    'max_capacity' => $classRoom->max_capacity,
                    'Registered' => $classRoom->student_count,
                    'RemainingStudnet' => $classRoom->max_capacity - $classRoom->student_count
                ]
            ]);
        }
    }

    public function getClassroomsByTeacherId($teacherId)
    {

        $classrooms = Classroom::whereDoesntHave('student', function ($query) {
            return $query->where('classroom_student.student_id', Auth::user('student')->id);;
        })
            ->where('start_date', '>', date('Y-m-d H:i:s'))
            ->where('status', "1")
            ->with('teacher')
            ->where('teacher_id', $teacherId)
            ->get();

        if ($classrooms) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => ClassRoomResource::collection($classrooms)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function getClassroomsBySubjectId($subjectId)
    {
        $classrooms = Classroom::whereDoesntHave('student', function ($query) {
            return $query->where('classroom_student.student_id', Auth::user('student')->id);;
        })
            ->where('start_date', '>', date('Y-m-d H:i:s'))
            ->where('status', "1")
            ->with('subject')
            ->where('subject_id', $subjectId)
            ->get();

        if ($classrooms) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => ClassRoomResource::collection($classrooms)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function classroomBasedOnAuthStudent($status)
    {
        $allClassroomBasedOnStatus = ClassRoom::whereHas('student', function ($query) use ($status) {
            return $query
                ->where('classroom_student.student_id', Auth::user('student')->id)
                ->where('classroom_student.status', $status);
        })->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => [
                'allStudent' => ClassRoomResource::collection($allClassroomBasedOnStatus),
            ]
        ]);
    }
}
