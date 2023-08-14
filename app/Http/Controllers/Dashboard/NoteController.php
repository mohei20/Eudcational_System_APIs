<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Note;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Requests\Dashboard\Note\NoteStoreRequest;
use App\Http\Requests\Dashboard\Note\NoteUpdateRequest;

class NoteController extends Controller
{
    public function getLastFiveNotesLByClassroomId($classroomId)
    {
        $notes = Note::with('classRoom')->where('class_room_id', $classroomId)->limit(5)->get();
        if ($notes) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => NoteResource::collection($notes)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function getNotesByClassroomId($classroomId)
    {
        $notes = Note::with('classRoom')->where('class_room_id', $classroomId)->get();
        if ($notes) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => NoteResource::collection($notes)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(NoteStoreRequest $request)
    {
        $note =  Note::create($request->all());
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new NoteResource($note)
        ]);
    }

    public function show($id)
    {
        $note = Note::whereId($id)->first();
        if ($note) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new NoteResource($note)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(NoteUpdateRequest $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());
        return response()->json([
            'message' => 'Update',
            'status' => Response::HTTP_NO_CONTENT
        ]);
    }

    public function destory($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
