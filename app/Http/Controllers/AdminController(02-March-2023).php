<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mail;


use Twilio\Rest\Client;




class AdminController extends Controller
{

    public function mail(){



        $email = "rallivishal3df4@gmail.com";
        $to = $email;
        $subject = "Please verify your Email !";



        // $message = "Helo";

        // $message = "gfjhg";

        
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";        
        // $headers .= 'From: <kumar.mairwa@gmail.com>' . "\r\n";

        // $mail = mail($to, $subject, $message, $headers); 

        // echo $to; echo "<br>";
        // echo $subject; echo "<br>";
        // echo $message; echo "<br>";

        
        // Mail::to('manish@programmates.com')->send(new MyTestMail());
        // return "Email sent";


    }


    public function ajaxNotification(Request $request){
        $id = $request->id;
        
        $update_is_read = DB::table('students')->where('id', $id)->update
        ([
         'is_read'=> 1, 

     ]);

    }


    public function admin_dashboard()
    {
        $notification_data = $office_array = array();    
        $user_type =  Auth::user()->type;
        if($user_type==1)
        {
            $student_count = DB::table('students')->where('is_delete', 0)->count();
        }
        else if($user_type==3){
            $office_id =  Auth::user()->office_id;
            $student_count = DB::table('students')->where(['office_id'=>$office_id, 'is_delete' => 0])->count();

        }
        
        if($user_type ==1)
        {
            $staff_count = DB::table('users')->where('is_delete', 0)->count();
        }
        elseif($user_type ==3)
        {
           $office_id =  Auth::user()->office_id;
           $staff_count = DB::table('users')->where(['office_id'=>$office_id, 'is_delete' => 0])->whereIn('type',[ 2,3 ])->count();
       }

       $college_count = DB::table('colleges')->where('is_delete', 0)->count();

       $colleges = DB::table('colleges')->get();


       
       if($user_type ==1)
       {
        $get_offices =DB::table('offices')->where('is_delete', 0)->pluck('name','id')->toArray();

            // echo "<pre>"; print_r($get_office_names);exit;

        $students  = DB::table('students')->where('students.is_delete', 0)->where([['offices.is_delete', '=', 0]] )
        ->select('students.*','users.first_name as staff_name')
        ->join('users','students.user_id','=','users.id')
        ->join('offices', 'students.office_id', '=', 'offices.id')
        ->orderBy('id','desc')->get();

        if($students){
            foreach ($students as $key => $student) {
             $office_array[$student->office_id] =$student->office_id;
             $notification_data[$student->office_id][] = $student;
         }
     }

                    //  echo "get_offices <pre>"; print_r($get_offices);
                    //   echo " Notifications <pre>"; print_r($notification_data);
                    //  echo "office array <pre>"; print_r($office_array);
                    //  exit;


            //  echo "<pre>"; print_r($students);exit;

     return view('admin/dashboard',compact('student_count','staff_count','college_count','colleges','students', 'get_offices','get_offices','notification_data','office_array'));
 }

 elseif ($user_type ==3)
 {
   $office_id = Auth::user()->office_id;

   $students =DB::table('students')->where('students.office_id', $office_id)->select('students.*','users.first_name as staff_name' )->join('users','students.user_id','=','users.id')->orderBy('created_at', 'DESC')->take(5)->get();

   return view('admin/dashboard',compact('student_count','staff_count','college_count','colleges','students'));
}



}

public function adminLogout(){


   $user_type =  Auth::user()->type;


   if($user_type==1) 
   {
    session()->flush();    
    return redirect('/admin/login');
}
elseif($user_type==3)
{
    session()->flush();    
    return redirect('/other_admin/login');
}
}

public function students(Request $request)
{

    $user_type =  Auth::user()->type;

    if($user_type==1)
    { 

        $get_prospect_students = DB::table('students')->where('students.type', 1)->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }
    else if($user_type==3)
    {

        $office_id =  Auth::user()->office_id;
        $get_prospect_students = DB::table('students')->where(['students.type'=> 1,'students.office_id'=>$office_id])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();



    }


    return view('/admin/students', compact('get_prospect_students'));
}


public function leads_students(Request $request)
{


    $user_type = Auth::user()->type;

    if($user_type==1)
    {

        $get_lead_students = DB::table('students')->where('students.type', 2)->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name', 'offices.name as office_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')        
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')  
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        ->where('course_fees_details.current_college_course', 1)       
        ->orderBy('first_name', 'ASC')->get();

    }

    elseif( $user_type==3)
    {
        $office_id = Auth::user()->office_id;
        $get_lead_students = DB::table('students')->where(['students.type' =>2, 'students.office_id' => $office_id])->where('students.is_delete', 0)->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')
        ->leftJoin('users','students.user_id','=','users.id')                
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        ->where('course_fees_details.current_college_course', 1)           
        ->orderBy('first_name', 'ASC')->get();

    }


    return view('/admin/leads_students', compact('get_lead_students'));
}



public function filtered_students(Request $request,$student_type=0,$register_type=0,$pass_exp_date=0,$visa_exp_date=0,$australian_id=0,$marital_status=0,$gender=0,$referral=0,$purpose_of_visit=0,$college=0,$dob=0,$country=0)
{
//echo "<pre>"; print_r($request->all()); exit;
 if($request->all()!=null)
    {  

    if($request->start_pass_exp_date != '')
    {
    $start_pass_exp_date = date('Y-m-d', strtotime($request->start_pass_exp_date));
    }
    else
    {
        $start_pass_exp_date = 0;
    }

    if($request->end_pass_exp_date != '')
    {
    $end_pass_exp_date = date('Y-m-d', strtotime($request->end_pass_exp_date));
    }
    else
    {
        $end_pass_exp_date = 0;
    }

    if($request->start_visa_exp_date != '')
    {
    $start_visa_exp_date = date('Y-m-d', strtotime($request->start_visa_exp_date));  
    }
    else
    {
        $start_visa_exp_date = 0;
    }

    if($request->end_visa_exp_date != '')
    {
    $end_visa_exp_date = date('Y-m-d', strtotime($request->end_visa_exp_date));  
    }
    else
    {
        $end_visa_exp_date = 0;
    }


    if($request->start_dob != '')
    {
    $start_dob = date('Y-m-d', strtotime($request->start_dob));
    }
    else
    {
        $start_dob = '';
    }

    if($request->end_dob != '')
    {
    $end_dob = date('Y-m-d', strtotime($request->end_dob));
    }
    else
    {
        $end_dob = '';
    }

    $student_type = $request->student_type;
    $register_type = $request->register_type;
    $australian_id = $request->australian_id;
    $marital_status = $request->marital_status;
    $gender = $request->gender;
    $referral = $request->referral;
    $purpose_of_visit = $request->purpose_of_visit;
    $college = $request->college;
    $country = $request->country;


    $all_students = DB::table('students')->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name', 'offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')        
       /* ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')  
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')*//*
        ->where('course_fees_details.current_college_course', 1)*/;

        // $all_students = DB::table('students')->where('students.is_delete', 0);

         if(!is_null($student_type)) {
 
       $students = $all_students->where(function($q) use ($student_type) {
            $q->wherein('students.type', $student_type);
            });
        }

        if(!is_null($register_type)) {
            $students = $all_students->where(function($q) use ($register_type) {
            $q->orwherein('students.added_by',$register_type);
            });            
            }

            if(!is_null($start_pass_exp_date && $end_pass_exp_date) && $start_pass_exp_date != 0 && $end_pass_exp_date != 0) {
            $students = $all_students->where(function($q) use ($start_pass_exp_date,$end_pass_exp_date) {
            $q->orwhereDate('students.passport_expiry_date', '>=',$end_pass_exp_date);
            $q->orwhereDate('students.passport_expiry_date', '<=',$start_pass_exp_date);            
            $q->where('students.passport_expiry_date', '!=',null);
            });            
            }

           /* if($pass_exp_date != 0) {
            $students = $all_students->where(function($q) use ($pass_exp_date) {
            $q->orwhere('students.passport_expiry_date',$pass_exp_date);
            });            
            }*/


            if(!is_null($start_visa_exp_date && $end_visa_exp_date) && $start_visa_exp_date != 0 && $end_visa_exp_date != 0) {
            $students = $all_students->where(function($q) use ($start_visa_exp_date,$end_visa_exp_date) {
            $q->orwhereDate('students.passport_expiry_date', '>=',$end_visa_exp_date);
            $q->orwhereDate('students.passport_expiry_date', '<=',$start_visa_exp_date);            
            $q->where('students.passport_expiry_date', '!=',null);
            });            
            }

           /* if($visa_exp_date != 0) {
            $students = $all_students->where(function($q) use ($visa_exp_date) {
            $q->orwhere('students.visa_expiry_date',$visa_exp_date);
            });            
            }*/

            if(!is_null($australian_id)) {
            $students = $all_students->where(function($q) use ($australian_id) {
            $q->orwhere('students.australian_id',$australian_id);
            });            
            }

            if(!is_null($marital_status)) {
            $students = $all_students->where(function($q) use ($marital_status) {
            $q->orwherein('students.marital_status',$marital_status);
            });            
            }

            if(!is_null($gender)) {
            $students = $all_students->where(function($q) use ($gender) {
            $q->orwherein('students.gender',$gender);
            });            
            }

            if(!is_null($referral)) {
            $students = $all_students->where(function($q) use ($referral) {
            $q->orwherein('students.referral',$referral);
            });            
            }

            if(!is_null($purpose_of_visit)) {
            $students = $all_students->where(function($q) use ($purpose_of_visit) {
            $q->orwherein('students.purpose',$purpose_of_visit);
            });            
            }

            if(!is_null($college)) {
            $students = $all_students->where(function($q) use ($college) {
            $q->orwherein('students.college',$college);
            });            
            }

            if(!is_null($end_dob && $start_dob)) {
            $students = $all_students->where(function($q) use ($end_dob,$start_dob) {
            $q->orwhereDate('students.dob', '>=',$start_dob);
            $q->orwhereDate('students.dob', '<=',$end_dob);            
            $q->where('students.dob', '!=','0000-00-00');
            });            
            }

            if(!is_null($country)) {
            $students = $all_students->where(function($q) use ($country) {
            $q->orwherein('students.country',$country);
            });            
            }

        $students = $all_students->orderBy('first_name', 'ASC')->get();
        $get_colleges = DB::table('colleges')->get();

        //echo "<pre>"; print_r($students); exit;

         return view('/admin/filtered_students', compact('students','get_colleges'));

 }
 else
 {
    
 /*$students = DB::table('students')->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name', 'offices.name as office_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')        
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')  
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        ->where('course_fees_details.current_college_course', 1)       
        ->orderBy('first_name', 'ASC')->get();*/


    $students = DB::table('students')->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name', 'offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')->orderBy('first_name', 'ASC')->get();

         $get_colleges = DB::table('colleges')->get();

          return view('/admin/filtered_students', compact('students','get_colleges'));
     }

   
}



public function viewAddStudents()
{
    $countries = DB::table('countries')->get();
    $get_colleges = DB::table('colleges')->get();
    $get_courses = DB::table('courses')->get();
    $get_staffs = DB::table('users')->whereNotIn('id',[1] )->whereIn('type', [1,3])->where('is_delete', 0)->get();

    return view('admin/addstudents',compact('countries','get_staffs','get_courses','get_colleges'));
}


public function add_students(Request $request)
{   

$email_exist_count = DB::table('students')->where(['email'=>$request->email,'is_delete'=>0])->count();

if($email_exist_count > 0)
{
request()->validate(
    [           
        'email' => 'required|email|unique:students|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
    ],
    [
        'email.required' => 'Email of student is required.',         
    ]
);
}
    request()->validate(
        [
            'first_name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'gender' => 'required',           
            'phone' => 'required',
            'whatsapp' => 'required',
            'country' => 'required',
            'emergency_phone' => 'required',                
            'purpose' => 'required',
            'priority' => 'required',         
            'comment' => 'required',     
            'other_purpose' => 'required_with:chkPassport',

        ],
        [
            'first_name.required' => 'First name is required.',
            'dob.required' => 'Date of Birth is required.',
            'address.required' => 'Address is required.',
            'gender.required' => 'Please select gender.',          
            'country.required' => 'Please select country.',
            'emergency_phone.required' => 'Emergency phone number is required.',              
            'purpose.required' => 'Please select purpose of visit.',

            'priority.required' => 'Please choose prospect priority.',
            'comment.required' => 'Please enter comment.',

        ]

    );


    if (str_contains($request->phone_flag, 'data1'))
    { 
        $phone_flag_arr  = explode(' ', $request->phone_flag);
        $phone_flag = $phone_flag_arr[1];
    }
    else
    {
        $phone_flag = $request->phone_flag;
    }

    if (str_contains($request->whatsapp_flag, 'data1'))
    { 
        $whatsapp_flag_arr  = explode(' ', $request->whatsapp_flag);
        $whatsapp_flag = $whatsapp_flag_arr[1];
    }
    else
    {    
        $whatsapp_flag = $request->whatsapp_flag;
    }

    $user_type =  Auth::user()->type;
    if($user_type==1)

       { request()->validate(

        [
          'staff_name' => 'required', 
      ], 
      [
          'staff_name.required' => 'Please assign staff.',
      ]
  );
}



$user_id = $request->staff_name;
$office_id =$request->office_id;
$first_name = $request->first_name;
$middle_name = $request->middle_name;
$last_name = $request->last_name;
$dob =  date('Y-m-d',strtotime($request->dob));
$address = $request->address;
$gender = $request->gender;
$email = $request->email;
$phone = $request->phone;
$phone_flag = $phone_flag;
$phone_dialcode = $request->phone_dialcode;
$whatsapp = $request->whatsapp;
$whatsapp_flag = $whatsapp_flag;
$whatsapp_dialcode = $request->whatsapp_dialcode;
$country = $request->country;
$emergency_phone = $request->emergency_phone;
$purpose = $request->purpose;
$other_purpose = $request->other_purpose;
$referral = $request->referral;      
$other_referral = $request->other_referral;      
$priority = $request->priority;      
$comment = $request->comment;      

if($request->purpose == 'Other Services'){
    request()->validate(
        [
            'other_purpose' => 'required',                            

        ],
        [
            'other_purpose.required' => 'Please Specify other Purpose.',             

        ]

    );
}

if($request->referral == 'Others Specified'){
    request()->validate(
        [
            'other_referral' => 'required',                            

        ],
        [
            'other_referral.required' => 'Please Specify other Referral.',             

        ]

    );
}


if( $request->staff_name)
{
    $get_office = DB::table('users')->where('id', $user_id)->first();

    $office = $get_office->office_id;
}
else 
{
    $user_id = Auth::id();
    $get_office = DB::table('users')->where('id', $user_id)->first();

    $office = $get_office->office_id;
}

DB::table('students')->insert([
    'user_id' => $user_id,
    'office_id' => $office,
    'type' => 1,
    'first_name' => $first_name,
    'middle_name' => $middle_name,
    'last_name' => $last_name,
    'dob' => $dob,
    'address' =>  $address,
    'gender' => $gender,
    'email' => $email,
    'phone' => $phone,
    'phone_flag' => $phone_flag,
    'phone_dialcode' => $phone_dialcode,
    'whatsapp' => $whatsapp,
    'whatsapp_flag' => $whatsapp_flag,
    'whatsapp_dialcode' => $whatsapp_dialcode,
    'country' => $country,
    'emergency_phone' => $emergency_phone,
    'purpose' => $purpose,
    'other_purpose' => $other_purpose,
    'referral' => $referral,
    'other_referral' => $other_referral,
    'priority' => $priority,
    'updated_at' => NOW(),
    'created_at' => NOW(),

]);

$student_id = DB::getPdo()->lastInsertId();

DB::table('communication_log')->insert([
    'student_id' => $student_id,
    'staff_id' => $user_id,
    'comment' => $comment,
    'updated_at' => NOW(),
    'created_at' => NOW(),

]);

    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .=$_SERVER["SERVER_NAME"]. dirname($_SERVER["PHP_SELF"]);  

$url = url('/verify-student') . '/' . base64_encode($email) . '/' . md5($student_id);
$back_url = url('/admin/students');



        // Mail::to('manish@programmates.com')->send(new MyTestMail());
        // return "Email sent";

$to = $email;
$subject = "Please verify your Email !";
$message = "<html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><link href='https://fonts.googleapis.com/css?family=Poppins:400,500,600' rel='stylesheet'><title>RMS</title></head><body style='padding:0px; margin:0px; font-family: 'Poppins', sans-serif; vertical-align:middle;'><div style='width: 540px; margin: 0px auto; display: table;'><div style='width: 100%; float: left; background-color: #fff; border: solid 1px #d5d5d5; padding: 20px 30px; margin: 30px 0;'><div style='width: 100%; margin: 10px 0px 15px; text-align: center; float: left;'><img src='".$path."/admin/images/logo.png' style='padding: 0px 6px 0px 12px;width:300px' border='0' alt=' /></div><div style='clear:both'>&nbsp;</div><h1 style='color: #1d94c7; text-align: center; font-size: 30px; font-weight: 500; margin: 5px 0px 10px; width: 100%; float: left;'>Email Confirmation</h1><h3 style='color: #000; font-size: 16px; text-align: center; font-weight: 400; width: 100%; margin: 0px; float: left;'>Hey ".$first_name.' '.$last_name.", you are almost ready for your admission process. Simply click on button to verify your email id.</h3><a href='".$url."' style='background: #1d94c7; color: #fff; padding: 15px 0px; text-decoration: none; font-weight: 600; text-align: center; font-size: 16px; border-radius: 4px; width: 100%; float: left; margin: 20px 0px;'>Verify email address </a><p style='width: 100%; float: left; text-align: center; color: #000; font-weight: 500;'> Copyright 2022 Student Management panel. All Rights Reserved.</p></div></div></body></html>";


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";        
$headers .= 'From: <info@rms.com>' . "\r\n";
        //$mail = mail($to, $subject, $message, $headers);  */      
echo $message; exit;
        // echo $mail; exit;


return redirect(route('students'))->with('success', 'Student added !!');

}

public function emailVerify($email = '',$id = '')
{
    $encrypt_email = $email;
    $encrypt_id = $id;
    $email = base64_decode($email);
    $get_student_data = DB::table('students')->where('email', $email);
    if ($get_student_data->count() > 0) {
        $student_id = $get_student_data->first()->id;
        if (md5($student_id) == $encrypt_id) {
            DB::table('students')->where('id', $student_id)->update(['is_verified' => 1]);
        }
    }
    return view('thankyou');    
}

public function addComment(Request $request){

    $comment = $request->comment;
    $student_id = $request->student_id;

    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => Auth::id(),
        'comment' => $comment,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);

    return back()->with('success','Comment added sucessfully.');
}

public function other_details($ids){
    $all_courses_val = $all_campuses_val = array();
    $id = base64_decode($ids);
        //echo $ids; exit;
    $get_course_fee_details = $get_courses = array();


    $get_student = DB::table('students')->where('students.id', $id)->select('students.*','students.id as sid','education_details.*')->leftJoin('education_details','students.id','=','education_details.student_id')->first();

    $get_coes_data = DB::table('coes_details')->where('student_id', $id)->first();


        // echo "<pre>"; print_r($get_student); exit;

    $countries = DB::table('countries')->get();
    $get_colleges = DB::table('colleges')->get();
    $get_campuses = DB::table('campuses')->get();
    if($get_student->college!='')
    {
        $get_courses = DB::table('courses')->where('college_id',$get_student->college)->get();   
    }

    $get_staffs = DB::table('users')->get();


    $get_course_fee_detail_count = DB::table('course_fees_details')->where('user_id', $id)->count();
    if($get_course_fee_detail_count > 0)
    {
        $get_course_fee_details = DB::table('course_fees_details')->where('user_id', $id)->get();
    }
    $get_fee_detail_count = DB::table('fee_details')->where('student_id', $id)->count();

    $get_all_courses = DB::table('courses')->where('is_delete',0)->get();

    if($get_all_courses)
    {
        foreach ($get_all_courses as $key => $all_courses_value)
        {   
            $all_courses_val[$all_courses_value->college_id][] = $all_courses_value;                    
        }
    }


    $get_all_campuses = DB::table('campuses')->get();

    if($get_all_campuses)
    {
        foreach ($get_all_campuses as $key => $all_campuses_value)
        {   
            $all_campuses_val[$all_campuses_value->course_id][] = $all_campuses_value;                    
        }
    }


    return view('admin/student-other-details', compact('get_student','countries','get_colleges','get_courses','get_staffs','get_coes_data','get_course_fee_detail_count','get_fee_detail_count','get_course_fee_details','all_courses_val','get_campuses','all_campuses_val'));


}

public function update_other_details(Request $request){

        //echo "<pre>"; print_r($request->all()); exit;

        //echo "<pre>"; print_r($request->course_fees_id); exit;
    request()->validate([

        'first_name' => 'required',

        'dob' => 'required',
        'address' => 'required',
        'gender' => 'required',
        /*'email' => 'required|email|unique:users|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',*/
        'phone' => 'required',
        'country' => 'required',
        'emergency_phone' => 'required',                
        'purpose' => 'required',
        'staff_name' => 'required',

        'passport_number' => 'required_with:chkPassport',
        'passport_expiry_date' => 'required_with:chkPassport',
        'old_passport_file' => 'required_with:chkPassport',


        'visa_expiry_date' => 'required_with:chkVisa',
        'visa_type' => 'required_with:chkVisa',
        'old_visa_file' => 'required_with:chkVisa',


        'ten_school_college' => 'required_with:chkEducation_details',
        'ten_board_university' => 'required_with:chkEducation_details',
        'ten_percentage' => 'required_with:chkEducation_details',
        'ten_session' => 'required_with:chkEducation_details',
        'old_ten_marksheet' => 'required_with:chkEducation_details',

        'twelve_school_college' => 'required_with:chkEducation_details',
        'twelve_board_university' => 'required_with:chkEducation_details',
        'twelve_percentage' => 'required_with:chkEducation_details',
        'twelve_session' => 'required_with:chkEducation_details',
        'old_twelve_marksheet' => 'required_with:chkEducation_details',

        'diploma_board_university' =>'required_with:diploma_school_college',
        'diploma_percentage' =>'required_with:diploma_school_college',
        'diploma_session' => 'required_with:diploma_school_college',
        'old_diploma_marksheet' => 'required_with:diploma_school_college',

        'bachelors_board_university' => 'required_with:bachelors_school_college',
        'bachelors_percentage' => 'required_with:bachelors_school_college',
        'bachelors_session' =>'required_with:bachelors_school_college',
        'old_bachelors_marksheet' => 'required_with:bachelors_school_college',

        'masters_board_university' => 'required_with:masters_school_college',
        'masters_percentage' => 'required_with:masters_school_college',
        'masters_session' =>'required_with:masters_school_college',
        'old_masters_marksheet' => 'required_with:masters_school_college',

        'old_oshc_ovhc_file' => 'required_with:chkOshc_Ovhc',
        'old_ielts_pte_score_file' => 'required_with:chkIelts_pte_score',
        'old_australian_id' => 'required_with:chkAustralianId',

        'start_date_one' => 'required_with:chkCoes',
        'end_date_one' => 'required_with:chkCoes',
        'old_file_one' => 'required_with:chkCoes',

        'course' => 'required_with:college',
        'fees' => 'required_with:college',
        'amount' => 'required_with:college',
        'installment_frequency' => 'required_with:college',
        'total_installment' => 'required_with:college',
        'intake_date' => 'required_with:college',

    ],
    [
        'first_name.required' => 'First name is required.',

        'dob.required' => 'Date of Birth is required.',
        'address.required' => 'Address is required.',
        'gender.required' => 'Please select gender.',
        'email.required' => 'Email of student is required.',
        'country.required' => 'Please select country.',
        'emergency_phone.required' => 'Emergency phone number is required.',              
        'purpose.required' => 'Please select purpose of visit.',
        'staff_name.required' => 'Please assign staff.',

        'passport_number.required_with' => 'Enter passport number.',
        'passport_expiry_date.required_with' => 'Enter passport expire date.',
        'old_passport_file.required_with' => 'Please upload passport.',                    

        'visa_expiry_date.required_with' => 'Enter visa expire date.',
        'visa_type.required_with' => 'Enter type of visa.',
        'old_visa_file.required_with' => 'Please upload visa.',       

        'ten_school_college.required_with' => 'Enter school name.',
        'ten_board_university.required_with' => 'Enter passing out board/univ.',
        'ten_percentage.required_with' => 'Enter %.',
        'ten_session.required_with' => 'Enter session.',
        'old_ten_marksheet.required_with' => 'Please upload 10th marksheet.',

        'twelve_school_college.required_with' => 'Enter school name.',
        'twelve_board_university.required_with' => 'Enter passing out board/univ.',
        'twelve_percentage.required_with' => 'Enter %.',
        'twelve_session.required_with' => 'Enter session.',
        'old_twelve_marksheet.required_with' => 'Please upload 12th marksheet.',

        'diploma_board_university.required_with' =>'Enter passing out board/univ.',
        'diploma_percentage.required_with' =>'Enter %.',
        'diploma_session.required_with' => 'Enter session.',
        'old_diploma_marksheet.required_with' => 'Please upload diploma marksheet.',


        'bachelors_board_university.required_with' => 'Enter passing out board/univ.',
        'bachelors_percentage.required_with' =>'Enter %.',
        'bachelors_session.required_with' =>'Enter session.',
        'old_bachelors_markshee.required_with' =>'Please upload bachelors marksheet.',

        'masters_board_university.required_with' => 'Enter passing out board/univ.',
        'masters_percentage.required_with' => 'Enter %.',
        'masters_session.required_with' =>'Enter session.',
        'old_masters_marksheet.required_with' => 'Please upload bachelors marksheet.',

        'old_oshc_ovhc_file.required_with' => 'Please upload OSHC/OVHC file.',
        'old_ielts_pte_score_file.required_with' => 'Please upload IELTS/PTE scorecard.',
        'old_australian_id.required_with' => 'Please upload Australian ID.',

        'start_date_one.required_with' => 'Enter Coes start date.',
        'end_date_one.required_with' => 'Enter Coes end date.',
        'old_file_one.required_with' => 'Please upload coes file.',

        'course.required_with' => 'Please select course.',
        'fees.required_with' => 'Fees is required.',
        'amount.required_with' => 'Amount is required.',
        'installment_frequency.required_with' => 'Choose installement frequency.',
        'total_installment.required_with' => 'Choose total installement.',
        'intake_date.required_with' => 'Choose intake date.',
    ]);

if (str_contains($request->phone_flag, 'data1'))
{ 
    $phone_flag_arr  = explode(' ', $request->phone_flag);
    $phone_flag = $phone_flag_arr[1];
}
else
{
    $phone_flag = $request->phone_flag;
}

if (str_contains($request->whatsapp_flag, 'data1'))
{ 
    $whatsapp_flag_arr  = explode(' ', $request->whatsapp_flag);
    $whatsapp_flag = $whatsapp_flag_arr[1];
}
else
{    
    $whatsapp_flag = $request->whatsapp_flag;
}


$user_id = $request->staff_name;
$student_id = $request->student_id;





$first_name = $request->first_name;
$middle_name = $request->middle_name;
$last_name = $request->last_name;
$dob =  date('Y-m-d',strtotime($request->dob));
$address = $request->address;
$gender = $request->gender;
$phone = $request->phone;
$phone_flag = $phone_flag;
$phone_dialcode = $request->phone_dialcode;
$whatsapp = $request->whatsapp;
$whatsapp_flag = $whatsapp_flag;
$whatsapp_dialcode = $request->whatsapp_dialcode;
$country = $request->country;
$emergency_phone = $request->emergency_phone;
$purpose = $request->purpose;
$other_purpose = $request->other_purpose;
$referral = $request->referral; 
$other_referral = $request->other_referral;   

$passport_number = $request->passport_number;
$passport_expiry_date = $request->passport_expiry_date;
$visa_expiry_date = $request->visa_expiry_date;
$visa_type = $request->visa_type;

$ten_school_college = $request->ten_school_college;
$ten_board_university = $request->ten_board_university;
$ten_percentage = $request->ten_percentage;
$ten_session = $request->ten_session;
$twelve_school_college = $request->twelve_school_college;
$twelve_board_university = $request->twelve_board_university;
$twelve_percentage = $request->twelve_percentage;
$twelve_session = $request->twelve_session;
$diploma_school_college = $request->diploma_school_college;
$diploma_board_university = $request->diploma_board_university;
$diploma_percentage = $request->diploma_percentage;
$diploma_session = $request->diploma_session;
$bachelors_school_college = $request->bachelors_school_college;
$bachelors_board_university = $request->bachelors_board_university;
$bachelors_percentage = $request->bachelors_percentage;
$bachelors_session = $request->bachelors_session;
$masters_school_college = $request->masters_school_college;
$masters_board_university = $request->masters_board_university;
$masters_percentage = $request->masters_percentage;
$masters_session = $request->masters_session;



$admission_fees = $request->admission_fees;
$material_fees = $request->material_fees;
$tuition_fees = $request->tuition_fees;
$discount_type = $request->discount_type;
$fees = $request->fees;
$discount = $request->discount;
$amount = $request->amount;
$installment_frequency = $request->installment_frequency;
$total_installment = $request->total_installment;  
$intake_date = $request->intake_date;  

$start_date_one = $request->start_date_one;
$end_date_one = $request->end_date_one;
$start_date_two = $request->start_date_two;
$end_date_two = $request->end_date_two;
$start_date_three = $request->start_date_three;
$end_date_three = $request->end_date_three;
$start_date_four = $request->start_date_four;
$end_date_four = $request->end_date_four;
$start_date_five = $request->start_date_five;
$end_date_five = $request->end_date_five;


if($request->discount_type == '1'){
    request()->validate(
        [
            'discount' => 'required',                            

        ],
        [
            'discount.required' => 'Please Enter Discount in amount.',             

        ]

    );
}

if($request->discount_type == '2'){
    request()->validate(
        [
            'discount' => 'required',                            

        ],
        [
            'discount.required' => 'Please Enter Discount in %.',             

        ]

    );
}


$passport_file = $request->old_passport_file;
if($request->hasFile('passport_file'))
{
    $psprt_file = $request->file('passport_file');
    $passport_file = time() .rand(1000,9999). 'passport.' . $psprt_file->getClientOriginalExtension();
    $destinationPath = public_path('/files/passport');
    $psprt_file->move($destinationPath, $passport_file);

    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Passport details added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);


}
else
{
    $passport_file = $request->old_passport_file;
}    

$visa_file = $request->old_visa_file; 
if($request->hasFile('visa_file'))
{
    $vsa_file = $request->file('visa_file');
    $visa_file = time() .rand(1000,9999). 'visa.' . $vsa_file->getClientOriginalExtension();
    $destinationPath = public_path('/files/visa');
    $vsa_file->move($destinationPath, $visa_file);

    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Visa details added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$oshc_ovhc_file = $request->old_oshc_ovhc_file;    
if($request->hasFile('oshc_ovhc_file'))
{
    $oshc_file = $request->file('oshc_ovhc_file');
    $oshc_ovhc_file = time() .rand(1000,9999). 'oshc_ovhc.' . $oshc_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $oshc_file->move($destinationPath, $oshc_ovhc_file);

    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'OSHC/OVHC updated.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$ielts_pte_score_file = $request->old_ielts_pte_score_file;
if($request->hasFile('ielts_pte_score_file'))
{
    $ielts_file = $request->file('ielts_pte_score_file');
    $ielts_pte_score_file = time() .rand(1000,9999). 'ielts_pte_score.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $ielts_pte_score_file);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'IELTS/PTE score added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$file_one = $request->old_file_one;   
if($request->hasFile('file_one'))
{
    $ielts_file = $request->file('file_one');
    $file_one = time() .rand(1000,9999). 'coes_file.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $file_one);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Coes file added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$file_two = $request->old_file_two;  
if($request->hasFile('file_two'))
{
    $ielts_file = $request->file('file_two');
    $file_two = time() .rand(1000,9999). 'coes_file.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $file_two);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Coes file added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$file_three = $request->old_file_three;   
if($request->hasFile('file_three'))
{
    $ielts_file = $request->file('file_three');
    $file_three = time() .rand(1000,9999). 'coes_file.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $file_three);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Coes file added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$file_four = $request->old_file_four;  
if($request->hasFile('file_four'))
{
    $ielts_file = $request->file('file_four');
    $file_four = time() .rand(1000,9999). 'coes_file.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $file_four);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Coes file added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$file_five = $request->old_file_five; 
if($request->hasFile('file_five'))
{
    $ielts_file = $request->file('file_five');
    $file_five = time() .rand(1000,9999). 'coes_file.' . $ielts_file->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $ielts_file->move($destinationPath, $file_five);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Coes file added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}
    //    $coes = implode(',', $coes_image);


$australian_id = $request->old_australian_id;
if($request->hasFile('australian_id'))
{
    $astralian_id = $request->file('australian_id');
    $australian_id = time() .rand(1000,9999). 'australian_id.' . $astralian_id->getClientOriginalExtension();

    $destinationPath = public_path('/files/others');
    $astralian_id->move($destinationPath, $australian_id);

    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Updated Australian ID added.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$ten_marksheet = $request->old_ten_marksheet;
if($request->hasFile('ten_marksheet'))
{
    $ten_mrksht = $request->file('ten_marksheet');
    $ten_marksheet = time() .rand(1000,9999). 'ten_marksheet.' . $ten_mrksht->getClientOriginalExtension();

    $destinationPath = public_path('/files/education');
    $ten_mrksht->move($destinationPath, $ten_marksheet);
    DB::table('communication_log')->insert([
        'student_id' => $student_id,
        'staff_id' => $user_id,
        'comment' => 'Tenth marksheet marksheet updated.',
        'updated_at' => NOW(),
        'created_at' => NOW(),
    ]);
}

$twelve_marksheet = $request->old_twelve_marksheet;
if($request->hasFile('twelve_marksheet'))
{
    $telve_mrksht = $request->file('twelve_marksheet');
    $twelve_marksheet = time() .rand(1000,9999). 'twelve_marksheet.' . $telve_mrksht->getClientOriginalExtension();

    $destinationPath = public_path('/files/education');
    $telve_mrksht->move($destinationPath, $twelve_marksheet);
}

$diploma_marksheet =$request->old_diploma_marksheet;
if($request->hasFile('diploma_marksheet'))
{
    $dplma_mrksht = $request->file('diploma_marksheet');
    $diploma_marksheet = time() .rand(1000,9999). 'diploma_marksheet.' . $dplma_mrksht->getClientOriginalExtension();

    $destinationPath = public_path('/files/education');
    $dplma_mrksht->move($destinationPath, $diploma_marksheet);
}

$bachelors_marksheet = $request->old_bachelors_marksheet;
if($request->hasFile('bachelors_marksheet'))
{
    $bchlrs_mrksht = $request->file('bachelors_marksheet');
    $bachelors_marksheet = time() . '.' . $bchlrs_mrksht->getClientOriginalExtension();

    $destinationPath = public_path('/files/education');
    $bchlrs_mrksht->move($destinationPath, $bachelors_marksheet);
}

$masters_marksheet = $request->old_masters_marksheet;
if($request->hasFile('masters_marksheet'))
{
    $mstrs_mrksht = $request->file('masters_marksheet');
    $masters_marksheet = time() .rand(1000,9999). 'masters_marksheet.' . $mstrs_mrksht->getClientOriginalExtension();

    $destinationPath = public_path('/files/education');
    $mstrs_mrksht->move($destinationPath, $masters_marksheet);
}


DB::table('students')->where('id', $student_id)->update([
    'user_id' => $user_id,

    'first_name' => $first_name,
    'middle_name' => $middle_name,
    'last_name' => $last_name,
    'dob' => $dob,
    'address' =>  $address,
    'gender' => $gender,
    'phone' => $phone,
    'phone_flag' => $phone_flag,
    'phone_dialcode' => $phone_dialcode,
    'whatsapp' => $whatsapp,
    'whatsapp_flag' => $whatsapp_flag,
    'whatsapp_dialcode' => $whatsapp_dialcode,
    'country' => $country,
    'emergency_phone' => $emergency_phone,
    'purpose' => $purpose,
    'other_purpose' => $other_purpose,
    'referral' => $referral,
    'other_referral' => $other_referral,

    'australian_id' => $australian_id,
    'passport_number' => $passport_number,
    'passport_expiry_date' => $passport_expiry_date,
    'passport_file' => $passport_file,
    'visa_expiry_date' => $visa_expiry_date,
    'visa_type' => $visa_type,
    'visa_file' => $visa_file,
    'oshc_ovhc_file' => $oshc_ovhc_file,
    'ielts_pte_score_file' => $ielts_pte_score_file,   
    'admission_fees' => $admission_fees,
    'material_fees' => $material_fees,
    'tuition_fees' => $tuition_fees,
    'discount_type' => $discount_type,
    'fees' => $fees,
    'discount' => $discount,
    'total_payable_amount' => $amount,
    'installment_frequency' => $installment_frequency,
    'total_installment' => $total_installment,
    'intake_date' => $intake_date,
    'updated_at' => NOW(),            

]);

if(isset($request->chkCoes) && $request->chkCoes == 1)
{
 $edu_coes_count = DB::table('coes_details')->where('student_id', $student_id)->count(); 
 if($edu_coes_count>0)
 {
    DB::table('coes_details')->where('student_id', $student_id)->update([
        'start_date_one' => $start_date_one,
        'end_date_one' => $end_date_one,
        'file_one' => $file_one,
        'start_date_two' => $start_date_two,
        'end_date_two' => $end_date_two,
        'file_two' =>  $file_two,
        'start_date_three' => $start_date_three,
        'end_date_three' => $end_date_three,
        'file_three' => $file_three,
        'start_date_four' => $start_date_four,
        'end_date_four' => $end_date_four,
        'file_four' => $file_four,
        'start_date_five' => $start_date_five,
        'end_date_five' => $end_date_five,
        'file_five' => $file_five,
        'updated_at' => NOW(),            
    ]);
}
else
{
    DB::table('coes_details')->insert([
        'student_id' => $student_id,
        'start_date_one' => $start_date_one,
        'end_date_one' => $end_date_one,
        'file_one' => $file_one,
        'start_date_two' => $start_date_two,
        'end_date_two' => $end_date_two,
        'file_two' =>  $file_two,
        'start_date_three' => $start_date_three,
        'end_date_three' => $end_date_three,
        'file_three' => $file_three,
        'start_date_four' => $start_date_four,
        'end_date_four' => $end_date_four,
        'file_four' => $file_four,
        'start_date_five' => $start_date_five,
        'end_date_five' => $end_date_five,
        'file_five' => $file_five,
        'created_at' => NOW(),            
        'updated_at' => NOW(),            
    ]);
}
}


$get_fees_data = DB::table('course_fees_details')->where('user_id', $student_id)->count();

$get_course = DB::table('fee_details')->where('student_id', $student_id)->count();

$get_office = DB::table('students')->where('id', $student_id)->first();

      /*  if($get_fees_data > 0)
        {
              DB::table('course_fees_details')->where('user_id', $student_id)->delete();
          }*/

       //echo "<pre>"; print_r($course); 
        //echo "<pre>"; print_r($request->campuses); exit;

//echo "<pre>"; print_r($request->all()); exit;

$course = $request->course;
if(isset($course))
{
$course = array_filter($course);
$course_count = count($course);
}   

$college = $request->college;
if(isset($college))
{
$college = array_filter($college);  
$college_count = count($college);
}

$campuses = $request->campuses;
if(isset($campuses))
{
$campuses = array_filter($campuses);
$campuses_count = count($campuses);
}    

//echo count($course); exit; 

          if($college_count > 0 && $course_count > 0 && $campuses_count > 0)
          {
               
            foreach ($request->course_fees_id as $key => $course_fee_value)
            {

                $fees_data_count = DB::table('course_fees_details')->where('id', $course_fee_value)->count();

                if($fees_data_count > 0)
                {
                    $update_courses = DB::table('course_fees_details')->where('id',$course_fee_value)->update(['current_college_course' => $request->current_course[$key]]);
                }
                else
                {

                    $get_course_bonus = DB::table('campuses')->where('id', $request->campuses[$key])->first(); 

                    DB::table('course_fees_details')->insert([
                        'user_id' => $student_id,
                        'college_id' => $request->college[$key],
                        'course_id' => $course[$key],
                        'campus_id' => $request->campuses[$key],
                        'office_id' => $get_office->office_id,
                        'current_college_course' => $request->current_course[$key],
                        'fees' => $request->admission_fees[$key],
                        'discount_type' => $request->discount_type[$key],
                        'discount' => $request->discount[$key],
                        'material_fees' => $request->material_fees[$key],
                        'tuition_fees' => $request->tuition_fees[$key],
                        'total_payable_amount' => $request->amount[$key],
                        'installment_frequency' => $request->installment_frequency[$key],
                        'total_installment' => $request->total_installment[$key],
                        'bonus' => $get_course_bonus->bonus,
                        'intake_date' => $request->intake_date[$key],
                        'updated_at' => NOW(),
                        'created_at' => NOW(),
                    ]);
                }

            }
        }
        /*else
        {

         if(isset($course) && $course != '')
         {
            foreach ($course as $key => $course_value)
            {

               $get_course_bonus = DB::table('campuses')->where('id', $request->campuses[$key])->first(); 

               DB::table('course_fees_details')->insert([
                'user_id' => $student_id,
                'college_id' => $request->college[$key],
                'course_id' => $course[$key],
                'campus_id' => $request->campuses[$key],
                'current_college_course' => $request->current_course[$key],
                'fees' => $request->admission_fees[$key],
                'discount_type' => $request->discount_type[$key],
                'discount' => $request->discount[$key],
                'material_fees' => $request->material_fees[$key],
                'tuition_fees' => $request->tuition_fees[$key],
                'total_payable_amount' => $request->amount[$key],
                'installment_frequency' => $request->installment_frequency[$key],
                'total_installment' => $request->total_installment[$key],
                'bonus' => $get_course_bonus->bonus,
                'intake_date' => $request->intake_date[$key],
                'updated_at' => NOW(),
                'created_at' => NOW(),
            ]);
            }
        }
    }*/


    $get_current_course_count = DB::table('course_fees_details')->where('user_id', $student_id)->where('current_college_course',1)->count();

    //echo $get_current_course_count; exit;

    if($get_current_course_count > 0)
    {

       $get_current_course = DB::table('course_fees_details')->where('user_id', $student_id)->where('current_college_course',1)->first();

     //echo "<pre>"; print_r($get_current_course); exit;

       $get_fee_details_count = DB::table('fee_details')->where(['college_id' => $get_current_course->college_id,'student_id' => $student_id,'staff_id' => $user_id,'course_id' => $get_current_course->course_id,'campus_id' => $get_current_course->campus_id])->count();

         //$get_course_commission = DB::table('courses')->where('id', $get_current_course->course_id)->first();
       $get_course_commission = DB::table('campuses')->where('id', $get_current_course->campus_id)->first();


       $tuition_fees = $get_course_commission->tuition_fees;
       $commission_percentage = $get_course_commission->commission;

       $total_commision = ($tuition_fees*$commission_percentage)/100;



       $today_date = date('Y-m-d');
       if($get_current_course->course_id !='' && $get_current_course->fees!='' && $get_current_course->total_payable_amount!='')
       {
        if($get_current_course->total_installment > 0)
        {
            $installementcommission = $total_commision/$get_current_course->total_installment;


            $installementAmount = $get_current_course->total_payable_amount/$get_current_course->total_installment;

            $installementAmount = number_format($installementAmount,2);


            if($get_current_course->total_installment!='')
            {
                for ($i=0; $i < $get_current_course->total_installment; $i++) 
                { 

                    if($get_current_course->installment_frequency==1)
                    {
                        $newDate = date('Y-m-d', strtotime($today_date. ' + 1 months'));
                    }
                    else if($get_current_course->installment_frequency==2)
                    {
                        $newDate = date('Y-m-d', strtotime($today_date. ' + 2 months'));
                    }
                    else if($get_current_course->installment_frequency==4)
                    {
                        $newDate = date('Y-m-d', strtotime($today_date. ' + 3 months'));
                    }   
                    else if($get_current_course->installment_frequency == 6)
                    {
                        $newDate = date('Y-m-d', strtotime($today_date. ' + 6 months'));
                    }

                    $today_date = $newDate;


                    if($get_fee_details_count == 0)
                    {
                        DB::table('fee_details')->insert(
                            [
                                'college_id' => $get_current_course->college_id,
                                'student_id' => $student_id,
                                'staff_id' => $user_id,
                                'course_id' => $get_current_course->course_id,                                
                                'campus_id' => $get_current_course->campus_id,                                
                                'office_id' => $get_current_course->office_id,                                
                                'due_date' => $newDate,
                                'amount' => $installementAmount,
                                'commission' => number_format($installementcommission,2),
                                'updated_at' => NOW(),
                                'created_at' => NOW(),
                            ]);  
                    } 
                    DB::table('students')->where('id',$student_id)->update(
                        [
                            'type' => 2,
                            'updated_at' => NOW(),
                        ]);             
                }
            }
        }
    }
}



if(isset($request->chkEducation_details) && $request->chkEducation_details == 1)
{

    $edu_student_count = DB::table('education_details')->where('student_id', $student_id)->count();
    if($edu_student_count > 0)
    {
        DB::table('education_details')->where('student_id', $student_id)->delete();
    }

    DB::table('education_details')->insert([

        'student_id' => $student_id,
        'ten_school_college' => $ten_school_college,
        'ten_board_university' => $ten_board_university,
        'ten_percentage' => $ten_percentage,
        'ten_session' => $ten_session,
        'ten_marksheet' => $ten_marksheet,
        'twelve_school_college' => $twelve_school_college,
        'twelve_board_university' => $twelve_board_university,
        'twelve_percentage' => $twelve_percentage,
        'twelve_session' => $twelve_session,
        'twelve_marksheet' => $twelve_marksheet,
        'diploma_school_college' => $diploma_school_college,
        'diploma_board_university' => $diploma_board_university,
        'diploma_percentage' => $diploma_percentage,
        'diploma_session' => $diploma_session,
        'diploma_marksheet' => $diploma_marksheet,
        'bachelors_school_college' => $bachelors_school_college,
        'bachelors_board_university' => $bachelors_board_university,
        'bachelors_percentage' => $bachelors_percentage,
        'bachelors_session' => $bachelors_session,
        'bachelors_marksheet' => $bachelors_marksheet,
        'masters_school_college' => $masters_school_college,
        'masters_board_university' => $masters_board_university,
        'masters_percentage' => $masters_percentage,
        'masters_session' => $masters_session,
        'masters_marksheet' => $masters_marksheet,

        'updated_at' => NOW(),
        'created_at' => NOW(),

    ]);
}



           /* DB::table('students')->where('id', $student_id)->update([
                'is_course_updated' => 1,
            ]);*/


            return redirect('admin/students')->with('success','Student details update succesfully.');

        }

        public function staff()
        {

            if (Auth::user()->type == 1){


                $get_staffs = DB::table('users')->where('users.is_delete', 0)->select('users.*', 'offices.name as office_name')->leftjoin('offices', 'users.office_id', '=', 'offices.id')->orderBy('id','desc')->get();

            }

            else if (Auth::user()->type == 3){

                $office_id = Auth::user()->office_id;

                $get_staffs = DB::table('users')->where('type', '>', 1)->where(['users.is_delete'=> 0, 'users.office_id' =>$office_id])->select('users.*', 'offices.name as office_name')->leftjoin('offices', 'users.office_id', '=', 'offices.id')->orderBy('id','desc')->get();

            }

            return view('/admin/staff', compact('get_staffs'));
        }



        public function viewAddStaff()

        {

            $type_user= Auth::user()->type;
        // echo $type_user; exit;

            if ($type_user != 1){

                return redirect('/admin/staff')->with('error', 'You are not authorised to access this page!');
                exit;

            }
            $get_countries = DB::table('countries')->get();
            $get_offices = DB::table('offices')->get();


            return view('admin/addstaff', compact('get_countries', 'get_offices'));
        }

        public function add_staff(Request $request)
        {



            request()->validate(
                [
                    'first_name' => 'required',     
                    'type' => 'required', 
                    'office' => 'required',           
                    'email' => 'required|email|unique:users|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
                    'password' => 'required|min:6',
                    'confirm_password' => 'same:password',
                    'mobile' => 'required|max:10',
                    'postal_code' => 'required|max:6',
                    'country' => 'required',
                    'city' => 'required',                
                ],
                [
                    'first_name.required' => 'First Name is required.', 
                    'type.required' => 'Type of Staff required.',   
                    'office.required' => 'Office of Staff required.',                
                    'email.required' => 'Email is required.',
                    'password.required' => 'Password is required.',
                    'mobile.required' => 'Mobile number is required.',
                    'postal_code.required' => 'Postal code is required.',
                    'country.required' => 'Please select country.',
                    'city.required' => 'City is required.',

                ]
            );

            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $type = $request->type;
            $office = $request->office;
            $email = $request->email;
            $password = Hash::make($request->password);
            $mobile = $request->mobile;
            $postal = $request->postal_code;
            $country = $request->country;
            $city = $request->city;

            if($type == 3 ){
                $student_management = $request->student_management =1; 
            } else
            $student_management = $request->student_management;
            if($request->student_management == '')
            {
                $student_management = 0; 
            }

            if($type == 3 ){
                $staff_management = $request->staff_management =1; 
            } else
            $staff_management = $request->staff_management;
            if($request->staff_management == '')
            {
                $staff_management = 0; 
            }


            if($type == 3 ){
                $college_management = $request->college_management =1; 
            } else
            $college_management = $request->college_management;
            if($request->college_management == '')
            {
                $college_management = 0; 
            }


            if($type == 3 ){
                $course_management = $request->course_management =1; 
            } else
            $course_management = $request->course_management;
            if($request->course_management == '')
            {
                $course_management = 0; 
            }

            $ofc_id = DB::table('offices')->where('id', $office)->first();

            $rights = $ofc_id->super_admin_rights;

            if($rights == 1)
            {
              $type =1;
          }

          $add = DB::table('users')->insert([

            'type' => $type,

            'first_name' => $first_name,
            'last_name' => $last_name,
            'office_id' =>  $office,
            'email' => $email,
            'password' => $password,
            'mobile' => $mobile,
            'postal' =>  $postal,
            'country' => $country,
            'city' => $city,

            'student_management' => $student_management,
            'staff_management' => $staff_management,
            'college_management' => $college_management,
            'course_management' => $course_management,

            'updated_at' => NOW(),
            'created_at' => NOW()

        ]);


          if($add){

            return redirect('/admin/staff')->with('success', 'Staff added sucessfully!!');
        } else{
            return back()->with('error', 'Something went wrong please try again.');
        }    


    }
    
    public function view_students($id)
    {
        $id = base64_decode($id);
        $curr_fee_details = $course_commission = array();
        $staff_first_name = $staff_last_name = '';
        $view_students = DB::table('students')->where('id', $id)->first();
        $view_education_details = DB::table('education_details')->where('student_id', $id)->first();
        $view_coes_details = DB::table('coes_details')->where('student_id', $id)->first();

        $view_communication_logs = DB::table('communication_log')->where('student_id',$id)->orderby('id','DESC')->get();

        $view_msg_logs = DB::table('messages_logs')->where(['student_id'=>$id])->orderby('id','DESC')->paginate(10);

        $view_all_courses = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name','courses.course_name')->join('colleges','course_fees_details.college_id','=','colleges.id')->join('courses','course_fees_details.course_id','=','courses.id')->where(['user_id'=>$id])->get();
        /*$view_whatsapp_msg_logs = DB::table('messages_logs')->where(['student_id'=>$id,'message_type'=>2])->orderby('id','DESC')->get();*/

        /*$view_fee_details = DB::table('fee_details')->select('fee_details.*','users.first_name as staff_name')->leftjoin('users','fee_details.payment_received_by','=','users.id')->where('fee_details.student_id', $id)->get();*/



        $curr_fee_count = DB::table('course_fees_details')->where('current_college_course', 1)->where('user_id', $id)->count();
        if($curr_fee_count > 0)
        {
            $curr_fee_details = DB::table('course_fees_details')->where('current_college_course', 1)->where('user_id', $id)->first();

            $view_fee_details = DB::table('fee_details')->select('fee_details.*','users.first_name as staff_name')->leftjoin('users','fee_details.payment_received_by','=','users.id')->where('fee_details.student_id', $curr_fee_details->user_id)->where('fee_details.course_id', $curr_fee_details->course_id)->where('fee_details.campus_id', $curr_fee_details->campus_id)->get();

            $course_commission = DB::table('courses')->where('id', $curr_fee_details->course_id)->first();

        }
        else
        {
         $view_fee_details = DB::table('fee_details')->select('fee_details.*','users.first_name as staff_name')->leftjoin('users','fee_details.payment_received_by','=','users.id')->where('fee_details.student_id', $id)->get(); 
     }

     $view_fee_count = DB::table('fee_details')->where('student_id', $id)->count();

     $staff_id = $view_students->user_id;

     $staff = DB::table('users')->where('id', $staff_id)->first();
     if($staff)
     {
        $staff_first_name = $staff->first_name;
        $staff_last_name = $staff->last_name;
    }
    $college_id = $view_students->college;

        // echo "<pre>"; print_r($view_education_details) ; exit;

    $college = DB::table('colleges')->where('id', $college_id)->first();
    $college_name = '';
    if($college)
    {
        $college_name = $college->college_trading_name;
    }


        // echo $college_name; exit;
    $course_id = $view_students->course;

    $course = DB::table('courses')->where('id', $course_id)->first();
    $course_name = '';
    if($course)
    {
        $course_name = $course->course_name;
    }



        // echo "<pre>"; print_r($college); exit;

    return view('/admin/viewstudents', compact('view_students', 'view_communication_logs', 'view_education_details','view_fee_details','staff_first_name','staff_last_name','college_name','course_name','view_fee_count','view_coes_details','view_msg_logs','view_all_courses','curr_fee_details','course_commission','curr_fee_count'));

}


public function edit_rec_fees(Request $request)
{    
    $feesinemi_count = DB::table('fees_in_emi')->where('fees_id', $request->fee_id)->count();
    if($feesinemi_count > 0)
    {

        $emi_data = '<table class="table"><thead><tr><th scope="col">#</th><th scope="col">Date</th><th scope="col">Amount</th><th scope="col">Action</th></tr></thead><tbody>';

        $fees_in_emi = DB::table('fees_in_emi')->where('fees_id', $request->fee_id)->get();

        foreach ($fees_in_emi as $key => $fees_in_emi_val)
        {
          $emi_data.= '<tr><th scope="row">1</th><td>'.date("d/m/Y", strtotime($fees_in_emi_val->created_at)).'</td><td><input class="form-control amount'.$fees_in_emi_val->id.'" type="text" name="amount" value="'.$fees_in_emi_val->recieve_amount.'"></td><td><button type="button" data-feedetail_id="'.$request->fee_id.'" id="'.$fees_in_emi_val->id.'" class="btn btn-primary update_rec_amt">Update</button></td><input type="hidden" name="editamount['.$key.']" value="'.$fees_in_emi_val->recieve_amount.'"></tr>';
        }

        echo $emi_data.= '</tbody></table>';
    }
    else
    {
       echo $emi_data = '';
        exit;
     }
}

public function edit_recieve_fees(Request $request)
{
    //echo "<pre>"; print_r($request->all()); exit;

    $fee_id = $request->feedetail_id;
    $amount = $request->amount;
    $fee_emi_id = $request->fee_emi_id;
    
    //$amount_sum = array_sum($request->editamount);.

     $fee_details_data = DB::table('fee_details')->where(['id'=>$fee_id])->first();
    
    $data = DB::table('fees_in_emi')->where('fees_id','=',$fee_id)->where('id','!=',$fee_emi_id)->sum('recieve_amount');
    
     $amount_sum = $data+=$amount;

    

    if($fee_details_data->amount < $amount_sum)
    {
        echo "not_allowed"; exit;        
    }
    else
    {

    $commission = $fee_details_data->commission;
    $intallment_amount = $fee_details_data->amount;
    $rec_commission =  ($amount/$intallment_amount)*$fee_details_data->commission;

    $remaining_amount = $intallment_amount-$amount_sum;

$update = DB::table('fees_in_emi')->where('id', $fee_emi_id)->update([
            'recieve_amount' => $amount,
            'remaining_amount' => $remaining_amount,
            'commission_received' => $rec_commission,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

 $total_commission = DB::table('fees_in_emi')->select(DB::raw("sum(commission_received) as total_rec_commission"),DB::raw("sum(commission_received) as recieved_amount"))->where('fees_id','=',$fee_id)->first();

 $total_rec_commission = DB::table('fees_in_emi')->where('fees_id','=',$fee_id)->sum('commission_received');
 $recieve_amount = DB::table('fees_in_emi')->where('fees_id','=',$fee_id)->sum('recieve_amount');

 //echo "sdfdsfds".$total_commission->total_rec_commission; exit;

$update = DB::table('fee_details')->where('id', $fee_id)->update([
            'remaining_amount' => $remaining_amount,
            'rec_commission' => $total_rec_commission,
            'received_amount' => $recieve_amount,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }    

    echo "updated"; exit;

    //return back()->with('success', 'Fee received.');
}

public function edit_students($id){
    $id = base64_decode($id);

    $edit_students = DB::table('students')->where('id', $id)->first();
    $get_countries = DB::table('countries')->get();
    $get_staffs = DB::table('users')->where('type', 2)->get();

    return view('/admin/editstudents', compact('edit_students','get_countries', 'get_staffs'));
}

public function update_students(Request $request,$id){

    request()->validate(
        [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'emergency_phone' => 'required',                
            'purpose' => 'required',

        ],
        [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'dob.required' => 'Date of Birth is required.',
            'address.required' => 'Address is required.',
            'gender.required' => 'Please select gender.',
            'country.required' => 'Please select country.',
            'emergency_phone.required' => 'Emergency phone number is required.',              
            'purpose.required' => 'Please select purpose of visit.',

        ]

    );
    $admin_students = DB::table('students')->where('id', $id)->first();

    if($admin_students->email != $request->email)
    {
        request()->validate(
            [        
                'email' => 'required|email|unique:students|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
            ],
            [
                'email.required' => 'Email of student is required.',
            ]);
    }

    $first_name = $request->first_name;
    $middle_name = $request->middle_name;
    $last_name = $request->last_name;
    $dob =  date('Y-m-d',strtotime($request->dob));
    $address = $request->address;
    $gender = $request->gender;
    $email = $request->email;
    $phone = $request->phone;
    $country = $request->country;
    $emergency_phone = $request->emergency_phone;
    $purpose = $request->purpose;
    $referral = $request->referral;
    $user_id = $request->user_id;

    $update = DB::table('students')->where('id', $id)->update([
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'last_name' => $last_name,
        'dob' => $dob,
        'address' =>  $address,
        'gender' => $gender,
        'email' => $email,
        'phone' => $phone,
        'country' => $country,
        'emergency_phone' => $emergency_phone,
        'purpose' => $purpose,
        'referral' => $referral,
        'user_id' => $user_id,
        'updated_at' => NOW(),
    ]);

    if($update){
        return redirect('/admin/students')->with('success', 'Student details updated.');
    }else{
        return back()->with('error','Something went wrong !');
    }

}

public function delete_students($id){

    $id = base64_decode($id);


        // echo $id; exit;


    $delete = DB::table('students')->where('id', $id)->update([
        'is_delete' => 1,
        'deleted_by' => Auth::user()->first_name
    ]);


    if($delete){
        return back()->with('success', 'Student deleted.');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}


public function editStaff($id){
    $id = base64_decode($id);

    $type_user=Auth::user()->type;
    if ($type_user != 1){

        return back ()->with('error', 'You are not authorised to access this page!');
        exit;
    }
    $get_countries = DB::table('countries')->get();
    $get_staff = DB::table('users')->where('id', $id)->first();
    $get_offices = DB::table('offices')->get();

    return view ('/admin/edit_staff',compact('get_staff','get_countries', 'get_offices'));

}

public function editedStaff(Request $request,$id){

    request()->validate(
        [
            'first_name' => 'required',    
            'type'       => 'required',
            'office'       => 'required',
            'mobile' => 'required|max:10',
            'password' => 'nullable|min:6',
            'confirm_password' => 'same:password',
            'postal_code' => 'required|max:6',
            'country' => 'required',
            'city' => 'required',

        ],
        [
            'first_name.required' => 'First Name is required.',   
            'type.required' => 'First Name is required.',                             
            'office.required' => 'First Name is required.',                             
            'mobile.required' => 'Mobile number is required.',
            'password.required' => 'Password is required.',
            'postal_code.required' => 'Postal code is required.',
            'country.required' => 'Please select country.',
            'city.required' => 'City is required.',
        ]
    );

    $first_name = $request->first_name;
    $last_name = $request->last_name;
    $type = $request->type;
    $office = $request->office;
    $mobile = $request->mobile;
    $postal = $request->postal_code;
    $country = $request->country;
    $city = $request->city;

    if($type == 3 ){
        $student_management = $request->student_management =1; 
    } else
    $student_management = $request->student_management;
    if($request->student_management == '')
    {
        $student_management = 0; 
    }

    if($type == 3 ){
        $staff_management = $request->staff_management =1; 
    } else
    $staff_management = $request->staff_management;
    if($request->staff_management == '')
    {
        $staff_management = 0; 
    }

    if($type == 3 ){
        $college_management = $request->college_management =1; 
    } else
    $college_management = $request->college_management;
    if($request->college_management == '')
    {
        $college_management = 0; 
    }

    if($type == 3 ){
        $course_management = $request->course_management =1; 
    } else
    $course_management = $request->course_management;
    if($request->course_management == '')
    {
        $course_management = 0; 
    }

    $get_user = DB::table('users')->where('id', $id)->first();

    $password = $get_user->password;

    if($request->password){
        $password = Hash::make($request->password);
    }

    $update = DB::table('users')->where('id', $id)->update([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'type' => $type,
        'office_id' => $office,
        'password' => $password,
        'mobile' => $mobile,
        'postal' =>  $postal,
        'country' => $country,
        'city' => $city,
        'student_management' => $student_management,
        'staff_management' => $staff_management,
        'college_management' => $college_management,
        'course_management' => $course_management,
        'updated_at' => NOW(),

    ]);

    if($update){
        return redirect('admin/staff')->with('success', 'Staff details updated.');
    }else{
        return back()->with('error', 'Something went wrong.');
    }

}

public function deleteStaff($id){
    $id = base64_decode($id);


    $delete = DB::table('users')->where('id', $id)->update(['is_delete' => 1,'deleted_by' => Auth::user()->first_name
]);




    if($delete){
        return back()->with('success', 'Staff deleted.');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function change_password()
{
    return view('admin/changepassword');
}

public function update_password(Request $request)
{
    $user_id = Auth::id();
    request()->validate(
        [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ],
        [
            'current_password.required' => 'Please enter your current password.',
            'new_password.required' => 'Please enter new password.'
        ]);

    $current_password = $request->current_password;
    $new_password = $request->new_password;
    $confirm_password = $request->confirm_password;

    $password = Auth::user()->password;

    if(!(Hash::check($current_password, $password))) 
    {
        return redirect()->back()->with("update_pass_error","Your current password does not matches with the password you provided. Please try again!");
    }else if(strcmp($current_password, $new_password) == 0){
        return redirect()->back()->with("update_pass_error","New Password cannot be same as your current password. Please choose a different password!");
    }else if($new_password == $confirm_password){

        DB::table('users')->where('id', $user_id)->update(['password' => Hash::make($new_password)]);
        return redirect()->back()->with("update_pass_success","Password changed successfully!");
    }else{
        return redirect()->back()->with("update_pass_error","New Password and confirm password does not match!");
    }
}


public function collegeCourses(Request $request){
    $college_id = $request->college_id;
    if($request->college_id == ''){
        $response['admission_fees'] = '';
        $response['material_fees'] = '';   
        $response['tuition_fees'] = '';   
        $response['course_fee'] =  '';

        $html = '<option value="">Select College First</option>';
        $response['html'] = $html;

        echo json_encode($response);   
        exit;
    }
    $get_courses = DB::table('courses')->where('college_id', $college_id)->get();

    $html = '<option value="">Select Course</option>';

    foreach ($get_courses as $get_course) {
        $html .= '<option value=' . $get_course->id . '>' . $get_course->course_name . '</option>';
    }

        //$response['html'] = $html;
        //echo json_encode($response); 
    echo $html;
    exit;

}


public function CoursesCampuses(Request $request){
     if($request->course_id != '')
     {   
    $course_id = $request->course_id;    
    if($request->course_id == ''){
        $response['admission_fees'] = '';
        $response['material_fees'] = '';   
        $response['tuition_fees'] = '';   
        $response['course_fee'] =  '';

        $html = '<option value="">Select Course First</option>';
        $response['html'] = $html;

        echo json_encode($response);   
        exit;
    }
    $get_campuses = DB::table('campuses')->where('course_id', $course_id)->get();

    $html = '<option value="">Select Campus</option>';

    foreach ($get_campuses as $get_campus) {
        $html .= '<option value=' . $get_campus->id . '>' . $get_campus->campus_name . '</option>';
    }

        //$response['html'] = $html;
        //echo json_encode($response); 
    echo $html;
    exit;   
    }
    else
    {
        echo '<option value="">Select Course First</option>';   
        exit; 
    }


}

public function courseFees(Request $request){
        //$course_id = $request->course_id;
    $campus_id = $request->campus_id;

    if($request->campus_id == ''){
        $response['admission_fees'] = '';
        $response['material_fees'] = '';   
        $response['tuition_fees'] = '';   
        $response['course_fee'] =  '';

        echo json_encode($response);   
        exit;
    }

    /*$get_fees = DB::table('courses')->where('id', $course_id)->first();*/
    $get_fees = DB::table('campuses')->where('id', $campus_id)->first();

        //$fees = $get_fees->course_fee;
    $course_fee = $get_fees->admission_fees + $get_fees->material_fees + $get_fees->tuition_fees;

    $response['admission_fees'] = $get_fees->admission_fees;
    $response['material_fees'] = $get_fees->material_fees;   
    $response['tuition_fees'] = $get_fees->tuition_fees;
    $response['course_fee'] =  $course_fee;


    echo json_encode($response);   
    exit;
}

public function adminPayFee(Request $request){

    $fee_id = $request->fee_id;
    $amount = $request->amount;
    $comment = $request->comment;
    $payment_type = $request->payment_type;

    $img = '';



    if($request->hasFile('payment_proof'))
    {
        $payment_proof = $request->file('payment_proof');
        $img = time() . '.' . $payment_proof->getClientOriginalExtension();

        $destinationPath = public_path('/payment');
        $payment_proof->move($destinationPath, $img);
    }

    $get_fee = DB::table('fee_details')->where('id', $fee_id)->first();

    if($get_fee->received_amount == '')
    {  
            //echo $get_fee->amount .'=>'. $amount; exit;
        if($amount > $get_fee->amount)  
        {
         return back()->with('error', 'Received amount can not be greater than installment amount.');
     }
 }
 else
 {            
     if($amount > $get_fee->remaining_amount)  
     {
        return back()->with('error', 'Received amount can not be greater than Remaining amount.');
    } 
}


$amt = $get_fee->amount;
$remaining_amount = $amt - $amount;

if($remaining_amount == 0){
    $status = 1;
}else{
    $status = 2;
}
if($get_fee->received_amount != '')
{
    DB::table('fee_details')->where('id', $fee_id)->update([
        'received_amount' => $get_fee->received_amount+=$amount,
        'remaining_amount' => $get_fee->remaining_amount-=$amount,
        'comment' => $comment,
        'status' => $status,
        'payment_proof' => $img,
        'payment_type' => $payment_type,
        'payment_received_date' => NOW(),
        'payment_received_by' => Auth::id(),
    ]);

    

}
else
{  
    DB::table('fee_details')->where('id', $fee_id)->update([
        'received_amount' => $amount,
        'remaining_amount' => $remaining_amount,
        'comment' => $comment,
        'status' => $status,
        'payment_proof' => $img,
        'payment_type' => $payment_type,
        'payment_received_date' => NOW(),
        'payment_received_by' => Auth::id(),
    ]); 
}

$get_fee = DB::table('fee_details')->where('id', $fee_id)->first();

        $amount = str_replace(',', '', $get_fee->amount);
        $received_amount = str_replace(',', '', $request->amount);//$get_fee->received_amount;
        $commission = str_replace(',', '', $get_fee->commission);
        if($get_fee->rec_commission != '')
        {
        $get_fee->rec_commission = str_replace(',', '', $get_fee->rec_commission);
        }

        $rec_amt_percent = ($received_amount/$amount)*100;

        $rec_amt_percent = str_replace(',', '', $rec_amt_percent);

        $rec_commission = ($commission*$rec_amt_percent)/100;
        $rec_commission =number_format($rec_commission,2);

         $rec_commission = str_replace(',', '', $rec_commission);

//echo $get_fee->rec_commission."=>".$rec_commission; exit;

// $get_fee->received_amount+=$amount,

         //echo $get_fee->rec_commission; exit;
        DB::table('fee_details')->where('id', $fee_id)->update([            
            'rec_commission' => $get_fee->rec_commission+=$rec_commission,//$rec_commission,
            'payment_type' => $payment_type,
            'payment_received_date' => NOW(),
        ]); 

        $fees_in_emi_count = DB::table('fees_in_emi')->where(['fees_id'=>$fee_id,'student_id'=>$get_fee->student_id,'college_id'=>$get_fee->college_id,'course_id'=>$get_fee->course_id])->count();

    /*if($fees_in_emi_count > 0)
    {
        $get_feesinemi = DB::table('fees_in_emi')->where(['fees_id'=>$fee_id,'student_id'=>$get_fee->student_id,'college_id'=>$get_fee->college_id,'course_id'=>$get_fee->course_id])->first();

        DB::table('fees_in_emi')->where('id', $get_feesinemi->id)->update([
            'recieve_amount' =>  $get_feesinemi->recieve_amount+=$received_amount,//$request->amount,
            'remaining_amount' => $get_fee->remaining_amount,//$get_fee->remaining_amount,
            'commission_received' => $get_feesinemi->commission_received+=$rec_commission,//$rec_commission,
            'is_commission_claimed' => 0,//$rec_commission,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]); 
    }
    else
    {*/
        DB::table('fees_in_emi')->insert([
            'fees_id' => $fee_id,
            'office_id' => $get_fee->office_id,
            'student_id' => $get_fee->student_id,
            'college_id' => $get_fee->college_id,
            'course_id' => $get_fee->course_id,
            'recieve_amount' => $request->amount,
            'remaining_amount' => $get_fee->remaining_amount,
            'commission_received' => $rec_commission,
            'campus_id' => $request->campus_id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);


        /*DB::table('fees_in_emi')->insert([
            'fees_id' => $fee_id,
            'student_id' => $get_fee->student_id,
            'college_id' => $get_fee->college_id,
            'course_id' => $get_fee->course_id,
            'recieve_amount' => $request->amount,
            'remaining_amount' => $get_fee->remaining_amount,
            'commission_received' => $rec_commission,
            'campus_id' => $request->campus_id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);*/  
        /* }   */     


        $fees_in_emi_count = DB::table('course_fees_details')->where(['user_id'=>$get_fee->student_id,'college_id'=>$get_fee->college_id,'course_id'=>$get_fee->course_id,'campus_id'=>$get_fee->campus_id])->update(['is_bonus_applicable' =>  1,
            'bonus_applicable_date' => NOW(),
        ]);

        return back()->with('success', 'Fee received.');
        
    }


    public function offices(Request $request)
    { 
        $user_type = Auth::user()->type;
        
        if ( $user_type !=1)
        {
            return back()->with('error', 'You are not authorised to access this page!!!');
        }
        $get_offices = DB::table('offices')->where('is_delete', 0)->orderBy('id','desc')->get();

        return view('/admin/offices', compact('get_offices'));
    }



    public function viewAddOffices(Request $request)
    {
        $user_type = Auth::user()->type;
        
        if ( $user_type !=1)
        {
            return back()->with('error', 'You are not authorised to access this page!!!');

        }
        return view('/admin/add_offices');
    }
    

    public function add_offices(Request $request)
    {

        request()->validate(
            [
                'name' => 'required',
                'address' => 'required',
                'status' => 'required',
                
            ],
            [
                'name.required' => 'Please enter office name.',
                'address.required' => 'Please enter office address.',
                'status.required' => 'Please enter office status.',
                
            ]);

        $name = $request->name;
        $address = $request->address;
        $status = $request->status;


        if ($status == 0)
        {
            $super_admin_rights =  $request->super_admin_rights = 0;
        }
        else 
            $super_admin_rights = $request->super_admin_rights;
        {
            $super_admin_rights = 1;
        }
        if($request->super_admin_rights == '')
        {
            $super_admin_rights = 0; 
        }



        $add =  DB::table('offices')->insert([

            'name' => $name,
            'address' => $address,
            'status' => $status,
            'super_admin_rights' => $super_admin_rights,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

        if($add){
            return redirect('/admin/offices')->with('success', 'Office added !!');
        }    
        
    }

    

    public function edit_offices ($id)
    {
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        if ($user_type !=1)
        {
          return back()->with('error', 'You are not authorised to access this page !!');
          exit;
      }

      $edit_offices = DB::table('offices')->where('id', $id)->first();

      return view('/admin/edit_offices', compact('edit_offices'));
  }

  public function update_offices(Request $request,$id)
  {


     request()->validate(
         [
            'name' => 'required',
            'address' => 'required',
            'status' => 'required',

        ],
        [
            'name.required' => 'Please enter office name.',
            'address.required' => 'Please enter office address.',
            'status.required' => 'Please enter office status.',


        ]);

     $name = $request->name;
     $address = $request->address;
     $status = $request->status;
     $type =1;
     $super_admin_rights = $request->super_admin_rights;
     if($request->super_admin_rights == '')
     {
      $super_admin_rights = 0; 
      $type = 3;
  }


  $update_offices= DB::table('offices')->where('id', $id)->update([
    'name' => $name,
    'address' => $address,
    'status' => $status,
    'super_admin_rights' => $super_admin_rights,
    'updated_at' => NOW(),

]);


  $update_users = DB::table('users')->where('office_id', $id )->update([

    'type' =>$type,
    'updated_at' => NOW(),


]);

  if($update_offices){
    return redirect ('/admin/offices/')->with('success','Office Details updated !!');
}

}    

public function delete_offices($id)
{
    $id = base64_decode($id);
    $delete_offices = DB::table('offices')->where('id', $id)->update([
        'is_delete' => 1,
        'deleted_by' => Auth::user()->first_name
    ]);

    if($delete_offices){
        return redirect('/admin/offices')->with('error', 'Office Deleted !!');
    }

}

public function trash()  
{ 


    $user_type= Auth::user()->id;
    if($user_type!=1)
    {
        return back()->with('error', 'You are not authorised to access this page!!');
    }

    $get_trash_student_data = DB::table('students')->where('is_delete', 1)->orderBy('id','desc')->get();
    $get_trash_course_data = DB::table('courses')->where('is_delete', 1)->orderBy('id','desc')->get();
    $get_trash_staff_data = DB::table('users')->where('is_delete', 1)->orderBy('id','desc')->get();
    $get_trash_college_data = DB::table('colleges')->where('is_delete', 1)->orderBy('id','desc')->get();
    $get_trash_office_data = DB::table('offices')->where('is_delete', 1)->orderBy('id','desc')->get();

    return view('/admin/trash', compact('get_trash_student_data','get_trash_course_data','get_trash_staff_data','get_trash_college_data','get_trash_office_data'));       
}

public function student_trash_restore($id){
    $id = base64_decode($id);

    $get_student = DB::table('students')->where('id', $id)->first();
    
    $student_email_count = DB::table('students')->where(['email'=>$get_student->email,'is_delete' => 0])->count();
    if($student_email_count > 0)
    {
        return back()->with('warning_msg', 'This email ID already exists.');   
    }


    $delete = DB::table('students')->where('id', $id)->update(['is_delete' => 0]);

    if($delete)
    {
        return back()->with('success', 'Student Restored Successfully');
    }
    else
    {
        return back()->with('error', 'Something went wrong.');
    }
}

public function student_trash_delete($id){
    $id = base64_decode($id);

    $delete = DB::table('students')->where('id', $id)->delete();



    if($delete){
        return back()->with('success', 'Student Deleted Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function course_trash_restore($id){
    $id = base64_decode($id);

    $delete = DB::table('courses')->where('id', $id)->update(['is_delete' => 0]);



    if($delete){
        return back()->with('success', 'Course Restored Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function course_trash_delete($id){
    $id = base64_decode($id);

    $delete = DB::table('courses')->where('id', $id)->delete();



    if($delete){
        return back()->with('success', 'Course Deleted Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function staff_trash_restore($id){
    $id = base64_decode($id);

    $delete = DB::table('users')->where('id', $id)->update(['is_delete' => 0]);



    if($delete){
        return back()->with('success', 'Staff Restored Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function staff_trash_delete($id){
    $id = base64_decode($id);

    $delete = DB::table('users')->where('id', $id)->delete();



    if($delete){
        return back()->with('success', 'Staff Deleted Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function college_trash_restore($id){
    $id = base64_decode($id);

    $delete = DB::table('colleges')->where('id', $id)->update(['is_delete' => 0]);



    if($delete){
        return back()->with('success', 'College Restored Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function college_trash_delete($id){
    $id = base64_decode($id);

    $delete = DB::table('colleges')->where('id', $id)->delete();



    if($delete){
        return back()->with('success', 'College Deleted Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function office_trash_restore($id){
    $id = base64_decode($id);

    $delete = DB::table('offices')->where('id', $id)->update(['is_delete' => 0]);



    if($delete){
        return back()->with('success', 'Office Restored Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function office_trash_delete($id){
    $id = base64_decode($id);

    $delete = DB::table('offices')->where('id', $id)->delete();



    if($delete){
        return back()->with('success', 'Office Deleted Successfully');
    }else{
        return back()->with('error', 'Something went wrong.');
    }
}

public function trashlogin()
{   

    $user_type =  Auth::user()->id;
    if($user_type!=1)
    {
        return back()->with('error', 'You are not authorised to access this page !!');
    }

    return view('admin/trashlogin');
}


public function trashloggedin(Request $request)
{
    request()->validate(  
        [               
           'password' => 'required',
       ],
   );
    



    $password = $request->password;

        // echo $password;
        // exit;

        // if (Auth::attempt(['password' => $password 
        // ])) {

        //     return redirect('admin/trash');

        // }

    $get_pin = DB::table('users')->where('id', Auth::id())->first();

        // echo "<pre>"; print_r($get_pin); exit;

    if((Hash::check($password, $get_pin->trash_pin))){
        return redirect('/admin/trash');
    }else{
        return back()->with('error', 'Invalid pin');
    }
} 


public function trash_change_password()
{
    $user_type =  Auth::user()->id;
    if($user_type!=1)
    {
        return back()->with('error', 'You are not authorised to access this page !!');
    }

    return view('admin/trashchangepassword');
}  

public function trash_update_password(Request $request)
{
    $user_id = Auth::id();
    request()->validate(
        [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ],
        [
            'current_password.required' => 'Please enter your current password.',
            'new_password.required' => 'Please enter new password.'
        ]);

    $current_password = $request->current_password;
    $new_password = $request->new_password;
    $confirm_password = $request->confirm_password;

    $password = Auth::user()->trash_pin;

    if(!(Hash::check($current_password, $password))) 
    {
        return redirect()->back()->with("update_pass_error","Your current password does not matches with the password you provided. Please try again!");
    }else if(strcmp($current_password, $new_password) == 0){
        return redirect()->back()->with("update_pass_error","New Password cannot be same as your current password. Please choose a different password!");
    }else if($new_password == $confirm_password){

        DB::table('users')->where('id', $user_id)->update(['trash_pin' => Hash::make($new_password)]);
        return redirect()->back()->with("update_pass_success","Password changed successfully!");
    }else{
        return redirect()->back()->with("update_pass_error","New Password and confirm password does not match!");
    }
}




public function send_sms_to_student(Request $request)
{
        //echo "<pre>"; print_r($request->all()); exit;
    $sender_id = Auth::id();
    $from_phone = '+12182559611';   
    $to_phone = $request->phone_number;   
    $phone_dialcode = $request->phone_dialcode;   
    $sms_desc = $request->sms_desc;   

    $sid = 'ACa84e51676d89be9d1cacc65a3a61d94a';
    $token = '916d3590debaa4059dfa44680fcec062';
    $client = new Client($sid, $token);

        //echo "<pre>"; print_r($client); exit;

    $client->messages->create(    
        '+'.$phone_dialcode.''.$to_phone,
        [  
            'from' => $from_phone,   
            'body' => $sms_desc
        ]
    );      

    $add = DB::table('messages_logs')->insert([
        'student_id' => $request->student_id,
        'sender_id' => $sender_id,
        'message' => $sms_desc,
        'message_type' => 1,
        'updated_at' => NOW(),
        'created_at' => NOW(),

    ]);

    return redirect(route('students'))->with('success', 'Message sent to student!!');
}


public function send_whatsapp_to_student(Request $request)
{

    $sender_id = Auth::id();
    $from_phone = '+12182559611';   
    $to_phone = $request->whatsapp_number;   
    $phone_dialcode = $request->phone_dialcode;   
    $sms_desc = $request->whatsapp_desc;   

    $sid = 'ACa84e51676d89be9d1cacc65a3a61d94a';
    $token = '916d3590debaa4059dfa44680fcec062';
    $client = new Client($sid, $token);

    $whatsapp_img = '';
    if ($request->hasFile('whatsapp_attachment')) {
        $image = $request->file('whatsapp_attachment');
        $whatsapp_img = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images/whatsapp_attachment');
        $image->move($destinationPath, $whatsapp_img);
    } 

    $add = DB::table('messages_logs')->insert([
        'student_id' => $request->student_id,
        'sender_id' => $sender_id,
        'message' => $sms_desc,
        'attachement' => $whatsapp_img,
        'message_type' => 2,
        'updated_at' => NOW(),
        'created_at' => NOW(),

    ]);

    $sms_log_id = DB::getPdo()->lastInsertId();

    if($whatsapp_img != '')
    {

        $get_log_data = DB::table('messages_logs')->where('id',$sms_log_id)->first();
        $media_path = url('/images/whatsapp_attachment/'.$get_log_data->attachement);
        $message = $client->messages 
        ->create("whatsapp:+919680184949", 
            array( 
                "from" => "whatsapp:+14155238886",
                "mediaUrl" => [$media_path],
            ) 
        );
        $message = $client->messages 
        ->create("whatsapp:+919680184949",
            array( 
                "from" => "whatsapp:+14155238886",       
                "body" => $sms_desc,
            ) 
        );

    }
    else
    {
        $message = $client->messages 
        ->create("whatsapp:+919680184949",
            array( 
                "from" => "whatsapp:+14155238886",       
                "body" => $sms_desc,
            ) 
        );
    }

    return redirect(route('students'))->with('success', 'Whatsapp message sent to student!!');
}




public function send_mail_to_student(Request $request)
{

 $mail_desc = $request->mail_desc; 
 $sender_id = Auth::id();  

 $add = DB::table('messages_logs')->insert([
    'student_id' => $request->student_id,
    'sender_id' => $sender_id,
    'message' => $mail_desc,
    'message_type' => 3,
    'updated_at' => NOW(),
    'created_at' => NOW(),

]); 

 return redirect(route('students'))->with('success', 'Mail sent to student!!');
}

public function generate_report(Request $request)
{
    $start_date = '';
    $end_date = '';
    $student_count = '';
    $college_data = '';
    $office = '';
    $fee_months_data_get = $fee_months_data_count = '';
    $all_student_count_arr = array();
    $loggedin_office_id = Auth::user()->office_id;
    $user_type = Auth::user()->type;
    $colleges = DB::table('colleges')->get();
    $offices = DB::table('offices')->get();     


    $office_id = $college_id = '';

    $office_data = DB::table('offices')->where('id',$loggedin_office_id)->first();


    return view('/admin/report_page',compact('colleges','student_count','start_date','end_date','offices','all_student_count_arr','fee_months_data_get','fee_months_data_count','loggedin_office_id','office_data','user_type'));        
}


public function show_report(Request $request)
{
    $start_date = '';
    $end_date = '';
    $student_count = '';
    $college = '';
    $office = '';
    $fee_months_data_get = $fee_months_data_count = '';
    $all_student_count_arr = array();

    $loggedin_office_id = Auth::user()->office_id;
    $user_type = Auth::user()->type;

    if($request->all()!=null)
    {      

        //echo $request->college_office_list; exit;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        $office_id = $college_id = '';        

        if($request->selectedType == 'college')
        {    
            if($request->college_id != '')
            {
                if($user_type != 1)
                {
                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', $request->college_id)->where('students.office_id', $loggedin_office_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.college');
                     
                     $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();

                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('received_amount', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();
                }
                else
                {

                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', $request->college_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.college');

                    $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();

                }
            }
            else
            {

                if($user_type != 1)
                {
                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name' , DB::raw('count(*) as total'))->groupBy('students.college');

                     $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('received_amount', '!=', '')->where('office_id', $loggedin_office_id)->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();
                }
                else
                {

                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', '!=', '')->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name' , DB::raw('count(*) as total'))->groupBy('students.college');

                     $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();
                }
            }
        }

        if($request->selectedType == 'office')
        {          
            if($request->office_id != '')
            {
                $all_student_count_data = DB::table('students')->select('offices.*','students.*')->leftJoin('offices','students.office_id','=','offices.id')->where('office_id', $request->office_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('offices.name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.office_id');

                $all_student_count_arr = $all_student_count_data->get();
                $all_student_count = $all_student_count_data->count();

                $all_amount_count_data = DB::table('fee_details')->select('offices.*','fee_details.*')->leftJoin('offices','fee_details.office_id','=','offices.id')->where('office_id', $request->office_id)->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('offices.name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.office_id');

                    $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();
            }
            else
            {
                $all_student_count_data = DB::table('students')->select('offices.*','students.*')->leftJoin('offices','students.office_id','=','offices.id')->where('office_id', '!=', '')->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('offices.name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.office_id');
                $all_student_count_arr = $all_student_count_data->get();
                $all_student_count = $all_student_count_data->count();

                $all_amount_count_data = DB::table('fee_details')->select('offices.*','fee_details.*')->leftJoin('offices','fee_details.office_id','=','offices.id')->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('offices.name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.office_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();
            }
        }        

        //echo "<pre>"; print_r($all_student_count_arr); exit;

        return view('/admin/ajax_report_page',compact('student_count','start_date','end_date','all_student_count_arr','fee_months_data_get','fee_months_data_count','all_amount_count_arr','all_student_count','all_amount_count'));
    } 


}


public function report(Request $request)
{
    $college_count = DB::table('colleges')->count();
    $colleges = DB::table('colleges')->get();
    return view('/admin/report_page',compact('colleges'));
}





public function commission_generate_report(Request $request)
{
    $start_date = date("Y-m-d",strtotime('-31 days'));
    $end_date = date('Y-m-d');
    $student_count = '';
    $college_data = '';
    $office = '';
    $fee_months_data_get = $fee_months_data_count = '';
    $all_student_count_arr = array();
    $colleges = DB::table('colleges')->get();
    $offices = DB::table('offices')->get();     

    $loggedin_office_id = Auth::user()->office_id; 
    $user_type = Auth::user()->type;

    $office_id = $college_id = '';

    $loggedin_office_id = Auth::user()->office_id;

    if($user_type == 1)
    {        

        $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();


        $all_bonus_count_arr = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();

    }
    else
    {
        $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();


        $all_bonus_count_arr = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();
    }


    return view('/admin/commission_report_page',compact('colleges','all_student_count_arr','fee_months_data_get','fee_months_data_count','start_date','end_date','all_amount_count_arr','all_bonus_count_arr'));        
}


public function commission_show_report(Request $request)
{
    $start_date = '';
    $end_date = '';
    $student_count = '';
    $college = '';
    $office = '';
    $fee_months_data_get = $fee_months_data_count = '';
    $all_student_count_arr = array();

    $loggedin_office_id = Auth::user()->office_id;
    $user_type = Auth::user()->type;

    if($request->all()!=null)
    {      

        //echo $request->college_office_list; exit;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        $office_id = $college_id = '';        

        if($request->selectedType == 'college')
        {    
            if($request->college_id != '')
            {   

                if($user_type == 1)
                {   

                 $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();                

                 $all_bonus_count_arr = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.college_id', $request->college_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();
             }
             else
             {
                $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('college_id', $request->college_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();                

                $all_bonus_count_arr = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->where('bonus_claim.college_id', $request->college_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();
            }

        }
        else
        {
            if($user_type == 1)
            {

                $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();


                $all_bonus_count_arr = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();
            }
            else
            {


                $all_amount_count_arr = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id')->get();


                $all_bonus_count_arr = DB::table('bonus_claimss')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id')->get();

            }
        }
    }  

        //echo "<pre>"; print_r($all_amount_count_arr); exit;

    return view('/admin/commission_ajax_report_page',compact('start_date','end_date','all_amount_count_arr','all_bonus_count_arr'));
} 


}


public function commission_claimed(Request $request)
{
    $commission_data  = DB::table('fees_in_emi')->select('fees_in_emi.*','students.first_name as fname','students.last_name as lname','students.email as email','colleges.college_trading_name as college_name','courses.course_name as cname',DB::raw("sum(commission_received) as total_rec_commission"))
    ->leftJoin('students','fees_in_emi.student_id','=','students.id')
    ->leftJoin('colleges', 'fees_in_emi.college_id', '=', 'colleges.id')
    ->leftJoin('courses', 'fees_in_emi.course_id', '=', 'courses.id')
    ->where('commission_received','!=','')
    ->where('is_commission_claimed','!=','1')
    ->groupBy('fees_in_emi.course_id')
    ->groupBy('fees_in_emi.student_id')
    ->paginate(10);

//echo "<pre>"; print_r($commission_data); exit;
    return view('admin/commission_claimed',compact('commission_data'));
}

public function commission_claim(Request $request)
{    

  $fees_emi_data = DB::table('fees_in_emi')->where('id',$request->id)->first();

  DB::table('fees_in_emi')->where(['student_id'=>$fees_emi_data->student_id,'college_id'=>$fees_emi_data->college_id,'course_id'=>$fees_emi_data->course_id,'campus_id'=>$fees_emi_data->campus_id])->update(['is_commission_claimed' => 1]);
  echo 1; exit;



     /* $fee_detail_data = DB::table('fee_details')->where(['student_id'=>$fees_emi_data->student_id,'college_id'=>$fees_emi_data->college_id,'course_id'=>$fees_emi_data->course_id,'campus_id'=>$fees_emi_data->campus_id,'remaining_amount'=>0])->get();

      if($fee_detail_data)
      {
        foreach ($fee_detail_data as $key => $fee_detail_val)
        {
            $all_ids[] = $fee_detail_val->id;
        }
    }*/

      //echo "<pre>"; print_r($fee_detail_data); exit;

      /*if($fee_detail_data->remaining_amount == 0)
      {*/
       /* DB::table('fees_in_emi')->wherein('fees_id', $all_ids)->update(['is_commission_claimed' => 1]);
       echo 1; exit;*/
      /*}
      else
      {
        DB::table('fees_in_emi')->where('fees_id', $fees_emi_data->fees_id)->update(['is_commission_claimed' => 1]);
        echo 1; exit;  
    }*/

}



public function bonus_claimed(Request $request)
{
    $bonus_data  = DB::table('course_fees_details')->select('course_fees_details.*','students.first_name as fname','students.last_name as lname','students.email as email','colleges.college_trading_name as college_name','courses.course_name as cname',DB::raw("sum(bonus_claimed) as total_bonus_claimed"))
    ->leftJoin('students','course_fees_details.user_id','=','students.id')
    ->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')
    ->leftJoin('courses', 'course_fees_details.course_id', '=', 'courses.id')
    ->where('is_bonus_applicable',1)
    ->groupBy('course_fees_details.campus_id')
    ->groupBy('course_fees_details.user_id')
    ->paginate(10);

//echo "<pre>"; print_r($bonus_data); exit;
    return view('admin/bonus_claimed',compact('bonus_data'));
}


public function bonus_claim(Request $request)
{
    $id = $request->id;
    $bonus_comment = $request->bonus_comment;
    $bonus_claimed = $request->bonus_claimed;


    $course_fees_data = DB::table('course_fees_details')->where('id',$id)->first();

    $remaining_bonus = $course_fees_data->bonus - $course_fees_data->bonus_claimed;

    if($remaining_bonus < $bonus_claimed)
    {
        echo 1; exit;
    }        
    else
    {
        DB::table('course_fees_details')->where(['id'=>$id])->update(['bonus_claimed' => $course_fees_data->bonus_claimed+=$bonus_claimed]);

        $course_fees_data = DB::table('course_fees_details')->where('id',$id)->first();

        DB::table('bonus_claim')->insert(['student_id'=>$course_fees_data->user_id,'college_id'=>$course_fees_data->college_id,'course_id'=>$course_fees_data->course_id,'campus_id'=>$course_fees_data->campus_id,'office_id'=>$course_fees_data->office_id,'bonus_claimed'=>$request->bonus_claimed,'updated_at' => NOW(),'created_at' => NOW() ]);

        if($course_fees_data->bonus == $course_fees_data->bonus_claimed)
        {
            echo 2; exit;
        }
        else
        {
         echo 3; exit; 
     }

 }

}


public function update_commision(Request $request)
{
    $course_data = DB::table('courses')->where('commission','!=','')->get();

        //echo "<pre>"; print_r($course_data); exit;

    if($course_data)
    {
        foreach ($course_data as $key => $course_value)
        {

            $course_details = DB::table('course_fees_details')->where('course_id', $course_value->id)->where('current_college_course',1)->first();

            echo "<pre>"; print_r($course_details);

            echo $course_details->total_installment.'<br>';

                   //echo $course_details->total_installment; exit; 

                // $total_commision = ($course_value->tuition_fees/100)*$course_value->commission;


                //echo $total_commision.'-->'.$course_details->total_installment;exit;

                 //$installment_commision = $total_commision/$course_details->total_installment;


            /* $update_is_read = DB::table('fee_details')->where(['student_id'=> $course_details->user_id,'college_id'=>$course_details->college_id,'course_id'=>$course_details->course_id])->update(['commission'=> $installment_commision]);*/
        }
    }
}


public function course_detail_remove(Request $request)
{
    $course_detail_id = $request->course_detail_id;
    $course_user_id = $request->course_user_id;

    $user_course_count = DB::table('course_fees_details')->where('user_id', $course_user_id)->count();
    $course_fees_data = DB::table('course_fees_details')->where('id', $course_detail_id)->first();


    $fee_details = DB::table('fee_details')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id]);

    $fee_details_data = $fee_details->first();
    $fee_details_count = $fee_details->count();

    $feesinemi = DB::table('fees_in_emi')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id]);

    $fee_feesinemi_data = $feesinemi->first();
    $fee_feesinemi_count = $feesinemi->count();

        if(isset($fee_details_data->received_amount) && $fee_details_data->received_amount != '')
        {
            echo 'cantremove'; 
            exit;
        }
        else if($user_course_count == 1 && $course_fees_data->current_college_course == 1)
        {
            $course_fees_details_data = DB::table('course_fees_details')->where(['id'=> $course_detail_id])->delete();

            if($fee_details_count > 0)
            {
            $fee_details_data = DB::table('fee_details')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id])->delete();
            }

            if($fee_feesinemi_count > 0)
            {    
            $fee_details_data = DB::table('fees_in_emi')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id])->delete();
            }

            $update_is_read = DB::table('students')->where('id', $course_user_id)->update(['type'=> 1]);
            echo 'all_course_removed';
            exit;
    }
    else if($user_course_count > 1 && $course_fees_data->current_college_course == 1)
    {
        echo 'current_course';
        exit;
    }    

    else if($user_course_count > 1 && $course_fees_data->current_college_course != 1)
    {
        $course_fees_details_data = DB::table('course_fees_details')->where(['id'=> $course_detail_id])->delete();

            if($fee_details_count > 0)
            {
            $fee_details_data = DB::table('fee_details')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id])->delete();
            }

            if($fee_feesinemi_count > 0)
            {    
            $fee_details_data = DB::table('fees_in_emi')->where(['student_id'=> $course_fees_data->user_id,'college_id'=> $course_fees_data->college_id,'course_id'=> $course_fees_data->course_id,'campus_id'=> $course_fees_data->campus_id])->delete();
            }           
            echo 'course_removed';
            exit;
    }    
    
        
}

}
