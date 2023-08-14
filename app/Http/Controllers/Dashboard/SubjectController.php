<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Subject;
use App\Http\trait\Imageable;
use Illuminate\Http\Response;
use App\Http\trait\Branchable;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\Subject\SubjectStoreRequest;
use App\Http\Requests\Dashboard\Subject\SubjectUpdateRequest;

class SubjectController extends Controller
{
    use Branchable, Imageable;
    public function index()
    {
        $allSubjects = Subject::all();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => SubjectResource::collection($allSubjects)
        ]);
    }

    public function getSubjectByBranchId($branchId)
    {
        $Subjects = Subject::with('branch')->where('branch_id', $branchId)->get();

        if ($Subjects) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' =>  SubjectResource::collection($Subjects)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(SubjectStoreRequest $request)
    {
        $branchId = $this->get_branch_id_by_auth_user();

        $newImage =
        $this->insertImage($request->name, $request->image, 'Subject_image');
        $data = array_merge(
            $request->all(),
            ['branch_id' =>$branchId],
            ['image' => $newImage]
        );
        $subject =  Subject::create($data);
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new SubjectResource($subject)
        ]);
    }

    public function show($id)
    {
        $subject = Subject::whereId($id)->first();
        if ($subject) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new SubjectResource($subject)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(SubjectUpdateRequest $request, $id)
{
    $question = Subject::findOrFail($id);

    if ($question) {
        if ($request->file('image')) {
            if ($question->image) {
                Storage::disk('subject_image')->delete($question->image);
            }
            $newImage = $this->insertImage($request->name, $request->file('image'), 'Subject_image');
            $question->update(array_merge($request->all(), ['image' => $newImage]));
        } else {
            $question->update($request->all());
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
        $subject = Subject::findOrFail($id);
        Storage::disk('subject_image')->delete($subject->image);
        $subject->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    public function all_subject_in_branch($branchId)
    {
        $allSubject = Subject::WhereHas('branch', function ($q) use ($branchId) {
            $q->where('branches.id', $branchId);
        })->with('branch')->get();

        if ($allSubject) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => SubjectResource::collection($allSubject)
            ]);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }

    }
}
