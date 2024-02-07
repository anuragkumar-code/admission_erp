<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CollegeController extends Controller
{
    public function colleges(Request $request)
    { 
        $get_colleges = DB::table('colleges')->where('colleges.is_delete', 0)->orderBy('id','desc')->get();

        return view('/admin/colleges', compact('get_colleges'));
    }

    public function viewAddColleges(Request $request)
    {
        // $courses = DB::table('courses')->where('status', 1)->get();

        $user_type = Auth::user()->type;
        if ($user_type !=1)
        {
          return back()->with('error', 'You are not authorised to access this page !!');
        }
        return view('/admin/addcolleges');
    }

    public function add_colleges(Request $request)
      {

        request()->validate(
            [
                'college_trading_name' => 'required',
                'college_company_name' => 'required',
                'rto_number' => 'required',
                'cricos_number' => 'required',
                'campus_address_1' => 'required',
                'admission_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges',
                'website' => 'required',
                'peo_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges',
                'marketing_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges',
            ],
            [
                'college_trading_name.required' => 'Please enter college trading name.',
                'college_company_name.required' => 'Please enter college name.',
                'rto_number.required' => 'Please enter RTO number.',
                'cricos_number.required' => 'Please enter cricos number.',
                'campus_address_1.required' => 'Please enter campus address one.',
                'admission_email.required' => 'Please enter admission email.',
                'website.required' => 'Please enter college website.',
                'peo_email.required' => 'Please enter PEO email.',
                'marketing_email.required' => 'Please enter marketing email.',
            ]);
     
        $college_trading_name = $request->college_trading_name;
        $college_company_name = $request->college_company_name;
        $rto_number = $request->rto_number;
        $cricos_number = $request->cricos_number;
        $campus_address_1 = $request->campus_address_1;
        $campus_address_2 = $request->campus_address_2;
        $admission_email = $request->admission_email;
        $website = $request->website;
        $peo_email = $request->peo_email;
        $marketing_email = $request->marketing_email;


    
        $add =  DB::table('colleges')->insert([

            'college_trading_name' => $college_trading_name,
            'college_company_name' => $college_company_name,
            'rto_number' => $rto_number,
            'cricos_number' => $cricos_number,
            'campus_address_1' =>  $campus_address_1,
            'campus_address_2' => $campus_address_2,
            'admission_email' => $admission_email,
            'website' => $website,
            'peo_email' => $peo_email,
            'marketing_email' => $marketing_email,
        
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

        if($add){
            return redirect('/admin/colleges')->with('success', 'College added !!');
        }    
        
    }

    public function view_colleges($id)
    {
        $id = base64_decode($id);

       
        $view_colleges = DB::table('colleges')->where('id', $id)->first();
      

        return view('/admin/viewcolleges', compact('view_colleges'));
        
    }

    public function edit_colleges($id)
    {

       
        $id = base64_decode($id);
        $user_type = Auth::user()->type;
        if ($user_type !=1)
        {
          return back()->with('error', 'You are not authorised to access this page !!');
          exit;
        }
    
        $edit_colleges = DB::table('colleges')->where('id', $id)->first();


        return view('/admin/editcolleges', compact('edit_colleges'));
    }

    public function update_colleges(Request $request,$id)
    {
       request()->validate(
       [
        'college_trading_name' => 'required',
        'college_company_name' => 'required',
        'rto_number' => 'required',
        'cricos_number' => 'required',
        'campus_address_1' => 'required',
        'admission_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges,admission_email,' . $id,
        'website' => 'required',
        'peo_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges,admission_email,' . $id,
        'marketing_email' => 'required|email|regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/|unique:colleges,admission_email,' . $id,
        
      ],
      [
        'college_trading_name.required' => 'Please enter college trading name.',
        'college_company_name.required' => 'Please enter college name.',
        'rto_number.required' => 'Please enter RTO number.',
        'cricos_number.required' => 'Please enter cricos number.',
        'campus_address_1.required' => 'Please enter campus address one.',
        'admission_email.required' => 'Please enter admission email.',
        'website.required' => 'Please enter college website.',
        'peo_email.required' => 'Please enter PEO email.',
        'marketing_email.required' => 'Please enter marketing email.',
        

      ]);

      $college_trading_name = $request->college_trading_name;
      $college_company_name = $request->college_company_name;
      $rto_number = $request->rto_number;
      $cricos_number = $request->cricos_number;
      $campus_address_1 = $request->campus_address_1;
      $campus_address_2 = $request->campus_address_2;
      $admission_email = $request->admission_email;
      $website = $request->website;
      $peo_email = $request->peo_email;
      $marketing_email = $request->marketing_email;

                         
      $update_colleges= DB::table('colleges')->where('id', $id)->update([
        'college_trading_name' => $college_trading_name,
        'college_company_name' => $college_company_name,
        'rto_number' => $rto_number,
        'cricos_number' => $cricos_number,
        'campus_address_1' =>  $campus_address_1,
        'campus_address_2' => $campus_address_2,
        'admission_email' => $admission_email,
        'website' => $website,
        'peo_email' => $peo_email,
        'marketing_email' => $marketing_email,

        'updated_at' => NOW()
      ]);

      if($update_colleges){
        return redirect ('/admin/colleges/')->with('success','College Details updated !!');
      }

    }

    public function delete_colleges($id)
    {
        $id = base64_decode($id);

        $delete_colleges = DB::table('colleges')->where('id', $id)->update(['is_delete' => 1,'deleted_by' => Auth::user()->first_name]);


        if($delete_colleges){
            return redirect('/admin/colleges')->with('error', 'College Deleted !!');
        }
      
    }

   
}
