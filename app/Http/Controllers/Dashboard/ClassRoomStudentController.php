<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\Website\ClassRoom\RegisterRequest;
use App\Http\Requests\Website\ClassRoom\AcceptStudentRequest;


class ClassRoomStudentController extends Controller
{
    public function AcceptStudentByAssistant(AcceptStudentRequest $request)
    {
        $this->getStudentObject($request->student_id)->classRoom()->updateExistingPivot($request->classroom_id, [
            'status' => ClassRoom::REQISTERED
        ]);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Student Registered in Classroom Successfully'
        ]);
    }

    public function AcceptAllStudentByAssistant(RegisterRequest $request)
    {
        $classRoom = ClassRoom::with('student')->find($request->classroom_id);
        $studentIds = $classRoom->student()->pluck('students.id');

        foreach ($studentIds as $studentId) {
            $classRoom->student()->updateExistingPivot($studentId, [
                'status' => ClassRoom::REQISTERED
            ]);

            $classRoomRegisteredStudent = ClassRoom::find($request->classroom_id)->withCount('student')->first();

            if ($classRoomRegisteredStudent->student_count == $classRoom->max_capacity) {
                break;
            }

        }
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'All Student Registered in Classroom Successfully'
        ]);
    }


    public function getAllStudentInClassRoom($classroomId, $appointmentId)
    {

        $found = Attendance::where('attendance_date', date('Y-m-d'))
            ->where('class_room_id', $classroomId)
            ->where('appointment_id', $appointmentId)
            ->exists();

        if ($found) {
            $appointmentInfo = Appointment::find($appointmentId);
            $allStudentAttendanceInAppointmentIdInClassRoomId =
            Student::whereHas('classRoom', function ($query) use ($classroomId) {
                return $query
                ->where('class_rooms.id', $classroomId)
                ->where('classroom_student.status', ClassRoom::REQISTERED);
            })->whereHas('attendance', function ($query) use ($appointmentId, $classroomId) {
                return $query
                ->where('class_room_id', $classroomId)
                ->where('appointment_id', $appointmentId)
                ->where('attendance_date', date('Y-m-d'));
            })->with('classRoom', 'attendance')->get();

            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => [
                    'date' => $allStudentAttendanceInAppointmentIdInClassRoomId[0]->attendance[0]->attendance_date,
                    'appoinment' => new AppointmentResource($appointmentInfo),
                    "numberOfStudent" => $allStudentAttendanceInAppointmentIdInClassRoomId->count(),
                    'allStudent' => StudentResource::collection($allStudentAttendanceInAppointmentIdInClassRoomId),
                ]
            ]);

        }else {
            $allStudentsRegisteredInClassRoom = Student::whereHas('classRoom', function ($query) use ($classroomId) {
                return $query
                ->where('class_rooms.id', $classroomId)
                ->where('classroom_student.status', ClassRoom::REQISTERED);
            })->with('classRoom')->get();


            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => [
                    'allStudent' => StudentResource::collection($allStudentsRegisteredInClassRoom),
                ]
            ]);
        }


    }

    public function getAllStudentInClassRoomBasedOnStatus($classroomId, $status)
    {
        $allStudentsRegisteredInClassRoom = Student::whereHas('classRoom', function ($query) use ($classroomId, $status) {
            return $query
            ->where('class_rooms.id', $classroomId)
            ->where('classroom_student.status', $status);
        })->with('classRoom')->get();


        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => [
                'allStudent' => StudentResource::collection($allStudentsRegisteredInClassRoom),
            ]
        ]);
    }

}
