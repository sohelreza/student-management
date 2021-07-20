<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZoomMetting;
use App\ZoomMeetingAttendance;
use App\Branch;
use App\User;
use App\StudentSubject;
use DB;
use App\ZoomApi;
use App\StudentProfile;
use App\Admin;
use Auth;

class TeacherZoomClass extends Controller
{
    private function generateZoomToken($id)
    {
    	$zoomapi=ZoomApi::find($id);
	    $key = $zoomapi->zoom_api_key;
	    $secret = $zoomapi->zoom_api_secret;

	    $payload = [
	        'iss' => $key,
	        'exp' => strtotime('+1 minute'),
	    ];
	    return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
	{
	    return env('ZOOM_API_URL', 'https://api.zoom.us/v2/');
	}

	public function zoomRequest($id)
	{
	    $jwt = $this->generateZoomToken($id);
	    return \Illuminate\Support\Facades\Http::withHeaders([
	        'authorization' => 'Bearer ' . $jwt,
	        'content-type' => 'application/json',
	    ]);
	}

	
    // These methods return Response that is used to execute GET/POST/PATCH/DELETE request.
	

	// public function zoomGet(string $path, array $query = [])
	// {
	//     $url = $this->retrieveZoomUrl();
	//     $request = $this->zoomRequest();
	//     return $request->get($url . $path, $query);
	// }

	public function zoomPost(string $path, int $id, array $body = [])
	{
	    $url = $this->retrieveZoomUrl();
	    $request = $this->zoomRequest($id);
	    return $request->post($url . $path, $body);
	}

	public function zoomPatch(string $path, int $id , array $body = [])
	{
	    $url = $this->retrieveZoomUrl();
	    $request = $this->zoomRequest($id);
	    return $request->patch($url . $path, $body);
	}

	public function zoomDelete(string $path, int $id, array $body = [])
	{
	    $url = $this->retrieveZoomUrl();
	    $request = $this->zoomRequest($id);
	    return $request->delete($url . $path, $body);
	}

	

    //Formatting Date

	public function toZoomTimeFormat(string $dateTime)
	{
	    try {
	        $date = new \DateTime($dateTime);
	        return $date->format('Y-m-d\TH:i:s');
	    } catch(\Exception $e) {
	        Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());
	        return '';
	    }
	}

	public function toUnixTimeStamp(string $dateTime, string $timezone)
	{
	    try {
	        $date = new \DateTime($dateTime, new \DateTimeZone($timezone));
	        return $date->getTimestamp();
	    } catch (\Exception $e) {
	        Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());
	        return '';
	    }
	}

	const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function add(){

        $branches=Branch::where('student_type',1)
                            ->orWhere('student_type',2)
                            ->get();
        $zoomapis=ZoomApi::all();                      
    	return view('teacher.liveClass.addClass',compact('branches','zoomapis'));
    }

    public function create(Request $request)
	{
	    
	    $request->validate([
	        
	        'topic' => 'required',
	        'date' => 'required|date_format:m/d/Y',
	        'time' => 'required',
	        'duration' => 'required',
	        'zoom_api'=>'required',
	        'student_type'=>'required',
	        'branch' => 'required',
	        'class' => 'required',
	        'batch' => 'required',
	        'subject' => 'required',
	        'host_video' => 'required',
	        'client_video' => 'required',
            
	    ]);

	    
	   

	    $path = 'users/me/meetings';
	    $response = $this->zoomPost($path,$request->zoom_api, [
	        'topic' => $request->topic,
	        'description' => $request->description,
	        'type' => self::MEETING_TYPE_SCHEDULE,
	        'start_time' => $this->toZoomTimeFormat($request->date.' '.$request->time),
	        'duration' => $request->duration,
	        'settings' => [
	            'host_video' => $request->host_video,
	            'participant_video' => $request->client_video,
	        ]
	    ]);

	    $data = json_decode($response->body(), true);

	    $admin=Auth::guard('admin')->user(); 


	    $meeting=new ZoomMetting;

	    $meeting->meeting_id=$data['id'];
	    // $meeting->password=$data['password'];
	    $meeting->topic=$request->topic;
	    $meeting->description=$request->description;
	    $meeting->when=$this->toZoomTimeFormat($request->date.' '.$request->time);
	    $meeting->duration=$request->duration;
	    $meeting->zoom_api=$request->zoom_api;
	    $meeting->teacher_id=$admin->id;
	    $meeting->branch=$request->branch;
	    $meeting->class=$request->class;
	    $meeting->batch=$request->batch;
	    $meeting->student_type=$request->student_type;
	    $meeting->subject=$request->subject;
	    $meeting->host_video=($request->host_video == true) ? 1:0;
	    $meeting->client_video=($request->client_video == true) ? 1:0;
	    $meeting->meeting_type=self::MEETING_TYPE_SCHEDULE;
	    $meeting->join_url=$data['join_url'];
	    $meeting->start_url=$data['start_url'];
	    $meeting->live_status=1;
	    $meeting->save();

	    return redirect('teacher/meetings/');
        
    }

    public function edit($id){

    	$meeting=ZoomMetting::find($id);

        $branches=Branch::where('student_type',1)
                            ->orWhere('student_type',2)
                            ->get();
        $zoomapis=ZoomApi::all();                      
    	return view('teacher.liveClass.editClass',compact('branches','zoomapis','meeting'));
    }


    public function list()
	{
	    // $path = 'users/me/meetings';
	    // $response = $this->zoomGet($path);

	    // $data = json_decode($response->body(), true);
	    // $data['meetings'] = array_map(function (&$m) {
	    //     $m['start_at'] = $this->toUnixTimeStamp($m['start_time'], $m['timezone']);
	    //     return $m;
	    // }, $data['meetings']);

	    $admin=Auth::guard('admin')->user(); 

	    $data['classes']=ZoomMetting::where('teacher_id',$admin->id)->get();

	    return view('teacher.liveClass.classList',compact('data'));
	}

	 public function changeStatus(Request $request){

         
           
           $zoom_meeting=ZoomMetting::find($request->meeting_id);
           $zoom_meeting->live_status=$request->status;
           $zoom_meeting->save();

           return back();
    }

    public function get(string $id)
	{
	    $path = 'meetings/' . $id;
	    $response = $this->zoomGet($path);

	    $data = json_decode($response->body(), true);
	    if ($response->ok()) {
	        $data['start_at'] = $this->toUnixTimeStamp($data['start_time'], $data['timezone']);
	    }

	    return [
	        'success' => $response->ok(),
	        'data' => $data,
	    ];
	}
    // public function update(Request $request, string $id) { /**/ }
    public function delete(string $id)
	{



		$meeting=ZoomMetting::where('meeting_id',$id)->first();
        
        $path = 'meetings/' . $id;
	    $response = $this->zoomDelete($path,$meeting->zoom_api);
         
	    $meeting->delete();

	    return back();
	}


	public function student_list(Request $request)
	{
	    $student=User::find($request->student_id);

	    $meetings=ZoomMetting::with('subjectname')
	                          ->with('branchname')
	                          ->with('batchname')
	                          ->with('classname')
	                          ->where('branch',$student->branch_id)
	                          ->where('batch',$student->batch_id)
	                          ->where('class',$student->class_id)
	                          ->where('live_status',3)
	                          ->get();

	    $data['classes']=ZoomMetting::all();

	    return response($meetings);
	}

	public function class_live_meetings(Request $request)
	{
	    $student=User::find($request->student_id);
	    $student_branch=$student->branch_id;
	    $student_class=$student->class_id;
	    $student_batch=$student->batch_id;

	    $student_class=DB::table('student_subjects')
	                    ->select('student_subjects.*','subjects.name','zoom_mettings.join_url','zoom_mettings.topic' ,'zoom_mettings.duration','zoom_mettings.when')
	                    ->join('subjects','student_subjects.subject_id','=','subjects.id')
	                    ->leftJoin('zoom_mettings', function($join) use($student_branch,$student_class,$student_batch)
                         {
                             $join->on('student_subjects.subject_id', '=', 'zoom_mettings.subject')
                             ->where('zoom_mettings.live_status','=',2)
                             ->where('zoom_mettings.branch',$student_branch)
                             ->where('zoom_mettings.class',$student_class)
                             ->where('zoom_mettings.batch',$student_batch);

                         })
	                     ->where('student_subjects.student_id',$student->id)
	                     ->where('student_subjects.status',1)
	                     ->get();

	    

	    return response($student_class);
	}


	public function liveClassHistory($id)
	{
	    $student=User::find($id);
	    $student_branch=$student->branch_id;
	    $student_class=$student->class_id;
	    $student_batch=$student->batch_id;

	    $student_class=DB::table('student_subjects')
	                    ->select('student_subjects.*','subjects.name','zoom_mettings.join_url','zoom_mettings.topic' ,'zoom_mettings.duration','zoom_mettings.when')
	                    ->join('subjects','student_subjects.subject_id','=','subjects.id')
	                    ->leftJoin('zoom_mettings', function($join) use($student_branch,$student_class,$student_batch)
                         {
                             $join->on('student_subjects.subject_id', '=', 'zoom_mettings.subject')
                             ->where('zoom_mettings.live_status','=',2)
                             ->where('zoom_mettings.branch',$student_branch)
                             ->where('zoom_mettings.class',$student_class)
                             ->where('zoom_mettings.batch',$student_batch);
                         })
	                     ->where('student_subjects.student_id',$student->id)
	                     ->where('student_subjects.status',1)
	                     ->get();

	    

	    return response($student_class);
	}


	public function participant_list($id)
	
	{
	    $path = 'report/meetings/'.$id.'/participants';
	    $response = $this->zoomGet($path);
        $data = json_decode($response->body(), true);

        // return $data;
        
        if (isset($data['code'])) {
        	return "not enough participants";
        } else {
        	$collection = collect($data['participants']);
   
			$groups = array();
		    foreach ($collection as $item) {
		        $key = $item['id'];
		        if (!isset($groups[$key])) {
		            $groups[$key] = array(
		                'id' => $key,
		                'user_id' => $item['user_id'],
		                'name' => $item['name'],
		                'user_email' => $item['user_email'],
		                'duration' => $item['duration'],
		                
		            );
		        } else {
		            $groups[$key]['duration'] = $groups[$key]['duration'] + $item['duration'];
		            
		        }
		    }

		    $meeting=ZoomMetting::where('meeting_id',$id)->first();
	        return view('admin.liveClass.participantList',compact('groups','meeting'));
	    }
       }

       public function submit_attendance(Request $request)
	   {
	      

	    foreach ($request->student_email as $key => $value) {



	        $student_profile=DB::table('student_profiles')
	     	                   ->where('zoom_id',$request->student_email[$key])
	     	                   ->first();

	     	$student=User::find($student_profile->student_id);
            $meeting=ZoomMetting::find($request->meeting_id[$key]);




            if (!empty($student_profile) && $request->student_email[$key] != null ) {

                  if ($student->batch_id == $meeting->batch) {
                  	
                        ZoomMeetingAttendance::create(
			                [   
			                	
			                	'student_id'=>$student_profile->student_id,
			                    'meeting_id'=>$request->meeting_id[$key],
			                    'duration'=>$request->duration[$key],
			                    'status'=>$request->status[$key],
			                     
			                ]

		                );
                  }
	     		
	     		
	     	}

            

        }


        $request->session()->flash('success', 'Student Attendance Added');
        return back();


    }


    public function attendance_list($id)
	
	{
	    

	    $meetings=ZoomMeetingAttendance::where('meeting_id',$id)->get();

	    return view('admin.liveClass.attendanceList',compact('meetings'));

       
	}

}
