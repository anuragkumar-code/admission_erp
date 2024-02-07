<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\tempnam;

require '../vendor/phpmailer/src/Exception.php';
require '../vendor/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/src/SMTP.php';

class UserController extends Controller
{



       
   public function login()
   {   
        return view('admin/login');
   }



   public function adminlogin(Request $request)
    {
        request()->validate(  
            [               
                'email' => 'required|email',
                'password' => 'required',
            ],
        );
    
        $email = $request->email;     
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'type' => 1, 
        ])) {

            return redirect('admin/dashboard');

        }
        
        
        else{        
            return back()->with('error', 'Incorrect id or password !');
        }
    } 
    

           
   public function stafflogin()
   {   
        return view('staff/login');
   }
   
   public function staffloggedin(Request $request)
   {    

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $curr_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $curr_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $curr_ip_address = $_SERVER['REMOTE_ADDR'];
    }

    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .=$_SERVER["SERVER_NAME"]. dirname($_SERVER["PHP_SELF"]);  

    request()->validate(  
        [               
            'email' => 'required|email',
            'password' => 'required',
        ],
    );

    $email = $request->email;     
    $password = $request->password;

    if (Auth::attempt(['email' => $email, 'password' => $password, 'type' => 2]))
    {
        $ip_address= Auth::user()->ip_address;
        $other_ip_allowed = Auth::user()->other_ip_allowed;
        $first_name = Auth::user()->first_name;
        $email = Auth::user()->email;
        $office_id = Auth::user()->office_id;
        $id = Auth::id();

        $url = url('/allow-staff') . '/' . base64_encode($email) . '/' . md5($id);

        $office = DB::table('offices')->where('id',$office_id)->first(); 

        //echo $ip_address.'=>'.$curr_ip_address; exit;

        if($ip_address == $curr_ip_address)
        {
            return redirect('staff/dashboard');
        }
        else if($other_ip_allowed == 1)
        {
            $update = DB::table('users')->where('id', $id)->update([
                'other_ip_allowed' => 0,
                'updated_at' => NOW(),
            ]);
            return redirect('staff/dashboard');
        }
        else
        {
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;        
            $mail->Username = 'satyendra.arrj@gmail.com';
            $mail->Password = 'ouawdioknoocemxy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->From = 'info@arrjdemo.in';
            $mail->FromName = 'Royal Migration';
            $mail->addAddress('satyendra.arrj@gmail.com');
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            $mail->Subject = 'Suspicious Staff Login Request';
            $mail->Body    = '

            <!DOCTYPE html><html><head><title>Royal Migration</title></head><body style="padding:0px; margin:0px; font-family: "Poppins", sans-serif; vertical-align:middle;">
    <table width="625" border="1" cellspacing="0" cellpadding="0" height="auto" align="center">
        <tr>
            <td style="background:#fff; padding:20px; border-radius:5px;">
                <p style="text-align:center">
                    <img width="200" src="'.$path.'"/admin/images/logo.png" alt="">
                </p>
                <p style="font-weight:600;color:#000;text-align:center; font-size: 22px; text-transform: uppercase;">Dear Admin,</p>
                
                <p style="color:#000;text-align:center; font-size: 16px;">One of the staff memeber try to login with diffrent IP Address. Please find the details below of the staff member.<br></p>
                    
                    <table width="625" border="1" cellspacing="0" cellpadding="0" height="auto" align="center" style="color:#000;text-align:center; font-size: 16px;">
            <tr>   
            <td>Name</td>
            <td>'.$first_name.'</td>
            </tr>
            <tr>
            <td>Email</td>
            <td>'.$email.'</td>
            </tr>
            <tr>
            <td>Office</td>
            <td>'.$office->name.'</td>
            </tr>
            <tr>
            <td>IP Address</td>
            <td>'.$curr_ip_address.'</td>
            </tr>            
            </thead>
            <tbody>
            </table>
                
            <p style="color:#FFFFFF;text-align:center; font-size: 16px;">Allow Staff :<a href="'.$url.'"> Click Here to Allow </a> </p>
                <p style="color:#FFFFFF;text-align:center; font-size: 16px;">Good luck! Hope it works.</p><p style="color:#FFFFFF;text-align:center; font-size: 16px;">Team RMS</p></td></tr></table></body>
    <p>Thank you</p>
</body>
</html>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send())
            {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
            else
            {
                session()->flush();
            return back()->with('error', 'You Are currently working with unauthorised IP address and not allowed to access Please contact Admin!');
            }


            
        }

    }
    else
    {        
        return back()->with('error', 'Incorrect id or password !');
    }
} 

   public function other_login()
   {   
        return view('admin/other_adminlogin');
   }


   

   public function other_adminlogin(Request $request)
   {

       request()->validate(  
           [               
               'email' => 'required|email',
               'password' => 'required',
           ],
       );
   
       $email = $request->email;     
       $password = $request->password;


       if (Auth::attempt(['email' => $email, 'password' => $password, 'type' => 3

       ])) {
 
      
                   $is_delete = Auth::user()->is_delete;


                    if($is_delete == 1)
                    {
                        return back()->with('error', 'Your Account is suspended !');
                    }

           return redirect('admin/dashboard');

       }
       
       
       else{        
           return back()->with('error', 'Incorrect id or password !');
       }
   } 

   
   
   public function form()
   {   
    $countries = DB::table('countries')->get();

        return view('form',compact('countries'));


   }


    public function form_students(Request $request)
    {

        request()->validate(
            [
                'first_name' => 'required',
                'dob' => 'required',
                'marital_status' => 'required',
                'address' => 'required',
                'country' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'visa_type' => 'required',
                'visa_expiry_date' => 'required',
                'purpose' => 'required',
                'declaration' => 'required',
                'referral' => 'required',

                
            ],
            [
                'first_name.required' => 'Please Enter First Name.',
                'dob.required' => 'Please Choose Date of Birth.',
                'marital_status.required' => 'Please Specify Marital Status.',
                'address.required' => 'Please Enter Address.',
                'country.required' => 'Please Choose Country.',
                'phone.required' => 'Please Enter Mobile Number.',
                'email.required' => 'Please Enter Email Address.',
                'visa_type.required' => 'Please Enter Type of Visa.',
                'visa_expiry_date.required' => 'Please Choose Visa Expiry Date.',
                'purpose.required' => 'Please Choose Purpose of Visit.',
                'declaration.required' => 'Please Check Declaration.',
                'referral.required' => 'Please Choose Referral.',

                
            ]);


            if($request->purpose == 'Other Services'){
                request()->validate(
                [
                    'other_purpose' => 'required',                            
                ],
                [
                    'other_purpose.required' => 'Please Specify the Purpose.',             
                ] );
               
            }
    
            
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $marital_status = $request->marital_status;
        $dob = $request->dob;
        $address = $request->address;
        $phone = $request->phone;
        $email = $request->email;
        $preferred_college = $request->preferred_college;
        $preferred_course = $request->preferred_course;
        $preferred_intake = $request->preferred_intake;
        $preferred_location = $request->preferred_location;
        $visa_type = $request->visa_type;
        $visa_expiry_date = $request->visa_expiry_date;
        $other_referral = $request->other_referral;
        $country = $request->country;
        $purpose = $request->purpose;
        $other_purpose = $request ->other_purpose;
        $referral = $request->referral;

      
        
        $add =  DB::table('students')->insert([

            'first_name' => $first_name,            
            'last_name' => $last_name,
            'dob' => $dob,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'preferred_college' => $preferred_college,
            'preferred_course' => $preferred_course,
            'preferred_intake' => $preferred_intake,
            'preferred_location' => $preferred_location,
            'visa_type' => $visa_type,
            'visa_expiry_date' => $visa_expiry_date,
            'referral' => $referral,
            'marital_status' => $marital_status,
            'other_purpose' => $other_purpose,
            'other_referral' => $other_referral,
            'purpose' => $purpose,
            'country' => $country,
            'type' => 1,
            'added_by' => 1,
            'updated_at' => NOW(),
            'created_at' => NOW(),

        ]);

        if($add){
            return back()->with('success', 'Congratulations your details are registered !!');
        }    
        else echo "error";exit;
    }

 





}
  

                
    

