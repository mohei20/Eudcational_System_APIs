<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Appointment;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\Dashboard\Appointment\AppointmentStoreRequest;
use App\Http\Requests\Dashboard\Appointment\AppointmentUpdateRequest;

class AppointmentController extends Controller
{
    public function index()
    {
        $allappointments = Appointment::all();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => AppointmentResource::collection($allappointments)
        ]);
    }

    public function getAppointmentsByClassroomId($classroomId)
    {
        $appointments = Appointment::with('classRoom')->where('class_room_id', $classroomId)->get();
        if ($appointments) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => AppointmentResource::collection($appointments)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(AppointmentStoreRequest $request)
    {
        $appointment =  Appointment::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new AppointmentResource($appointment)
        ]);
    }

    public function show($id)
    {
        $appointment = Appointment::whereId($id)->first();

        if ($appointment) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new AppointmentResource($appointment)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(AppointmentUpdateRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
