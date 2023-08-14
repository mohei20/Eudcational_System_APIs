<?php


use App\Http\Controllers\Dashboard\AssistantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\HeadBranchController;
use App\Http\Controllers\Dashboard\ShopController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\AcademicYearController;
use App\Http\Controllers\Dashboard\SemesterController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\NoteController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\ClassRoomController;
use App\Http\Controllers\Dashboard\AttachmentController;
use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\ClassRoomStudentController;
use App\Http\Controllers\Dashboard\LessonController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::group([

    'middleware' => ['auth','role:manager'],
    'prefix' => 'branches/'
], function () {
    Route::get('/', [BranchController::class, 'index']);
    Route::post('/', [BranchController::class, 'store']);
    Route::get('{branch}', [BranchController::class, 'show']);
    Route::post('{branch}', [BranchController::class, 'update']);
    Route::delete('{branch}', [BranchController::class, 'destory']);
});


Route::group([

    'middleware' => ['auth', 'role:head_of_branch|manager'],
    'prefix' => 'head-branch/'
], function () {
    Route::get('/', [HeadBranchController::class, 'index']);
    Route::post('/', [HeadBranchController::class, 'store']);
    Route::get('{headofBranch}', [HeadBranchController::class, 'show']);
    Route::post('{headofBranch}', [HeadBranchController::class, 'update']);
    Route::delete('{headofBranch}', [HeadBranchController::class, 'destory']);
});


Route::group([
    'middleware' => ['auth','role:head_of_branch'],
], function () {
    Route::get('assistants', [AssistantController::class, 'index']);
    Route::post('assistants', [AssistantController::class, 'store']);
    Route::get('assistants/{id}', [AssistantController::class, 'show']);
    Route::post('assistants/{id}', [AssistantController::class, 'update']);
    Route::delete('assistants/{id}', [AssistantController::class, 'destory']);
});


Route::group([
    'middleware' => ['auth','role:assistant']
], function () {
    Route::get('teachers', [TeacherController::class, 'index']);
    Route::post('teachers', [TeacherController::class, 'store']);
    Route::get('teachers/{id}', [TeacherController::class, 'show']);
    Route::post('teachers/{id}', [TeacherController::class, 'update']);
    Route::delete('teachers/{id}', [TeacherController::class, 'destory']);
});


Route::group([

    'middleware' => ['auth','role:assistant'],

], function () {
    Route::get('academicYears', [AcademicYearController::class, 'index']);
    Route::post('academicYears', [AcademicYearController::class, 'store']);
    Route::get('academicYears/{id}', [AcademicYearController::class, 'show']);
    Route::get('academicYears_get_by_branch_id/{id}', [AcademicYearController::class, 'getAcademicYearByBranchId']);
    Route::post('academicYears/{id}', [AcademicYearController::class, 'update']);
    Route::delete('academicYears/{id}', [AcademicYearController::class, 'destory']);
});


Route::group([
    'middleware' => ['auth', 'role:assistant'],
], function () {
    Route::get('semesters', [SemesterController::class, 'index']);
    Route::post('semesters', [SemesterController::class, 'store']);
    Route::get('semesters/{id}', [SemesterController::class, 'show']);
    Route::post('semesters/{id}', [SemesterController::class, 'update']);
    Route::delete('semesters/{id}', [SemesterController::class, 'destory']);
});


Route::group([

    'middleware' => ['auth','role:assistant'],

], function () {
    Route::get('subjects', [SubjectController::class, 'index']);
    Route::post('subjects', [SubjectController::class, 'store']);
    Route::get('subjects/{id}', [SubjectController::class, 'show']);
    Route::get('subjects_get_by_branch_id/{id}', [SubjectController::class, 'getSubjectByBranchId']);
    Route::post('subjects/{id}', [SubjectController::class, 'update']);
    Route::delete('subjects/{id}', [SubjectController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']
], function () {
    Route::get('shops/{branch_id}', [ShopController::class, 'index']);
    Route::post('shops', [ShopController::class, 'store']);
    Route::get('shop/{id}', [ShopController::class, 'show']);
    Route::post('shops/{id}', [ShopController::class, 'update']);
    Route::delete('shops/{id}', [ShopController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']
], function () {
    Route::get('categories/{shop_id}', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth','role:assistant']
], function () {
    Route::get('products/{category_id}', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::post('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth','role:assistant']
], function () {
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders/{id}', [OrderController::class, 'update']);
    Route::delete('orders/{id}', [OrderController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth','role:assistant']
], function () {
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);
    Route::post('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::post('classRooms', [ClassRoomController::class, 'store']);
    Route::get('classRooms/{id}', [ClassRoomController::class, 'show']);
    Route::get('classrooms_get_by_branch_id/{id}', [ClassRoomController::class, 'getClassroomsByBranchId']);
    Route::post('classRooms/{id}', [ClassRoomController::class, 'update']);
    Route::delete('classRooms/{id}', [ClassRoomController::class, 'destory']);

    Route::post('/accept-student-classroom', [
        ClassRoomStudentController::class, 'AcceptStudentByAssistant'
    ]);

    Route::post('/accept-all-student-classroom', [
        ClassRoomStudentController::class, 'AcceptAllStudentByAssistant'
    ]);

    Route::get('/all-students-classroom/{classroom_id}/{appointment_id}', [
        ClassRoomStudentController::class, 'getAllStudentInClassRoom'
    ]);

    Route::get('/all-students-classroom_based_on_status/{classroom_id}/{status}', [
        ClassRoomStudentController::class, 'getAllStudentInClassRoomBasedOnStatus'
    ]);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::get('notes', [NoteController::class, 'index']);
    Route::post('notes', [NoteController::class, 'store']);
    Route::get('notes/{id}', [NoteController::class, 'show']);
    Route::get('notes_get_by_classroom_id/{id}', [NoteController::class, 'getNotesByClassroomId']);
    Route::post('notes/{id}', [NoteController::class, 'update']);
    Route::delete('notes/{id}', [NoteController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::get('attachment', [AttachmentController::class, 'index']);
    Route::post('attachment', [AttachmentController::class, 'store']);
    Route::get('attachment/{id}', [AttachmentController::class, 'show']);
    Route::get('attachment_get_by_classroom_id/{id}', [AttachmentController::class, 'getAttachmentsByClassroomId']);
    Route::post('attachment/{id}', [AttachmentController::class, 'update']);
    Route::delete('attachment/{id}', [AttachmentController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::get('appointment', [AppointmentController::class, 'index']);
    Route::post('appointment', [AppointmentController::class, 'store']);
    Route::get('appointment/{id}', [AppointmentController::class, 'show']);
    Route::get('appointment_get_by_classroom_id/{id}', [AppointmentController::class, 'getAppointmentsByClassroomId']);
    Route::post('appointment/{id}', [AppointmentController::class, 'update']);
    Route::delete('appointment/{id}', [AppointmentController::class, 'destory']);
});


Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::post('/attendance', [AttendanceController::class, 'attendanceStudent']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::post('exams', [ExamController::class, 'store']);
    Route::get('exams/{id}', [ExamController::class, 'show']);
    Route::get('exams_get_by_classroom_id/{id}', [ExamController::class, 'getExamsByClassroomId']);
    Route::post('exams/{id}', [ExamController::class, 'update']);
    Route::delete('exams/{id}', [ExamController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::post('questions', [QuestionController::class, 'store']);
    Route::get('questions/{id}', [QuestionController::class, 'show']);
    Route::get('questions_get_by_exam_id/{id}', [QuestionController::class, 'getQuestionsByExamId']);
    Route::post('questions/{id}', [QuestionController::class, 'update']);
    Route::delete('questions/{id}', [QuestionController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant']

], function () {
    Route::post('options/{questionId}', [OptionController::class, 'store']);
    Route::get('options_get_by_question_id/{id}', [OptionController::class, 'getOptionsByQuestionId']);
    Route::delete('options/{questionId}', [OptionController::class, 'destory']);
});

Route::group([
    'middleware' => ['auth', 'role:assistant'],
], function () {
    Route::post('lessons',[LessonController::class,'store']);
    Route::get('lessons/{classRoom_id}',[LessonController::class,'index']);
    Route::post('lessons/{lesson_id}',[LessonController::class,'update']);
    Route::delete('lessons/{lesson_id}',[LessonController::class,'destory']);
});

