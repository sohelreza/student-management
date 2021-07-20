<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([

   'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');
    Route::post('registration', 'AuthController@registration');
    Route::post('forgotpassword', 'AuthController@forgotpassword');
});


Route::prefix('student')->group(function () {
    
  
    


    // Get Academic Info

    Route::post('search_branch', 'StudentAuthController@searchBranch');
    Route::post('search_branch_single', 'StudentAuthController@searchBranchSingle');
    Route::post('search_class', 'StudentAuthController@searchClass');
    Route::post('search_batch', 'StudentAuthController@searchBatch');
    Route::post('search_subject', 'StudentAuthController@searchSubject');
    Route::post('search_subject_amount', 'StudentAuthController@searchSubjectAmount');







    //Get academic Info of Particular student


    Route::post('search_student_branch', 'StudentAuthController@searchStudentBranch');
    Route::post('search_student_class', 'StudentAuthController@searchStudentClass');
    Route::post('search_student_batch', 'StudentAuthController@searchStudentBatch');


    //Student Profile Add & Update & Student Password Change


    Route::get('student_profile', 'StudentProfileController@getUser');
    Route::post('student_info', 'StudentProfileController@getInfo');
    Route::post('student_payment', 'StudentProfileController@getPayment');
    Route::post('student_subject', 'StudentProfileController@getSubject');
    Route::get('student_teacher', 'StudentProfileController@getTeacher');




    Route::post('student_profile', 'StudentProfileController@store');
    Route::patch('student_profile/{id}', 'StudentProfileController@update');
    Route::post('change_password', 'StudentProfileController@changePassword');

    Route::post('last_payment', 'StudentAuthController@lastPayment');

    Route::post('student_image_add', 'StudentProfileController@imageAdd');
    Route::post('student_image_update', 'StudentProfileController@imageUpdate');





    //Student payment & Add Subject

    Route::resource('payments', 'StudentPaymentController');
    Route::post('add_transaction_id', 'StudentPaymentController@addTransactionId');

    //Student Homework Upload

    Route::resource('homeworks', 'StudentHomeworkController');
    Route::post('homework_list', 'StudentHomeworkController@homework_list');


    //Student mcq exam


    Route::post('mcq_exams', 'StudentMCQExamController@exam_list');
    Route::post('mcq_exam_show', 'StudentMCQExamController@exam_show');
    Route::post('mcq_exam_results', 'StudentMCQExamController@exam_result_list');



    Route::group(['middleware' => ['sessions']], function () {
        Route::post('mcq_exam_answer_submit', 'StudentMCQExamController@answer_submit');
    });
    
    Route::post('mcq_exam_show_result', 'StudentMCQExamController@exam_show_result');
    Route::post('mcq_exam_show_answer', 'StudentMCQExamController@exam_show_answer');
    Route::post('mcq_exam_rank', 'StudentMCQExamController@mcq_exam_rank');
    Route::post('mcq_exam_rank_pdf', 'StudentMCQExamController@mcq_exam_rank_pdf');

    

    //Student cq exam

    Route::post('cq_exams', 'StudentCQExamController@exam_list');
    Route::post('cq_exam_show', 'StudentCQExamController@exam_show');
    Route::post('cq_exam_answer_submit', 'StudentCQExamController@answer_submit');
    Route::post('cq_exam_results', 'StudentCQExamController@exam_result_list');
    
    Route::post('cq_exam_rank', 'StudentCQExamController@cq_exam_rank');
    Route::post('cq_exam_rank_pdf', 'StudentCQExamController@cq_exam_rank_pdf');



    //Student Zoom
    Route::post('meetings', 'ZoomClass@student_list');
    Route::post('class_live_meetings', 'ZoomClass@class_live_meetings');

    Route::get('live-class-history/{id}', 'ZoomClass@liveClassHistory');

    Route::get('/meetings/participants/{id}', 'ZoomClass@attendance_list');


    Route::post('class_live_dashboard', 'ZoomClass@class_live_dashboard');




    //Student Content Show

    Route::post('contents', 'StudentContentController@contentList');
    Route::post('lecture_sheets', 'StudentLectureSheetController@lectureList');


    //Message


    Route::post('message', 'StudentMessageController@message');
    Route::post('message_count', 'StudentMessageController@messageCount');

    

    Route::post('sms', 'StudentSMSController@sms');

    Route::get('payment_instruction', 'StudentProfileController@paymentInstruction');
});
