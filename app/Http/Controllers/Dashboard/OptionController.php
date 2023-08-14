<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use App\Http\Requests\Dashboard\Option\OptionStoreRequest;
use App\Models\Question;

class OptionController extends Controller
{
    public function getOptionsByQuestionId($questionId)
    {
        $options = Option::with('question')->where('question_id', $questionId)->get();

        if ($options) {
            return response()->json([
                'message' => 'ok',
                'status' => Response::HTTP_OK,
                'data' =>  OptionResource::collection($options)
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }

    public function store(OptionStoreRequest $request, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $data = $request->json()->all();
        $options = [];
        foreach ($data['option'] as $key => $value) {
            $options[] = [
                'option' => $value,
                'is_correct' => $data['is_correct'][$key],
                'exam_id' => $data['exam_id'],
                'question_id' => $questionId,
            ];
        }
        Option::insert($options);
        return response()->json([
            'message' => 'Created Successfully',
            'status' => Response::HTTP_CREATED,
        ]);
    }

    public function destory($questionId)
    {
        $options = Option::where('question_id', $questionId)->get();

        foreach ($options as $option) {
            $option->delete();
        }
        return response()->json([
            'message' => 'All Options Deleted',
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
