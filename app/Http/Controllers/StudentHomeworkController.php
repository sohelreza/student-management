<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentHomework;
use App\StudentHomeworkImage;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;
use JWTAuth;




class StudentHomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_homeworks=$user->homeworks;
       
        return response()->json($user_homeworks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            

            'subject_id' => 'required',
            'title' => 'required',
            'teacher_id'=>'required',
            // 'homework_image'=>'required |filled| mimes:jpeg,jpg,png | max:2048',
            'homework_image'=>'required |filled|max:2048',



        ]);


        // $user = JWTAuth::parseToken()->authenticate();

        $user = User::find($request->student_id);
        $homework=new StudentHomework;
        $homework->student_id=$user->id;
        $homework->branch_id=$user->branch_id;
        $homework->class_id=$user->class_id;
        $homework->batch_id=$user->batch_id;
        $homework->subject_id=$request->subject_id;
        $homework->title=$request->title;
        $homework->teacher_id=$request->teacher_id;
        $homework->submission_date=Carbon::now();
        $homework->save();

        session(['homework_id'=>$homework->id]);
        $homework_id=session('homework_id');

        if($request->hasFile('homework_image')) {

            foreach($request->file('homework_image') as $image)
            {
                // dd($image);
                $homework_image=new StudentHomeworkImage;
                $homework_image->student_homework_id=$homework_id;
                $homework_image->save();

                $filename=time().$image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(1000, 1000);
                $image_resize->save(public_path('homework/' .$filename));
                $homework_image->homework_image = $filename;
                $homework_image->save();
            }
            

           
        }

         return response()->json($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function homework_list(Request $request)
    {
        $homeworks=StudentHomework::with('images')->
                                  where('student_id', $request->student_id)->get();
        return response($homeworks);
    }
}
