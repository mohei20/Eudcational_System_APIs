<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Http\trait\Imageable;
use Illuminate\Http\Response;
use App\Http\trait\Branchable;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\Teacher\TeacherStoreRequest;
use App\Http\Requests\Dashboard\Teacher\TeacherUpdateRequest;

class TeacherController extends Controller
{
    use Imageable, Branchable;
    public function index()
    {
        $teachers = Teacher::all();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => TeacherResource::collection($teachers)
        ]);
    }
    public function store(TeacherStoreRequest $request)
    {
        $branchId = $this->get_branch_id_by_auth_user();
        $newImage =
            $this->insertImage($request->nick_name, $request->avatar, 'Teacher_image');
        $teacher = Teacher::create(array_merge(
            $request->all(),
            ['avatar' => $newImage]
        ));
        $teacher->branch()->attach([$branchId]);
        return response()->json([
            'message' => 'Created',
            'status' => Response::HTTP_CREATED,
            'data' => new TeacherResource($teacher)
        ]);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            return response()->json([
                'message' => 'Ok',
                'status' => Response::HTTP_OK,
                'data' => new TeacherResource($teacher)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(TeacherUpdateRequest $request, $id)
    {
        $teacher = Teacher::find($id);

        if ($teacher) {
            if ($request->file('avatar')) {
                Storage::disk('teacher_image')->delete($teacher->avatar);
                $newImage = $this->insertImage($request->nick_name, $request->avatar, 'Teacher_image');
                $teacher->update(array_merge(
                    $request->all(),
                    ['avatar' => $newImage]
                ));
            } else {
                $teacher->update($request->all());
            }
            return response()->json([
                'message' => 'Updated',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function destory($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            Storage::disk('teacher_image')->delete($teacher->avatar);
            $teacher->branch()->detach();
            $teacher->delete();
            return response()->json([
                'message' => 'Deleted',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function all_teacher_in_branch($branchId)
    {
        $allTeacher = Teacher::WhereHas('branch', function ($q) use ($branchId) {
            $q->where('branches.id', $branchId);
        })->with('branch')->get();

        if ($allTeacher) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => TeacherResource::collection($allTeacher)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function getTeachersByClassroomId($classroomId)
    {
        $classroom = ClassRoom::with('teacher')->where('id', $classroomId)->first();
        $teacher = $classroom->teacher;
        if ($teacher) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new TeacherResource($teacher)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }
}
