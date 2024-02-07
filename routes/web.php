<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Auth\UserProvider;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('staff/login', [UserController::class,'stafflogin'])->name('staff/login');
Route::get('/admin/login', [UserController::class,'login'])->name('login');
Route::post('/admin/loggedin',[UserController::class,'adminlogin'])->name('adminlogin');
Route::get('/other_admin/login', [UserController::class,'other_login'])->name('other_login');
Route::post('/other_admin/loggedin',[UserController::class,'other_adminlogin'])->name('other_adminlogin');

Route::post('/staff/loggedin',[UserController::class,'staffloggedin'])->name('staffloggedin');

Route::get('/student-form', [UserController::class,'form'])->name('form');
Route::post('/students-form',[UserController::class,'form_students'])->name('form_students');

//-----------------------Admin Head function--------------------------------//

View::composer('admin.layout.head', function ($view) {
    
    $user_type =  Auth::user()->type;
        if($user_type==1)
        {
            $get_students_count = DB::table('students')->where('is_delete', 0)->count();
        }
        else if($user_type==3){ 
            $office_id =  Auth::user()->office_id;
            $get_students_count = DB::table('students')->where('office_id',$office_id)->where('is_delete', 0)->count();

        }

    $get_colleges_count = DB::table('colleges')->where('is_delete', 0)->count();

    if($user_type==1)
    {
    /*$get_staffs_count = DB::table('users')->whereIn('type', [1,2,3])->where('is_delete', 0)->count();*/
    $get_staffs_count = DB::table('users')->where('id','!=', 1)->where('is_delete', 0)->count();
    $task_count = DB::table('tasks')->where('status', 1)->where('is_delete', 0)->where('is_read', 0)->count();
    $student_count = DB::table('students')->where('added_by', 1)->where('is_delete', 0)->where('is_read', 0)->count();

    }
    else if($user_type==3){ 
        $office_id =  Auth::user()->office_id;
        $get_staffs_count = DB::table('users')->where('office_id',$office_id)->whereIn('type', [1,3])->where('is_delete', 0)->count();

        $task_count = DB::table('tasks')->where('status', 1)->where('is_delete', 0)->where('office_id',$office_id)->where('is_read', 0)->count();
        $student_count = DB::table('students')->where('added_by', 1)->where('is_delete', 0)->where('office_id',$office_id)->where('is_read', 0)->count();
    }


    $get_offices_count = DB::table('offices')->where('is_delete', 0)->count();

    $get_trash_student_count = DB::table('students')->where('is_delete', 1)->count();
    $get_migration_student_count = DB::table('students')->where('is_migrate', 1)->count();
    $get_extra_student_count = DB::table('students')->where('is_extra', 1)->count();
    $get_trash_staff_count = DB::table('users')->where('is_delete', 1)->count();
    $get_trash_offices_count = DB::table('offices')->where('is_delete', 1)->count();
    $get_trash_colleges_count = DB::table('colleges')->where('is_delete', 1)->count();
    $get_trash_courses_count = DB::table('courses')->where('is_delete', 1)->count();


   
$view->with(['get_colleges_count'=>$get_colleges_count,'get_students_count'=>$get_students_count, 'get_staffs_count' =>$get_staffs_count, 'get_offices_count' =>$get_offices_count, 'get_trash_student_count' =>$get_trash_student_count, 'get_trash_staff_count' => $get_trash_staff_count, 'get_trash_offices_count' => $get_trash_offices_count ,  'get_trash_colleges_count' => $get_trash_colleges_count , 'get_trash_courses_count' => $get_trash_courses_count , 'migration_student_count' => $get_migration_student_count,'extra_student_count' => $get_extra_student_count,'task_count' => $task_count,'student_count' => $student_count ]);

});




View::composer('staff.layout.head', function ($view) {
    
    $user_type =  Auth::user()->type;
    $student_management = Auth::user()->student_management;
    $student_delete_management = Auth::user()->student_delete_management;
    $college_management = Auth::user()->college_management;
    $rights_college_add = Auth::user()->rights_college_add;
    $migration_management = Auth::user()->migration_management;
    $extra_management = Auth::user()->extra_management;
    $task_management = Auth::user()->task_management;
    $follow_up_management = Auth::user()->follow_up_management;
    $rights_visa_expire = Auth::user()->rights_visa_expire;
    $rights_passport_expire = Auth::user()->rights_passport_expire;
    $rights_fees_due = Auth::user()->rights_fees_due;
    $rights_course_completion = Auth::user()->rights_course_completion;
    $filter_management = Auth::user()->filter_management;


       /*if($user_type==2){ */
            $office_id =  Auth::user()->office_id;
            $get_students_count = DB::table('students')->where('office_id',$office_id)->where('is_delete', 0)->count();

        /*}*/

    $get_colleges_count = DB::table('colleges')->where('is_delete', 0)->count();

   /*if($user_type==2){ */
        $office_id =  Auth::user()->office_id;
        $get_staffs_count = DB::table('users')->where('office_id',$office_id)->whereIn('type', [2])->where('is_delete', 0)->count();

        $task_count = DB::table('tasks')->where('status', 1)->where('is_delete', 0)->where('office_id',$office_id)->where('is_read', 0)->count();
        $student_count = DB::table('students')->where('is_delete', 0)->where('office_id',$office_id)->where('is_read', 0)->count();
    /*}*/


    $get_offices_count = DB::table('offices')->where('is_delete', 0)->count();

    $get_trash_student_count = DB::table('students')->where('office_id',$office_id)->where('is_delete', 1)->count();
    $get_migration_student_count = DB::table('students')->where('office_id',$office_id)->where('is_migrate', 1)->count();
    $get_extra_student_count = DB::table('students')->where('office_id',$office_id)->where('is_extra', 1)->count();
    $get_trash_staff_count = DB::table('users')->where('office_id',$office_id)->where('is_delete', 1)->count();
    $get_trash_offices_count = DB::table('offices')->where('is_delete', 1)->count();
    $get_trash_colleges_count = DB::table('colleges')->where('is_delete', 1)->count();
    $get_trash_courses_count = DB::table('courses')->where('is_delete', 1)->count();




   
$view->with(['get_colleges_count'=>$get_colleges_count,'get_students_count'=>$get_students_count, 'get_staffs_count' =>$get_staffs_count, 'get_offices_count' =>$get_offices_count, 'get_trash_student_count' =>$get_trash_student_count, 'get_trash_staff_count' => $get_trash_staff_count, 'get_trash_offices_count' => $get_trash_offices_count ,  'get_trash_colleges_count' => $get_trash_colleges_count , 'get_trash_courses_count' => $get_trash_courses_count , 'migration_student_count' => $get_migration_student_count,'extra_student_count' => $get_extra_student_count,'task_count' => $task_count,'student_count' => $student_count, 'student_management' => $student_management,'student_delete_management' => $student_delete_management,'college_management' => $college_management,'rights_college_add' => $rights_college_add,'migration_management' => $migration_management,'extra_management' => $extra_management,'task_management' => $task_management,'follow_up_management' => $follow_up_management,'rights_visa_expire' => $rights_visa_expire,'rights_passport_expire' => $rights_passport_expire,'rights_fees_due' => $rights_fees_due,'rights_course_completion' => $rights_course_completion,'filter_management' => $filter_management]);

});



//-------------------------------  Admin Middleware routes------------------------------------//

Route::group(['middleware' => ['admin']], function(){

    Route::get('/admin/mail',[AdminController::class,'mail']);

    Route::post('/admin/ajaxNotification',[AdminController::class,'ajaxNotification'])->name('ajaxNotification');

    
    Route::get('/admin/dashboard',[AdminController::class,'admin_dashboard'])->name('admin_dashboard');
    Route::get('/admin/students',[AdminController::class, 'students'])->name('students');
    Route::get('/admin/migrate_students',[AdminController::class, 'migrate_students'])->name('migrate_students');
    Route::get('/admin/extra_students',[AdminController::class, 'extra_students'])->name('extra_students');
    Route::get('/admin/leads_students',[AdminController::class, 'leads_students'])->name('leads_students');
    Route::get('/admin/filtered_students/{student_type}/register_type/{pass_exp_date}/{visa_exp_date}/{australian_id}/{marital_status}/{gender}/{referral}/{purpose_of_visit}/{college}/{dob}/{country}/{offices}/{community}',[AdminController::class, 'filtered_students'])->name('filtered_students');

    Route::get('/admin/filtered_students',[AdminController::class, 'filtered_students'])->name('filtered_students');


    Route::get('/admin/student_payment_details/{id}',[AdminController::class, 'student_payment_details'])->name('student_payment_details');

    Route::get('/admin/staff',[AdminController::class, 'staff'])->name('staff');
    Route::get('/admin/colleges',[CollegeController::class, 'colleges'])->name('colleges');
    Route::get('/admin/offices',[AdminController::class, 'offices'])->name('offices');
    Route::get('/admin/trash',[AdminController::class, 'trash'])->name('trash');
    Route::get('/admin/trashlogin', [AdminController::class,'trashlogin'])->name('trashlogin');


   

    // Trash Forgot Password
    Route::post('/admin/trashloggedin',[AdminController::class,'trashloggedin'])->name('trashloggedin');
    Route::get('/admin/trash_change-password',[AdminController::class,'trash_change_password'])->name('trash_change_password');
    Route::post('/admin/trash_password-updated',[AdminController::class,'trash_update_password'])->name('trash_update_password');

    // END Trash Forgot password

   
    Route::get('/admin/logout',[AdminController::class,'adminLogout'])->name('adminLogout');

    Route::get('/admin/change-password',[AdminController::class,'change_password'])->name('change_password');
    Route::post('/admin/password-updated',[AdminController::class,'update_password'])->name('update_password');

    Route::get('/admin/add-students',[AdminController::class, 'viewAddStudents'])->name('viewAddStudents');
    Route::post('/admin/student-added',[AdminController::class, 'add_students'])->name('add_students');
    Route::get('/admin/student-details/{id}',[AdminController::class, 'view_students'])->name('view_students');
    Route::get('/admin/student-edit/{id}',[AdminController::class, 'edit_students'])->name('edit_students');    
    Route::post('/admin/student-updated/{id}',[AdminController::class, 'update_students'])->name('update_students');
    Route::get('/admin/student-deleted/{id}',[AdminController::class, 'delete_students'])->name('delete_students');
    Route::get('/admin/student-other-details/{id}',[AdminController::class, 'other_details']);
    Route::post('/admin/student-other-details',[AdminController::class, 'update_other_details'])->name('update_other_details');
    Route::post('edit_rec_fees',[AdminController::class, 'edit_rec_fees'])->name('edit_rec_fees');
    Route::post('edit_recieve_fees',[AdminController::class, 'edit_recieve_fees'])->name('edit_recieve_fees');



    

    Route::get('/admin/student_trash_restore/{id}',[AdminController::class, 'student_trash_restore'])->name('student_trash_restore');
    Route::post('/admin/student_trash_restored/{id}',[AdminController::class, 'trash']);
    Route::get('/admin/student_trash_delete/{id}',[AdminController::class, 'student_trash_delete']);  
    Route::get('/admin/course_trash_restore/{id}',[AdminController::class, 'course_trash_restore'])->name('course_trash_restore');
    Route::get('/admin/course_trash_delete/{id}',[AdminController::class, 'course_trash_delete']);
    Route::get('/admin/staff_trash_restore/{id}',[AdminController::class, 'staff_trash_restore'])->name('staff_trash_restore');
    Route::get('/admin/staff_trash_delete/{id}',[AdminController::class, 'staff_trash_delete']);
    Route::get('/admin/college_trash_restore/{id}',[AdminController::class, 'college_trash_restore'])->name('college_trash_restore');
    Route::get('/admin/college_trash_delete/{id}',[AdminController::class, 'college_trash_delete']);





    Route::get('/admin/office_trash_restore/{id}',[AdminController::class, 'office_trash_restore'])->name('office_trash_restore');
    Route::get('/admin/office_trash_delete/{id}',[AdminController::class, 'office_trash_delete']);


    Route::get('/admin/add-staff',[AdminController::class, 'viewAddStaff'])->name('viewAddStaff');
    Route::post('/admin/staff-added',[AdminController::class, 'add_staff'])->name('add_staff');
    Route::get('/admin/staff-edit/{id}',[AdminController::class, 'editStaff'])->name('edit_staff');
    Route::post('/admin/staff-edited/{id}',[AdminController::class, 'editedStaff']);
    Route::get('/admin/staff-delete/{id}',[AdminController::class, 'deleteStaff']);  
    
    Route::get('/admin/add-college',[CollegeController::class, 'viewAddColleges'])->name('viewAddColleges');
    Route::post('/admin/college-added',[CollegeController::class, 'add_colleges'])->name('add_colleges');   
    Route::get('/admin/college-details/{id}',[CollegeController::class, 'view_colleges'])->name('view_colleges');
    Route::get('/admin/college-edit/{id}',[CollegeController::class, 'edit_colleges'])->name('edit_colleges');
    Route::post('/admin/college-updated/{id}',[CollegeController::class, 'update_colleges'])->name('update_colleges');
    Route::get('/admin/college-deleted/{id}',[CollegeController::class,'delete_colleges'])->name('delete_colleges');

    Route::get('/admin/add-course/{id}',[CourseController::class, 'viewAddCourses'])->name('viewAddCourses');
    Route::post('/admin/college/course-added',[CourseController::class, 'add_courses'])->name('add_courses');
    
    Route::post('/admin/collegeCourses',[AdminController::class,'collegeCourses'])->name('get_collegeCourses');
    
    Route::post('CoursesCampuses',[AdminController::class,'CoursesCampuses'])->name('CoursesCampuses');


    Route::post('/admin/courseFees',[AdminController::class,'courseFees'])->name('get_courseFees');
    Route::get('/admin/add_course_campus/{id}',[CourseController::class, 'add_course_campus'])->name('add_course_campus');
    Route::get('/admin/edit_course_campus/{id}',[CourseController::class, 'edit_course_campus'])->name('edit_course_campus');

    Route::post('/admin/edit_course_campus',[CourseController::class, 'edit_course_campus'])->name('edit_course_campus');

    Route::post('/admin/campus_remove',[CourseController::class, 'campus_remove'])->name('campus_remove');    
    Route::post('/admin/course_detail_remove',[AdminController::class, 'course_detail_remove'])->name('course_detail_remove');    


    Route::get('/admin/course-edit/{id}',[CourseController::class, 'edit_courses'])->name('edit_courses');
    Route::post('/admin/course-updated/{id}',[CourseController::class, 'update_courses'])->name('update_courses');
    Route::get('/admin/course-deleted/{id}',[CourseController::class,'delete_courses'])->name('delete_courses');
   
    Route::get('/admin/search',[SearchController::class,'search'])->name('search');
    Route::post('/admin/add_comment',[AdminController::class,'addComment'])->name('adminAddComment');
    
    Route::post('/admin/adminPayFee',[AdminController::class,'adminPayFee'])->name('adminPayFee');
    Route::post('/admin/adminPayFee_discount',[AdminController::class,'adminPayFee_discount'])->name('adminPayFee_discount');

    Route::get('/verify-student/{email}/{id}',[AdminController::class,'emailVerify']);

    Route::get('/admin/add-office',[AdminController::class, 'viewAddOffices'])->name('viewAddOffices');
    Route::post('/admin/office-added',[AdminController::class, 'add_offices'])->name('add_offices');  
    Route::get('/admin/office-edit/{id}',[AdminController::class, 'edit_offices'])->name('edit_offices');
    Route::post('/admin/office-updated/{id}',[AdminController::class, 'update_offices'])->name('update_offices');
    Route::get('/admin/office-deleted/{id}',[AdminController::class,'delete_offices'])->name('delete_offices');

    Route::post('send_sms_to_student',[AdminController::class,'send_sms_to_student'])->name('send_sms_to_student');
    Route::post('send_whatsapp_to_student',[AdminController::class,'send_whatsapp_to_student'])->name('send_whatsapp_to_student');
    Route::post('send_mail_to_student',[AdminController::class,'send_mail_to_student'])->name('send_mail_to_student');

    Route::get('generate_report',[AdminController::class,'generate_report'])->name('generate_report');
    Route::post('show_report',[AdminController::class,'show_report'])->name('show_report');


    Route::get('commission_generate_report',[AdminController::class,'commission_generate_report'])->name('commission_generate_report');
    Route::post('commission_show_report',[AdminController::class,'commission_show_report'])->name('commission_show_report');
    Route::get('commission_claimed',[AdminController::class,'commission_claimed'])->name('commission_claimed');
    Route::post('commission_claim',[AdminController::class,'commission_claim'])->name('commission_claim');

    Route::get('bonus_claimed',[AdminController::class,'bonus_claimed'])->name('bonus_claimed');
    Route::post('bonus_claim',[AdminController::class,'bonus_claim'])->name('bonus_claim');



    Route::get('update_commision',[AdminController::class,'update_commision'])->name('update_commision');

    
    Route::get('update_commision',[AdminController::class,'update_commision'])->name('update_commision');


    //Route::get('report',[AdminController::class,'report'])->name('report');

     Route::post('ajax_followup',[AdminController::class,'ajax_followup'])->name('ajax_followup');    
     Route::post('ajax_followup_data',[AdminController::class,'ajax_followup_data'])->name('ajax_followup_data');    
     Route::post('ajax_followup_close',[AdminController::class,'ajax_followup_close'])->name('ajax_followup_close');  

     Route::get('migration',[AdminController::class,'migration'])->name('migration');  
     Route::post('migration',[AdminController::class,'migration'])->name('migration');

     Route::get('extra',[AdminController::class,'extra'])->name('extra');  
     Route::post('extra',[AdminController::class,'extra'])->name('extra');  
       
     Route::post('send_mail_checklist',[AdminController::class,'send_mail_checklist'])->name('send_mail_checklist');    
     
     Route::post('admissionPayFee',[AdminController::class,'admissionPayFee'])->name('admissionPayFee');    

     Route::get('migration_student_detail/{id}',[AdminController::class,'migration_student_detail'])->name('migration_student_detail');    
     Route::post('migration_student_detail',[AdminController::class,'migration_student_detail'])->name('migration_student_detail'); 

     Route::get('extra_student_detail/{id}',[AdminController::class,'extra_student_detail'])->name('extra_student_detail');    
     Route::post('extra_student_detail',[AdminController::class,'extra_student_detail'])->name('extra_student_detail'); 


     Route::post('remove_migration_image',[AdminController::class,'remove_migration_image'])->name('remove_migration_image');

     Route::get('visa_expire',[AdminController::class,'visa_expire'])->name('visa_expire');
     Route::get('passport_expire',[AdminController::class,'passport_expire'])->name('passport_expire');
     Route::get('fees_due',[AdminController::class,'fees_due'])->name('fees_due');
     Route::get('course_completion',[AdminController::class,'course_completion'])->name('course_completion');

     Route::post('ajax_visa_expire_followup_data',[AdminController::class,'ajax_visa_expire_followup_data'])->name('ajax_visa_expire_followup_data');
     Route::post('ajax_passport_expire_followup_data',[AdminController::class,'ajax_passport_expire_followup_data'])->name('ajax_passport_expire_followup_data');
     Route::post('ajax_fees_due_followup_data',[AdminController::class,'ajax_fees_due_followup_data'])->name('ajax_fees_due_followup_data');
     Route::post('ajax_course_completion_followup_data',[AdminController::class,'ajax_course_completion_followup_data'])->name('ajax_course_completion_followup_data');

     Route::post('save_visa_expire_followup',[AdminController::class,'save_visa_expire_followup'])->name('save_visa_expire_followup');
     Route::post('save_passport_expire_followup',[AdminController::class,'save_passport_expire_followup'])->name('save_passport_expire_followup');
     Route::post('save_fees_due_followup',[AdminController::class,'save_fees_due_followup'])->name('save_fees_due_followup');
     Route::post('save_course_completion_followup',[AdminController::class,'save_course_completion_followup'])->name('save_course_completion_followup');



    Route::get('/admin/admin_tasks',[AdminController::class, 'admin_tasks'])->name('admin_tasks');
    Route::get('/admin/add_task',[AdminController::class, 'add_task'])->name('/admin/add_task');
    Route::post('/admin/add_task',[AdminController::class, 'add_task'])->name('/admin/add_task');
    Route::get('/admin/edit_task/{id}',[AdminController::class, 'edit_task'])->name('/admin/edit_task');
    Route::post('/admin/edit_task',[AdminController::class, 'edit_task'])->name('/admin/edit_task');
    Route::post('add_task_comments',[AdminController::class, 'add_task_comments'])->name('add_task_comments');
    Route::get('/admin/task_delete/{id}',[AdminController::class,'task_delete'])->name('task_delete');
    Route::post('ajax_task_comment_data',[AdminController::class,'ajax_task_comment_data'])->name('ajax_task_comment_data');



    Route::get('/admin/referal_list',[AdminController::class,'referal_list'])->name('referal_list');
    Route::get('/admin/all_referral_student/{id}',[AdminController::class,'all_referral_student'])->name('all_referral_student');

    Route::post('fees_reciept',[AdminController::class,'fees_reciept'])->name('fees_reciept');


    Route::get('/admin/add_refferals',[AdminController::class, 'add_refferals'])->name('/admin/add_refferals');
    Route::post('/admin/add_refferals',[AdminController::class, 'add_refferals'])->name('/admin/add_refferals');
    Route::get('/admin/edit_refferals/{id}',[AdminController::class, 'edit_refferals'])->name('/admin/edit_refferals');
    Route::post('/admin/edit_refferals',[AdminController::class, 'edit_refferals'])->name('/admin/edit_refferals');


    Route::post('ajax_show_commission',[AdminController::class, 'ajax_show_commission'])->name('ajax_show_commission');
    Route::post('save_referral_commission',[AdminController::class, 'save_referral_commission'])->name('save_referral_commission');


    Route::post('ajax_task_read_unread',[AdminController::class, 'ajax_task_read_unread'])->name('ajax_task_read_unread');   

    Route::post('ajax_student_read_unread',[AdminController::class, 'ajax_student_read_unread'])->name('ajax_student_read_unread');

    Route::post('ajax_client_notes_read_unread',[AdminController::class, 'ajax_client_notes_read_unread'])->name('ajax_client_notes_read_unread');     

    Route::get('payment_proof/{id}',[AdminController::class, 'payment_proof'])->name('payment_proof'); 

    Route::get('/admin/event_list',[AdminController::class, 'event_list'])->name('/admin/event_list'); 
    Route::get('/admin/add_event',[AdminController::class, 'add_event'])->name('/admin/add_event');
    Route::post('/admin/add_event',[AdminController::class, 'add_event'])->name('/admin/add_event');
    Route::get('/admin/edit_event/{id}',[AdminController::class, 'edit_event'])->name('/admin/edit_event');
    Route::post('/admin/edit_event',[AdminController::class, 'edit_event'])->name('/admin/edit_event');
    Route::get('/admin/event_delete/{id}',[AdminController::class,'event_delete'])->name('event_delete');  



    Route::get('/admin/other_services/service_list',[AdminController::class, 'other_service'])->name('/admin/other_services/service_list'); 
    Route::get('/admin/other_services/add_service',[AdminController::class, 'add_service'])->name('/admin/other_services/add_service');
    Route::post('/admin/other_services/add_service',[AdminController::class, 'add_service'])->name('/admin/other_services/add_service');
    Route::get('/admin/other_services/edit_service/{id}',[AdminController::class, 'edit_service'])->name('/admin/other_services/edit_service');
    Route::post('/admin/other_services/edit_service',[AdminController::class, 'edit_service'])->name('/admin/other_services/edit_service');
    Route::get('/admin/other_services/service_delete/{id}',[AdminController::class,'service_delete'])->name('service_delete'); 


    Route::get('/admin/miscellaneous_income/index',[AdminController::class, 'miscellaneous_income'])->name('/admin/miscellaneous_income/index'); 
    
    Route::get('/admin/miscellaneous_income/add_miscellaneous_income',[AdminController::class, 'add_miscellaneous_income'])->name('/admin/miscellaneous_income/add_miscellaneous_income');

    Route::post('/admin/miscellaneous_income/add_miscellaneous_income',[AdminController::class, 'add_miscellaneous_income'])->name('/admin/miscellaneous_income/add_miscellaneous_income');

    Route::get('/admin/miscellaneous_income/edit_miscellaneous_income/{id}',[AdminController::class, 'edit_miscellaneous_income'])->name('/admin/miscellaneous_income/edit_miscellaneous_income');
    
    Route::post('/admin/miscellaneous_income/edit_miscellaneous_income',[AdminController::class, 'edit_miscellaneous_income'])->name('/admin/miscellaneous_income/edit_miscellaneous_income');
    
    Route::get('/admin/miscellaneous_income/delete_miscellaneous_income/{id}',[AdminController::class,'delete_miscellaneous_income'])->name('delete_miscellaneous_income');  
    
    Route::get('event_calendar',[AdminController::class, 'event_calendar'])->name('event_calendar');  


    Route::get('/admin/miscellaneous_income/miscellaneous_income_report',[AdminController::class,'miscellaneous_income_report'])->name('/admin/miscellaneous_income/miscellaneous_income_report');
    Route::post('ajax_miscellaneous_income_report',[AdminController::class,'ajax_miscellaneous_income_report'])->name('ajax_miscellaneous_income_report');

     Route::get('allow-staff/{email}/{id}',[AdminController::class,'allow_staff'])->name('allow-staff');

});

//-------------------------------  Staff Middleware routes------------------------------------//
Route::group(['middleware' => ['staff']], function(){
    Route::get('/staff/dashboard',[StaffController::class,'staff_dashboard'])->name('staff/dashboard');
    Route::get('/staff/leads_students',[StaffController::class, 'staff_leads_students'])->name('/staff/staff_leads_students');
    Route::get('/staff/students',[StaffController::class, 'staff_students'])->name('/staff/staff_students');
    Route::get('/staff/all-staff',[StaffController::class, 'staff_staff'])->name('/staff/staff_staff');
    Route::get('/staff/staffcolleges',[StaffController::class, 'staff_colleges'])->name('/staff/staffcolleges');
    Route::get('/staff/courses',[StaffController::class, 'staff_courses'])->name('/staff/staff_courses');    

    Route::get('/staff/staff_change_password',[StaffController::class,'staff_change_password'])->name('/staff/staff_change_password');
    Route::post('/staff/password-updated',[StaffController::class,'staff_update_password'])->name('/staff/staff_update_password');

    Route::get('/staff/add-students',[StaffController::class, 'staff_viewAddStudents'])->name('/staff/staff_viewAddStudents');
    Route::post('/staff/student-added',[StaffController::class, 'staff_add_students'])->name('/staff/staff_add_students');
    Route::get('/staff/student-details/{id}',[StaffController::class, 'staff_view_students'])->name('/staff/staff_view_students');
    Route::get('/staff/student-edit/{id}',[StaffController::class, 'staff_edit_students'])->name('/staff/staff_edit_students');    
    Route::post('/staff/student-updated/{id}',[StaffController::class, 'staff_update_students'])->name('/staff/staff_update_students');
    Route::get('/staff/student-deleted/{id}',[StaffController::class, 'staff_delete_students'])->name('/staff/staff_delete_students');
    Route::get('/staff/student-other-details/{id}',[StaffController::class, 'staff_student_other_details'])->name('/staff/staff_student_other_details');
    Route::post('/staff/student-other-details',[StaffController::class, 'staff_update_other_details'])->name('/staff/staff_update_other_details');


 
   /* Route::get('/staff/add-staff',[StaffController::class, 'staff_viewAddStaff'])->name('/staff/staff_viewAddStaff');
    Route::post('/staff/staff-added',[StaffController::class, 'staff_add_staff'])->name('/staff/staff_add_staff');
    Route::get('/staff/edit-staff/{id}',[StaffController::class, 'staff_editStaff'])->name('/staff/staff_editStaff');
    Route::post('/staff/staff-updated/{id}',[StaffController::class, 'staff_updateStaff'])->name('/staff/staff_updateStaff');
    Route::get('/staff/delete-staff/{id}',[StaffController::class, 'staff_deleteStaff'])->name('/staff/staff_deleteStaff');  */

    Route::get('/staff/add-college',[StaffController::class, 'staff_viewAddColleges'])->name('/staff/add-college');
    Route::post('/staff/college-added',[StaffController::class, 'staff_add_colleges'])->name('/staff/college-added'); 
    Route::get('/staff/college-details/{id}',[StaffController::class, 'staff_view_colleges'])->name('/staff/staff_view_colleges');
    Route::get('/staff/college-edit/{id}',[StaffController::class, 'staff_edit_colleges'])->name('/staff/college-edit'); 
    Route::post('/staff/college-updated/{id}',[StaffController::class, 'staff_update_colleges'])->name('/staff/college-updated');
    Route::get('/staff/college-deleted/{id}',[StaffController::class,'staff_delete_colleges'])->name('/staff/college-deleted');

    Route::get('/staff/add-course/{id}',[StaffController::class, 'staff_viewAddCourses'])->name('/staff/staff_viewAddCourses');
    Route::post('/staff/course-added',[StaffController::class, 'staff_add_courses'])->name('/staff/staff_add_courses');
    Route::post('/staff/collegeCourses',[StaffController::class,'staff_collegeCourses'])->name('/staff/get_staff_collegeCourses');
    Route::post('/staff/courseFees',[StaffController::class,'staff_courseFees'])->name('/staff/get_staff_courseFees');
    Route::get('/staff/course-edit/{id}',[StaffController::class, 'staff_edit_courses'])->name('/staff/staff_edit_courses');
    Route::post('/staff/course-updated/{id}',[StaffController::class, 'staff_update_courses'])->name('/staff/staff_update_courses');
    Route::get('/staff/course-deleted/{id}',[StaffController::class,'staff_delete_courses'])->name('/staff/course-deleted');

    Route::get('/staff/search',[SearchController::class,'staff_search'])->name('/staff/search');
    Route::post('/staff/add_comment',[StaffController::class,'staff_addComment'])->name('/staff/staffAddComment');

    Route::post('/staff/staffPayFee',[StaffController::class,'staffPayFee'])->name('/staff/staffPayFee');
    
   

    Route::get('/staff/mail',[StaffController::class,'mail']);

    Route::post('/staff/ajaxNotification',[StaffController::class,'ajaxNotification'])->name('/staff/ajaxNotification');

    /*
    Route::get('/staff/dashboard',[StaffController::class,'staff_dashboard'])->name('/staff/staff_dashboard');*/
    Route::get('/staff/students',[StaffController::class, 'students'])->name('/staff/students');
    Route::get('/staff/migrate_students',[StaffController::class, 'migrate_students'])->name('/staff/migrate_students');
    Route::get('/staff/extra_students',[StaffController::class, 'extra_students'])->name('/staff/extra_students');
    Route::get('/staff/leads_students',[StaffController::class, 'leads_students'])->name('/staff/leads_students');
    Route::get('/staff/filtered_students/{student_type}/register_type/{pass_exp_date}/{visa_exp_date}/{australian_id}/{marital_status}/{gender}/{referral}/{purpose_of_visit}/{college}/{dob}/{country}/{offices}/{community}',[StaffController::class, 'filtered_students'])->name('/staff/filtered_students');

    Route::get('/staff/filtered_students',[StaffController::class, 'filtered_students'])->name('/staff/filtered_students');


    Route::get('/staff/student_payment_details/{id}',[StaffController::class, 'student_payment_details'])->name('/staff/student_payment_details');

    Route::get('/staff/staff',[StaffController::class, 'staff'])->name('/staff/staff');
    /*Route::get('/staff/colleges',[StaffController::class, 'staff_view_colleges'])->name('/staff/colleges');*/
    Route::get('/staff/offices',[StaffController::class, 'offices'])->name('/staff/offices');
    Route::get('/staff/trash',[StaffController::class, 'trash'])->name('/staff/trash');
    Route::get('/staff/trashlogin', [StaffController::class,'trashlogin'])->name('/staff/trashlogin');


   

    // Trash Forgot Password
    Route::post('/staff/trashloggedin',[StaffController::class,'trashloggedin'])->name('/staff/trashloggedin');
    Route::get('/staff/trash_change-password',[StaffController::class,'trash_change_password'])->name('/staff/trash_change_password');
    Route::post('/staff/trash_password-updated',[StaffController::class,'trash_update_password'])->name('/staff/trash_update_password');

    // END Trash Forgot password

   
    Route::get('staffLogout',[StaffController::class,'staffLogout'])->name('staffLogout');

    Route::get('/staff/change-password',[StaffController::class,'change_password'])->name('change_password');
    Route::post('/staff/password-updated',[StaffController::class,'update_password'])->name('update_password');

    Route::get('/staff/add-students',[StaffController::class, 'viewAddStudents'])->name('/staff/viewAddStudents');
    Route::post('/staff/student-added',[StaffController::class, 'add_students'])->name('/staff/add_students');
    Route::get('/staff/student-details/{id}',[StaffController::class, 'view_students'])->name('/staff/view_students');
    Route::get('/staff/student-edit/{id}',[StaffController::class, 'edit_students'])->name('/staff/edit_students');    
    Route::post('/staff/student-updated/{id}',[StaffController::class, 'update_students'])->name('/staff/update_students');
    Route::get('/staff/student-deleted/{id}',[StaffController::class, 'delete_students'])->name('/staff/delete_students');
    Route::get('/staff/student-other-details/{id}',[StaffController::class, '/staff/other_details']);
    Route::post('/staff/student-other-details',[StaffController::class, 'update_other_details'])->name('/staff/update_other_details');
    Route::post('/staff/edit_rec_fees',[StaffController::class, 'edit_rec_fees'])->name('/staff/edit_rec_fees');
    Route::post('/staff/edit_recieve_fees',[StaffController::class, 'edit_recieve_fees'])->name('/staff/edit_recieve_fees');



    

    Route::get('/staff/student_trash_restore/{id}',[StaffController::class, 'student_trash_restore'])->name('/staff/student_trash_restore');
    Route::post('/staff/student_trash_restored/{id}',[StaffController::class, 'trash']);
    Route::get('/staff/student_trash_delete/{id}',[StaffController::class, 'student_trash_delete']);  
    Route::get('/staff/course_trash_restore/{id}',[StaffController::class, 'course_trash_restore'])->name('/staff/course_trash_restore');
    Route::get('/staff/course_trash_delete/{id}',[StaffController::class, 'course_trash_delete']);
    Route::get('/staff/staff_trash_restore/{id}',[StaffController::class, 'staff_trash_restore'])->name('/staff/staff_trash_restore');
    Route::get('/staff/staff_trash_delete/{id}',[StaffController::class, 'staff_trash_delete']);
    Route::get('/staff/college_trash_restore/{id}',[StaffController::class, 'college_trash_restore'])->name('/staff/college_trash_restore');
    Route::get('/staff/college_trash_delete/{id}',[StaffController::class, 'college_trash_delete']);





    Route::get('/staff/office_trash_restore/{id}',[StaffController::class, 'office_trash_restore'])->name('/staff/office_trash_restore');
    Route::get('/staff/office_trash_delete/{id}',[StaffController::class, 'office_trash_delete']);


    Route::get('/staff/add-staff',[StaffController::class, 'viewAddStaff'])->name('/staff/viewAddStaff');
    Route::post('/staff/staff-added',[StaffController::class, 'add_staff'])->name('/staff/add_staff');
    Route::get('/staff/staff-edit/{id}',[StaffController::class, 'editStaff'])->name('/staff/edit_staff');
    Route::post('/staff/staff-edited/{id}',[StaffController::class, 'editedStaff'])->name('/staff/staff-edited');
    Route::get('/staff/staff-delete/{id}',[StaffController::class, 'deleteStaff'])->name('/staff/staff-delete');  
    
    Route::post('/staff/college/course-added',[StaffController::class, 'add_courses'])->name('/staff/college/course-added');
    
    Route::post('/staff/collegeCourses',[StaffController::class,'collegeCourses'])->name('/staff/get_collegeCourses');
    
    Route::post('/staff/CoursesCampuses',[StaffController::class,'CoursesCampuses'])->name('/staff/CoursesCampuses');


    Route::post('/staff/courseFees',[StaffController::class,'courseFees'])->name('/staff/get_courseFees');
    Route::get('/staff/add_course_campus/{id}',[StaffController::class, 'add_course_campus'])->name('/staff/add_course_campus');
    Route::get('/staff/edit_course_campus/{id}',[StaffController::class, 'edit_course_campus'])->name('/staff/edit_course_campus');

    Route::post('/staff/edit_course_campus',[StaffController::class, 'edit_course_campus'])->name('/staff/edit_course_campus');

    Route::post('/staff/campus_remove',[StaffController::class, 'campus_remove'])->name('/staff/campus_remove');    
    Route::post('/staff/course_detail_remove',[StaffController::class, 'course_detail_remove'])->name('/staff/course_detail_remove');    


    Route::get('/staff/course-edit/{id}',[StaffController::class, 'edit_courses'])->name('/staff/edit_courses');
    Route::post('/staff/course-updated/{id}',[StaffController::class, 'update_courses'])->name('/staff/update_courses');
    /*Route::get('/staff/course-deleted/{id}',[StaffController::class,'delete_courses'])->name('/staff/delete_courses');*/
   
    Route::get('/staff/search',[SearchController::class,'search'])->name('/staff/search');
    Route::post('/staff/add_comment',[StaffController::class,'addComment'])->name('/staff/adminAddComment');
    
    Route::post('/staff/adminPayFee',[StaffController::class,'adminPayFee'])->name('/staff/adminPayFee');
    Route::post('/staff/adminPayFee_discount',[StaffController::class,'adminPayFee_discount'])->name('/staff/adminPayFee_discount');

    Route::get('/verify-student/{email}/{id}',[StaffController::class,'emailVerify'])->name('/staff/verify-student');

    Route::get('/staff/add-office',[StaffController::class, 'viewAddOffices'])->name('/staff/viewAddOffices');
    Route::post('/staff/office-added',[StaffController::class, 'add_offices'])->name('/staff/add_offices');  
    Route::get('/staff/office-edit/{id}',[StaffController::class, 'edit_offices'])->name('/staff/edit_offices');
    Route::post('/staff/office-updated/{id}',[StaffController::class, 'update_offices'])->name('/staff/update_offices');
    Route::get('/staff/office-deleted/{id}',[StaffController::class,'delete_offices'])->name('/staff/delete_offices');

    Route::post('/staff/send_sms_to_student',[StaffController::class,'send_sms_to_student'])->name('/staff/send_sms_to_student');
    Route::post('/staff/send_whatsapp_to_student',[StaffController::class,'send_whatsapp_to_student'])->name('/staff/send_whatsapp_to_student');
    Route::post('/staff/send_mail_to_student',[StaffController::class,'send_mail_to_student'])->name('/staff/send_mail_to_student');

    


    //Route::get('report',[StaffController::class,'report'])->name('report');

     Route::post('/staff/ajax_followup',[StaffController::class,'ajax_followup'])->name('/staff/ajax_followup');    
     Route::post('/staff/ajax_followup_data',[StaffController::class,'ajax_followup_data'])->name('/staff/ajax_followup_data');    
     Route::post('/staff/ajax_followup_close',[StaffController::class,'ajax_followup_close'])->name('/staff/ajax_followup_close');  

     Route::get('/staff/migration',[StaffController::class,'migration'])->name('/staff/migration');  
     Route::post('/staff/migration',[StaffController::class,'migration'])->name('/staff/migration');

     Route::get('/staff/extra',[StaffController::class,'extra'])->name('/staff/extra');  
     Route::post('/staff/extra',[StaffController::class,'extra'])->name('/staff/extra');  
       
     Route::post('/staff/send_mail_checklist',[StaffController::class,'send_mail_checklist'])->name('/staff/send_mail_checklist');    
     
     Route::post('/staff/admissionPayFee',[StaffController::class,'admissionPayFee'])->name('/staff/admissionPayFee');    

     Route::get('/staff/migration_student_detail/{id}',[StaffController::class,'migration_student_detail'])->name('/staff/migration_student_detail');    
     Route::post('/staff/migration_student_detail',[StaffController::class,'migration_student_detail'])->name('/staff/migration_student_detail'); 

     Route::get('/staff/extra_student_detail/{id}',[StaffController::class,'extra_student_detail'])->name('/staff/extra_student_detail');    
     Route::post('/staff/extra_student_detail',[StaffController::class,'extra_student_detail'])->name('/staff/extra_student_detail'); 


     Route::post('/staff/remove_migration_image',[StaffController::class,'remove_migration_image'])->name('/staff/remove_migration_image');

     Route::get('/staff/visa_expire',[StaffController::class,'visa_expire'])->name('/staff/visa_expire');
     Route::get('/staff/passport_expire',[StaffController::class,'passport_expire'])->name('/staff/passport_expire');
     Route::get('/staff/fees_due',[StaffController::class,'fees_due'])->name('/staff/fees_due');
     Route::get('/staff/course_completion',[StaffController::class,'course_completion'])->name('/staff/course_completion');

     Route::post('/staff/ajax_visa_expire_followup_data',[StaffController::class,'ajax_visa_expire_followup_data'])->name('/staff/ajax_visa_expire_followup_data');
     Route::post('/staff/ajax_passport_expire_followup_data',[StaffController::class,'ajax_passport_expire_followup_data'])->name('/staff/ajax_passport_expire_followup_data');
     Route::post('/staff/ajax_fees_due_followup_data',[StaffController::class,'ajax_fees_due_followup_data'])->name('/staff/ajax_fees_due_followup_data');
     Route::post('/staff/ajax_course_completion_followup_data',[StaffController::class,'ajax_course_completion_followup_data'])->name('/staff/ajax_course_completion_followup_data');

     Route::post('/staff/save_visa_expire_followup',[StaffController::class,'save_visa_expire_followup'])->name('/staff/save_visa_expire_followup');
     Route::post('/staff/save_passport_expire_followup',[StaffController::class,'save_passport_expire_followup'])->name('/staff/save_passport_expire_followup');
     Route::post('/staff/save_fees_due_followup',[StaffController::class,'save_fees_due_followup'])->name('/staff/save_fees_due_followup');
     Route::post('/staff/save_course_completion_followup',[StaffController::class,'save_course_completion_followup'])->name('/staff/save_course_completion_followup');



    Route::get('/staff/staff_tasks',[StaffController::class, 'staff_tasks'])->name('/staff/staff_tasks');
    Route::get('/staff/add_task',[StaffController::class, 'add_task'])->name('/staff/add_task');
    Route::post('/staff/add_task',[StaffController::class, 'add_task'])->name('/staff/add_task');
    Route::get('/staff/edit_task/{id}',[StaffController::class, 'edit_task'])->name('/staff/edit_task');
    Route::post('/staff/edit_task',[StaffController::class, 'edit_task'])->name('/staff/edit_task');
    Route::post('/staff/add_task_comments',[StaffController::class, 'add_task_comments'])->name('/staff/add_task_comments');
    Route::get('/staff/task_delete/{id}',[StaffController::class,'task_delete'])->name('/staff/task_delete');
    Route::post('/staff/ajax_task_comment_data',[StaffController::class,'ajax_task_comment_data'])->name('/staff/ajax_task_comment_data');



    Route::get('/staff/referal_list',[StaffController::class,'referal_list'])->name('/staff/referal_list');
    Route::get('/staff/all_referral_student/{id}',[StaffController::class,'all_referral_student'])->name('/staff/all_referral_student');

    Route::post('/staff/fees_reciept',[StaffController::class,'fees_reciept'])->name('/staff/fees_reciept');


    Route::get('/staff/add_refferals',[StaffController::class, 'add_refferals'])->name('/staff/add_refferals');
    Route::post('/staff/add_refferals',[StaffController::class, 'add_refferals'])->name('/staff/add_refferals');
    Route::get('/staff/edit_refferals/{id}',[StaffController::class, 'edit_refferals'])->name('/staff/edit_refferals');
    Route::post('/staff/edit_refferals',[StaffController::class, 'edit_refferals'])->name('/staff/edit_refferals');


    Route::post('/staff/ajax_show_commission',[StaffController::class, 'ajax_show_commission'])->name('/staff/ajax_show_commission');
    Route::post('/staff/save_referral_commission',[StaffController::class, 'save_referral_commission'])->name('/staff/save_referral_commission');


    Route::post('/staff/ajax_task_read_unread',[StaffController::class, 'ajax_task_read_unread'])->name('/staff/ajax_task_read_unread');   

    Route::post('/staff/ajax_student_read_unread',[StaffController::class, 'ajax_student_read_unread'])->name('/staff/ajax_student_read_unread');

    Route::post('/staff/ajax_client_notes_read_unread',[StaffController::class, 'ajax_client_notes_read_unread'])->name('/staff/ajax_client_notes_read_unread');     

    Route::get('/staff/payment_proof/{id}',[StaffController::class, 'payment_proof'])->name('/staff/payment_proof'); 

    Route::get('/staff/event_list',[StaffController::class, 'event_list'])->name('/staff/event_list'); 
    Route::get('/staff/add_event',[StaffController::class, 'add_event'])->name('/staff/add_event');
    Route::post('/staff/add_event',[StaffController::class, 'add_event'])->name('/staff/add_event');
    Route::get('/staff/edit_event/{id}',[StaffController::class, 'edit_event'])->name('/staff/edit_event');
    Route::post('/staff/edit_event',[StaffController::class, 'edit_event'])->name('/staff/edit_event');
    Route::get('/staff/event_delete/{id}',[StaffController::class,'event_delete'])->name('event_delete');  



    Route::get('/staff/other_services/service_list',[StaffController::class, 'other_service'])->name('/staff/other_services/service_list'); 
    Route::get('/staff/other_services/add_service',[StaffController::class, 'add_service'])->name('/staff/other_services/add_service');
    Route::post('/staff/other_services/add_service',[StaffController::class, 'add_service'])->name('/staff/other_services/add_service');
    Route::get('/staff/other_services/edit_service/{id}',[StaffController::class, 'edit_service'])->name('/staff/other_services/edit_service');
    Route::post('/staff/other_services/edit_service',[StaffController::class, 'edit_service'])->name('/staff/other_services/edit_service');
    Route::get('/staff/other_services/service_delete/{id}',[StaffController::class,'service_delete'])->name('/staff/service_delete'); 


    Route::get('/staff/miscellaneous_income/index',[StaffController::class, 'miscellaneous_income'])->name('/staff/miscellaneous_income/index'); 
    
    Route::get('/staff/miscellaneous_income/add_miscellaneous_income',[StaffController::class, 'add_miscellaneous_income'])->name('/staff/miscellaneous_income/add_miscellaneous_income');

    Route::post('/staff/miscellaneous_income/add_miscellaneous_income',[StaffController::class, 'add_miscellaneous_income'])->name('/staff/miscellaneous_income/add_miscellaneous_income');

    Route::get('/staff/miscellaneous_income/edit_miscellaneous_income/{id}',[StaffController::class, 'edit_miscellaneous_income'])->name('/staff/miscellaneous_income/edit_miscellaneous_income');
    
    Route::post('/staff/miscellaneous_income/edit_miscellaneous_income',[StaffController::class, 'edit_miscellaneous_income'])->name('/staff/miscellaneous_income/edit_miscellaneous_income');
    
    Route::get('/staff/miscellaneous_income/delete_miscellaneous_income/{id}',[StaffController::class,'delete_miscellaneous_income'])->name('/staff/delete_miscellaneous_income');  
    
    Route::get('/staff/event_calendar',[StaffController::class, 'event_calendar'])->name('/staff/event_calendar');  


    Route::get('/staff/miscellaneous_income/miscellaneous_income_report',[StaffController::class,'miscellaneous_income_report'])->name('/staff/miscellaneous_income/miscellaneous_income_report');
    Route::post('/staff/ajax_miscellaneous_income_report',[StaffController::class,'ajax_miscellaneous_income_report'])->name('/staff/ajax_miscellaneous_income_report');   

});