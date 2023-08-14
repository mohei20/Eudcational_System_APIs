<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStudentRegisteredInClassRoom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $foundStudent = ClassRoom::whereHas('classroom_student', [])
        $classRoomId = $request->route('classroom_id');
        $foundStudent = Student::whereHas('classRoom', function ($query) use ($classRoomId) {
            return $query
            ->where('class_rooms.id', $classRoomId)
            ->where('classroom_student.student_id', Auth::user('student')->id)
            ->where('classroom_student.status', ClassRoom::REQISTERED);
        })->first();

        if (!is_null($foundStudent)) {
            return $next($request);
        }else {
            return response()->json([
                'message' => 'Student not Registered in This ClassRoom'
            ]);
        }
    }
}
