<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Attendance\StoreRequest;
use App\Models\Attendance;
use Illuminate\Http\Response;

class AttendanceController extends Controller
{
    public function attendanceStudent(StoreRequest $request)
    {
        foreach ($request->attendances as $studentId => $status) {
            $found = Attendance::where('attendance_date', date('Y-m-d'))
            ->where('student_id', $studentId)
            ->where('appointment_id', $request->appointment_id)
            ->first();
            if ($found) {
                $found->update([
                    'status' => $status
                ]);
            } else {
                Attendance::create([
                    'class_room_id' => $request->class_room_id,
                    'appointment_id' => $request->appointment_id,
                    'student_id' => $studentId,
                    'attendance_date' => date("Y-m-d"),
                    'status' => $status
                ]);
            }
        }
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Attendances Saved'
        ]);
    }


}
