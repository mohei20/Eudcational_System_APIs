<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Question;
use App\Http\trait\Imageable;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\Dashboard\Question\QuestionStoreRequest;
use App\Http\Requests\Dashboard\Question\QuestionUpdateRequest;

class QuestionController extends Controller
{
    use Imageable;
    public function getQuestionsByExamId($examId)
    {
        $questions = Question::with('exam')->where('exam_id', $examId)->get();

        if ($questions) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' =>  QuestionResource::collection($questions)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(QuestionStoreRequest $request)
    {
        $newImage = $this->insertImage($request->exam_id, $request->image, 'Question_image');
        $data = array_merge($request->all(), ['image' => $newImage]);
        $question = Question::create($data);
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
            'data' => new QuestionResource($question)
        ]);
    }

    public function show($id)
    {
        $question = Question::whereId($id)->first();

        if ($question) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' => new QuestionResource($question)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function update(QuestionUpdateRequest $request, $id)
    {
        $question = Question::findOrFail($id);

        if ($question) {
            if ($request->file('image')) {
                if ($question->image) {
                    Storage::disk('question_image')->delete($question->image);
                }
                $newImage = $this->insertImage($request->exam_id, $request->file('image'), 'Question_image');
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
        $question = Question::findOrFail($id);
        Storage::disk('question_image')->delete($question->image);
        $question->delete();
        return response()->json([
            'message' => 'Delete',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
