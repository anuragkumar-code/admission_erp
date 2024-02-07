<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SearchController extends Controller
{

    public function search(Request $request)
    {
        $name=$request->input('name');
        $dob=$request->input('dob');
        $phone=$request->input('phone');
        $st_type=$request->input('st_type');
        //echo "<pre>"; print_r($request->all()); exit;
        $name_count = str_word_count($name);
        if($name_count > 1)
        {
        $name = explode(' ', $name);
        $first_name = $name[0];
        $second_name = $name[1];
        }
        else
        {
          $first_name = $name;
          $second_name = ''; 
        }

        $user_type = 0;
         if($st_type == 'leads')
         {
            $user_type = 2;
         }
         if($st_type == 'prospects')
         {
            $user_type = 1;
         }
        $users_one =  DB::table('students')->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')->leftJoin('users','students.user_id','=','users.id');

        $users_two =  DB::table('students')->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name','course_fees_details.course_id as feedetail_courseid','course_fees_details.id as course_fees_details_id')->leftJoin('users','students.user_id','=','users.id');


        

        $users_lead =  $users_one;
        $users_prospects =  $users_two;

            
            if(!is_null($first_name)) {

              $users_lead = $users_one->where(function($q) use ($first_name) {
            $q->where('students.first_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$first_name%'"));
            });


            $users_prospects = $users_two->where(function($q) use ($first_name) {
            $q->where('students.first_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$first_name%'"));
            });  

              /*  $users_prospects =  $users_two->where(function($q) use ($name) {
                    $q->where('students.first_name', 'like', '%'.$name.'%')->orwhere('students.middle_name', 'like', '%'.$name.'%')->orwhere('students.last_name', 'like', '%'.$name.'%');
                    });*/
            }

            else if(!is_null($first_name && $second_name)) {
         
                $users_lead = $users_one->where(function($q) use ($first_name,$second_name) {
            $q->where('students.first_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.first_name', 'like', DB::raw("'%$second_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$second_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$second_name%'"));
            });

            $users_prospects = $users_two->where(function($q) use ($first_name,$second_name) {
            $q->where('students.first_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$first_name%'"));
            $q->orwhere('students.first_name', 'like', DB::raw("'%$second_name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$second_name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$second_name%'"));
            }); 
            }
            
        if(!is_null($dob)) {
            $users_lead =  $users_one->where('students.dob', 'like', '%'.$dob.'%');
            $users_prospects =  $users_two->where('students.dob', 'like', '%'.$dob.'%');
            }
           
        if(!is_null($phone)) {
            $users_lead =  $users_one->where('students.phone', 'like', '%'.$phone.'%');
            $users_prospects =  $users_two->where('students.phone', 'like', '%'.$phone.'%');

            }

            if($user_type == 0)
            {
                $get_lead_students = $users_lead->where('students.type', 2)
                ->where('students.is_delete', 0)                           
                ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
                ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
                ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
                ->where('course_fees_details.current_college_course', 1)
                ->orderBy('students.id', 'DESC')->get();

            $get_prospect_students = $users_prospects->where('students.type', 1)
            ->where('students.is_delete', 0)                           
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
            ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
            ->orderBy('students.id', 'DESC')->get();
            }
            else
            {
                $get_lead_students = $users_lead->where('students.type', 2)
                ->where('students.is_delete', 0)                               
                ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
                ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
                ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
                ->where('course_fees_details.current_college_course', 1)
                ->orderBy('students.id', 'DESC')->get();

            $get_prospect_students = $users_prospects->where('students.type', 1)->where('students.is_delete', 0)                          
            ->leftJoin('course_fees_details','students.id','=','course_fees_details.user_id')
            ->leftJoin('courses','course_fees_details.course_id','=','courses.id')        
            ->leftJoin('colleges','course_fees_details.college_id','=','colleges.id')
            ->orderBy('students.id', 'DESC')->get();    
            }
            


           //echo "<pre>"; print_r($get_lead_students); exit;

        //    echo "<pre>"; print_r($get_prospect_students); exit;

            if($st_type == 'leads')
            {                
                return view('/admin/leads_students',  compact('get_prospect_students','get_lead_students'));
            }
            elseif($st_type == 'prospects')
            {
                return view('/admin/students',  compact('get_prospect_students','get_lead_students'));
            }
            else
            {
                return view('/admin/students',  compact('get_prospect_students','get_lead_students'));   
            }

    }

   
    public function staff_search(Request $request)
    {

       $name=$request->input('name');
       $dob=$request->input('dob');
       $phone=$request->input('phone');
       $st_type=$request->input('st_type');
       
        $users_one =  DB::table('students')->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name')->leftJoin('users','students.user_id','=','users.id');



        $users_two =  DB::table('students')->select('students.*','users.first_name as staff_name','colleges.id as college_id','courses.id as course_id','colleges.college_trading_name as college_name','courses.course_name as course_name')->leftJoin('users','students.user_id','=','users.id');

        $users_lead =  $users_one;
        $users_prospects =  $users_two;
        
       if(!is_null($name))
       {
        /*$users_lead = $users_one->where(function($k) use ($name) {
            $k->where('students.first_name', 'like', '%'.$name.'%')->orwhere('students.middle_name', 'like', '%'.$name.'%')->orwhere('students.last_name', 'like', '%'.$name.'%');
            }); */ 


         $users_lead = $users_one->where(function($q) use ($name) {
            $q->where('students.first_name', 'like', DB::raw("'%$name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$name%'"));
            });


            $users_prospects = $users_one->where(function($q) use ($name) {
            $q->where('students.first_name', 'like', DB::raw("'%$name%'"));
            $q->orwhere('students.middle_name', 'like', DB::raw("'%$name%'"));
            $q->orwhere('students.last_name', 'like', DB::raw("'%$name%'"));
            });  
         
       /* $users_prospects =  $users_two->where(function($k) use ($name) {
                $k->where('students.first_name', 'like', '%'.$name.'%')->orwhere('students.middle_name', 'like', '%'.$name.'%')->orwhere('students.last_name', 'like', '%'.$name.'%');
                }); */  
       }
       if(!is_null($dob))
       {
        $users_lead =$users_one->where('students.dob', 'like', '%'.$dob.'%');
        $users =$users_two->where('students.dob', 'like', '%'.$dob.'%');

       }
       
       if(!is_null($phone))
       {
        $users_lead=$users_one->where('students.phone', 'like', '%'.$phone.'%');
        $users=$users_two->where('students.phone', 'like', '%'.$phone.'%');

       }

       $get_staff_lead_students= $users_lead->where(['user_id'=>Auth::id(),'students.type'=> 2])->leftJoin('colleges','students.college','=','colleges.id')->leftJoin('courses','students.course','=','courses.id')->orderBy('students.id', 'DESC')->paginate(10); 



       $get_staff_prospect_students = $users_prospects->where(['user_id'=> Auth::id(),'students.type' => 1])->orderBy('students.id', 'DESC')->paginate(10);

       if($st_type == 'leads')
       {
           return view('/staff/leads_students',  compact('get_staff_prospect_students','get_staff_lead_students'));
       }
       elseif($st_type == 'prospects')
       {
           return view('/staff/students',  compact('get_staff_prospect_students','get_staff_lead_students'));
       }
       else
       {
           return view('/staff/students',  compact('get_staff_prospect_students','get_staff_lead_students'));   
       }

    //    return view('staff/students', compact('get_staff_lead_students','get_staff_prospect_students'));

    }


} 
 