<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Attachment;
use Illuminate\Http\Response;
use App\Http\trait\Fileable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AttachmentResource;
use App\Http\Requests\Dashboard\Attachment\AttachmentStoreRequest;
use App\Http\Requests\Dashboard\Attachment\AttachmentUpdateRequest;

class AttachmentController extends Controller
{
    use Fileable;
    public function index()
    {
        $allattachments = Attachment::all();
        $allattachments = Attachment::with('classRoom')->get();
        return response()->json([
            'message' => 'Ok',
            'status' => Response::HTTP_OK,
            'data' => AttachmentResource::collection($allattachments)
        ]);
    }

    public function getAttachmentsByClassroomId($classroomId)
    {
        $attachments = Attachment::with('classRoom')->where('class_room_id', $classroomId)->get();
        if ($attachments) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => AttachmentResource::collection($attachments)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(AttachmentStoreRequest $request)
    {
        $newFile = $this->uploadFile($request->description, $request->name, 'Attachments');
        $attachment = Attachment::create(array_merge(
            $request->all(),
            ['name' => $newFile]
        ));
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new AttachmentResource($attachment)
        ]);
    }

    public function show($id)
    {
        $attachment = Attachment::whereId($id)->first();
        if ($attachment) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new AttachmentResource($attachment)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(AttachmentUpdateRequest $request, $id)
    {
        $attachment = Attachment::find($id);

        if ($attachment) {
            if ($request->file('name')) {
                Storage::disk('attachment_name')->delete($attachment->name);
                $newFile = $this->uploadFile($request->description, $request->name, 'Attachments');
                $attachment->update(array_merge(
                    $request->all(),
                    ['name' => $newFile]
                ));
            } else {
                $attachment->update($request->all());
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
        $attachment = Attachment::find($id);
        if ($attachment) {
            Storage::disk('attachment_name')->delete($attachment->name);
            $attachment->delete();
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
}
