<?php

namespace App\Imports;

use DB;
use App\Exam;
use App\ExamEnroll;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExamEnrollsImport implements ToModel,WithStartRow,ShouldQueue,WithChunkReading,
    WithBatchInserts
{
    public $exam_id;

    public function __construct($exam_id)
    {
        $this->exam_id = $exam_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = DB::table('users')->where('registration_id',$row[0])->first();
        $exam=Exam::find($this->exam_id);
       
        // POST Method example

        if ($student) {
            $url = "http://66.45.237.70/api.php";
            $number=$student->phone;
            $text=$student->first_name.' '.$student->last_name.' Registration Number '.$student->registration_id.' Exam Name: '.$exam->name.' Total Marks: '.$exam->total_marks.' Your Marks:'.$row[3].' Height Marks: '.$exam->height_marks.' Merit Position: '.$row[5].' - Shadow Aide And Life Line';
            $username="01918184015";
            $password="FB72C69Z";
            $data= array(
            'username'=>$username,
            'password'=>$password,
            'number'=>"$number",
            'message'=>"$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

        }

        if($student){
            return new ExamEnroll([
              
               'student_id'      =>$student->id,
               'exam_id'         =>$this->exam_id,
               'total_marks'     => $row[2],
               'obtained_marks'  => $row[3],
               'height_marks'    => $row[4],
               'merit_position'  => $row[5],  
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
