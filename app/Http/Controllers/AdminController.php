<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mail;
use Response;
use ZipArchive;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\tempnam;

require '../vendor/phpmailer/src/Exception.php';
require '../vendor/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/src/SMTP.php';




class AdminController extends Controller
{


public function send_mail_checklist(Request $request)
{
     $get_stdata = DB::table('students')->where(['id'=>$request->id])->first();
$mail = new PHPMailer;
$mail->isSMTP(); /*make commented on live sever*/     // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'satyendra.arrj@gmail.com';                 // SMTP username
$mail->Password = 'ouawdioknoocemxy';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'info@arrjdemo.in';
$mail->FromName = 'Mailer';
$mail->addAddress('satyendra.arrj@gmail.com', $get_stdata->first_name);     // Add a recipient
$mail->addAddress('abhi.arrj@gmail.com');               // Name is optional
$mail->addAddress('vishal@programmates.com');               // Name is optional
$mail->addReplyTo('vishal.arrj@gmail.com', 'Information');
/*$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');*/

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Dcoument Required';
$mail->Body    = $request->mail_content;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
    exit;
}

}

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
        $date = date("Y-m-d",strtotime("+31 days"));
        $currdate = date("Y-m-d");



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


            $office_id =  Auth::user()->office_id;
            $id =  Auth::id();
            if($id == 1)
            {


            $visaExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.visa_expiry_date', '<=',$date)
            ->where('students.visa_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $visa_expiry_students = $visaExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.visa_follow_status', 2);                
            $q->whereDate('students.visa_snooze_date', '<',$currdate);            
            });            

            $visa_expiry_students = $visaExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            //$visa_expiry_students_count = $visa_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();
            $visa_expiry_students_count = count($visa_expiry_students);


             $passportExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.passport_expiry_date', '<=',$date)
            ->where('students.passport_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $passport_expiry_students = $passportExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.passport_follow_status', 2);                
            $q->whereDate('students.passport_snooze_date', '<',$currdate);            
            });            

            $passport_expiry_students = $passportExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            //$passport_expiry_students_count = $passport_expiry_students->count();
            $passport_expiry_students = $passport_expiry_students->get();
            $passport_expiry_students_count = count($passport_expiry_students);
           
            }
            else
            {

            $visaExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.visa_expiry_date', '<=',$date)
            ->where('students.visa_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $visa_expiry_students = $visaExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.visa_follow_status', 2);                
            $q->whereDate('students.visa_snooze_date', '<',$currdate);            
            });            

            $visa_expiry_students = $visaExpireStudents->orderBy('students.visa_expiry_date', 'ASC')->groupBy('students.id');

            /*$visa_expiry_students_count = $visa_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();*/

            //$passport_expiry_students_count = $passport_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();
            $visa_expiry_students_count = count($visa_expiry_students);



            $passportExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.passport_expiry_date', '<=',$date)
            ->where('students.passport_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $passport_expiry_students = $passportExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.passport_follow_status', 2);                
            $q->whereDate('students.passport_snooze_date', '<',$currdate);            
            });
            $passport_expiry_students = $passportExpireStudents->orderBy('students.passport_expiry_date', 'ASC')->groupBy('students.id');

            $passport_expiry_students_count = $passport_expiry_students->count();
            $passport_expiry_students = $passport_expiry_students->get();               
            }




         $open_course_completion_students = DB::table('students')    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
           
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where('course_fees_details.course_complete_follow_status',0);

        $course_completion_students_list = $open_course_completion_students->where(function($q) use ($currdate,$date) {
            $q->where('course_fees_details.current_college_course', 1);
            });

         $course_completion_students_list = $open_course_completion_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.course_complete_follow_status', 2);                
            $q->whereDate('course_fees_details.course_complete_snooze_date', '<',$currdate);            
            });   

       $course_completion_students = $course_completion_students_list->orderBy('course_fees_details.course_completion_date', 'ASC')->groupBy('students.id');            
       //$course_completion_students_count = $course_completion_students->count();            
       $course_completion_students = $course_completion_students->get(); 

       $course_completion_students_count = count($course_completion_students);  
       //echo "<pre>"; print_r($course_completion_students); exit;
       

        
       $open_feesdue_students = DB::table('students')->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where('fee_details.status','!=', 1)        
        ->where('course_fees_details.fees_due_follow_status',0);

        $feesdue_students_list = $open_feesdue_students->where(function($q) use ($currdate,$date) {
            $q->whereDate('fee_details.due_date', '<=',$date);
            $q->where('course_fees_details.current_college_course', 1);            
            });

         $feesdue_students_list = $open_feesdue_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.fees_due_follow_status', 2);                
            $q->whereDate('course_fees_details.fees_due_snooze_date', '<',$currdate);            
            });   

       $fees_duedate_students = $feesdue_students_list->orderBy('due_date', 'ASC')->groupBy('students.id');            
//       $fees_duedate_students_count = $fees_duedate_students->count();            
       $fees_duedate_students = $fees_duedate_students->get();
       $fees_duedate_students_count = count($fees_duedate_students);

                     
        //echo $fees_duedate_students_count; exit;


       $client_hp_count = DB::table('students')->where('type',2)->where('is_delete',0)->where('office_id',10)->count();
       $prospects_hp_count = DB::table('students')->where('type',1)->where('is_delete',0)->where('office_id',10)->count(); 
       $migration_hp_count = DB::table('students')->where('is_migrate',1)->where('is_delete',0)->where('office_id',10)->count(); 
       $extra_hp_count = DB::table('students')->where('is_extra',1)->where('is_delete',0)->where('office_id',10)->count();


       $client_sh_count = DB::table('students')->where('type',2)->where('is_delete',0)->where('office_id',11)->count();
       $prospects_sh_count = DB::table('students')->where('type',1)->where('is_delete',0)->where('office_id',11)->count(); 
       $migration_sh_count = DB::table('students')->where('is_migrate',1)->where('is_delete',0)->where('office_id',11)->count(); 
       $extra_sh_count = DB::table('students')->where('is_extra',1)->where('is_delete',0)->where('office_id',11)->count();


       $client_ad_count = DB::table('students')->where('type',2)->where('is_delete',0)->where('office_id',12)->count();
       $prospects_ad_count = DB::table('students')->where('type',1)->where('is_delete',0)->where('office_id',12)->count(); 
       $migration_ad_count = DB::table('students')->where('is_migrate',1)->where('is_delete',0)->where('office_id',12)->count(); 
       $extra_ad_count = DB::table('students')->where('is_extra',1)->where('is_delete',0)->where('office_id',12)->count(); 


        $close_passportExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.passport_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_passport_expiry_students = $close_passportExpireStudents->get();
            $close_passport_expiry_students_count = count($close_passport_expiry_students);


             $snooze_passport_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.passport_snooze_date', '>',$currdate)
            ->where('students.passport_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_passport_expiry_students = $snooze_passport_expiry_students->get();
            $snooze_passport_expiry_students_count = count($snooze_passport_expiry_students);



            $close_visaExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.visa_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_visa_expiry_students = $close_visaExpireStudents->get();
            $close_visa_expiry_students_count = $close_visaExpireStudents->count();


             $snooze_visa_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.visa_snooze_date', '>=',$currdate)
            ->where('students.visa_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_visa_expiry_students = $snooze_visa_expiry_students->get();
            $snooze_visa_expiry_students_count = count($snooze_visa_expiry_students);


            $close_fees_duedateStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
            ->where('course_fees_details.fees_due_follow_status', 1)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id')            
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');
            
            $close_fees_duedate_students = $close_fees_duedateStudents->get();
            $close_fees_duedate_students_count = count($close_fees_duedate_students);


             $snooze_fees_duedate_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')            
            ->whereDate('course_fees_details.fees_due_snooze_date', '>',$currdate)
            ->where('course_fees_details.fees_due_follow_status', 2)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id') 
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_fees_duedate_students = $snooze_fees_duedate_students->get();
            $snooze_fees_duedate_students_count = count($snooze_fees_duedate_students);


             $close_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
            ->where('course_fees_details.course_complete_follow_status', 1)  
            ->where('course_fees_details.current_college_course', 1)          
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_course_completion_students_count = $close_course_completion_students->count();
            $close_course_completion_students = $close_course_completion_students->get();


             $snooze_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')            
            ->whereDate('course_fees_details.course_complete_snooze_date', '>',$currdate)
            ->where('course_fees_details.course_complete_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->where('course_fees_details.current_college_course', 1)
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_course_completion_students_count = $snooze_course_completion_students->count();
            $snooze_course_completion_students = $snooze_course_completion_students->get();


            return view('admin/dashboard',compact('student_count','staff_count','college_count','colleges','students', 'get_offices','get_offices','notification_data','office_array','visa_expiry_students','passport_expiry_students','visa_expiry_students_count','passport_expiry_students_count','course_completion_students','fees_duedate_students','course_completion_students_count','fees_duedate_students_count','client_hp_count','prospects_hp_count','migration_hp_count','extra_hp_count','client_sh_count','prospects_sh_count','migration_sh_count','extra_sh_count','client_ad_count','prospects_ad_count','migration_ad_count','extra_ad_count','close_passport_expiry_students_count','snooze_passport_expiry_students_count','close_visa_expiry_students_count','snooze_visa_expiry_students_count','close_fees_duedate_students_count','snooze_fees_duedate_students_count','close_course_completion_students_count','snooze_course_completion_students_count'));
 }

 elseif ($user_type == 3)
 {
   $office_id = Auth::user()->office_id;

   $get_offices =DB::table('offices')->where('id', $office_id)->where('is_delete', 0)->first();

   $students =DB::table('students')->where('students.office_id', $office_id)->select('students.*','users.first_name as staff_name' )->join('users','students.user_id','=','users.id')->orderBy('created_at', 'DESC')->take(5)->get();

   $visaExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.visa_expiry_date', '<=',$date)
            ->where('students.visa_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

           /* $visa_expiry_students = $visaExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.visa_follow_status', 2);                
            $q->whereDate('students.visa_snooze_date', '<',$currdate);            
            });    */        

            $visa_expiry_students = $visaExpireStudents->orderBy('students.visa_expiry_date', 'DESC')->groupBy('students.id');

            $visa_expiry_students_count = $visa_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();



                $passport_expiry_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)->select('students.*','users.first_name as staff_name','students.id as stid')->whereDate('students.passport_expiry_date', '<=',$date)
                ->whereDate('students.passport_expiry_date', '>=',$currdate)
                ->where('students.passport_follow_status', '!=',1)
                ->leftJoin('users','students.user_id','=','users.id')
                ->orderBy('students.passport_expiry_date', 'DESC')        
                ->groupBy('students.id'); 

                $passport_expiry_students_count = $passport_expiry_students->count();
                $passport_expiry_students = $passport_expiry_students->get();

    //echo $passport_expiry_students_count; exit;                


                 $open_course_completion_students = DB::table('students')    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
           
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where(['students.office_id'=>$office_id])
        ->where('course_fees_details.course_complete_follow_status',0);

        $course_completion_students_list = $open_course_completion_students->where(function($q) use ($currdate,$date) {
            $q->where('course_fees_details.current_college_course', 1);
            });

        /* $course_completion_students_list = $open_course_completion_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.course_complete_follow_status', 2);                
            $q->whereDate('course_fees_details.course_complete_snooze_date', '<',$currdate);            
            });  */ 

       $course_completion_students = $course_completion_students_list->orderBy('course_fees_details.course_completion_date', 'ASC')->groupBy('students.id');            
       $course_completion_students_count = $course_completion_students->count();            
       $course_completion_students = $course_completion_students->get();


       

       $open_feesdue_students = DB::table('students')->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where(['students.office_id'=>$office_id])
        ->where('fee_details.status','!=', 1)
        ->where('course_fees_details.fees_due_follow_status',0);

        $feesdue_students_list = $open_feesdue_students->where(function($q) use ($currdate,$date) {
            $q->whereDate('fee_details.due_date', '<=',$date);
            $q->where('course_fees_details.current_college_course', 1);            
            });

        /* $feesdue_students_list = $open_feesdue_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.fees_due_follow_status', 2);                
            $q->whereDate('course_fees_details.fees_due_snooze_date', '<',$currdate);            
            }); */  

       $fees_duedate_students = $feesdue_students_list->orderBy('due_date', 'ASC')->groupBy('students.id');            
       $fees_duedate_students_count = $fees_duedate_students->count();            
       $fees_duedate_students = $fees_duedate_students->get();


       
       $client_st_count = DB::table('students')->where('type',2)->where('is_delete',0)->where('office_id',$office_id)->count();
       $prospects_st_count = DB::table('students')->where('type',1)->where('is_delete',0)->where('office_id',$office_id)->count(); 
       $migration_st_count = DB::table('students')->where('is_migrate',1)->where('is_delete',0)->where('office_id',$office_id)->count(); 
       $extra_st_count = DB::table('students')->where('is_extra',1)->where('is_delete',0)->where('office_id',$office_id)->count();


       $close_passportExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.passport_follow_status', 1)
            ->where(['students.office_id'=>$office_id])            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_passport_expiry_students = $close_passportExpireStudents->get();
            $close_passport_expiry_students_count = count($close_passport_expiry_students);


             $snooze_passport_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.passport_snooze_date', '>',$currdate)
            ->where('students.passport_follow_status', 2)
            ->where(['students.office_id'=>$office_id])
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_passport_expiry_students = $snooze_passport_expiry_students->get();
            $snooze_passport_expiry_students_count = count($snooze_passport_expiry_students);



            $close_visaExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.visa_follow_status', 1)
            ->where(['students.office_id'=>$office_id])            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_visa_expiry_students = $close_visaExpireStudents->get();
            $close_visa_expiry_students_count = $close_visaExpireStudents->count();


             $snooze_visa_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.visa_snooze_date', '>=',$currdate)
            ->where('students.visa_follow_status', 2)
            ->where(['students.office_id'=>$office_id])
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_visa_expiry_students = $snooze_visa_expiry_students->get();
            $snooze_visa_expiry_students_count = count($snooze_visa_expiry_students);



             $snooze_fees_duedate_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')            
            ->whereDate('course_fees_details.fees_due_snooze_date', '>',$currdate)
            ->where('course_fees_details.fees_due_follow_status', 2)
            ->where(['students.office_id'=>$office_id])
            ->leftJoin('fee_details','students.id','=','fee_details.student_id') 
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_fees_duedate_students = $snooze_fees_duedate_students->get();
            $snooze_fees_duedate_students_count = count($snooze_fees_duedate_students);


             $close_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
            ->where(['students.office_id'=>$office_id])
            ->where('course_fees_details.course_complete_follow_status', 1)  
            ->where('course_fees_details.current_college_course', 1)          
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_course_completion_students_count = $close_course_completion_students->count();
            $close_course_completion_students = $close_course_completion_students->get();


             $snooze_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')            
            ->whereDate('course_fees_details.course_complete_snooze_date', '>',$currdate)
            ->where(['students.office_id'=>$office_id])
            ->where('course_fees_details.course_complete_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->where('course_fees_details.current_college_course', 1)
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_course_completion_students_count = $snooze_course_completion_students->count();
            $snooze_course_completion_students = $snooze_course_completion_students->get();


            $close_fees_duedateStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
            ->where('course_fees_details.fees_due_follow_status', 1)
            ->where(['students.office_id'=>$office_id])
            ->leftJoin('fee_details','students.id','=','fee_details.student_id')            
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');
            
            $close_fees_duedate_students = $close_fees_duedateStudents->get();
            $close_fees_duedate_students_count = count($close_fees_duedate_students);


       return view('admin/dashboard',compact('student_count','staff_count','college_count','colleges','students', 'get_offices','get_offices','notification_data','office_array','visa_expiry_students','passport_expiry_students','visa_expiry_students_count','passport_expiry_students_count','course_completion_students','fees_duedate_students','course_completion_students_count','fees_duedate_students_count','client_st_count','prospects_st_count','migration_st_count','extra_st_count','close_passport_expiry_students_count','snooze_passport_expiry_students_count','close_visa_expiry_students_count','snooze_visa_expiry_students_count','close_fees_duedate_students_count','snooze_fees_duedate_students_count','close_course_completion_students_count','snooze_course_completion_students_count'));

   /*return view('admin/dashboard',compact('student_count','staff_count','college_count','colleges','students'));*/
}

}

public function ajax_followup(Request $request)
{

    DB::table('followup')->insert([
        'student_id' => $request->id,        
        'follow_message' => $request->follow_message,
        'follow_type' => $request->follow_type,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);


 $message_count = DB::table('followup')->where('student_id',$request->id)->where('follow_type',$request->follow_type)->where('follow_message','!=', '')->count();

    //echo$request->follow_type; exit;

    if($request->follow_type == 'visa_expiry_followup')
    {
        if($request->follow_status == 1)
        {
         DB::table('students')->where(['id'=>$request->id])->update(['visa_follow_status' => $request->follow_status,'visa_expire_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('students')->where(['id'=>$request->id])->update(['visa_follow_status' => $request->follow_status,'visa_snooze_date'=> $request->snooze_calender,'visa_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }
    }
    else if($request->follow_type == 'passport_expiry_followup')
    {
        if($request->follow_status == 1)
        {
         DB::table('students')->where(['id'=>$request->id])->update(['passport_follow_status' => $request->follow_status,'passport_expire_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('students')->where(['id'=>$request->id])->update(['passport_follow_status' => $request->follow_status,'passport_snooze_date'=> $request->snooze_calender,'passport_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }
    }

    else if($request->follow_type == 'course_completion_followup')
    {
        if($request->follow_status == 1)
        {
         DB::table('course_fees_details')->where(['id'=>$request->course_fee_detail_id])->update(['course_complete_follow_status' => $request->follow_status,'course_complete_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('course_fees_details')->where(['id'=>$request->course_fee_detail_id])->update(['course_complete_follow_status' => $request->follow_status,'course_complete_snooze_date'=> $request->snooze_calender,'course_complete_msg_count' => $message_count,'updated_at'=> now()]);   
        }
    }


    else if($request->follow_type == 'fees_due_followup')
    {
        if($request->follow_status == 1)
        {
         DB::table('course_fees_details')->where(['id'=>$request->course_fee_detail_id])->update(['fees_due_follow_status' => $request->follow_status,'fees_due_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('course_fees_details')->where(['id'=>$request->course_fee_detail_id])->update(['fees_due_follow_status' => $request->follow_status,'fees_due_snooze_date'=> $request->snooze_calender,'fees_due_msg_count' => $message_count,'updated_at'=> now()]);   
        }
    }
    
}


public function ajax_followup_data(Request $request)
{
     $get_followup_count = DB::table('followup')->where(['student_id' => $request->id,'follow_type' => $request->follow_type])->count();


    if($get_followup_count > 0)
    {
    $count =1;
        $followup_data = '<div class="modal_table_class"><table id="user_list" class="">
                                                    <thead>
                                                        <tr>   
                                                            <th width="10%">S.No.</th>
                                                            <th width="50%">Followup Comments</th>
                                                            <th width="20%">Added By</th>
                                                            <th width="20%">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

        $get_followup = DB::table('followup')->where(['student_id' => $request->id,'follow_type' => $request->follow_type])->get();

        foreach ($get_followup as $key => $get_followup_val)
        {
          $followup_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$get_followup_val->follow_message.'</td><td width="50%">'.$get_followup_val->added_from_name.'</td><td width="20%">'.$get_followup_val->created_at.'</td></tr>';
          $count++;
        }
        

        echo $followup_data.= '</tbody></table></div>';
    }
    else
    {
       echo $followup_data = '';
        exit;
     }

}

public function ajax_followup_close(Request $request)
{

DB::table('followup')->where(['student_id'=>$request->id,'follow_type'=>$request->follow_type])->update(['is_read' => 1,'updated_at'=> now()]);

echo 1; exit;
}


public function migration(Request $request)
{

    $get_stdata = DB::table('students')->where(['id'=>$request->id])->first();

    if($get_stdata->is_migrate == 1)
    {
        DB::table('students')->where(['id'=>$request->id])->update(['is_migrate' => 0]);    
    }
    else
    {
        DB::table('students')->where(['id'=>$request->id])->update(['is_migrate' => 1]);
    }
    
    echo 1; exit;
}

public function migrate_students(Request $request)
{
    $user_type =  Auth::user()->type;

    if($user_type==1)
    { 

        $get_migrated_students = DB::table('students')->where(['students.type'=> 1,'students.is_migrate'=> 1])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }
    else if($user_type==3)
    {

        $office_id =  Auth::user()->office_id;
        $get_migrated_students = DB::table('students')->where(['students.type'=> 1,'students.is_migrate'=> 1,'students.office_id'=>$office_id])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }


    return view('/admin/migrate_students', compact('get_migrated_students'));
}



public function extra(Request $request)
{

    $get_stdata = DB::table('students')->where(['id'=>$request->id])->first();

    if($get_stdata->is_extra == 1)
    {
        DB::table('students')->where(['id'=>$request->id])->update(['is_extra' => 0]);    
    }
    else
    {
        DB::table('students')->where(['id'=>$request->id])->update(['is_extra' => 1]);
    }
    
    echo 1; exit;
}

public function extra_students(Request $request)
{
    $user_type =  Auth::user()->type;

    if($user_type==1)
    { 

        $get_extra_students = DB::table('students')->where(['students.type'=> 1,'students.is_extra'=> 1])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }
    else if($user_type==3)
    {

        $office_id =  Auth::user()->office_id;
        $get_extra_students = DB::table('students')->where(['students.type'=> 1,'students.is_extra'=> 1,'students.office_id'=>$office_id])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }


    return view('/admin/extra_students', compact('get_extra_students'));
}




public function extra_student_detail(Request $request, $id=0){
    if($request->all()!=null)
    { 

    request()->validate([
        'first_name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'gender' => 'required',
        'email' => 'required|email|unique:users|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
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
        'course_completion_date.required_with' => 'Choose course completion date.',
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


$get_user_data = DB::table('users')->where(['id'=>$user_id])->first();
$office_id = $get_user_data->office_id;


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
/*$intake_date = date('Y-m-d',strtotime($request->intake_date[1]));
$course_completion_date = date('Y-m-d',strtotime($request->course_completion_date[1]));  */

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
DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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


 $student_data = DB::table('students')->where('id', $student_id)->first();

 if($student_data->migration_other_images != '')
 {
    $existing_img = $student_data->migration_other_images;
 }
 else
 {
    $existing_img = '';  
 }

$name = $request->other_images;

$images_name = array();            

      if ($request->hasFile('other_images')) {
        if($name)
        {
          foreach ($name as $key => $value) {

            $image = $request->file('other_images')[$key];

            $name = time().$key.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/migration_other_images');
            $image->move($destinationPath, $name);
            $images_name[] = $name;
          }
        }
      }
      else
      {
        $name = $request->old_images;
        $images_name[] = $name;
      }

        //echo "<pre>"; print_r($images_name); exit;

      $image_name = implode(',', $images_name);
      $image_name = $image_name.','.$existing_img; 

        $image_namearr = explode(',', $image_name);   
        $image_name_arr = array_filter($image_namearr);
        $image_name = implode(',',$image_name_arr);
//echo $image_name; exit;

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
    'office_id' => $office_id,

    'australian_id' => $australian_id,
    'passport_number' => $passport_number,
    'passport_expiry_date' => $passport_expiry_date,
    'passport_file' => $passport_file,
    'visa_expiry_date' => $visa_expiry_date,
    'visa_type' => $visa_type,
    'visa_file' => $visa_file,
    'oshc_ovhc_file' => $oshc_ovhc_file,
    'ielts_pte_score_file' => $ielts_pte_score_file,
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



$get_office = DB::table('students')->where('id', $student_id)->first();


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

return redirect('/admin/extra_students')->with('success','Student details update succesfully.');
}
else
{

    //echo "fdsfds"; exit;

    $id = base64_decode($id);
    $get_student = DB::table('students')->where('students.id', $id)->select('students.*','students.id as sid','education_details.*')->leftJoin('education_details','students.id','=','education_details.student_id')->first();
    $get_staffs = DB::table('users')->get();

    $get_coes_data = DB::table('coes_details')->where('student_id', $id)->first();
    $countries = DB::table('countries')->get();
    return view('admin/extra_student_detail', compact('get_student','countries','get_coes_data','get_staffs'));
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

        $get_prospect_students = DB::table('students')->where(['students.type'=> 1,'students.is_migrate'=>0])->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','offices.name as office_name')
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('offices', 'offices.id', 'students.office_id')
        ->orderBy('students.id', 'DESC')->get();
    }
    else if($user_type==3)
    {

        $office_id =  Auth::user()->office_id;
        $get_prospect_students = DB::table('students')->where(['students.type'=> 1,'students.office_id'=>$office_id,'students.is_migrate'=>0])->where('students.is_delete', 0)
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

    //echo $user_type; exit;

    if($user_type==1)
    {

        $get_lead_students = DB::table('students')->where('students.type', 2)->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name', 'offices.name as office_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')        
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')  
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        /*->where('course_fees_details.current_college_course', 1) */      
        ->orderBy('first_name', 'ASC')->groupBy('students.email')->get();

    }

    elseif( $user_type==3)
    {
        $office_id = Auth::user()->office_id;
        $get_lead_students = DB::table('students')->where(['students.type' =>2, 'students.office_id' => $office_id])->where('students.is_delete', 0)->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')
        ->leftJoin('users','students.user_id','=','users.id')                
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        /*->where('course_fees_details.current_college_course', 1)*/           
        ->orderBy('first_name', 'ASC')->groupBy('students.email')->get();
    }

    return view('/admin/leads_students', compact('get_lead_students'));
}


public function filtered_students(Request $request,$student_type=0,$register_type=0,$pass_exp_date=0,$visa_exp_date=0,$australian_id=0,$marital_status=0,$gender=0,$referral=0,$purpose_of_visit=0,$college=0,$dob=0,$country=0,$offices=0,$end_completion_date=0,$start_completion_date=0,$community=0)
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


    if($request->start_completion_date != '')
    {
    $start_completion_date = date('Y-m-d', strtotime($request->start_completion_date));
    }
    else
    {
        $start_completion_date = 0;
    }

    if($request->end_completion_date != '')
    {
    $end_completion_date = date('Y-m-d', strtotime($request->end_completion_date));
    }
    else
    {
        $end_completion_date = 0;
    }


     if($request->start_fees_due_date != '')
    {
    $start_fees_due_date = date('Y-m-d', strtotime($request->start_fees_due_date));
    }
    else
    {
        $start_fees_due_date = 0;
    }

    if($request->end_fees_due_date != '')
    {
    $end_fees_due_date = date('Y-m-d', strtotime($request->end_fees_due_date));
    }
    else
    {
        $end_fees_due_date = 0;
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
    $offices = $request->offices;
    $community = $request->community;
    //$all_students = DB::table('students')->where('students.is_delete', 0)

    $all_students = DB::table('students')    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','offices.name as office_name','fee_details.due_date as fee_due_date','fee_details.remaining_amount as remain_amount','fee_details.received_amount as rec_amount','courses.*','colleges.*','students.id as stid')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->leftJoin('courses','course_fees_details.course_id','=','courses.id')
        ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
        ->where('students.is_delete', 0)        
          
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
            $q->whereDate('students.passport_expiry_date', '>=',$start_pass_exp_date);
            $q->whereDate('students.passport_expiry_date', '<=',$end_pass_exp_date);
            });            
            }

            if(!is_null($start_completion_date && $end_completion_date) && $start_completion_date != 0 && $end_completion_date != 0) {
            $students = $all_students->where(function($q) use ($start_completion_date,$end_completion_date) {
            $q->whereDate('students.course_completion_date', '>=',$start_completion_date);
            $q->whereDate('students.course_completion_date', '<=',$end_completion_date);            
            $q->where('course_fees_details.current_college_course', 1);
            });            
            }

             $is_fees_filter=0;
            if(!is_null($start_fees_due_date && $end_fees_due_date) && $start_fees_due_date != 0 && $end_fees_due_date != 0) {
                $is_fees_filter=1;
            $students = $all_students->where(function($q) use ($start_fees_due_date,$end_fees_due_date) {
            $q->whereDate('fee_details.due_date', '>=',$start_fees_due_date);
            $q->whereDate('fee_details.due_date', '<=',$end_fees_due_date);
            $q->where('course_fees_details.current_college_course', 1);            
            });
                $remaining_amount = 0;$remain_amount = null;
            $students = $all_students->where(function($q) use ($remaining_amount,$remain_amount) {
            $q->where('fee_details.remaining_amount','>',$remaining_amount);
            $q->orwhere('fee_details.remaining_amount','=',$remain_amount);            
            });           

            }

            if(!is_null($start_visa_exp_date && $end_visa_exp_date) && $start_visa_exp_date != 0 && $end_visa_exp_date != 0) {
            $students = $all_students->where(function($q) use ($start_visa_exp_date,$end_visa_exp_date) {
            $q->whereDate('students.visa_expiry_date', '>=',$start_visa_exp_date);
            $q->whereDate('students.visa_expiry_date', '<=',$end_visa_exp_date);
            });            
            }

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
            $q->orwherein('course_fees_details.college_id',$college);
            });            
            }

            if(!is_null($offices)) {
            $students = $all_students->where(function($q) use ($offices) {
            $q->orwherein('students.office_id',$offices);
            });            
            }

            if($end_dob != '' && $start_dob != '') {
            $students = $all_students->where(function($q) use ($end_dob,$start_dob) {
            $q->whereDate('students.dob', '>=',$start_dob);
            $q->whereDate('students.dob', '<=',$end_dob);            
            $q->where('students.dob', '!=','0000-00-00');
            });            
            }

            if(!is_null($country)) {
            $students = $all_students->where(function($q) use ($country) {
            $q->orwherein('students.country',$country);
            });            
            }

            if(!is_null($community)) {
            $students = $all_students->where(function($q) use ($community) {
            $q->orwherein('students.community',$community);
            });            
            }

        $students = $all_students->orderBy('first_name', 'ASC')->groupBy('students.id')->get();

        //echo "<pre>"; print_r($students);

        $all_students = array();
        if($is_fees_filter==1)
        {
            if($students)
            {
                foreach($students as $key => $value)
                {
                    $all_students[] = $value->stid;
                }
            }
        }

        //echo "<pre>"; print_r($all_students);
     

        $all_due_fees_data = DB::table('fee_details')    
        ->select('fee_details.*','course_fees_details.*','fee_details.discount as fee_discount')      
        ->leftJoin('course_fees_details','fee_details.course_fee_detail_id','=','course_fees_details.id')
        ->where('course_fees_details.current_college_course', 1)
        ->wherein('fee_details.student_id',$all_students)->get();

        //echo "<pre>"; print_r($all_due_fees_data);
        //exit;

        if($all_due_fees_data)
        {
            foreach ($all_due_fees_data as $key => $due_fees_data_val)
            {
                $students_data[$due_fees_data_val->student_id][] = $due_fees_data_val; 
            }
        }

        //echo "<pre>"; print_r($students_data); exit;

        if(isset($request->excel) && $request->excel == 'excel')
        {
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=filter_student_report.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $header_name = "S.No.,Name,Staff Name,Email,Phone,Date of Birth,College,Course,Office,Country,";

            if(!is_null($start_pass_exp_date && $end_pass_exp_date) && $start_pass_exp_date != 0 && $end_pass_exp_date != 0) {

                $header_name .= "Passport Expired,";
            }

            if(!is_null($start_completion_date && $end_completion_date) && $start_completion_date != 0 && $end_completion_date != 0) {
                $header_name .= "Course Completion,";
            }

            if(!is_null($start_fees_due_date && $end_fees_due_date) && $start_fees_due_date != 0 && $end_fees_due_date != 0) {

                $header_name .= "Fees Due,";                
                $header_name .= "Total Payable Amount,";                
                $header_name .= "Installment 1,";                
                $header_name .= "Installment 2,";                
                $header_name .= "Installment 3,";                
                $header_name .= "Installment 4,";                
                $header_name .= "Installment 5,";                
                $header_name .= "Installment 6,";                
                $header_name .= "Installment 7,";                
                $header_name .= "Installment 8,";                
                $header_name .= "Installment 9,";                
                $header_name .= "Installment 10,";                
                $header_name .= "Installment 11,";                
                $header_name .= "Installment 12,";                
                $header_name .= "Installment 13,";                
                $header_name .= "Installment 14,";                
                $header_name .= "Installment 15,";                
                $header_name .= "Installment 16,";                
                $header_name .= "Installment 17,";                
                $header_name .= "Installment 18,";                
                $header_name .= "Installment 19,";                
                $header_name .= "Installment 20,";                
                $header_name .= "Installment 21,";                
                $header_name .= "Installment 22,";                
                $header_name .= "Installment 23,";                
                $header_name .= "Installment 24,";                
                $header_name .= "Installment 25,";                
                $header_name .= "Installment 26,";                
                $header_name .= "Installment 27,";                
                $header_name .= "Installment 28,";                
                $header_name .= "Installment 29,";                
                $header_name .= "Installment 30,";                

            }

            if(!is_null($start_visa_exp_date && $end_visa_exp_date) && $start_visa_exp_date != 0 && $end_visa_exp_date != 0) {

                $header_name .= "Visa Expired,";
             }            

             if(!is_null($marital_status)) {
                $header_name .= "Marital Status,";
             }

             if(!is_null($gender)) {
                $header_name .= "Gender,";
             }

             if(!is_null($referral)) {
                $header_name .= "Referral,";
             }

             if(!is_null($purpose_of_visit)) {
                $header_name .= "Purpose Of visit,";
             }

             if(!is_null($community)) {
                $header_name .= "Community,";
             }

             echo $header_name."\n";

            $i = 1;


            //echo "<pre>"; print_r($students); exit;
        if($students)
        { 
          foreach ($students as $key => $get_student)
          {

            if($get_student->current_college_course == 1)
            {
                $student_id[] = $get_student->stid;
            }

            
                //$date_placed = date('h:i a M d',strtotime($get_student->date_placed));           

                $excel_data = $i.",".$get_student->first_name.",".$get_student->staff_name.",".$get_student->email.",".$get_student->phone.",".$get_student->dob.",".$get_student->college_trading_name.",".$get_student->course_name.",".$get_student->office_name.",".$get_student->country.",";

                if(!is_null($start_pass_exp_date && $end_pass_exp_date) && $start_pass_exp_date != 0 && $end_pass_exp_date != 0) {

                $excel_data .= $get_student->passport_expiry_date.",";
            }

            if(!is_null($start_completion_date && $end_completion_date) && $start_completion_date != 0 && $end_completion_date != 0) {
                $excel_data .= $get_student->course_completion_date.",";
            }


            if(!is_null($start_fees_due_date && $end_fees_due_date) && $start_fees_due_date != 0 && $end_fees_due_date != 0) {

                $excel_data .= $get_student->fee_due_date.",";
                $excel_data .= $get_student->tuition_fees.",";

                //echo "<pre>"; print_r($students_data); exit;

                if(isset($students_data[$get_student->stid]))
                {
                    foreach ($students_data[$get_student->stid] as $key => $students_data_val)
                    {
                       /* echo $students_data_val->total_payable_amount;
                        exit;*/

                        $excel_data .= "Fees:- ".$students_data_val->amount." Received Amount:- ".$students_data_val->received_amount." Discount:- ".$students_data_val->fee_discount.",";
                    }
                }
            }            

            if(!is_null($start_visa_exp_date && $end_visa_exp_date) && $start_visa_exp_date != 0 && $end_visa_exp_date != 0) {

                $excel_data .= $get_student->visa_expiry_date.",";
             }            

             if(!is_null($marital_status)) {
                $excel_data .= $get_student->marital_status.",";
             }

             if(!is_null($gender)) {
                $excel_data .= $get_student->gender.",";
             }

             if(!is_null($referral)) {
                $excel_data .= $get_student->referral.",";
             }

             if(!is_null($purpose_of_visit)) {
                $excel_data .= $get_student->purpose.",";
             }

             if(!is_null($community)) {
                $excel_data .= $get_student->community.",";
             }

                echo $excel_data."\n";

                $i++;  
            }
        }

        //echo "<pre>"; print_r($student_id);
        exit;

      }


        $get_colleges = DB::table('colleges')->get();
        $get_country = DB::table('students')->where('country','!=', '')->groupBy('country')->get();
        $get_offices = DB::table('offices')->get();

        //echo "<pre>"; print_r($students); exit;          

         return view('/admin/filtered_students', compact('students','get_colleges','get_offices','student_type','register_type','australian_id','marital_status','gender','referral', 'purpose_of_visit','college','country','get_country'));

 }
 else
 {

    $students = DB::table('students')->where('students.is_delete', 0)
        ->select('students.*','users.first_name as staff_name', 'offices.name as office_name','students.id as stid')
        ->leftJoin('users','students.user_id','=','users.id')        
        ->leftJoin('offices','offices.id','=','students.office_id')->orderBy('first_name', 'ASC')->get();

         $get_colleges = DB::table('colleges')->get();         
         $get_country = DB::table('students')->where('country','!=', '')->groupBy('country')->get();
         $get_offices = DB::table('offices')->get();

          return view('/admin/filtered_students', compact('students','get_colleges','get_offices','get_country'));
     }

   
}

/*
public function filter_student_excel(Request $request)
{
    

}*/


public function student_payment_details(Request $request,$id=0)
{
    $id = base64_decode($id);

    $student_name = DB::table('students')->where('id',$id)->first();

    $studentCourseArray = $student_all_courses = $studentbonusArray = $studentCourseCampusArray = array();
    
    $student_all_courses = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name','courses.course_name','campuses.campus_name')->leftjoin('colleges','course_fees_details.college_id','=','colleges.id')->leftjoin('courses','course_fees_details.course_id','=','courses.id')->leftjoin('campuses','course_fees_details.campus_id','=','campuses.id')->where('user_id',$id)->get();

 if($student_all_courses)
  {
    foreach ($student_all_courses as $key => $student_all_courses_val)
    {
        $studentCourseCampusArray[$student_all_courses_val->course_id][$student_all_courses_val->campus_id] = $student_all_courses_val;
    }
  }

    $student_fee_details = DB::table('fee_details')->select('fee_details.*','users.first_name as staff_name','colleges.college_trading_name','courses.course_name')->leftjoin('users','fee_details.payment_received_by','=','users.id')->leftjoin('colleges','fee_details.college_id','=','colleges.id')->leftjoin('courses','fee_details.course_id','=','courses.id')->where('fee_details.student_id', $id)->get();

    
   if($student_fee_details)
   {
        foreach ($student_fee_details as $key => $value)
        {
            $studentCourseArray[$value->course_id][$value->campus_id][] = $value;
        }
    }
   return view('/admin/student_payment_details', compact('student_fee_details','student_all_courses','studentCourseArray','studentCourseCampusArray','student_name'));
}

public function viewAddStudents()
{
    $countries = DB::table('countries')->get();
    $get_colleges = DB::table('colleges')->get();
    $get_courses = DB::table('courses')->get();
    $get_staffs = DB::table('users')->whereNotIn('id',[1] )->whereIn('type', [1,3])->where('is_delete', 0)->get();
    $referrals_list = DB::table('referrals')->get();
    return view('admin/addstudents',compact('countries','get_staffs','get_courses','get_colleges','referrals_list'));
}


public function add_students(Request $request)
{   

$email_exist_count = DB::table('students')->where(['email'=>$request->email,'is_delete'=>0])->count();
$new_email = DB::table('students')->where(['email'=>$request->email])->count();



//echo $email_exist_count; exit;

if($email_exist_count > 0 || $new_email == 0)
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

DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);

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
DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
    return back()->with('success','Comment added sucessfully.');
}

public function other_details($ids){
    $all_courses_val = $all_campuses_val = array();
    $id = base64_decode($ids);
        //echo $ids; exit;
    $get_course_fee_details = $get_courses = array();

    $referrals_list = DB::table('referrals')->get();


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

    $get_staffs = DB::table('users')->whereNotIn('id',[1] )->whereIn('type', [1,3])->where('is_delete', 0)->get();


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


    return view('admin/student-other-details', compact('get_student','countries','get_colleges','get_courses','get_staffs','get_coes_data','get_course_fee_detail_count','get_fee_detail_count','get_course_fee_details','all_courses_val','get_campuses','all_campuses_val','referrals_list'));
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
        'course_completion_date.required_with' => 'Choose course completion date.',
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

$get_user_data = DB::table('users')->where(['id'=>$user_id])->first();
$office_id = $get_user_data->office_id;

$first_name = $request->first_name;
$middle_name = $request->middle_name;
$last_name = $request->last_name;
$dob =  date('Y-m-d',strtotime($request->dob));
$address = $request->address;
$gender = $request->gender;
$phone = $request->phone;
$community = $request->community;
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
//echo $request->intake_date; exit;
$intake_date = date('Y-m-d',strtotime($request->intake_date[1]));
$course_completion_date = date('Y-m-d',strtotime($request->course_completion_date[1]));  

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
DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);

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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    'community' => $community,
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
    'office_id' => $office_id,

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

$course_count = $college_count = $campuses_count = 0;

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
            //echo "here"; exit;
               
            foreach ($request->course_fees_id as $key => $course_fee_value)
            {

                $fees_data_count = DB::table('course_fees_details')->where('id', $course_fee_value)->count();

                //echo $fees_data_count; exit;

                if($fees_data_count > 0)
                {
                    $update_courses = DB::table('course_fees_details')->where('id',$course_fee_value)->update(['current_college_course' => $request->current_course[$key],'course_completion_date' => $request->course_completion_date[$key]]);

                    DB::table('students')->where('id', $student_id)->update([    
                        'fees' => $request->admission_fees[$key],
                        'discount_type' => $request->discount_type[$key],
                        'discount' => $request->discount[$key],
                        'material_fees' => $request->material_fees[$key],
                        'tuition_fees' => $request->tuition_fees[$key],
                        'total_payable_amount' => $request->amount[$key],
                        'installment_frequency' => $request->installment_frequency[$key],
                        'total_installment' => $request->total_installment[$key],                        
                        'intake_date' => date('Y-m-d',strtotime($request->intake_date[$key])),
                        'course_completion_date' => date('Y-m-d',strtotime($request->course_completion_date[$key])),
                        'updated_at' => NOW(),
                         ]);
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
                        'intake_date' => date('Y-m-d',strtotime($request->intake_date[$key])),
                        'course_completion_date' => date('Y-m-d',strtotime($request->course_completion_date[$key])),
                        'updated_at' => NOW(),
                        'created_at' => NOW(),
                    ]);


                    DB::table('students')->where('id', $student_id)->update([    
                        'fees' => $request->admission_fees[$key],
                        'discount_type' => $request->discount_type[$key],
                        'discount' => $request->discount[$key],
                        'material_fees' => $request->material_fees[$key],
                        'tuition_fees' => $request->tuition_fees[$key],
                        'total_payable_amount' => $request->amount[$key],
                        'installment_frequency' => $request->installment_frequency[$key],
                        'total_installment' => $request->total_installment[$key],                        
                        'intake_date' => date('Y-m-d',strtotime($request->intake_date[$key])),
                        'course_completion_date' => date('Y-m-d',strtotime($request->course_completion_date[$key])),
                        'updated_at' => NOW(),          

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

       $get_course_commission_count = DB::table('campuses')->where('id', $get_current_course->campus_id)->count();
        if($get_course_commission_count == 0)
        {
          return back()->with('campus_id', 'Please assign Campus.');  
        }


       $tuition_fees = $get_course_commission->tuition_fees;
       $commission_percentage = $get_course_commission->commission;

       $total_commision = ($tuition_fees*$commission_percentage)/100;



      $today_date = $get_current_course->intake_date;
       if($get_current_course->course_id !='' && $get_current_course->fees!='' && $get_current_course->total_payable_amount!='')
       {
        if($get_current_course->total_installment > 0)
        {
            $installementcommission = $total_commision/$get_current_course->total_installment;


           /* $installementAmount = $get_current_course->total_payable_amount/$get_current_course->total_installment;*/
            $installementAmount = $get_current_course->tuition_fees/$get_current_course->total_installment;

            $installementAmount = str_replace(',','', number_format($installementAmount,2));


            if($get_current_course->total_installment!='')
            {
                for ($i=0; $i < $get_current_course->total_installment; $i++) 
                { 

                   if($i==0)
                    {
                       $newDate =  $get_current_course->intake_date;            
                    }
                    else
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
                    }

                    $today_date = $newDate;

                     //echo "<pre>"; print_r($get_fee_details_count); exit;

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
                                'course_fee_detail_id' => $get_current_course->id,
                                'due_date' => $newDate,
                                'amount' =>  $installementAmount,
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



public function migration_student_detail(Request $request, $id=0){
    if($request->all()!=null)
    { 

    request()->validate([
        'first_name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'gender' => 'required',
        'email' => 'required|email|unique:users|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
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
        'course_completion_date.required_with' => 'Choose course completion date.',
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
/*$intake_date = date('Y-m-d',strtotime($request->intake_date[1]));  
$course_completion_date = date('Y-m-d',strtotime($request->course_completion_date[1]));  */

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
DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);

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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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
    DB::table('students')->where('id', $student_id)->update(['is_read_client_notes' => 0]);
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


 $student_data = DB::table('students')->where('id', $student_id)->first();

 if($student_data->migration_other_images != '')
 {
    $existing_img = $student_data->migration_other_images;
 }
 else
 {
    $existing_img = '';  
 }

$name = $request->other_images;

$images_name = array();            

      if ($request->hasFile('other_images')) {
        if($name)
        {
          foreach ($name as $key => $value) {

            $image = $request->file('other_images')[$key];

            $name = time().$key.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/migration_other_images');
            $image->move($destinationPath, $name);
            $images_name[] = $name;
          }
        }
      }
      else
      {
        $name = $request->old_images;
        $images_name[] = $name;
      }

        //echo "<pre>"; print_r($images_name); exit;

      $image_name = implode(',', $images_name);
      $image_name = $image_name.','.$existing_img; 

        $image_namearr = explode(',', $image_name);   
        $image_name_arr = array_filter($image_namearr);
        $image_name = implode(',',$image_name_arr);
//echo $image_name; exit;

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
    'migration_other_images' => $image_name,
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



$get_office = DB::table('students')->where('id', $student_id)->first();


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

return redirect('/admin/migrate_students')->with('success','Student details update succesfully.');
}
else
{

    //echo "fdsfds"; exit;

    $id = base64_decode($id);
    $get_student = DB::table('students')->where('students.id', $id)->select('students.*','students.id as sid','education_details.*')->leftJoin('education_details','students.id','=','education_details.student_id')->first();
    $get_staffs = DB::table('users')->get();

    $get_coes_data = DB::table('coes_details')->where('student_id', $id)->first();
    $countries = DB::table('countries')->get();
    return view('admin/migration_student_detail', compact('get_student','countries','get_coes_data','get_staffs'));
}
}



public function remove_migration_image(Request $request)
     {
        $image_arr = array();
        $userid = $request->userid;
        $image_name = $request->image_name;

        $students = DB::table('students')->where(['id'=>$userid])->first();
        $image_arr = explode(',', $students->migration_other_images);
        if (($key = array_search($image_name, $image_arr)) !== false)
        {
            unset($image_arr[$key]);

//echo "<pre>"; print_r($image_arr); exit;

            $updated_image = implode(',', $image_arr);
             $updated_image_arr =  explode(',', $updated_image);
             $imagearr = array_filter($updated_image_arr);

             $updated_image = implode(',', $imagearr);
            //echo $updated_image; exit; 
            DB::table('students')->where('id', $userid)
                ->update(['migration_other_images'=>$updated_image,'updated_at'=>NOW()]);
           echo 1;
           exit;
        }
     }


 public function staff()
   {
        if (Auth::user()->type == 1){

            $get_staffs = DB::table('users')->where('users.is_delete', 0)->where('users.id','!=', 1)->select('users.*', 'offices.name as office_name')->leftjoin('offices', 'users.office_id', '=', 'offices.id')->orderBy('id','desc')->get();

            }

            else if (Auth::user()->type == 3){

                $office_id = Auth::user()->office_id;

                $get_staffs = DB::table('users')->whereIn('type', [1,3])->where(['users.is_delete'=> 0, 'users.office_id' =>$office_id])->select('users.*', 'offices.name as office_name')->leftjoin('offices', 'users.office_id', '=', 'offices.id')->orderBy('id','desc')->get();

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
            //echo "<pre>"; print_r($request->all()); exit;

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

            if($type == 2 )
            {
                if(isset($request->student_management))
                {
                    $student_management = 1;
                }
                else
                {
                    $student_management = 0;   
                }
            }
            else
            {
                $student_management = 1;
            }



            if($type == 2 )
            {
                if(isset($request->student_delete_management))
                {
                    $student_delete_management = 1;
                }
                else
                {
                    $student_delete_management = 0;   
                }
            }
            else
            {
                $student_delete_management = 1;
            }


              // STUDENT MANGEMENT SUB POINTS (start)

            // if($type == 2 ){
            //     $rights_prospects = $request->rights_prospects =1; 
            // } else
            // $rights_prospects = $request->rights_prospects;
            // if($request->rights_prospects == '')
            // {
            //     $rights_prospects = 0; 
            // }
        
            //  if($type == 2 ){
            //     $rights_clients = $request->rights_clients =1; 
            // } else
            // $rights_clients = $request->rights_clients;
            // if($request->rights_clients == '')
            // {
            //     $rights_clients = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_whatsapp = $request->rights_whatsapp =1; 
            // } else
            // $rights_whatsapp = $request->rights_whatsapp;
            // if($request->rights_whatsapp == '')
            // {
            //     $rights_whatsapp = 0; 
            // }
 
            //  if($type == 2 ){
            //     $rights_message = $request->rights_message =1; 
            // } else
            // $rights_message = $request->rights_message;
            // if($request->rights_message == '')
            // {
            //     $rights_message = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_email = $request->rights_email =1; 
            // } else
            // $rights_email = $request->rights_email;
            // if($request->rights_email == '')
            // {
            //     $rights_email = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_migration = $request->rights_migration =1; 
            // } else
            // $rights_migration = $request->rights_migration;
            // if($request->rights_migration == '')
            // {
            //     $rights_migration = 0; 
            // }            


            //  if($type == 2 ){
            //     $rights_extra = $request->rights_extra =1; 
            // } else
            // $rights_extra = $request->rights_extra;
            // if($request->rights_extra == '')
            // {
            //     $rights_extra = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_mark_unread = $request->rights_mark_unread =1; 
            // } else
            // $rights_mark_unread = $request->rights_mark_unread;
            // if($request->rights_mark_unread == '')
            // {
            //     $rights_mark_unread = 0; 
            // }

            // if($type == 2 ){
            //     $rights_client_notes = $request->rights_client_notes =1; 
            // } else
            // $rights_client_notes = $request->rights_client_notes;
            // if($request->rights_client_notes == '')
            // {
            //     $rights_client_notes = 0; 
            // }  
            
            //  if($type == 2 ){
            //     $rights_read_client_notes = $request->rights_read_client_notes =1; 
            // } else
            // $rights_read_client_notes = $request->rights_read_client_notes;
            // if($request->rights_read_client_notes == '')
            // {
            //     $rights_read_client_notes = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_checklist = $request->rights_checklist =1; 
            // } else
            // $rights_checklist = $request->rights_checklist;
            // if($request->rights_checklist == '')
            // {
            //     $rights_checklist = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_convert_to_client = $request->rights_convert_to_client =1; 
            // } else
            // $rights_convert_to_client = $request->rights_convert_to_client;
            // if($request->rights_convert_to_client == '')
            // {
            //     $rights_convert_to_client = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_delete = $request->rights_delete =1; 
            // } else
            // $rights_delete = $request->rights_delete;
            // if($request->rights_delete == '')
            // {
            //     $rights_delete = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_admission_fees = $request->rights_admission_fees =1; 
            // } else
            // $rights_admission_fees = $request->rights_admission_fees;
            // if($request->rights_admission_fees == '')
            // {
            //     $rights_admission_fees = 0; 
            // }


            //  if($type == 2 ){
            //     $rights_material_fees = $request->rights_material_fees =1; 
            // } else
            // $rights_material_fees = $request->rights_material_fees;
            // if($request->rights_material_fees == '')
            // {
            //     $rights_material_fees = 0; 
            // }


            //  if($type == 2 ){
            //     $rights_fees_details = $request->rights_fees_details =1; 
            // } else
            // $rights_fees_details = $request->rights_fees_details;
            // if($request->rights_fees_details == '')
            // {
            //     $rights_fees_details = 0; 
            // }


            // STUDENT MANAGEMENT SUB POINTS (end)






            // if($type == 2 ){
            //     $staff_management = $request->staff_management =1; 
            // } else
            // $staff_management = $request->staff_management;
            // if($request->staff_management == '')
            // {
            //     $staff_management = 0; 
            // }



            // STAFF MANAGEMENT SUB POINTS (start)
            
           // if($type == 2 ){
           //      $rights_staff_add = $request->rights_staff_add =1; 
           //  } else
           //  $rights_staff_add = $request->rights_staff_add;
           //  if($request->rights_staff_add == '')
           //  {
           //      $rights_staff_add = 0; 
           //  }


           //   if($type == 2 ){
           //      $rights_staff_edit = $request->rights_staff_edit =1; 
           //  } else
           //  $rights_staff_edit = $request->rights_staff_edit;
           //  if($request->rights_staff_edit == '')
           //  {
           //      $rights_staff_edit = 0; 
           //  }


           //   if($type == 2 ){
           //      $rights_staff_delete = $request->rights_staff_delete =1; 
           //  } else
           //  $rights_staff_delete = $request->rights_staff_delete;
           //  if($request->rights_staff_delete == '')
           //  {
           //      $rights_staff_delete = 0; 
           //  }


            // STAFF MANAGEMENT SUB POINTS (end)


            if($type == 2 )
            {
                if(isset($request->college_management))
                {
                    $college_management = 1;
                }
                else
                {
                    $college_management = 0;
                }
            }
            else
            {
                $college_management = 1;
            }


            if($type == 2 )
            {
                if(isset($request->rights_college_add))
                {
                    $rights_college_add = 1;
                }
                else
                {
                    $rights_college_add = 0;
                }
            }
            else
            {
                $rights_college_add = 1;
            }


            // COLLEGE & COURSE  MANAGEMENT SUB POINTS (start)
            
            if($type == 2 )
            {
                if(isset($request->rights_college_add))
                {
                    $rights_college_add = 1;
                }
                else
                {
                    $rights_college_add = 0;   
                }
            }
            else
            {
                $rights_college_add = 1;
            }

            
            //  if($type == 2 ){
            //     $rights_college_edit = $request->rights_college_edit =1; 
            // } else
            // $rights_college_edit = $request->rights_college_edit;
            // if($request->rights_college_edit == '')
            // {
            //     $rights_college_edit = 0; 
            // }


            //  if($type == 2 ){
            //     $rights_college_delete = $request->rights_college_delete =1; 
            // } else
            // $rights_college_delete = $request->rights_college_delete;
            // if($request->rights_college_delete == '')
            // {
            //     $rights_college_delete = 0; 
            // }



            //  if($type == 2 ){
            //     $rights_college_course = $request->rights_college_course =1; 
            // } else
            // $rights_college_course = $request->rights_college_course;
            // if($request->rights_college_course == '')
            // {
            //     $rights_college_course = 0; 
            // }


            //  if($type == 2 ){
            //     $rights_college_course_add = $request->rights_college_course_add =1; 
            // } else
            // $rights_college_course_add = $request->rights_college_course_add;
            // if($request->rights_college_course_add == '')
            // {
            //     $rights_college_course_add = 0; 
            // }



            //  if($type == 2 ){
            //     $rights_college_course_edit = $request->rights_college_course_edit =1; 
            // } else
            // $rights_college_course_edit = $request->rights_college_course_edit;
            // if($request->rights_college_course_edit == '')
            // {
            //     $rights_college_course_edit = 0; 
            // }

            //  if($type == 2 ){
            //     $rights_college_course_delete = $request->rights_college_course_delete =1; 
            // } else
            // $rights_college_course_delete = $request->rights_college_course_delete;
            // if($request->rights_college_course_delete == '')
            // {
            //     $rights_college_course_delete = 0; 
            // } 



            // COLLEGE & COURSE  MANAGEMENT SUB POINTS (end) 





            // if($type == 2 ){
            //     $course_management = $request->course_management =1; 
            // } else
            // $course_management = $request->course_management;
            // if($request->course_management == '')
            // {
            //     $course_management = 0; 
            // }


            if($type == 2 )
            {
                if(isset($request->migration_management))
                {
                    $migration_management = 1;
                }
                else
                {
                    $migration_management = 0;   
                }
            }
            else
            {
                $migration_management = 1;
            }


             if($type == 2 )
            {
                if(isset($request->extra_management))
                {
                    $extra_management = 1;
                }
                else
                {
                    $extra_management = 0;   
                }
            }
            else
            {
                $extra_management = 1;
            }

           
           // MIGRATION  MANAGEMENT SUB POINTS (start)

            // if($type == 2 ){
            //     $rights_migration_message = $request->rights_migration_message =1; 
            // } else
            // $rights_migration_message = $request->rights_migration_message;
            // if($request->rights_migration_message == '')
            // {
            //     $rights_migration_message = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_whatsapp = $request->rights_migration_whatsapp =1; 
            // } else
            // $rights_migration_whatsapp = $request->rights_migration_whatsapp;
            // if($request->rights_migration_whatsapp == '')
            // {
            //     $rights_migration_whatsapp = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_email = $request->rights_migration_email =1; 
            // } else
            // $rights_migration_email = $request->rights_migration_email;
            // if($request->rights_migration_email == '')
            // {
            //     $rights_migration_email = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_prospect = $request->rights_migration_prospect =1; 
            // } else
            // $rights_migration_prospect = $request->rights_migration_prospect;
            // if($request->rights_migration_prospect == '')
            // {
            //     $rights_migration_prospect = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_clientnotes = $request->rights_migration_clientnotes =1; 
            // } else
            // $rights_migration_clientnotes = $request->rights_migration_clientnotes;
            // if($request->rights_migration_clientnotes == '')
            // {
            //     $rights_migration_clientnotes = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_checklist = $request->rights_migration_checklist =1; 
            // } else
            // $rights_migration_checklist = $request->rights_migration_checklist;
            // if($request->rights_migration_checklist == '')
            // {
            //     $rights_migration_checklist = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_details = $request->rights_migration_details =1; 
            // } else
            // $rights_migration_details = $request->rights_migration_details;
            // if($request->rights_migration_details == '')
            // {
            //     $rights_migration_details = 0; 
            // }

            // if($type == 2 ){
            //     $rights_migration_delete = $request->rights_migration_delete =1; 
            // } else
            // $rights_migration_delete = $request->rights_migration_delete;
            // if($request->rights_migration_delete == '')
            // {
            //     $rights_migration_delete = 0; 
            // }


            // MIGRATION  MANAGEMENT SUB POINTS (end)


            if($type == 2 )
            {
                if(isset($request->task_management))
                {
                    $task_management = 1;
                }
                else
                {
                    $task_management = 0;   
                }
            }
            else
            {
                $task_management = 1;
            }

           // TASK  MANAGEMENT SUB POINTS (start)
           // if($type == 2 ){
           //      $rights_task_open = $request->rights_task_open =1; 
           //  } else
           //  $rights_task_open = $request->rights_task_open;
           //  if($request->rights_task_open == '')
           //  {
           //      $rights_task_open = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_snooze = $request->rights_task_snooze =1; 
           //  } else
           //  $rights_task_snooze = $request->rights_task_snooze;
           //  if($request->rights_task_snooze == '')
           //  {
           //      $rights_task_snooze = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_close = $request->rights_task_close =1; 
           //  } else
           //  $rights_task_close = $request->rights_task_close;
           //  if($request->rights_task_close == '')
           //  {
           //      $rights_task_close = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_comment = $request->rights_task_comment =1; 
           //  } else
           //  $rights_task_comment = $request->rights_task_comment;
           //  if($request->rights_task_comment == '')
           //  {
           //      $rights_task_comment = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_edit = $request->rights_task_edit =1; 
           //  } else
           //  $rights_task_edit = $request->rights_task_edit;
           //  if($request->rights_task_edit == '')
           //  {
           //      $rights_task_edit = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_read = $request->rights_task_read =1; 
           //  } else
           //  $rights_task_read = $request->rights_task_read;
           //  if($request->rights_task_read == '')
           //  {
           //      $rights_task_read = 0; 
           //  }

           //  if($type == 2 ){
           //      $rights_task_delete = $request->rights_task_delete =1; 
           //  } else
           //  $rights_task_delete = $request->rights_task_delete;
           //  if($request->rights_task_delete == '')
           //  {
           //      $rights_task_delete = 0; 
           //  }




            // TASK  MANAGEMENT SUB POINTS (end)


            if($type == 2 )
            {
                if(isset($request->follow_up_management))
                {
                    $follow_up_management = 1;
                }
                else
                {
                    $follow_up_management = 0;   
                }
            }
            else
            {
                $follow_up_management = 1;
            }

          
            // FOllOW UP  MANAGEMENT SUB POINTS (start)    


            if($type == 2 )
            {
                if(isset($request->rights_visa_expire))
                {
                    $rights_visa_expire = 1;
                }
                else
                {
                    $rights_visa_expire = 0;   
                }
            }
            else
            {
                $rights_visa_expire = 1;
            }


            // if($type == 2 ){
            //     $rights_visa_message = $request->rights_visa_message =1; 
            // } else
            // $rights_visa_message = $request->rights_visa_message;
            // if($request->rights_visa_message == '')
            // {
            //     $rights_visa_message = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_whatsapp = $request->rights_visa_whatsapp =1; 
            // } else
            // $rights_visa_whatsapp = $request->rights_visa_whatsapp;
            // if($request->rights_visa_whatsapp == '')
            // {
            //     $rights_visa_whatsapp = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_email = $request->rights_visa_email =1; 
            // } else
            // $rights_visa_email = $request->rights_visa_email;
            // if($request->rights_visa_email == '')
            // {
            //     $rights_visa_email = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_comment = $request->rights_visa_comment =1; 
            // } else
            // $rights_visa_comment = $request->rights_visa_comment;
            // if($request->rights_visa_comment == '')
            // {
            //     $rights_visa_comment = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_open = $request->rights_visa_open =1; 
            // } else
            // $rights_visa_open = $request->rights_visa_open;
            // if($request->rights_visa_open == '')
            // {
            //     $rights_visa_open = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_snooze = $request->rights_visa_snooze =1; 
            // } else
            // $rights_visa_snooze = $request->rights_visa_snooze;
            // if($request->rights_visa_snooze == '')
            // {
            //     $rights_visa_snooze = 0; 
            // }

            // if($type == 2 ){
            //     $rights_visa_close = $request->rights_visa_close =1; 
            // } else
            // $rights_visa_close = $request->rights_visa_close;
            // if($request->rights_visa_close == '')
            // {
            //     $rights_visa_close = 0; 
            // }

            if($type == 2 )
            {
                if(isset($request->rights_passport_expire))
                {
                    $rights_passport_expire = 1;
                }
                else
                {
                    $rights_passport_expire = 0;   
                }
            }
            else
            {
                $rights_passport_expire = 1;
            }

            // if($type == 2 ){
            //     $rights_passport_message = $request->rights_passport_message =1; 
            // } else
            // $rights_passport_message = $request->rights_passport_message;
            // if($request->rights_passport_message == '')
            // {
            //     $rights_passport_message = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_whatsapp = $request->rights_passport_whatsapp =1; 
            // } else
            // $rights_passport_whatsapp = $request->rights_passport_whatsapp;
            // if($request->rights_passport_whatsapp == '')
            // {
            //     $rights_passport_whatsapp = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_email = $request->rights_passport_email =1; 
            // } else
            // $rights_passport_email = $request->rights_passport_email;
            // if($request->rights_passport_email == '')
            // {
            //     $rights_passport_email = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_comment = $request->rights_passport_comment =1; 
            // } else
            // $rights_passport_comment = $request->rights_passport_comment;
            // if($request->rights_passport_comment == '')
            // {
            //     $rights_passport_comment = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_open = $request->rights_passport_open =1; 
            // } else
            // $rights_passport_open = $request->rights_passport_open;
            // if($request->rights_passport_open == '')
            // {
            //     $rights_passport_open = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_snooze = $request->rights_passport_snooze =1; 
            // } else
            // $rights_passport_snooze = $request->rights_passport_snooze;
            // if($request->rights_passport_snooze == '')
            // {
            //     $rights_passport_snooze = 0; 
            // }

            // if($type == 2 ){
            //     $rights_passport_close = $request->rights_passport_close =1; 
            // } else
            // $rights_passport_close = $request->rights_passport_close;
            // if($request->rights_passport_close == '')
            // {
            //     $rights_passport_close = 0; 
            // }


            if($type == 2 )
            {
                if(isset($request->rights_fees_due))
                {
                    $rights_fees_due = 1;
                }
                else
                {
                    $rights_fees_due = 0;   
                }
            }
            else
            {
                $rights_fees_due = 1;
            }

            // if($type == 2 ){
            //     $rights_fees_due_message = $request->rights_fees_due_message =1; 
            // } else
            // $rights_fees_due_message = $request->rights_fees_due_message;
            // if($request->rights_fees_due_message == '')
            // {
            //     $rights_fees_due_message = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_whatsapp = $request->rights_fees_due_whatsapp =1; 
            // } else
            // $rights_fees_due_whatsapp = $request->rights_fees_due_whatsapp;
            // if($request->rights_fees_due_whatsapp == '')
            // {
            //     $rights_fees_due_whatsapp = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_email = $request->rights_fees_due_email =1; 
            // } else
            // $rights_fees_due_email = $request->rights_fees_due_email;
            // if($request->rights_fees_due_email == '')
            // {
            //     $rights_fees_due_email = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_comment = $request->rights_fees_due_comment =1; 
            // } else
            // $rights_fees_due_comment = $request->rights_fees_due_comment;
            // if($request->rights_fees_due_comment == '')
            // {
            //     $rights_fees_due_comment = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_open = $request->rights_fees_due_open =1; 
            // } else
            // $rights_fees_due_open = $request->rights_fees_due_open;
            // if($request->rights_fees_due_open == '')
            // {
            //     $rights_fees_due_open = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_snooze = $request->rights_fees_due_snooze =1; 
            // } else
            // $rights_fees_due_snooze = $request->rights_fees_due_snooze;
            // if($request->rights_fees_due_snooze == '')
            // {
            //     $rights_fees_due_snooze = 0; 
            // }

            // if($type == 2 ){
            //     $rights_fees_due_close = $request->rights_fees_due_close =1; 
            // } else
            // $rights_fees_due_close = $request->rights_fees_due_close;
            // if($request->rights_fees_due_close == '')
            // {
            //     $rights_fees_due_close = 0; 
            // }

            if($type == 2 )
            {
                if(isset($request->rights_course_completion))
                {
                    $rights_course_completion = 1;
                }
                else
                {
                    $rights_course_completion = 0;   
                }
            }
            else
            {
                $rights_course_completion = 1;
            }

            // if($type == 2 ){
            //     $rights_course_completion_message = $request->rights_course_completion_message =1; 
            // } else
            // $rights_course_completion_message = $request->rights_course_completion_message;
            // if($request->rights_course_completion_message == '')
            // {
            //     $rights_course_completion_message = 0; 
            // }

            // if($type == 2 ){
            //     $rights_course_completion_whatsapp = $request->rights_course_completion_whatsapp =1; 
            // } else
            // $rights_course_completion_whatsapp = $request->rights_course_completion_whatsapp;
            // if($request->rights_course_completion_whatsapp == '')
            // {
            //     $rights_course_completion_whatsapp = 0; 
            // }
            
            // if($type == 2 ){
            //     $rights_course_completion_email = $request->rights_course_completion_email =1; 
            // } else
            // $rights_course_completion_email = $request->rights_course_completion_email;
            // if($request->rights_course_completion_email == '')
            // {
            //     $rights_course_completion_email = 0; 
            // }

            // if($type == 2 ){
            //     $rights_course_completion_comment = $request->rights_course_completion_comment =1; 
            // } else
            // $rights_course_completion_comment = $request->rights_course_completion_comment;
            // if($request->rights_course_completion_comment == '')
            // {
            //     $rights_course_completion_comment = 0; 
            // }

            // if($type == 2 ){
            //     $rights_course_completion_open = $request->rights_course_completion_open =1; 
            // } else
            // $rights_course_completion_open = $request->rights_course_completion_open;
            // if($request->rights_course_completion_open == '')
            // {
            //     $rights_course_completion_open = 0; 
            // }

            // if($type == 2 ){
            //     $rights_course_completion_snooze = $request->rights_course_completion_snooze =1; 
            // } else
            // $rights_course_completion_snooze = $request->rights_course_completion_snooze;
            // if($request->rights_course_completion_snooze == '')
            // {
            //     $rights_course_completion_snooze = 0; 
            // }

            // if($type == 2 ){
            //     $rights_course_completion_close = $request->rights_course_completion_close =1; 
            // } else
            // $rights_course_completion_close = $request->rights_course_completion_close;
            // if($request->rights_course_completion_close == '')
            // {
            //     $rights_course_completion_close = 0; 
            // }




            // FOllOW UP  MANAGEMENT SUB POINTS (end)

            if($type == 2 )
            {
                if(isset($request->filter_management))
                {
                    $filter_management = 1;
                }
                else
                {
                    $filter_management = 0;   
                }
            }
            else
            {
                $filter_management = 1;
            }

            // if($type == 2 ){
            //     $referral_management = $request->referral_management =1; 
            // } else
            // $referral_management = $request->referral_management;
            // if($request->referral_management == '')
            // {
            //     $referral_management = 0; 
            // }

    

             // REFERRAL  MANAGEMENT SUB POINTS (start)


            // if($type == 2 ){
            //     $rights_referral_view = $request->rights_referral_view =1; 
            // } else
            // $rights_referral_view = $request->rights_referral_view;
            // if($request->rights_referral_view == '')
            // {
            //     $rights_referral_view = 0; 
            // }

            // if($type == 2 ){
            //     $rights_referral_add = $request->rights_referral_add =1; 
            // } else
            // $rights_referral_add = $request->rights_referral_add;
            // if($request->rights_referral_add == '')
            // {
            //     $rights_referral_add = 0; 
            // }

            // if($type == 2 ){
            //     $rights_referral_edit = $request->rights_referral_edit =1; 
            // } else
            // $rights_referral_edit = $request->rights_referral_edit;
            // if($request->rights_referral_edit == '')
            // {
            //     $rights_referral_edit = 0; 
            // }


            // REFERRAL  MANAGEMENT SUB POINTS (end)

            //echo $type; exit;

            $ofc_id = DB::table('offices')->where('id', $office)->first();
            $rights = $ofc_id->super_admin_rights;

            if($type == 3 && $rights == 1)
            {
                $user_type =1;
            }
            elseif ($type == 3 && $rights !== 1)
            {
                $user_type = 3;
            }
            elseif($type == 2 && $rights == 1)
            {
                $user_type = 2;
            }
            else
            {
                $user_type = 2;
            }

          $add = DB::table('users')->insert([

            'type' => $user_type,
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
            'student_delete_management' => $student_delete_management, 
            'college_management' => $college_management,
            'rights_college_add' => $rights_college_add,
            'migration_management' => $migration_management,
            'extra_management' => $extra_management,
            'task_management' => $task_management,
            'follow_up_management' => $follow_up_management,
            'filter_management' => $filter_management,
            'rights_visa_expire' => $rights_visa_expire,   
            'rights_passport_expire' => $rights_passport_expire,   
            'rights_fees_due' => $rights_fees_due,   
            'rights_course_completion' => $rights_course_completion,
            'ip_address' => $request->ip_address,
            'updated_at' => NOW(),
            'created_at' => NOW()
        ]);

          if($add)
          {
            return redirect('/admin/staff')->with('success', 'Staff added sucessfully!!');
          }
          else
          {
            return back()->with('error', 'Something went wrong please try again.');
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
            'ip_address' => 'required',

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
            'ip_address.required' => 'IP Address is required.',
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

    // if($type == 3 ){
    //     $student_management = $request->student_management =1; 
    // } else
    // $student_management = $request->student_management;
    // if($request->student_management == '')
    // {
    //     $student_management = 0; 
    // }

    // if($type == 3 ){
    //     $staff_management = $request->staff_management =1; 
    // } else
    // $staff_management = $request->staff_management;
    // if($request->staff_management == '')
    // {
    //     $staff_management = 0; 
    // }

    // if($type == 3 ){
    //     $college_management = $request->college_management =1; 
    // } else
    // $college_management = $request->college_management;
    // if($request->college_management == '')
    // {
    //     $college_management = 0; 
    // }

    // if($type == 3 ){
    //     $course_management = $request->course_management =1; 
    // } else
    // $course_management = $request->course_management;
    // if($request->course_management == '')
    // {
    //     $course_management = 0; 
    // }

    if($type == 2 )
    {
        if(isset($request->student_management))
        {
            $student_management = 1;
        }
        else
        {
            $student_management = 0;   
        }
    }
    else
    {
        $student_management = 1;
    }



    if($type == 2 )
    {
        if(isset($request->student_delete_management))
        {
            $student_delete_management = 1;
        }
        else
        {
            $student_delete_management = 0;   
        }
    }
    else
    {
        $student_delete_management = 1;
    }


    if($type == 2 )
    {
        if(isset($request->college_management))
        {
            $college_management = 1;
        }
        else
        {
            $college_management = 0;
        }
    }
    else
    {
        $college_management = 1;
    }


    if($type == 2 )
    {
        if(isset($request->rights_college_add))
        {
            $rights_college_add = 1;
        }
        else
        {
            $rights_college_add = 0;   
        }
    }
    else
    {
        $rights_college_add = 1;
    }


// COLLEGE & COURSE  MANAGEMENT SUB POINTS (start)

    if($type == 2 )
    {
        if(isset($request->rights_college_add))
        {
            $rights_college_add = 1;
        }
        else
        {
            $rights_college_add = 0;   
        }
    }
    else
    {
        $rights_college_add = 1;
    }

    if($type == 2 )
    {
        if(isset($request->migration_management))
        {
            $migration_management = 1;
        }
        else
        {
            $migration_management = 0;   
        }
    }
    else
    {
        $migration_management = 1;
    }


    if($type == 2 )
    {
        if(isset($request->extra_management))
        {
            $extra_management = 1;
        }
        else
        {
            $extra_management = 0;   
        }
    }
    else
    {
        $extra_management = 1;
    }

    if($type == 2 )
    {
        if(isset($request->task_management))
        {
            $task_management = 1;
        }
        else
        {
            $task_management = 0;   
        }
    }
    else
    {
        $task_management = 1;
    }


    if($type == 2 )
    {
        if(isset($request->follow_up_management))
        {
            $follow_up_management = 1;
        }
        else
        {
            $follow_up_management = 0;   
        }
    }
    else
    {
        $follow_up_management = 1;
    }


    if($type == 2 )
    {
        if(isset($request->rights_visa_expire))
        {
            $rights_visa_expire = 1;
        }
        else
        {
            $rights_visa_expire = 0;   
        }
    }
    else
    {
        $rights_visa_expire = 1;
    }

    if($type == 2 )
    {
        if(isset($request->rights_passport_expire))
        {
            $rights_passport_expire = 1;
        }
        else
        {
            $rights_passport_expire = 0;   
        }
    }
    else
    {
        $rights_passport_expire = 1;
    }


    if($type == 2 )
    {
        if(isset($request->rights_fees_due))
        {
            $rights_fees_due = 1;
        }
        else
        {
            $rights_fees_due = 0;   
        }
    }
    else
    {
        $rights_fees_due = 1;
    }

    if($type == 2 )
    {
        if(isset($request->rights_course_completion))
        {
            $rights_course_completion = 1;
        }
        else
        {
            $rights_course_completion = 0;   
        }
    }
    else
    {
        $rights_course_completion = 1;
    }


    if($type == 2 )
    {
        if(isset($request->filter_management))
        {
            $filter_management = 1;
        }
        else
        {
            $filter_management = 0;   
        }
    }
    else
    {
        $filter_management = 1;
    }



    $ofc_id = DB::table('offices')->where('id', $office)->first();
            $rights = $ofc_id->super_admin_rights;

            if($type == 3 && $rights == 1)
            {
                $user_type =1;
            }
            elseif ($type == 3 && $rights !== 1)
            {
                $user_type = 3;
            }
            elseif($type == 2 && $rights == 1)
            {
                $user_type = 2;
            }
            else
            {
                $user_type = 2;
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
        'student_delete_management' => $student_delete_management, 
        'college_management' => $college_management,
        'rights_college_add' => $rights_college_add,
        'migration_management' => $migration_management,
        'extra_management' => $extra_management,
        'task_management' => $task_management,
        'follow_up_management' => $follow_up_management,
        'filter_management' => $filter_management,   
        'rights_visa_expire' => $rights_visa_expire,   
        'rights_passport_expire' => $rights_passport_expire,   
        'rights_fees_due' => $rights_fees_due,   
        'rights_course_completion' => $rights_course_completion,
        /*'student_management' => $student_management,
        'staff_management' => $staff_management,
        'college_management' => $college_management,
        'course_management' => $course_management,*/
        'ip_address' => $request->ip_address,
        'updated_at' => NOW(),

    ]);

    if($update){
        return redirect('admin/staff')->with('success', 'Staff details updated.');
    }else{
        return back()->with('error', 'Something went wrong.');
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


        $view_curr_courses = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name','courses.course_name')->join('colleges','course_fees_details.college_id','=','colleges.id')->join('courses','course_fees_details.course_id','=','courses.id')->where(['user_id'=>$id,'current_college_course'=>1]);

        $view_curr_course = $view_curr_courses->first();
        $view_curr_course_count = $view_curr_courses->count();
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

    return view('/admin/viewstudents', compact('view_students', 'view_communication_logs', 'view_education_details','view_fee_details','staff_first_name','staff_last_name','college_name','course_name','view_fee_count','view_coes_details','view_msg_logs','view_all_courses','curr_fee_details','course_commission','curr_fee_count','view_curr_course','view_curr_course_count'));

}


public function admissionPayFee(Request $request)
{

    $curr_course_data = DB::table('course_fees_details')->where('id', $request->fee_id)->first();

    $img = '';
    if($request->hasFile('payment_proof'))
    {
        $payment_proof = $request->file('payment_proof');
        $img = time() . '.' . $payment_proof->getClientOriginalExtension();

        $destinationPath = public_path('/payment');
        $payment_proof->move($destinationPath, $img);
    }

    if($request->fees_type == 'admission_fees')
    {   
        if($curr_course_data->fees >= $request->amount)
        {

    $update = DB::table('course_fees_details')->where('id', $request->fee_id)->update([
            'rec_admission_fees' => $curr_course_data->rec_admission_fees+=$request->amount,
            'admission_fees_proof' => $img,
            'admission_fees_comment' => $request->comment,
            'payment_type' => $request->payment_type,
            'admission_fees_income' => $request->admission_fees_income,
            'admission_fees_rec_date' => NOW(),
        ]);
    }
    else
    {
        return back()->with('error','You Can not take fees greater than actual amount !');
    }
}
    else if($request->fees_type == 'material_fees')
    {
        if($curr_course_data->material_fees >= $request->amount)
        {
         $update = DB::table('course_fees_details')->where('id', $request->fee_id)->update([
            'rec_material_fees' => $curr_course_data->rec_material_fees+=$request->amount,
            'material_fees_proof' => $img,
            'material_fees_comment' => $request->comment,
            'payment_type' => $request->payment_type,
            'material_fees_income' => $request->material_fees_income,
            'material_fees_rec_date' => NOW(),
        ]); 
    }
    else
    {
        return back()->with('error','You Can not take Material fees greater than actual amount !');
    }
}
    return back()->with('success', 'Fee received.');
}


public function edit_rec_fees(Request $request)
{    
    $feesinemi_count = DB::table('fees_in_emi')->where('fees_id', $request->fee_id)->count();
    if($feesinemi_count > 0)
    {

        $emi_data = '<table class="table"><thead><tr><th scope="col">#</th><th scope="col">Date</th><th scope="col">Amount</th><th scope="col">Action</th></tr></thead><tbody>';

        $fees_in_emi = DB::table('fees_in_emi')->where('fees_id', $request->fee_id)->get();

        //echo "<pre>"; print_r($fees_in_emi); exit;

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

       $commission = str_replace(',', '', $fee_details_data->commission); 

    $rec_commission =  ($amount/$intallment_amount)*$commission;

    $remaining_amount = $intallment_amount-$amount_sum;


     if($fee_details_data->amount < $amount_sum+$fee_details_data->discount)
     {
             echo 'You cant give discount greater than remaining amount.'; exit;
     } 
     else
      {
         $remaining_amount = $fee_details_data->amount-($fee_details_data->discount+$amount_sum);
      }
     


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
            'received_amount' => $amount_sum,
            'remaining_amount' => $remaining_amount,
            'rec_commission' => $total_rec_commission,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }    

$feeDetailsData = DB::table('fee_details')->where(['id'=>$fee_id])->first();

 $total_rec_amount = $feeDetailsData->received_amount+$feeDetailsData->discount;

 //echo $total_rec_amount."=> base amount".$feeDetailsData->amount; exit;

 if($total_rec_amount == $feeDetailsData->amount)
 {
   $status = 1;
 }
 else
 {
    $status = 2;
 }
    $update = DB::table('fee_details')->where('id', $fee_id)->update([
            'status' => $status,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        

    echo "updated"; exit;

    //return back()->with('success', 'Fee received.');
}

public function adminPayFee_discount(Request $request)
{
    $fee_id = $request->fee_id;
    $discount = $request->discount;

     $fee_details_data = DB::table('fee_details')->where('id','=',$fee_id)->first();

     if($fee_details_data->remaining_amount != '')
     {
         if($fee_details_data->remaining_amount+$fee_details_data->discount < $discount)
         {
             return back()->with('error', 'You cant give discount greater than remaining amount.');
         }
         else
         {
            $remaining_amount = ($fee_details_data->remaining_amount+$fee_details_data->discount)-($discount);
         }
     }

     if($fee_details_data->remaining_amount == '')
     {
         if($fee_details_data->amount < $discount)
         {
             return back()->with('error', 'You cant give discount greater than base amount.');
         }
         else
         {
            $remaining_amount = $fee_details_data->amount-$discount;
         }
     }

    $update = DB::table('fee_details')->where('id', $fee_id)->update([
            'discount' => $discount,
            'remaining_amount' => $remaining_amount,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

$feeDetailsData = DB::table('fee_details')->where(['id'=>$fee_id])->first();

 $total_rec_amount = $feeDetailsData->received_amount+$feeDetailsData->discount;

 //echo $total_rec_amount."=> base amount".$feeDetailsData->amount; exit;

 if($total_rec_amount == $feeDetailsData->amount)
 {
   $status = 1;
 }
 else
 {
    $status = 2;
 }
    $update = DB::table('fee_details')->where('id', $fee_id)->update([
            'status' => $status,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

    return back()->with('success', 'Discount details updated.');
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
    $get_courses = DB::table('courses')->where('college_id', $college_id)->where('is_delete', 0)->get();

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

    if($get_fee->payment_proof != '')
    {
    $all_img = $img.','.$get_fee->payment_proof;
    }
    else
    {
     $all_img = $img;   
    }
    
    $discount = $get_fee->discount;
    $received_amount = $get_fee->received_amount;
    $remaining_amount = $get_fee->remaining_amount;

    

   /* if($get_fee->received_amount == '' && $get_fee->discount != '')
    {  
        if($amount > $get_fee->remaining_amount)  
        {
         return back()->with('error', 'Received amount can not be greater than installment amount.');
        }
     }

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
}*/


$amt = $get_fee->remaining_amount;
$remaining_amount = $amt - $amount;

if($remaining_amount == 0){
    $status = 1;
}else{
    $status = 2;
}
if($get_fee->received_amount != '')
{

        if($amount<=$get_fee->remaining_amount)
        {
            DB::table('fee_details')->where('id', $fee_id)->update([
            'received_amount' => $get_fee->received_amount+=$amount,
            'remaining_amount' =>  $get_fee->remaining_amount-=$amount,
            'comment' => $comment,
            'status' => $status,
            'payment_proof' => $all_img,
            'payment_type' => $payment_type,
            'payment_received_date' => NOW(),
            'payment_received_by' => Auth::id(),
        ]);
        }
        else
        {
            return back()->with('error', 'Received amount can not be greater than Remaining amount.');
        }

}
else
{  
    if($request->amount+$get_fee->discount<=$get_fee->amount)
    {
        $total_remaining = $get_fee->amount - ($request->amount+$get_fee->discount);

        DB::table('fee_details')->where('id', $fee_id)->update([
            'received_amount' => $amount,
            'remaining_amount' => $total_remaining,
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
        return back()->with('error', 'Received amount can not be greater than Remaining amount.');
    }
    
   /* DB::table('fee_details')->where('id', $fee_id)->update([
        'received_amount' => $amount,
        'remaining_amount' => $remaining_amount,
        'comment' => $comment,
        'status' => $status,
        'payment_proof' => $img,
        'payment_type' => $payment_type,
        'payment_received_date' => NOW(),
        'payment_received_by' => Auth::id(),
    ]); */
}




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

$feeDetailsData = DB::table('fee_details')->where(['id'=>$fee_id])->first();


 $total_rec_amount = $feeDetailsData->received_amount+$feeDetailsData->discount;

 //echo $total_rec_amount."=> base amount".$feeDetailsData->amount; exit;

 if($total_rec_amount == $feeDetailsData->amount)
 {
   $status = 1;
 }
 else
 {
    $status = 2;
 }
    $update = DB::table('fee_details')->where('id', $fee_id)->update([
            'status' => $status,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        $fees_in_emi_count = DB::table('fees_in_emi')->where(['fees_id'=>$fee_id,'student_id'=>$feeDetailsData->student_id,'college_id'=>$feeDetailsData->college_id,'course_id'=>$feeDetailsData->course_id])->count();

    /*if($fees_in_emi_count > 0)
    {
        $feeDetailsDatasinemi = DB::table('fees_in_emi')->where(['fees_id'=>$fee_id,'student_id'=>$feeDetailsData->student_id,'college_id'=>$feeDetailsData->college_id,'course_id'=>$feeDetailsData->course_id])->first();

        DB::table('fees_in_emi')->where('id', $feeDetailsDatasinemi->id)->update([
            'recieve_amount' =>  $feeDetailsDatasinemi->recieve_amount+=$received_amount,//$request->amount,
            'remaining_amount' => $feeDetailsData->remaining_amount,//$feeDetailsData->remaining_amount,
            'commission_received' => $feeDetailsDatasinemi->commission_received+=$rec_commission,//$rec_commission,
            'is_commission_claimed' => 0,//$rec_commission,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]); 
    }
    else
    {*/
        DB::table('fees_in_emi')->insert([
            'fees_id' => $fee_id,
            'office_id' => $feeDetailsData->office_id,
            'student_id' => $feeDetailsData->student_id,
            'college_id' => $feeDetailsData->college_id,
            'course_id' => $feeDetailsData->course_id,
            'recieve_amount' => $request->amount,
            'remaining_amount' => $feeDetailsData->remaining_amount,
            'commission_received' => $rec_commission,
            'campus_id' => $request->campus_id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);


        /*DB::table('fees_in_emi')->insert([
            'fees_id' => $fee_id,
            'student_id' => $feeDetailsData->student_id,
            'college_id' => $feeDetailsData->college_id,
            'course_id' => $feeDetailsData->course_id,
            'recieve_amount' => $request->amount,
            'remaining_amount' => $feeDetailsData->remaining_amount,
            'commission_received' => $rec_commission,
            'campus_id' => $request->campus_id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);*/  
        /* }   */     


        $fees_in_emi_count = DB::table('course_fees_details')->where(['user_id'=>$feeDetailsData->student_id,'college_id'=>$feeDetailsData->college_id,'course_id'=>$feeDetailsData->course_id,'campus_id'=>$feeDetailsData->campus_id])->update(['is_bonus_applicable' =>  1,
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
    $from_phone = '+14253744467';   
    $to_phone = $request->phone_number;   
    $phone_dialcode = $request->phone_dialcode;   
    $sms_desc = $request->sms_desc;   

    $sid = 'ACd1d3dfe52bc1ca8f609b2a65a6c27fb2';
    $token = '11454977b1e9bac7d505f2518e34c743';
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
    return back()->with('success', 'Message sent to student!!');
    //return redirect(route('students'))->with('success', 'Message sent to student!!');
}


public function send_whatsapp_to_student(Request $request)
{

    $sender_id = Auth::id();
    $from_phone = '+14155238886';   
    $to_phone = $request->whatsapp_number;   
    $phone_dialcode = $request->phone_dialcode;   
    $sms_desc = $request->whatsapp_desc;   

    $sid = 'ACd1d3dfe52bc1ca8f609b2a65a6c27fb2';
    $token = '11454977b1e9bac7d505f2518e34c743';
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

    return back()->with('success', 'Whatsapp message sent to student!!');
    //return redirect(route('students'))->with('success', 'Whatsapp message sent to student!!');
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

$student_data = DB::table('students')->where('id',$request->student_id)->first(); 


$mail = new PHPMailer;
$mail->isSMTP(); /*make commented on live sever*/     // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'satyendra.arrj@gmail.com';                 // SMTP username
$mail->Password = 'ouawdioknoocemxy';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'info@arrjdemo.in';
$mail->FromName = 'Royal Migration';
//$mail->addAddress($student_data->email);     // Add a recipient
$mail->addAddress('satyendra.arrj@gmail.com');               // Name is optional
//$mail->addAddress('vishal@programmates.com');              // Name is optional
/*$mail->addReplyTo('vishal.arrj@gmail.com', 'Information');*/
/*$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');*/

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $request->subject;
$mail->Body    = $mail_desc;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    return back()->with('success', 'Mail sent to student!!');

}
 
 //return redirect(route('students'))->with('success', 'Mail sent to student!!');
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

                     //echo "one";exit;
                     $all_admission_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('rec_admission_fees', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_admission_count_arr = $all_admission_data->get();
                     $all_admission_count = $all_admission_data->count();


                     $all_material_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('material_fees', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_material_count_arr = $all_material_data->get();
                     $all_material_count = $all_material_data->count();


                }
                else
                {

                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', $request->college_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.college');

                    $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();


                     //echo "two";exit;
                     $all_admission_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('rec_admission_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_admission_count_arr = $all_admission_data->get();
                     $all_admission_count = $all_admission_data->count();



                     $all_material_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('material_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_material_count_arr = $all_material_data->get();
                     $all_material_count = $all_material_data->count();

                }
            }
            else
            {

                if($user_type != 1)
                {
                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name' , DB::raw('count(*) as total'))->groupBy('students.college');

                     $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('received_amount', '!=', '')->where('office_id', $loggedin_office_id)->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();

                     //echo "three";exit;
                     $all_admission_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('rec_admission_fees', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_admission_count_arr = $all_admission_data->get();
                     $all_admission_count = $all_admission_data->count();


                     $all_material_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('material_fees', '!=', '')->where('students.office_id', $loggedin_office_id)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_material_count_arr = $all_material_data->get();
                     $all_material_count = $all_material_data->count();
                }
                else
                {

                    $all_student_count_data = DB::table('students')->select('colleges.*','students.*')->leftJoin('colleges','students.college','=','colleges.id')->where('college', '!=', '')->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name' , DB::raw('count(*) as total'))->groupBy('students.college');

                     $all_student_count_arr = $all_student_count_data->get();
                     $all_student_count = $all_student_count_data->count();


                    $all_amount_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.college_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();

                     //echo "four";exit;
                     $all_admission_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('rec_admission_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_admission_count_arr = $all_admission_data->get();
                     $all_admission_count = $all_admission_data->count();


                     $all_material_data = DB::table('course_fees_details')->select('colleges.*','course_fees_details.*')->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')->where('rec_material_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_material_count_arr = $all_material_data->get();
                     $all_material_count = $all_material_data->count();
                     
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

                     //echo "five";exit;
                     $all_admission_data = DB::table('course_fees_details')->select('offices.*','course_fees_details.*')->leftJoin('offices','course_fees_details.office_id','=','offices.id')->where('office_id', $request->office_id)->where('rec_admission_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_admission_count_arr = $all_admission_data->get();
                     $all_admission_count = $all_admission_data->count();



                     $all_material_data = DB::table('course_fees_details')->select('offices.*','course_fees_details.*')->leftJoin('offices','course_fees_details.office_id','=','offices.id')->where('office_id', $request->office_id)->where('rec_material_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                     $all_material_count_arr = $all_material_data->get();
                     $all_material_count = $all_material_data->count();
            }
            else
            {
                $all_student_count_data = DB::table('students')->select('offices.*','students.*')->leftJoin('offices','students.office_id','=','offices.id')->where('office_id', '!=', '')->whereDate('students.created_at', '>=', $start_date)->whereDate('students.created_at', '<=', $end_date)->select('offices.name as college_office_name', DB::raw('count(*) as total'))->groupBy('students.office_id');
                $all_student_count_arr = $all_student_count_data->get();
                $all_student_count = $all_student_count_data->count();

                $all_amount_count_data = DB::table('fee_details')->select('offices.*','fee_details.*')->leftJoin('offices','fee_details.office_id','=','offices.id')->where('received_amount', '!=', '')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('offices.name as college_office_name',DB::raw("sum(case when payment_type=1 then received_amount else 0 end) as total_cash_received"),DB::raw("sum(case when payment_type=2 then received_amount else 0 end) as total_bank_transfer_received"))->groupBy('fee_details.office_id');

                     $all_amount_count_arr = $all_amount_count_data->get();
                     $all_amount_count = $all_amount_count_data->count();

                     //echo "six";exit;
                 $all_admission_data = DB::table('course_fees_details')->select('offices.*','course_fees_details.*')->leftJoin('offices','course_fees_details.office_id','=','offices.id')->where('rec_admission_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then admission_fees_income else 0 end) as total_admission_income_cash"),DB::raw("sum(case when payment_type=2 then admission_fees_income else 0 end) as total_admission_income_bank"),DB::raw("sum(case when payment_type=1 then rec_admission_fees else 0 end) as rec_admission_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_admission_fees else 0 end) as rec_admission_fees_bank"))->groupBy('course_fees_details.college_id');

                   $all_admission_count_arr = $all_admission_data->get();
                   $all_admission_count = $all_admission_data->count();


                   $all_material_data = DB::table('course_fees_details')->select('offices.*','course_fees_details.*')->leftJoin('offices','course_fees_details.office_id','=','offices.id')->where('rec_material_fees', '!=', '')->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(case when payment_type=1 then material_fees_income else 0 end) as total_material_income_cash"),DB::raw("sum(case when payment_type=2 then material_fees_income else 0 end) as total_material_income_bank"),DB::raw("sum(case when payment_type=1 then rec_material_fees else 0 end) as rec_material_fees_cash"),DB::raw("sum(case when payment_type=2 then rec_material_fees else 0 end) as rec_material_fees_bank"))->groupBy('course_fees_details.college_id');

                   $all_material_count_arr = $all_material_data->get();
                   $all_material_count = $all_material_data->count();

            }
        }        

        //echo "<pre>"; print_r($all_admission_count_arr); exit;

        return view('/admin/ajax_report_page',compact('student_count','start_date','end_date','all_student_count_arr','fee_months_data_get','fee_months_data_count','all_amount_count_arr','all_student_count','all_amount_count','all_admission_count_arr','all_admission_count','all_material_count_arr','all_material_count'));
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

        $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id');

            $all_amount_count_arr = $all_amount_count_data->get();
            $all_amount_count = $all_amount_count_data->count();

        $all_pending_comm_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('commission_received','!=','')->where('is_commission_claimed','!=','1')->whereDate('fees_in_emi.created_at', '>=', $start_date)->whereDate('fees_in_emi.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(fees_in_emi.commission_received) as total_commission_pending"))->groupBy('fees_in_emi.college_id');

            $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
            $all_pending_comm_count = $all_pending_comm_count_data->count();


         $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id');

            $all_pending_bonus_data = $all_pending_bonus->get();
            $all_pending_bonus_data_count = $all_pending_bonus->count();

        $all_bonus_data = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

            $all_bonus_count_arr = $all_bonus_data->get();
            $all_bonus_count = $all_bonus_data->count();


             $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');

            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();


    }
    else
    {
        $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id');

            $all_amount_count_arr = $all_amount_count_data->get();
            $all_amount_count = $all_amount_count_data->count();

         $all_pending_comm_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('commission_received','!=','')->where('is_commission_claimed','!=','1')->whereDate('fees_in_emi.created_at', '>=', $start_date)->whereDate('fees_in_emi.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(fees_in_emi.commission_received) as total_commission_pending"))->groupBy('fees_in_emi.college_id');

            $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
            $all_pending_comm_count = $all_pending_comm_count_data->count();

         $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('course_fees_details.office_id', $loggedin_office_id)->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id');

            $all_pending_bonus_data = $all_pending_bonus->get();
            $all_pending_bonus_data_count = $all_pending_bonus->count();

        $all_bonus_data = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

            $all_bonus_count_arr = $all_bonus_data->get();
            $all_bonus_count = $all_bonus_data->count();


            $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('fee_details.office_id', $loggedin_office_id)->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');

            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();

    }


    return view('/admin/commission_report_page',compact('colleges','all_student_count_arr','fee_months_data_get','fee_months_data_count','start_date','end_date','all_amount_count','all_amount_count_arr','all_bonus_count','all_bonus_count_arr','all_pending_comm_count','all_pending_comm_count_arr','all_pending_bonus_data_count','all_pending_bonus_data','all_discount_data','all_discount_count'));        
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

                       //echo "here one"; exit;

                 $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('college_id', $request->college_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id'); 

                 $all_amount_count_arr = $all_amount_count_data->get();
                 $all_amount_count = $all_amount_count_data->count();               

                 $all_pending_comm_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('fee_details.college_id', $request->college_id)->whereDate('fee_details.due_date', '>=', $start_date)->whereDate('fee_details.due_date', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission) as total_commission_pending"),DB::raw("sum(rec_commission) as total_rec_commission"))->groupBy('fee_details.college_id');

                 $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
                 $all_pending_comm_count = $all_pending_comm_count_data->count();

                 $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('course_fees_details.college_id', $request->college_id)->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id'); 

                 $all_pending_bonus_data = $all_pending_bonus->get();
                 $all_pending_bonus_data_count = $all_pending_bonus->count();

                 $all_bonus_data = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.college_id', $request->college_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

                 $all_bonus_count_arr = $all_bonus_data->get();
                 $all_bonus_count = $all_bonus_data->count();

                 $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('fee_details.college_id', $request->college_id)->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');

            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();
             }
             else
             {
                 //echo "here two"; exit;

                $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('college_id', $request->college_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id');  

                    $all_amount_count_arr = $all_amount_count_data->get();
                    $all_amount_count = $all_amount_count_data->count();

                $all_pending_comm_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('fee_details.office_id', $loggedin_office_id)->where('fee_details.college_id', $request->college_id)->whereDate('fee_details.due_date', '>=', $start_date)->whereDate('fee_details.due_date', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission) as total_commission_pending"),DB::raw("sum(rec_commission) as total_rec_commission"))->groupBy('fee_details.college_id');    

                    $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
                    $all_pending_comm_count = $all_pending_comm_count_data->count();

                $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('course_fees_details.office_id', $loggedin_office_id)->where('course_fees_details.college_id', $request->college_id)->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id');          

                $all_pending_bonus_data = $all_pending_bonus->get();
                $all_pending_bonus_data_count = $all_pending_bonus->count();

                $all_bonus_data = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->where('bonus_claim.college_id', $request->college_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

                $all_bonus_count_arr = $all_bonus_data->get();
                $all_bonus_count = $all_bonus_data->count();


                $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('fee_details.office_id', $loggedin_office_id)->where('fee_details.college_id', $request->college_id)->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');


            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();
            }

        }
        else
        {
            if($user_type == 1)
            {
                 //echo "here three"; exit;

                $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id');

                $all_amount_count_arr = $all_amount_count_data->get();
                $all_amount_count = $all_amount_count_data->count();

                $all_pending_comm_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->whereDate('fee_details.due_date', '>=', $start_date)->whereDate('fee_details.due_date', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission) as total_commission_pending"),DB::raw("sum(rec_commission) as total_rec_commission"))->groupBy('fee_details.college_id');

                $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
                $all_pending_comm_count = $all_pending_comm_count_data->count();

                $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name','colleges.id as college_id')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id');

                $all_pending_bonus_data = $all_pending_bonus->get();
                $all_pending_bonus_data_count = $all_pending_bonus->count();

                $all_bonus_data = DB::table('bonus_claim')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

                $all_bonus_count_arr = $all_bonus_data->get();
                $all_bonus_count = $all_bonus_data->count();


                $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');

            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();
            }
            else
            { 
                 //echo "here four"; exit;

                $all_amount_count_data = DB::table('fees_in_emi')->select('colleges.*','fees_in_emi.*')->leftJoin('colleges','fees_in_emi.college_id','=','colleges.id')->where('fees_in_emi.office_id', $loggedin_office_id)->where('is_commission_claimed', 1)->whereDate('fees_in_emi.updated_at', '>=', $start_date)->whereDate('fees_in_emi.updated_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission_received) as total_commission_received"))->groupBy('fees_in_emi.college_id');

                $all_amount_count_arr = $all_amount_count_data->get();
                $all_amount_count = $all_amount_count_data->count();


                $all_pending_comm_count_data = DB::table('fee_details')->select('colleges.*','fee_details.*')->leftJoin('colleges','fee_details.college_id','=','colleges.id')->where('fee_details.office_id', $loggedin_office_id)->whereDate('fee_details.due_date', '>=', $start_date)->whereDate('fee_details.due_date', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(commission) as total_commission_pending"),DB::raw("sum(rec_commission) as total_rec_commission"))->groupBy('fee_details.college_id');
                
                $all_pending_comm_count_arr = $all_pending_comm_count_data->get();
                $all_pending_comm_count = $all_pending_comm_count_data->count();

                $all_pending_bonus  = DB::table('course_fees_details')->select('course_fees_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'course_fees_details.college_id', '=', 'colleges.id')->where('fee_details.office_id', $loggedin_office_id)->where('is_bonus_applicable',1)->whereDate('course_fees_details.created_at', '>=', $start_date)->whereDate('course_fees_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus) as total_pending_bonus"),DB::raw("sum(bonus_claimed) as total_claimed_bonus"))->groupBy('course_fees_details.college_id');
                
                $all_pending_bonus_data = $all_pending_bonus->get();
                $all_pending_bonus_data_count = $all_pending_bonus->count();


                $all_bonus_data = DB::table('bonus_claimss')->select('colleges.*','bonus_claim.*')->leftJoin('colleges','bonus_claim.college_id','=','colleges.id')->where('bonus_claim.office_id', $loggedin_office_id)->whereDate('bonus_claim.created_at', '>=', $start_date)->whereDate('bonus_claim.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(bonus_claim.bonus_claimed) as total_bonus"))->groupBy('bonus_claim.college_id');

                $all_bonus_count_arr = $all_bonus_data->get();
                $all_bonus_count = $all_bonus_data->count();


                $all_discount  = DB::table('fee_details')->select('fee_details.*','colleges.college_trading_name as college_name')->leftJoin('colleges', 'fee_details.college_id', '=', 'colleges.id')->where('fee_details.office_id', $loggedin_office_id)->where('discount','!=','')->whereDate('fee_details.created_at', '>=', $start_date)->whereDate('fee_details.created_at', '<=', $end_date)->select('colleges.college_trading_name as college_office_name',DB::raw("sum(discount) as total_discount"))->groupBy('fee_details.college_id');

            $all_discount_data = $all_discount->get();
            $all_discount_count = $all_discount->count();

            }
        }
    }  

        //echo "<pre>"; print_r($all_amount_count_arr); exit;    

    return view('/admin/commission_ajax_report_page',compact('start_date','end_date','all_amount_count','all_amount_count_arr','all_bonus_count','all_bonus_count_arr','all_pending_comm_count','all_pending_comm_count_arr','all_pending_bonus_data_count','all_pending_bonus_data','all_discount_data','all_discount_count'));
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
    ->where('students.is_delete',0)
    ->groupBy('course_fees_details.campus_id')
    ->groupBy('course_fees_details.user_id')
    ->get();

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

    
 public function visa_expire(Request $request)
    {
        $date = date("Y-m-d",strtotime("+31 days"));
        $currdate = date("Y-m-d");
        $office_id =  Auth::user()->office_id;
        $id =  Auth::id();
        if($id == 1)
        {
            $visaExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.visa_expiry_date', '<=',$date)
            ->where('students.visa_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $visa_expiry_students = $visaExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.visa_follow_status', 2);                
            $q->whereDate('students.visa_snooze_date', '<',$currdate);            
            });            

            $visa_expiry_students = $visaExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            $visa_expiry_students_count = $visa_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();


            $close_visaExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.visa_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_visa_expiry_students_count = $close_visaExpireStudents->count();
            $close_visa_expiry_students = $close_visaExpireStudents->get();


             $snooze_visa_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.visa_snooze_date', '>=',$currdate)
            ->where('students.visa_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_visa_expiry_students_count = $snooze_visa_expiry_students->count();
            $snooze_visa_expiry_students = $snooze_visa_expiry_students->get();
        }
        else
        {
            $visaExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.visa_expiry_date', '<=',$date)
            ->where('students.visa_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $visa_expiry_students = $visaExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.visa_follow_status', 2);                
            $q->whereDate('students.visa_snooze_date', '<',$currdate);            
            });            

            $visa_expiry_students = $visaExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            $visa_expiry_students_count = $visa_expiry_students->count();
            $visa_expiry_students = $visa_expiry_students->get();


            $close_visaExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.visa_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_visa_expiry_students_count = $close_visaExpireStudents->count();
            $close_visa_expiry_students = $close_visaExpireStudents->get();


             $snooze_visa_expiry_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.visa_snooze_date', '>',$currdate)
            ->where('students.visa_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_visa_expiry_students_count = $snooze_visa_expiry_students->count();
            $snooze_visa_expiry_students = $snooze_visa_expiry_students->get();
        }                

        //echo "<pre>"; print_r($visa_expiry_students); exit;

     return view('admin/followup_visa_expire',compact('visa_expiry_students','visa_expiry_students_count','close_visa_expiry_students','snooze_visa_expiry_students'));
    }  


public function save_visa_expire_followup(Request $request)
{
    $added_from_id = Auth::id();
    $added_from_name = Auth::user()->first_name;

    if($request->follow_message != '')
    {
    DB::table('followup')->insert([
        'student_id' => $request->user_id,        
        'follow_message' => $request->follow_message,
        'follow_type' => 'visa_expiry_followup',
        'added_from_id' => $added_from_id,
        'added_from_name' => $added_from_name,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);
    }

    $message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','visa_expiry_followup')->where('follow_message','!=', '')->count();

    if($request->follow_status == 1)
        {
         DB::table('students')->where(['id'=>$request->user_id])->update(['visa_follow_status' => $request->follow_status,'visa_expire_msg_count' => $message_count,'close_by_id' =>$added_from_id,'close_by_name'=>$added_from_name,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('students')->where(['id'=>$request->user_id])->update(['visa_follow_status' => $request->follow_status,'visa_snooze_date'=> $request->snooze_calender,'visa_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }

        else if($request->follow_status == 3)
        {
            DB::table('students')->where(['id'=>$request->user_id])->update(['visa_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }

    return back()->with('success', 'Follow up message has been updated!');
    /*return redirect(route('visa_expire'))->with('success', 'Follow up message has been updated!');*/
}


    public function ajax_visa_expire_followup_data(Request $request)
    {
        $follow_message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','visa_expiry_followup')->count();

        if($follow_message_count > 0)
        {
            $count =1;
            $followup_data = '<div class="modal_table_class"><table id="user_list" class="">
            <thead>
            <tr>   
            <th width="10%">S.No.</th>
            <th width="50%">Followup Comments</th>
            <th width="20%">Added By</th>
            <th width="20%">Date</th>
            </tr>
            </thead>
            <tbody>';

            $message_data = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','visa_expiry_followup')->get(); 

            foreach ($message_data as $key => $get_followup_val)
            {
                $followup_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$get_followup_val->follow_message.'</td><td width="20%">'.$get_followup_val->added_from_name.'</td><td width="20%">'.$get_followup_val->created_at.'</td></tr>';
                $count++;
            }

            echo $followup_data.= '</tbody></table></div>';
        }
        else
        {
            echo $followup_data = '';
            exit;
        }  
    } 





    public function passport_expire(Request $request)
    {
        $date = date("Y-m-d",strtotime("+31 days"));
        $currdate = date("Y-m-d");
        $office_id =  Auth::user()->office_id;
        $id =  Auth::id();
        if($id == 1)
        {
            $passportExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.passport_expiry_date', '<=',$date)
            ->where('students.passport_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $passport_expiry_students = $passportExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.passport_follow_status', 2);                
            $q->whereDate('students.passport_snooze_date', '<',$currdate);            
            });            

            $passport_expiry_students = $passportExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            $passport_expiry_students_count = $passport_expiry_students->count();
            $passport_expiry_students = $passport_expiry_students->get();


            $close_passportExpireStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.passport_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_passport_expiry_students_count = $close_passportExpireStudents->count();
            $close_passport_expiry_students = $close_passportExpireStudents->get();


             $snooze_passport_expiry_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.passport_snooze_date', '>',$currdate)
            ->where('students.passport_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_passport_expiry_students_count = $snooze_passport_expiry_students->count();
            $snooze_passport_expiry_students = $snooze_passport_expiry_students->get();
        }
        else
        {
            $passportExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->whereDate('students.passport_expiry_date', '<=',$date)
            ->where('students.passport_follow_status', 0)
            ->leftJoin('users','students.user_id','=','users.id');

            $passport_expiry_students = $passportExpireStudents->orwhere(function($q) use ($currdate){  
            $q->orwhere('students.passport_follow_status', 2);                
            $q->whereDate('students.passport_snooze_date', '<',$currdate);            
            });            

            $passport_expiry_students = $passportExpireStudents->orderBy('students.id', 'DESC')->groupBy('students.id');

            $passport_expiry_students_count = $passport_expiry_students->count();
            $passport_expiry_students = $passport_expiry_students->get();


            $close_passportExpireStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')
            ->where('students.passport_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_passport_expiry_students_count = $close_passportExpireStudents->count();
            $close_passport_expiry_students = $close_passportExpireStudents->get();


             $snooze_passport_expiry_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid')            
            ->whereDate('students.passport_snooze_date', '>=',$currdate)
            ->where('students.passport_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_passport_expiry_students_count = $snooze_passport_expiry_students->count();
            $snooze_passport_expiry_students = $snooze_passport_expiry_students->get();
        }

     return view('admin/followup_passport_expire',compact('passport_expiry_students','passport_expiry_students_count','close_passport_expiry_students','snooze_passport_expiry_students'));
    }  


public function save_passport_expire_followup(Request $request)
{
    $added_from_id = Auth::id();
    $added_from_name = Auth::user()->first_name;
    if($request->follow_message != '')
    {
    DB::table('followup')->insert([
        'student_id' => $request->user_id,        
        'follow_message' => $request->follow_message,
        'follow_type' => 'passport_expiry_followup',
        'added_from_id' => $added_from_id,
        'added_from_name' => $added_from_name,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);
    }
    $message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','passport_expiry_followup')->where('follow_message','!=', '')->count();

    if($request->follow_status == 1)
        {
         DB::table('students')->where(['id'=>$request->user_id])->update(['passport_follow_status' => $request->follow_status,'passport_expire_msg_count' => $message_count,'close_by_id' =>$added_from_id,'close_by_name'=>$added_from_name,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('students')->where(['id'=>$request->user_id])->update(['passport_follow_status' => $request->follow_status,'passport_snooze_date'=> $request->snooze_calender,'passport_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }

        else if($request->follow_status == 3)
        {
            DB::table('students')->where(['id'=>$request->user_id])->update(['passport_expire_msg_count' => $message_count,'updated_at'=> now()]);   
        }
         return back()->with('success', 'Follow up message has been updated!');
    //return redirect(route('passport_expire'))->with('success', 'Follow up message has been updated!');
}


    public function ajax_passport_expire_followup_data(Request $request)
    {
        $follow_message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','passport_expiry_followup')->count();

        if($follow_message_count > 0)
        {
            $count =1;
            $followup_data = '<div class="modal_table_class"><table id="user_list" class="">
            <thead>
            <tr>   
            <th width="10%">S.No.</th>
            <th width="50%">Followup Comments</th>
            <th width="20%">Added By</th>
            <th width="20%">Date</th>
            </tr>
            </thead>
            <tbody>';

            $message_data = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','passport_expiry_followup')->get(); 

            foreach ($message_data as $key => $get_followup_val)
            {
                $followup_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$get_followup_val->follow_message.'</td><td width="20%">'.$get_followup_val->added_from_name.'</td><td width="20%">'.$get_followup_val->created_at.'</td></tr>';
                $count++;
            }

            echo $followup_data.= '</tbody></table></div>';
        }
        else
        {
            echo $followup_data = '';
            exit;
        }  
    } 


public function fees_due(Request $request)
    {
        $date = date("Y-m-d",strtotime("+31 days"));
        //$date = date("Y-m-d",strtotime("+31 days"));
        $currdate = date("Y-m-d");
        $office_id =  Auth::user()->office_id;
        $id =  Auth::id();
        if($id == 1)
        {

            $open_feesdue_students = DB::table('students')->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where('fee_details.status','!=', 1)        
        ->where('course_fees_details.fees_due_follow_status',0);

        $feesdue_students_list = $open_feesdue_students->where(function($q) use ($currdate,$date) {
            $q->whereDate('fee_details.due_date', '<=',$date);
            $q->where('course_fees_details.current_college_course', 1);            
            });

         $feesdue_students_list = $open_feesdue_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.fees_due_follow_status', 2);                
            $q->whereDate('course_fees_details.fees_due_snooze_date', '<',$currdate);            
            });   

       $fees_duedate_students = $feesdue_students_list->orderBy('due_date', 'ASC')->groupBy('students.id');            
//       $fees_duedate_students_count = $fees_duedate_students->count();            
       $fees_duedate_students = $fees_duedate_students->get();
       $fees_duedate_students_count = count($fees_duedate_students);

       //echo $fees_duedate_students_count; exit;


            $close_fees_duedateStudents = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
            ->where('course_fees_details.fees_due_follow_status', 1)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id')            
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_fees_duedate_students_count = $close_fees_duedateStudents->count();
            $close_fees_duedate_students = $close_fees_duedateStudents->get();


             $snooze_fees_duedate_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')            
            ->whereDate('course_fees_details.fees_due_snooze_date', '>',$currdate)
            ->where('course_fees_details.fees_due_follow_status', 2)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id') 
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_fees_duedate_students_count = $snooze_fees_duedate_students->count();
            $snooze_fees_duedate_students = $snooze_fees_duedate_students->get();
        }
        else
        {
            $open_feesdue_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','fee_details.due_date as fee_due_date','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('fee_details.status','!=', 1)
        ->where('students.is_delete', 0)
        ->where('course_fees_details.fees_due_follow_status',0);

        $feesdue_students_list = $open_feesdue_students->where(function($q) use ($currdate,$date) {
            $q->whereDate('fee_details.due_date', '<=',$date);
            $q->where('course_fees_details.current_college_course', 1);            
            });

         $feesdue_students_list = $open_feesdue_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.fees_due_follow_status', 2);                
            $q->whereDate('course_fees_details.fees_due_snooze_date', '<',$currdate);            
            });   

       $fees_duedate_students = $feesdue_students_list->orderBy('due_date', 'ASC')->groupBy('students.id');            
       $fees_duedate_students_count = $fees_duedate_students->count();            
       $fees_duedate_students = $fees_duedate_students->get();



            $close_fees_duedateStudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')
            ->where('course_fees_details.fees_due_follow_status', 1)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id')             
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_fees_duedate_students_count = $close_fees_duedateStudents->count();
            $close_fees_duedate_students = $close_fees_duedateStudents->get();


             $snooze_fees_duedate_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id','fee_details.due_date as fee_due_date')            
            ->whereDate('course_fees_details.fees_due_snooze_date', '>',$currdate)
            ->where('course_fees_details.fees_due_follow_status', 2)
            ->leftJoin('fee_details','students.id','=','fee_details.student_id')            
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_fees_duedate_students_count = $snooze_fees_duedate_students->count();
            $snooze_fees_duedate_students = $snooze_fees_duedate_students->get();
        }

        //echo "<pre>"; print_r($fees_duedate_students); exit;

     return view('admin/followup_fees_due',compact('fees_duedate_students','fees_duedate_students_count','close_fees_duedate_students','close_fees_duedate_students_count','snooze_fees_duedate_students','snooze_fees_duedate_students_count'));
    }  


public function save_fees_due_followup(Request $request)
{
    $added_from_id = Auth::id();
    $added_from_name = Auth::user()->first_name;
    if($request->follow_message != '')
    {
    DB::table('followup')->insert([
        'student_id' => $request->user_id,        
        'course_fee_detail_id' => $request->cfd_id,        
        'follow_message' => $request->follow_message,
        'follow_type' => 'fees_due_followup',
        'added_from_id' => $added_from_id,
        'added_from_name' => $added_from_name,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);
    }

    $message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','fees_due_followup')->where('follow_message','!=', '')->count();

    if($request->follow_status == 1)
        {
         DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['fees_due_follow_status' => $request->follow_status,'close_by_id' =>$added_from_id,'close_by_name'=>$added_from_name,'fees_due_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['fees_due_follow_status' => $request->follow_status,'fees_due_snooze_date'=> $request->snooze_calender,'fees_due_msg_count' => $message_count,'updated_at'=> now()]);   
        }

        else if($request->follow_status == 3)
        {
            DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['fees_due_msg_count' => $message_count,'updated_at'=> now()]);   
        }

         return back()->with('success', 'Follow up message has been updated!');

    //return redirect(route('fees_due'))->with('success', 'Follow up message has been updated!');
}


    public function ajax_fees_due_followup_data(Request $request)
    {
        $follow_message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','fees_due_followup')->count();

        if($follow_message_count > 0)
        {
            $count =1;
            $followup_data = '<div class="modal_table_class"><table id="user_list" class="">
            <thead>
            <tr>   
            <th width="10%">S.No.</th>
            <th width="50%">Followup Comments</th>
            <th width="20%">Added By</th>
            <th width="20%">Date</th>
            </tr>
            </thead>
            <tbody>';

            $message_data = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','fees_due_followup')->get(); 

            foreach ($message_data as $key => $get_followup_val)
            {
                $followup_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$get_followup_val->follow_message.'</td><td width="20%">'.$get_followup_val->added_from_name.'</td><td width="20%">'.$get_followup_val->created_at.'</td></tr>';
                $count++;
            }

            echo $followup_data.= '</tbody></table></div>';
        }
        else
        {
            echo $followup_data = '';
            exit;
        }  
    } 


/*Course Completion Start here*/

    public function course_completion(Request $request)
    {
        $date = date("Y-m-d",strtotime("+31 days"));
        $currdate = date("Y-m-d");
        $office_id =  Auth::user()->office_id;
        $id =  Auth::id();
        if($id == 1)
        {

            $open_course_completion_students = DB::table('students')    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
           
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where('course_fees_details.course_complete_follow_status',0);

        $course_completion_students_list = $open_course_completion_students->where(function($q) use ($currdate,$date) {
            $q->where('course_fees_details.current_college_course', 1);
            });

         $course_completion_students_list = $open_course_completion_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.course_complete_follow_status', 2);                
            $q->whereDate('course_fees_details.course_complete_snooze_date', '<',$currdate);            
            });   

       $course_completion_students = $course_completion_students_list->orderBy('course_fees_details.course_completion_date', 'ASC')->groupBy('students.id');            
       $course_completion_students_count = $course_completion_students->count();            
       $course_completion_students = $course_completion_students->get();



            $close_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
            ->where('course_fees_details.course_complete_follow_status', 1)  
            ->where('course_fees_details.current_college_course', 1)          
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_course_completion_students_count = $close_course_completion_students->count();
            $close_course_completion_students = $close_course_completion_students->get();


             $snooze_course_completion_students = DB::table('students')->where('students.is_delete', 0)
            ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')            
            ->whereDate('course_fees_details.course_complete_snooze_date', '>',$currdate)
            ->where('course_fees_details.course_complete_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->where('course_fees_details.current_college_course', 1)
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_course_completion_students_count = $snooze_course_completion_students->count();
            $snooze_course_completion_students = $snooze_course_completion_students->get();
        }
        else
        {
            $open_course_completion_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)    
        ->select('students.*','course_fees_details.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
        ->leftJoin('fee_details','students.id','=','fee_details.student_id')        
        ->leftJoin('users','students.user_id','=','users.id')
        ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
        ->where('students.is_delete', 0)
        ->where('course_fees_details.course_complete_follow_status',0);

        $courseCompletionStudents = $open_course_completion_students->where(function($q) use ($currdate,$date) {
            $q->whereDate('course_fees_details.course_completion_date', '<=',$date);
            $q->where('course_fees_details.current_college_course', 1);            
            });

         $courseCompletionStudents = $open_course_completion_students->orwhere(function($q) use ($currdate){  
            $q->orwhere('course_fees_details.course_complete_follow_status', 2);                
            $q->whereDate('course_fees_details.course_complete_snooze_date', '<',$currdate);            
            });   

       $course_completion_students = $courseCompletionStudents->orderBy('course_fees_details.course_completion_date', 'ASC')->groupBy('students.id');            
       $course_completion_students_count = $course_completion_students->count();            
       $course_completion_students = $course_completion_students->get();



            $close_course_completionstudents = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')
            ->where('course_fees_details.course_complete_follow_status', 1)            
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')->groupBy('students.id');

            $close_course_completion_students_count = $close_course_completionstudents->count();
            $close_course_completion_students = $close_course_completionstudents->get();


             $snooze_course_completion_students = DB::table('students')->where(['students.office_id'=>$office_id])->where('students.is_delete', 0)
            ->select('students.*','users.first_name as staff_name','students.id as stid','course_fees_details.id as cfd_id')            
            ->whereDate('course_fees_details.course_complete_snooze_date', '>',$currdate)
            ->where('course_fees_details.course_complete_follow_status', 2)
            ->leftJoin('users','students.user_id','=','users.id')
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->orderBy('students.id', 'DESC')
            ->groupBy('students.id');   

            $snooze_course_completion_students_count = $snooze_course_completion_students->count();
            $snooze_course_completion_students = $snooze_course_completion_students->get();
        }

        //echo "<pre>"; print_r($fees_duedate_students); exit;

     return view('admin/followup_course_completion',compact('course_completion_students','course_completion_students_count','close_course_completion_students','close_course_completion_students_count','snooze_course_completion_students','snooze_course_completion_students_count'));
    }  


public function save_course_completion_followup(Request $request)
{
    $added_from_id = Auth::id();
    $added_from_name = Auth::user()->first_name;
if($request->follow_message != '')
    {
    DB::table('followup')->insert([
        'student_id' => $request->user_id,        
        'course_fee_detail_id' => $request->cfd_id,        
        'follow_message' => $request->follow_message,
        'follow_type' => 'course_completion_followup',
        'added_from_id' => $added_from_id,
        'added_from_name' => $added_from_name,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);
    }
    $message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','course_completion_followup')->where('follow_message','!=', '')->count();

    if($request->follow_status == 1)
        {
         DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['course_complete_follow_status' => $request->follow_status,'close_by_id' =>$added_from_id,'close_by_name'=>$added_from_name,'course_complete_msg_count' => $message_count,'updated_at'=> now()]);
        }
        else if($request->follow_status == 2)
        {
            DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['course_complete_follow_status' => $request->follow_status,'course_complete_snooze_date'=> $request->snooze_calender,'course_complete_msg_count' => $message_count,'updated_at'=> now()]);   
        }

        else if($request->follow_status == 3)
        {
            DB::table('course_fees_details')->where(['id'=>$request->cfd_id])->update(['course_complete_msg_count' => $message_count,'updated_at'=> now()]);   
        }
         return back()->with('success', 'Follow up message has been updated!');

    //return redirect(route('course_completion'))->with('success', 'Follow up message has been updated!');
}


    public function ajax_course_completion_followup_data(Request $request)
    {
        $follow_message_count = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','course_completion_followup')->count();

        if($follow_message_count > 0)
        {
            $count =1;
            $followup_data = '<div class="modal_table_class"><table id="user_list" class="">
            <thead>
            <tr>   
            <th width="10%">S.No.</th>
            <th width="50%">Followup Comments</th>
            <th width="20%">Added By</th>
            <th width="20%">Date</th>
            </tr>
            </thead>
            <tbody>';

            $message_data = DB::table('followup')->where('student_id',$request->user_id)->where('follow_type','course_completion_followup')->get(); 

            foreach ($message_data as $key => $get_followup_val)
            {
                $followup_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$get_followup_val->follow_message.'</td><td width="20%">'.$get_followup_val->added_from_name.'</td><td width="20%">'.$get_followup_val->created_at.'</td></tr>';
                $count++;
            }

            echo $followup_data.= '</tbody></table></div>';
        }
        else
        {
            echo $followup_data = '';
            exit;
        }  
    } 

 public function admin_tasks(Request $request)
    {
        $id = Auth::id();
        $currentdate = date('Y-m-d');

        if($id = 1)
        {
        $get_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.is_delete', 0);

        $get_tasks = $get_tasks->where(function($q) use ($currentdate) {
            $q->orwhere('tasks.status', 1);
            $q->orwhereDate('tasks.status', 2);
            $q->whereDate('tasks.snooze_date', '<=',$currentdate);
            });

        $get_tasks = $get_tasks->get();

        $get_snoozed_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.is_delete', 0)->where('tasks.status', 2)->whereDate('tasks.snooze_date', '>',$currentdate)->orderBy('tasks.id','desc')->get();
        
        $get_closed_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.is_delete', 0)->where('tasks.status',3)->orderBy('tasks.id','desc')->get();  
        }
        else
        {
            $get_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.office_id', $id)->where('tasks.is_delete', 0);

            $get_tasks = $get_tasks->where(function($q) use ($currentdate) {
                $q->orwhere('tasks.status', 1);
                $q->orwhereDate('tasks.status', 2);
                $q->whereDate('tasks.snooze_date', '<=',$currentdate);
            });

            $get_tasks = $get_tasks->get();

            $get_snoozed_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.office_id', $id)->where('tasks.is_delete', 0)->where('tasks.status', 2)->whereDate('tasks.snooze_date', '>',$currentdate)->orderBy('tasks.id','desc')->get();

            $get_closed_tasks = DB::table('tasks')->select('tasks.*','offices.name as office_name')->leftJoin('offices','tasks.office_id','=','offices.id')->where('tasks.office_id', $id)->where('tasks.is_delete', 0)->where('tasks.status',3)->orderBy('tasks.id','desc')->get(); 
        }     

        //echo "<pre>"; print_r($get_tasks); exit;

        return view('/admin/tasks', compact('get_tasks','get_closed_tasks','get_snoozed_tasks'));
    }


    public function add_task(Request $request)
    {
        $user_id = Auth::id();
        $user_type = Auth::user()->type;
        $offices = DB::table('offices')->where('status',1)->where('is_delete',0)->get(); 
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'task_name' => 'required',
                'office_id' => 'required',
                'task' => 'required',
                'task_date' => 'required',

            ]);

            $add = DB::table('tasks')->insert([
            'task_name' => $request->task_name,
            'office_id' => $request->office_id,
            'created_by' => $request->user_id,
            'task' => $request->task,
            'task_date' =>  date('Y-m-d',strtotime($request->task_date)),
            'staff_name' => $request->staff_name,
            'status' => 1,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

            return redirect('admin/admin_tasks')->with('success', 'task Successfully Added');
        }    
        return view('/admin/add_task',compact('offices'));
    }


    public function edit_task(Request $request,$id=0)
    {
        $user_id = Auth::id();
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        $offices = DB::table('offices')->where('status',1)->where('is_delete',0)->get(); 
        $task_list = DB::table('tasks')->where('id',$id)->where('is_delete',0)->first(); 
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'task_name' => 'required',
                'office_id' => 'required',
                'task' => 'required',
                'task_date' => 'required',

            ]);
/*
             DB::table('tasks')->where(['id'=>$request->task_id])->update(['status' => $request->status_task_update_type,'updated_at'=> now()]);*/

            $edit = DB::table('tasks')->where(['id'=>$request->task_id])->update([
            'task_name' => $request->task_name,
            'task' => $request->task,
            'office_id' => $request->office_id,
            'status' => $request->status,
            'task_date' =>  date('Y-m-d',strtotime($request->task_date)),
            'staff_name' => $request->staff_name,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

            return redirect('admin/admin_tasks')->with('success', 'task Successfully Updated');
        }    
        return view('/admin/edit_task',compact('offices','task_list'));
    }


    public function add_task_comments(Request $request)
    {
            $added_from_id = Auth::id();
            $added_from_name = Auth::user()->first_name;

    DB::table('task_comments')->insert([
        'task_id' => $request->task_id,        
        'user_id' => $request->office_id,        
        'comment' => $request->comment,
        'added_from_id' => $added_from_id,
        'added_from_name' => $added_from_name,
        'updated_at' => NOW(),
        'created_at' => NOW()
    ]);


/*echo $request->status_task_update_type; exit;*/

    if($request->status_task_update_type == 1)
        {
         DB::table('tasks')->where(['id'=>$request->task_id])->update(['status' => $request->status_task_update_type,'updated_at'=> now()]);
        }
        else if($request->status_task_update_type == 2)
        {
            DB::table('tasks')->where(['id'=>$request->task_id])->update(['status' => $request->status_task_update_type,'snooze_date'=> $request->snooze_date,'is_snoozed'=> 1,'updated_at'=> now()]);   
        }

        else if($request->status_task_update_type == 3)
        {
            DB::table('tasks')->where(['id'=>$request->task_id])->update(['status' => $request->status_task_update_type,'updated_at'=> now()]);   
        }

    return redirect(route('admin_tasks'))->with('success', 'Task Comments has been updated!');
    }

    public function task_delete(Request $request,$id)
    {
        $id = base64_decode($id);
        DB::table('tasks')->where(['id'=>$id])->update(['is_delete' => 1,'updated_at'=> now()]); 
        return redirect(route('admin_tasks'))->with('success', 'Task Comments has been Removed!');   
    }


    public function ajax_task_comment_data(Request $request)
    {
         $comment_count = DB::table('task_comments')->where(['task_id'=>$request->task_id])->count();

         if($comment_count > 0)
    {
    $count =1;
        $comment_data = '<div class="modal_table_class"><table id="user_list" class="">
                                                    <thead>
                                                        <tr>   
                                                            <th width="10%">S.No.</th>
                                                            <th width="50%">Comments</th>
                                                            <th width="20%">Added By</th>
                                                            <th width="20%">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

       $comment = DB::table('task_comments')->where('comment','!=','')->where(['task_id'=>$request->task_id])->get();

        foreach ($comment as $key => $comment_val)
        {
          $comment_data.= '<tr><td width="10%">'.$count.'</td><td width="50%">'.$comment_val->comment.'</td><td width="50%">'.$comment_val->added_from_name.'</td><td width="20%">'.$comment_val->created_at.'</td></tr>';
          $count++;
        }        

        echo $comment_data.= '</tbody></table></div>';
    }
    else
    {
       echo $comment_data = '';
        exit;
     }

    }    


    public function fees_reciept(Request $request)
    {
        $course_id = $request->course_id;
        $college_id = $request->college_id;
        $student_id = $request->student_id;
        $fee_id = $request->fee_id;

        $get_stdata = DB::table('students')->where('id',$student_id)->first(); 
        $college_data = DB::table('colleges')->where('id',$college_id)->first(); 
        $course_data = DB::table('courses')->where('id',$course_id)->first(); 
        $fee_data = DB::table('fee_details')->where('id',$fee_id)->first(); 

//echo "<pre>"; print_r($college_data); exit;


$mail = new PHPMailer;
$mail->isSMTP(); /*make commented on live sever*/     // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'satyendra.arrj@gmail.com';                 // SMTP username
$mail->Password = 'ouawdioknoocemxy';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'info@arrjdemo.in';
$mail->FromName = 'Mailer';
$mail->addAddress('satyendra.arrj@gmail.com', $get_stdata->first_name);     // Add a recipient
//$mail->addAddress('abhi.arrj@gmail.com');               // Name is optional
//$mail->addAddress('vishal@programmates.com');               // Name is optional
//$mail->addReplyTo('vishal.arrj@gmail.com', 'Information');
/*$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');*/

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Fees Reciept';
$mail->Body    = 'Hi '.$get_stdata->first_name.'<br> Kindly find the payment receipt of your course'.$course_data->course_name.'<br> College name : '.$college_data->college_trading_name.'<br> Amount recived is : '.$fee_data->received_amount;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 1;
    exit;
}

    }



public function referal_list(Request $request)
    {
        $referal_list = DB::table('referrals')->get();
        return view('/admin/referal_list',compact('referal_list'));
    }


     public function all_referral_student(Request $request, $id=0)
    {
        $id = base64_decode($id);
        $referal_list = DB::table('referrals')->where('id',$id)->first();

        $refferal_name = $referal_list->name;

        $referal_student_list = DB::table('students')->where('other_referral',$id)->where('is_delete',0)->orderBy('created_at','desc')->get();

        return view('/admin/all_referral_student',compact('referal_student_list','refferal_name'));
    }



public function add_refferals(Request $request)
    {
        $user_id = Auth::id();
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'name' => 'required',
            ]);

            $add = DB::table('referrals')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

            return redirect('admin/referal_list')->with('success', 'Referrals Successfully Added');
        }    
        return view('/admin/add_refferals');
    }


    public function edit_refferals(Request $request,$id=0)
    {
        $user_id = Auth::id();
        $id = base64_decode($id);

        $referrals_data = DB::table('referrals')->where('id',$id)->first(); 
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'name' => 'required',
            ]);

            $edit = DB::table('referrals')->where(['id'=>$request->id])->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => NOW(),
            'created_at' => NOW(),
        ]);

            return redirect('admin/referal_list')->with('success', 'Referrals Successfully Updated');
        }    
        return view('/admin/edit_refferals',compact('referrals_data'));
    }

    

    public function ajax_show_commission(Request $request)
    {
        $referrals_data_count = DB::table('referral_commission')->where('referral_id',$request->referral_id)->where('student_id',$request->student_id)->count();
        $referrals_data = DB::table('referral_commission')->where('referral_id',$request->referral_id)->where('student_id',$request->student_id)->get();

        $referrals_info = DB::table('referrals')->where('id',$request->referral_id)->first();

        $total_commission = DB::table('referral_commission')->where('referral_id',$request->referral_id)->where('student_id',$request->student_id)->sum('commission');


        $count =1;
        if($referrals_data_count > 0)
        {
        $referralsData = '<div class="modal_table_class"><table id="user_list" class="">
                                                    <thead>
                                                        <tr>   
                                                            <th width="10%">S.No.</th>
                                                            <th width="20%">Price</th>
                                                            <th width="50%">Comments</th>
                                                            <th width="20%">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

      

        foreach ($referrals_data as $key => $referrals_data_val)
        {
          $referralsData.= '<tr><td width="10%">'.$count.'</td><td width="20%">'.$referrals_data_val->commission.'</td><td width="50%">'.$referrals_data_val->comment.'</td><td width="20%">'. date('d-m-Y h:i:s', strtotime($referrals_data_val->created_at)).'</td></tr>';
          $count++;
        }
        

        $referralsData.= '</tbody></table></div>';

        $return["referralsData"] = $referralsData;
        $return["total_commission"] = $total_commission;
        $return["referrals_name"] = $referrals_info->name;

          echo json_encode($return); die();
        
    }
    else
    {
       $return["referralsData"] = $referralsData;
        $return["total_commission"] = $total_commission;
        $return["referrals_name"] = $referrals_info->name;

          echo json_encode($return); die();
    }

    }


    public function save_referral_commission(Request $request)
    {
    
    $given_by_id = Auth::id();
    $given_by_name = Auth::user()->first_name;
      
            request()->validate(
             [
                'commission' => 'required',
            ]);

            $add = DB::table('referral_commission')->insert([
            'commission' => $request->commission,
            'comment' => $request->commission_message,
            'student_id' => $request->student_id,
            'referral_id' => $request->referral_id,
            'given_by_id' => $given_by_id,
            'given_by_name' => $given_by_name,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);
            return back()->with('success','Referrals commission Successfully Added');
            /*return redirect('admin/referal_list')->with('success', 'Referrals commission Successfully Added');*/
        } 
   

        public function ajax_task_read_unread(Request $request)
        {
            $edit = DB::table('tasks')->where(['id'=>$request->task_id])->update(['is_read' => $request->is_read,'updated_at' => NOW()]);
        }

        public function ajax_student_read_unread(Request $request)
        {
            $edit = DB::table('students')->where(['id'=>$request->student_id])->update(['is_read' => $request->is_read,'updated_at' => NOW()]);
        }  


        public function ajax_client_notes_read_unread(Request $request)
              {
                $edit = DB::table('students')->where(['id'=>$request->student_id])->update(['is_read_client_notes' => $request->type,'updated_at' => NOW()]);

                echo $request->type;
                exit;
              }      


              public function payment_proof(Request $request,$id=0)
              {            
                $get_imgs = DB::table('fee_details')->where(['id'=>$id])->first();

                $img_Arr = explode(',', $get_imgs->payment_proof);

                foreach ($img_Arr as $key => $img_Arr_val)
                {
                    $filepath[] = public_path('payment/').$img_Arr_val;
                }

                $tmpFile = tempnam(sys_get_temp_dir(), 'data');

                $zip = new ZipArchive;
                $zip->open($tmpFile, ZipArchive::CREATE);
                foreach ($filepath as $file) {

                    $fileContent = file_get_contents($file);

                    $zip->addFromString(basename($file), $fileContent);
                }
                $zip->close();

                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=file.zip');
                header('Content-Length: ' . filesize($tmpFile));
                readfile($tmpFile);
                unlink($tmpFile);

            }



public function event_list(Request $request)
{
       $event_list = DB::table('events')->get();
       return view('/admin/event_list', compact('event_list'));  
}

public function add_event(Request $request)
    {
        $user_id = Auth::id();        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'event_title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $add = DB::table('events')->insert([
            'event_title' => $request->event_title,
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

            return redirect('admin/event_list')->with('success', 'Event Successfully Added');
        }    
        return view('/admin/add_event');
    }


    public function edit_event(Request $request,$id=0)
    {
        $user_id = Auth::id();
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        $event_list = DB::table('events')->where('id',$id)->first(); 
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'event_title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);


            $edit = DB::table('events')->where(['id'=>$request->event_id])->update([
            'event_title' => $request->event_title,
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'updated_at' => NOW(),

        ]);

            return redirect('admin/event_list')->with('success', 'Event Successfully Updated');
        }    
        return view('/admin/edit_event',compact('event_list'));
    }


     public function event_delete(Request $request,$id=0)
    {
        $id = base64_decode($id);
        DB::table('events')->where(['id'=>$id])->delete(); 
        return redirect('admin/event_list')->with('success', 'Event Successfully Updated');
    }

    public function event_calendar()
    {
        
       $event_list = DB::table('events')->get();
       return view('/admin/event_calendar', compact('event_list'));
    }




    public function other_service(Request $request)
{
       $service_list = DB::table('other_services')->get();
       return view('/admin/other_services/service_list', compact('service_list'));  
}

public function add_service(Request $request)
    {
        $user_id = Auth::id();        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'service_name' => 'required',
            ]);

            $add = DB::table('other_services')->insert([
            'service_name' => $request->service_name,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

            return redirect('/admin/other_services/service_list')->with('success', 'Services Successfully Added');
        }    
        return view('/admin/other_services/add_service');
    }


    public function edit_service(Request $request,$id=0)
    {
        $user_id = Auth::id();
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        $service_list = DB::table('other_services')->where('id',$id)->first(); 
        
        if($request->all()!=null)
        {
            request()->validate(
             [
                'service_name' => 'required',
            ]);


            $edit = DB::table('other_services')->where(['id'=>$request->service_id])->update([
            'service_name' => $request->service_name,
            'updated_at' => NOW(),

        ]);

            return redirect('/admin/other_services/service_list')->with('success', 'Services Successfully Updated');
        }    
        return view('/admin/other_services/edit_service',compact('service_list'));
    }


     public function service_delete(Request $request,$id=0)
    {
        $id = base64_decode($id);

        $data_count = DB::table('miscellaneous_income')->where(['other_services'=>$id])->count(); 
        if($data_count > 0)
        {
            return redirect('/admin/other_services/service_list')->with('warning', 'Thid service will not delete due to some data is existed in records of this service. First delete miscellaneous income.');
        }
        else
        {
        DB::table('other_services')->where(['id'=>$id])->delete(); 
        return redirect('/admin/other_services/service_list')->with('success', 'Services Successfully Deleted');
        }
    }

    public function miscellaneous_income(Request $request)
    {
        //$miscellaneous_income_list = DB::table('miscellaneous_income')->get();

        $miscellaneous_income_list  = DB::table('miscellaneous_income')
        ->select('miscellaneous_income.*','other_services.id as service_id','other_services.service_name as servicename')
        ->join('other_services','miscellaneous_income.other_services','=','other_services.id')
        ->orderBy('id','desc')->get();

        return view('/admin/miscellaneous_income/index', compact('miscellaneous_income_list'));  
    }


    public function add_miscellaneous_income(Request $request)
    {   
        $office_id = Auth::id();
        $countries = DB::table('countries')->get();
        $referrals_list  = DB::table('referrals')->get();
        $colleges = DB::table('colleges')->get();
        $other_services = DB::table('other_services')->get();
        if($request->all()!=null)
        {

            $img = '';
            if($request->hasFile('invoice'))
            {
                $payment_proof = $request->file('invoice');
                $img = time() . '.' . $payment_proof->getClientOriginalExtension();

                $destinationPath = public_path('/miscellaneous');
                $payment_proof->move($destinationPath, $img);
            }


            request()->validate(
             [
                'first_name' => 'required',
                'address' => 'required',
                'country' => 'required',
                'gender' => 'required',
                'email' => 'required',
                'whatsapp' => 'required',
                'other_services' => 'required',
                'income' => 'required',
                'total_recieve' => 'required',
            ]);

            $add = DB::table('miscellaneous_income')->insert([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'country_name' => $request->country,
            'gender' => $request->gender,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'whatsapp_flag' => $request->whatsapp_flag,
            'whatsapp_dialcode' => $request->whatsapp_dialcode,
            'other_services' => $request->other_services,
            'income' => $request->income,
            'total_recieve' => $request->total_recieve,
            'invoice' => $img,
            'office_id' => $office_id,
            'updated_at' => NOW(),
            'created_at' => NOW(),
        ]);

            return redirect('/admin/miscellaneous_income/index')->with('success', 'Services Successfully Added');
        }    

        return view('/admin/miscellaneous_income/add_miscellaneous_income', compact('countries','referrals_list','colleges','other_services'));   
    }


    public function edit_miscellaneous_income(Request $request,$id=0)
    {
        //echo "<pre>"; print_r($request->all()); exit;
        $office_id = Auth::id();
        $countries = DB::table('countries')->get();
        $referrals_list  = DB::table('referrals')->get();
        $colleges = DB::table('colleges')->get();
        $get_miscellaneous_income = DB::table('miscellaneous_income')->where('id',$id)->first();
        $other_services = DB::table('other_services')->get();


        if($request->all()!=null)
        {            
            request()->validate(
             [
                'first_name' => 'required',
                'address' => 'required',
                'country' => 'required',
                'gender' => 'required',
                'email' => 'required',
                'whatsapp' => 'required',             
                'other_services' => 'required',
                'income' => 'required',
                'total_recieve' => 'required',
            ]);

            $img = '';
            if($request->hasFile('invoice'))
            {
                $payment_proof = $request->file('invoice');
                $img = time() . '.' . $payment_proof->getClientOriginalExtension();

                $destinationPath = public_path('/miscellaneous');
                $payment_proof->move($destinationPath, $img);
            }

            $add = DB::table('miscellaneous_income')->where(['id'=>$request->miscellaneous_income_id])->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'country_name' => $request->country,
            'gender' => $request->gender,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'whatsapp_flag' => $request->whatsapp_flag,
            'whatsapp_dialcode' => $request->whatsapp_dialcode,
            'other_services' => $request->other_services,
            'income' => $request->income,
            'total_recieve' => $request->total_recieve,
            'invoice' => $img,
            'office_id' => $office_id,
            'updated_at' => NOW(),
            'created_at' => NOW(),
        ]);

            return redirect('/admin/miscellaneous_income/index')->with('success', 'Services Successfully Added');
        }
        return view('/admin/miscellaneous_income/edit_miscellaneous_income', compact('countries','get_miscellaneous_income','referrals_list','other_services','colleges'));  
    }

      public function delete_miscellaneous_income(Request $request,$id=0)
    {
        DB::table('miscellaneous_income')->where(['id'=>$id])->delete(); 
        return redirect('/admin/miscellaneous_income/index')->with('success', 'Miscellaneous Income Successfully Deleted');
    }


    public function miscellaneous_income_report(Request $request)
    {
        $all_amount_count = 0;
        $start_date = date("Y-m-d",strtotime('-31 days'));
        $end_date = date('Y-m-d');
        $office = '';
        $all_amount_count_arr = array();
        $other_services = DB::table('other_services')->get();

        $user_type = Auth::user()->type;

        $loggedin_office_id = Auth::user()->office_id;

        if($user_type == 1)
        {        

            $all_income_count_data = DB::table('miscellaneous_income')->select('other_services.*','miscellaneous_income.*')->leftJoin('other_services','miscellaneous_income.other_services','=','other_services.id')->whereDate('miscellaneous_income.updated_at', '>=', $start_date)->whereDate('miscellaneous_income.updated_at', '<=', $end_date)->select('other_services.service_name as services_name',DB::raw("sum(total_recieve) as recieved_amount"),DB::raw("sum(income) as total_income"))->groupBy('miscellaneous_income.other_services');

            $all_amount_count_arr = $all_income_count_data->get();
            $all_amount_count = $all_income_count_data->count();
        }
        else
        {
            $all_income_count_data = DB::table('miscellaneous_income')->select('other_services.*','miscellaneous_income.*')->leftJoin('other_services','miscellaneous_income.other_services','=','other_services.id')->where('miscellaneous_income.office_id', $loggedin_office_id)->whereDate('miscellaneous_income.updated_at', '>=', $start_date)->whereDate('miscellaneous_income.updated_at', '<=', $end_date)->select('other_services.service_name as services_name',DB::raw("sum(total_recieve) as recieved_amount"),DB::raw("sum(income) as total_income"))->groupBy('miscellaneous_income.other_services');

            $all_amount_count_arr = $all_income_count_data->get();
            $all_amount_count = $all_income_count_data->count();
        }

        return view('/admin/miscellaneous_income/miscellaneous_income_report',compact('other_services','all_amount_count_arr','all_amount_count'));        
    }


    public function ajax_miscellaneous_income_report(Request $request)
    {
        $all_amount_count = 0;
        $start_date = date("Y-m-d",strtotime('-31 days'));
        $end_date = date('Y-m-d');
        $service_id = $request->service_id;
        $office = '';
        $all_amount_count_arr = array();
        $other_services = DB::table('other_services')->get();

        $user_type = Auth::user()->type;

        $loggedin_office_id = Auth::user()->office_id;

        if($user_type == 1)
        {        

            $all_income_count_data = DB::table('miscellaneous_income')->select('other_services.*','miscellaneous_income.*')->leftJoin('other_services','miscellaneous_income.other_services','=','other_services.id')->where('miscellaneous_income.other_services', $service_id)->whereDate('miscellaneous_income.updated_at', '>=', $start_date)->whereDate('miscellaneous_income.updated_at', '<=', $end_date)->select('other_services.service_name as services_name',DB::raw("sum(total_recieve) as recieved_amount"),DB::raw("sum(income) as total_income"))->groupBy('miscellaneous_income.other_services');

            $all_amount_count_arr = $all_income_count_data->get();
            $all_amount_count = $all_income_count_data->count();
        }
        else
        {
            $all_income_count_data = DB::table('miscellaneous_income')->select('other_services.*','miscellaneous_income.*')->leftJoin('other_services','miscellaneous_income.other_services','=','other_services.id')->where('miscellaneous_income.office_id', $loggedin_office_id)->where('miscellaneous_income.other_services', $service_id)->whereDate('miscellaneous_income.updated_at', '>=', $start_date)->whereDate('miscellaneous_income.updated_at', '<=', $end_date)->select('other_services.service_name as services_name',DB::raw("sum(total_recieve) as recieved_amount"),DB::raw("sum(income) as total_income"))->groupBy('miscellaneous_income.other_services');

            $all_amount_count_arr = $all_income_count_data->get();
            $all_amount_count = $all_income_count_data->count();
        }

        return view('/admin/miscellaneous_income/ajax_miscellaneous_income_report',compact('other_services','all_amount_count_arr','all_amount_count'));        
    }
public function allow_staff($email = '',$id = '')
{
    $encrypt_email = $email;
    $encrypt_id = $id;
    $email = base64_decode($email);
    $get_user_data = DB::table('users')->where('email', $email);
    if ($get_user_data->count() > 0) {
        $user_id = $get_user_data->first()->id;
        if (md5($user_id) == $encrypt_id) {
            DB::table('users')->where('id', $user_id)->update(['other_ip_allowed' => 1]);
        }
    }
    return view('thanks_allow_staff');    
}

}
