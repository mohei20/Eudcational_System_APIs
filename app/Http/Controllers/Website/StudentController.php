<?php

namespace App\Http\Controllers\Website;

use Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\trait\Imageable;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Student\ChangeStudentPasswordRequest;
use App\Http\Requests\Website\Student\StudentUpdateRequest;
use App\Http\Resources\GovernorateResource;
use App\Http\Resources\StudentResource;
use App\Models\Governorate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    use Imageable;

    public $regex = '/^[\p{Arabic} ]+$/u';

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('student')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a Studnet.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|between:2,100|regex:'.$this->regex,
            'm_name' => 'required|string|between:2,100|regex:'.$this->regex,
            'l_name' => 'required|string|between:2,100|regex:'.$this->regex,
            'phone_number' => ['required','regex:/(01)[0-9]{9}/','size:11'],
            'email' => 'required|string|email|max:100|unique:students|',
            'password' => 'required|string|confirmed|min:6',
            'guardian_number' => ['required','regex:/(01)[0-9]{9}/','size:11','different:phone_number'],
            'year' => 'required',
            'month' => ['required','numeric','max:12'],
            'day' => ['required','numeric','max:32'],
            'acedemic_year' => ['required','numeric'],
            'division' =>  ['required', Rule::in(1, 2, 3, 4, 5)],
            'national_id_card' => ['required','mimes:jpg,png,jpeg'],
            'governorate_id' => ['required']
        ]);




        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $newImage = $this->insertImage($request->f_name, $request->national_id_card, 'Student_image/');
        Student::create(array_merge(
            $validator->validated(),
            [
            'password' => Hash::make($request->password),
            'national_id_card' => $newImage
            ]
        ));
        $attempt = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (! $token = auth('student')->attempt($attempt)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return response()->json([
            'message' => 'Student successfully registered',
            'student' => $this->createNewToken($token)
        ], Response::HTTP_CREATED)->header('Content-Type', 'application/json; charset=utf-8');

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('student')->logout();
        return response()->json(['message' => 'Student successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('student')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth('student')->user());
    }

    public function update(StudentUpdateRequest $request, $id)
    {
        $student = Student::whereId(auth('student')->user()->id)->first();
        if ($student->id == $id) {
            if ($request->file('national_id_card')) {
                Storage::disk('student_image')->delete($student->national_id_card);
                $newImage = $this->insertImage($request->f_name, $request->national_id_card, 'Student_image/');
                $student->update(array_merge(
                    $request->all(),
                    ['national_id_card' => $newImage]
                ));
            }else {
                $student->update($request->except('national_id_card'));
            }
            return response()->json([
                'message' => 'Student Updated Successfully..',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }
        return response()->json([
            'message' => 'Studnet Not Found',
            'status' => Response::HTTP_NOT_FOUND
        ]);
    }

    public function destory($id)
    {
        $student = Student::find(auth('student')->user()->id);
        if ($id == $student->id) {
            Storage::disk('student_image')->delete($student->national_id_card);
            $student->delete();
            return response()->json([
                'message' => 'Student Deleted Successfully',
                'status' => Response::HTTP_NO_CONTENT
            ]);
        }
    }

    public function changePassword(ChangeStudentPasswordRequest $request)
    {
        if (password_verify($request->current_password, Auth::user('student')->password)) {
            $user = Student::find(Auth::user('student')->id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Password Change Successfully',
                'status' => Response::HTTP_OK
            ]);
        }else {
            return response()->json([
                'message' => "Current Password not Correct",
            ]);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new StudentResource(auth('student')->user())
        ]);
    }

    public function getAllGov()
    {
        $allGov = Governorate::orderBy('id')->get();

        if ($allGov) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => GovernorateResource::collection($allGov)
            ]);
        }
    }
}
