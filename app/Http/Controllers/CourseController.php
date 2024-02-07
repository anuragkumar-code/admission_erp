<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function viewAddCourses(Request $request, $id)
    {
        $college_id = base64_decode($id);
        $get_courses = DB::table('courses')->where('college_id', $college_id)->where('courses.is_delete', 0)->orderBy('id','desc')->get();

        /*$get_courses = DB::table('courses')->where('courses.college_id',$college_id)->where('courses.is_delete', 0)->select('courses.*','courses.id as id','campuses.*', 'campuses.id as campus_id')->leftjoin('campuses', 'courses.id', '=', 'campuses.course_id')->groupBy('campuses.course_id')->get();*/

        //echo "<pre>"; print_r($get_courses); exit;

        return view('/admin/addcourses' , compact('get_courses','college_id'));
    }

    
    public function add_course_campus(Request $request,$college_id)
    {
        $college_id = base64_decode($college_id);
        return view('/admin/add_course_campus', compact('college_id'));
    }


    public function add_courses(Request $request)
    {
        // echo "hi"; exit;
        //echo "<pre>"; print_r($request->all()); exit;

        $college_id = $request->college_id;
        $course_name = $request->course_name;
        $course_duration = $request->course_duration;       

       //$course_fees = $admission_fees + $material_fees + $tuition_fees;       

        $add = DB::table('courses')->insert([
            'course_name' => $course_name,
            'course_duration' => $course_duration,
            'college_id' => $college_id,
            'updated_at' => NOW(),
            'created_at' => NOW(),            
        ]);

        $course_id = DB::getPdo()->lastInsertId();


        if(isset($request->admission_fees) && $request->admission_fees != '')
         {
            foreach ($request->admission_fees as $key => $campus_val)
            {

                DB::table('campuses')->insert([
                'college_id' => $college_id,
                'course_id' => $course_id,
                'admission_fees'=>$request->admission_fees[$key],
                'tuition_fees'  =>  $request->tuition_fees[$key],
                'material_fees' => $request->material_fees[$key],
                'commission' => $request->commission[$key],
                'bonus' => $request->bonus[$key],
                'campus_name' => $request->campus[$key],
                'updated_at' => NOW(),
                'created_at' => NOW(),
              ]);
            }
        }
            $college_id = base64_encode($college_id);     
            return redirect ('/admin/add-course/'.$college_id)->with('success','Course Details Updated !!');
    }

    public function edit_courses($id)
    {
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        if ($user_type !=1)
        {
          return back()->with('error', 'You are not authorised to access this page !!');
          exit;
        }
        $edit_courses = DB::table('courses')->where('id', $id)->first();

        
        return view('/admin/editcourses', compact('edit_courses'));
    }

    public function edit_course_campus(Request $request, $id=0)
    {
        //echo "sat"; exit;
    $course_id = base64_decode($id);

      if($request->all()!=null)
      {
        //echo "<pre>"; print_r($request->all()); exit;

        /*$request->validate(
       [
          'course_name' => 'required',
          'course_duration' => 'required',
          'admission_fees' => 'required',
          'tuition_fees' =>'required',
          'material_fees' => 'required',
          'campus' =>  'required',
              
        ],
        [
            'course_name.required' => 'Please enter course name.',
            'course_duration.required' => 'Please enter course duration.',
            'admission_fees.required' => 'Please enter Admission Fees.',
            'tuition_fees.required' => 'Please enter Tuition Fees.',
            'material_fees.required' => 'Please enter Material Fees.',
            'campus.required' => 'Please enter Campus.',
            
        ]);
*/



        $update_courses= DB::table('courses')->where('id', $request->course_id)->update([          
            'course_name' => $request->course_name,
            'course_duration' => $request->course_duration,
            'college_id' => $request->college_id,
            'updated_at' => NOW(),       
        ]);

         //$delete_campuse = DB::table('campuses')->where('id', $course_id)->delete();
        //echo "<pre>";print_r($request->admission_fees); exit;

        if(isset($request->admission_fees) && $request->admission_fees != '')
         {
            foreach ($request->admission_fees as $key => $campus_val)
            {
                $get_campuses_count = DB::table('campuses')->where('id',$request->campus_id[$key])->count();
                if($get_campuses_count > 0)
                {
                    $get_campuses = DB::table('campuses')->where('id',$request->campus_id[$key])->first();

                    $update_courses= DB::table('campuses')->where('id', $get_campuses->id)->update([
                        'admission_fees'=>$request->admission_fees[$key],
                        'tuition_fees'  =>  $request->tuition_fees[$key],
                        'material_fees' => $request->material_fees[$key],
                        'commission' => $request->commission[$key],
                        'bonus' => $request->bonus[$key],
                        'campus_name' => $request->campus[$key],
                        'updated_at' => NOW(),
                        'created_at' => NOW(),
                    ]);  


                }

                else
                {
                    DB::table('campuses')->insert([
                        'college_id' => $request->college_id,
                        'course_id' => $request->course_id,
                        'admission_fees'=>$request->admission_fees[$key],
                        'tuition_fees'  =>  $request->tuition_fees[$key],
                        'material_fees' => $request->material_fees[$key],
                        'commission' => $request->commission[$key],
                        'bonus' => $request->bonus[$key],
                        'campus_name' => $request->campus[$key],
                        'updated_at' => NOW(),
                        'created_at' => NOW(),
                    ]);
                }
                
            }
        }

            $college_id = base64_encode($request->college_id);     
            return redirect ('/admin/add-course/'.$college_id)->with('success','Course Details Updated !!');

      }
      else
      {        
        $user_type = Auth::user()->type;
        if ($user_type !=1)
        {
          return back()->with('error', 'You are not authorised to access this page !!');
          exit;
        }
         $get_courses = DB::table('courses')->where('id', $course_id)->first();
         $edit_courses = DB::table('campuses')->where('course_id',$course_id)->get();

         return view('/admin/edit_course_campus', compact('edit_courses','course_id','get_courses'));
         //echo "<pre>"; print_r($edit_courses); exit;
      } 

    }

    public function delete_courses($id)
    {
        $id = base64_decode($id);       

        $course_fees_details_count = DB::table('course_fees_details')->where('course_id', $id)->count();
        $fee_details_count = DB::table('fee_details')->where('course_id', $id)->count();

        if($course_fees_details_count > 0 || $fee_details_count > 0)
        {
            return back()->with('error', 'This course is already assigned to student or Something went wrong !!');
        }
        else
        {
            $delete_courses = DB::table('courses')->where('id', $id)->update(['is_delete' => 1,'deleted_by' => Auth::user()->first_name]);

            $delete_courses = DB::table('campuses')->where('course_id', $id)->update(['is_delete' => 1,'deleted_by' => Auth::user()->first_name]);


            return back()->with('error', 'Course Deleted.');
        }
    }

    public function campus_remove(Request $request)
    {
         $course_fees_data = DB::table('course_fees_details')->where('campus_id', $request->campus_id)->count();
         $fee_details_data = DB::table('fee_details')->where('campus_id',$request->campus_id)->count();

         if($course_fees_data > 0 || $fee_details_data > 0)
         {
            echo 1; exit;
         }
         else
         {
            $delete_campus = DB::table('campuses')->where('id', $request->campus_id)->delete();
            echo 0; exit;   
         }        

    }

}
