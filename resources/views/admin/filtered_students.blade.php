@extends('admin.layout.head')
@section('admin')

<style type="text/css">
    .only_header
    {
        display: none !important;
    }
</style>

<?php
$name = $dob = $phone = '';

$name = Request::get('name');
$dob = Request::get('dob'); 
$phone = Request::get('phone');

//echo "DOB =>".$name.'DOB =>'.$dob.'Phone =>'.$phone;


?>
<link rel="stylesheet" href="{{ asset('admin/css/bootstrap-datepicker.css') }}">
  <script src="{{ asset('admin/js/bootstrap-datepicker.min.js') }}"></script>

   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script type="text/javascript">
    
    $("#startdate1").datepicker({

           todayBtn:  1,
           startDate: new Date(),
           autoclose: true,
           format: 'dd/mm/yyyy',
           orientation: 'top',

        }).on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());

            $('#enddate').datepicker('setStartDate', minDate);

        });


        </script>

<div class="main">
        <div class="container-fluid">
            <div class="header">      
                <div class="container-fluid">
                    <div class="topnavstrip">
                        <div class="row">

                            <div class="col-md-1">
                                <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                   
                            </div>
                        </div>
                            <div class="col-md-9">
                                <form action="{{url('/admin/search')}}" method="get" class="top-search">
                                    <input type="text" class="form-control" name="name" value="{{ app('request')->input('name') }}" placeholder="Student Name">
                                    <input type="text" id="startdate1" class="form-control" name="dob" value="{{ app('request')->input('dob') }}"  placeholder="dd/mm/yyyy">
                                    <input type="text" class="form-control" name="phone" value="{{ app('request')->input('phone') }}" placeholder="Mobile No.">
                                    <input type="hidden" name="st_type" value="prospects">
                                    <button type="submit" class="btn btn-outline-info searchbtnsinto"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        
                            <div class="col-md-2 mobilehides">
                                <div class="dropdown dib" style="float: right">
                                    <div class="header-icon" data-toggle="dropdown">
                                        <span class="user-avatar">{{Auth::user()->first_name}}
                                            <i class="ti-angle-down f-s-10"></i>
                                        </span>
                                        <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-content-heading">
                                                <span class="text-left">{{Auth::user()->first_name}}</span>
                                            </div>
                                            <div class="dropdown-content-body">
                                                <ul>
                                                    <li>
                                                        <a href="{{route('change_password')}}">
                                                            <i class="fa fa-key"></i>
                                                            <span>Change Password</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('adminLogout')}}">
                                                            <i class="fa fa-power-off"></i>
                                                            <span>Logout</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  

<div style="clear: both;">&nbsp;</div>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            @if(session()->has('success'))
            <div class="alert alert-success" id="myDIV" role="alert">
                <strong>{{session()->get('success')}}</strong> 
                <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                   
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger" id="myDIV" role="alert">
                <strong>{{session()->get('error')}}</strong> 
                <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                    
            </div>
            @endif


<?php

 $start_pass_exp_date = $end_pass_exp_date = $start_visa_exp_date = $end_visa_exp_date = $start_dob = $end_dob = $start_completion_date = $end_completion_date = $start_fees_due_date = $end_fees_due_date = '';

$student_type = $register_type = $australian_id = $marital_status = $gender = $referral = $purpose_of_visit = $college = $country = $offices = $community = array();


if(Request::get('_token') != '')
{

if(Request::get('community') != '')
{
$community = implode(',', Request::get('community'));
$community = explode(',', $community);
}

if(Request::get('student_type') != '')
{
$student_type = implode(',', Request::get('student_type'));
$student_type = explode(',', $student_type);
}

if(Request::get('register_type') != '')
{
$register_type = implode(',', Request::get('register_type'));
$register_type = explode(',', $register_type);
}


$start_pass_exp_date = Request::get('start_pass_exp_date');
$end_pass_exp_date = Request::get('end_pass_exp_date');
$start_visa_exp_date = Request::get('start_visa_exp_date');
$end_visa_exp_date = Request::get('end_visa_exp_date');
$start_completion_date = Request::get('start_completion_date');
$end_completion_date = Request::get('end_completion_date');

$start_fees_due_date = Request::get('start_fees_due_date');
$end_fees_due_date = Request::get('end_fees_due_date');



$start_dob = Request::get('start_dob');
$end_dob = Request::get('end_dob');
$australian_id = Request::get('australian_id');

if(Request::get('marital_status') != '')
{
$marital_status = implode(',', Request::get('marital_status'));
$marital_status = explode(',', $marital_status);
}

//$gender = Request::get('gender');
if(Request::get('gender') != '')
{
$gender = implode(',', Request::get('gender'));
$gender = explode(',', $gender);
}
//$referral = Request::get('referral');
if(Request::get('referral') != '')
{
$referral = implode(',', Request::get('referral'));
$referral = explode(',', $referral);
}
//$purpose_of_visit = Request::get('purpose_of_visit');
if(Request::get('purpose_of_visit') != '')
{
$purpose_of_visit = implode(',', Request::get('purpose_of_visit'));
$purpose_of_visit = explode(',', $purpose_of_visit);
}


//$college = Request::get('college');
if(Request::get('college') != '')
{
$college = implode(',', Request::get('college'));
$college = explode(',', $college);
}

if(Request::get('offices') != '')
{
$offices = implode(',', Request::get('offices'));
$offices = explode(',', $offices);
}

//$country = Request::get('country');
if(Request::get('country')!= '')
{
$country = implode(',', Request::get('country'));
$country = explode(',', $country);
}
}
/*else
{
   
}*/

//echo "<pre>"; print_r($register_type); exit;

?>

            <div class="row">

                <div class="col-md-3">                   
                        <div id="filters">
                            <div class="accordion" id="faq">
                                <form name="filter_form" action="{{ url('admin/filtered_students') }}" method="get">



                                    <?php
                                if($start_visa_exp_date != '' || $end_visa_exp_date != '')
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead4">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4">Visa Expiry Date</a>
                                    </div>

                                    <div id="faq4" class="<?php echo $open_class; ?>" aria-labelledby="faqhead4" data-parent="#faq">
                                        <div class="card-body">
                                            <input type="date" name="start_visa_exp_date" class="form-control visa_exp_date" value="<?php if(isset($start_visa_exp_date) && $start_visa_exp_date != ''){ echo $start_visa_exp_date; } ?>">
                                            <input type="date" name="end_visa_exp_date" class="form-control visa_exp_date" value="<?php if(isset($end_visa_exp_date) && $end_visa_exp_date != ''){ echo $end_visa_exp_date; } ?>">
                                        </div>
                                    </div>
                                </div>



                                 <?php
                                 $id = Auth::id(); 
                                 if($id == 1)
                                 {
                                if(!empty($offices))
                                {
                                    $offices_collapse_class = '';
                                    $offices_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $offices_collapse_class = 'collapsed';
                                    $offices_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead13">
                                        <a href="#" class="btn btn-header-link <?php echo $offices_collapse_class; ?>" data-toggle="collapse" data-target="#faq13" aria-expanded="true" aria-controls="faq13">Office</a>
                                    </div>

                                    <div id="faq13" class="<?php echo $offices_open_class; ?>" aria-labelledby="faqhead13" data-parent="#faq">
                                        <div class="card-body">

                                           <?php

                                           if($get_offices)
                                           {
                                            $count = 90;
                                            foreach ($get_offices as $key => $get_offices_val)
                                            {
                                                
                                             $checked = '';
                                             if($offices != '')
                                             {
                                             if (in_array($get_offices_val->id, $offices))
                                              {
                                                $checked = 'checked';
                                              }
                                              else
                                              {
                                                $checked = '';
                                              }
                                            }
                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" <?php echo $checked; ?> class="custom-control-input college" id="customCheck<?php echo $count; ?>" name="offices[]"  value="<?php echo $get_offices_val->id; ?>">
                                                <label class="custom-control-label" for="customCheck<?php echo $count; ?>"><?php echo $get_offices_val->name; ?></label>
                                            </div>
                                            <?php
                                            $count++;
                                            }
                                           }
                                            ?>                                         

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php
                                 $id = Auth::id();                                  
                                if(!empty($community))
                                {
                                    $community_collapse_class = '';
                                    $community_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $community_collapse_class = 'collapsed';
                                    $community_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead9">
                                        <a href="#" class="btn btn-header-link <?php echo $community_collapse_class; ?>" data-toggle="collapse" data-target="#faq09" aria-expanded="true" aria-controls="faq09">Community</a>
                                    </div>

                                    <div id="faq09" class="<?php echo $community_open_class; ?>" aria-labelledby="faqhead09" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input purpose_of_visit" id="community12" name="community[]" <?php if(in_array('Assamese',$community)){?> checked <?php } ?> value="Assamese">
                                                <label class="custom-control-label" for="community12">Assamese
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community13" name="community[]" <?php if(in_array('Bengali',$community)){?> checked <?php } ?> value="Bengali">
                                                <label class="custom-control-label" for="community13">Bengali
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community14" name="community[]" <?php if(in_array('Hindi',$community)){?> checked <?php } ?> value="Hindi">
                                                <label class="custom-control-label" for="community14">Hindi
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community15" name="community[]" <?php if(in_array('Kannada',$community)){?> checked <?php } ?> value="Kannada">
                                                <label class="custom-control-label" for="community15">Kannada
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community16" name="community[]" <?php if(in_array('Kashmiri',$community)){?> checked <?php } ?> value="Kashmiri">
                                                <label class="custom-control-label" for="community16">Kashmiri
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community17" name="community[]" <?php if(in_array('Konkani',$community)){?> checked <?php } ?> value="Konkani">
                                                <label class="custom-control-label" for="community17">Konkani
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community18" name="community[]" <?php if(in_array('Malayalam',$community)){?> checked <?php } ?> value="Malayalam">
                                                <label class="custom-control-label" for="community18">Malayalam</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community19" name="community[]" <?php if(in_array('Manipuri',$community)){?> checked <?php } ?> value="Manipuri">
                                                <label class="custom-control-label" for="community19">Manipuri
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community20" name="community[]" <?php if(in_array('Marathi',$community)){?> checked <?php } ?> value="Marathi">
                                                <label class="custom-control-label" for="community20">Marathi
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community21" name="community[]" <?php if(in_array('Nepali',$community)){?> checked <?php } ?> value="Nepali">
                                                <label class="custom-control-label" for="community21">Nepali
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community22" name="community[]" <?php if(in_array('Oriya',$community)){?> checked <?php } ?> value="Oriya">
                                                <label class="custom-control-label" for="community22">Oriya
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community23" name="community[]" <?php if(in_array('Punjabi',$community)){?> checked <?php } ?> value="Punjabi">
                                                <label class="custom-control-label" for="community23">Punjabi
                                                </label>
                                            </div>


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community25" name="community[]" <?php if(in_array('Tamil',$community)){?> checked <?php } ?> value="Tamil">
                                                <label class="custom-control-label" for="community25">Tamil
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community26" name="community[]" <?php if(in_array('Telugu',$community)){?> checked <?php } ?> value="Telugu">
                                                <label class="custom-control-label" for="community26">Telugu
                                                </label>
                                            </div>  

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community27" name="community[]" <?php if(in_array('Urdu',$community)){?> checked <?php } ?> value="Urdu">
                                                <label class="custom-control-label" for="community27">Urdu
                                                </label>
                                            </div> 

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community29" name="community[]" <?php if(in_array('Santhali',$community)){?> checked <?php } ?> value="Santhali">
                                                <label class="custom-control-label" for="community29">Santhali
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community30" name="community[]" <?php if(in_array('Maithili',$community)){?> checked <?php } ?> value="Maithili">
                                                <label class="custom-control-label" for="community30">Maithili
                                                </label>
                                            </div> 

                                          
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community32" name="community[]" <?php if(in_array('Filipino',$community)){?> checked <?php } ?> value="Filipino">
                                                <label class="custom-control-label" for="community32">Filipino
                                                </label>
                                            </div>


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community33" name="community[]" <?php if(in_array('Fiji Indian',$community)){?> checked <?php } ?> value="Fiji Indian">
                                                <label class="custom-control-label" for="community33">Fiji Indian</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community34" name="community[]" <?php if(in_array('Gujarati',$community)){?> checked <?php } ?> value="Gujarati">
                                                <label class="custom-control-label" for="community34">Gujarati
                                                </label>
                                            </div>

                                             <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community35" name="community[]" <?php if(in_array('Malaysian',$community)){?> checked <?php } ?> value="Malaysian">
                                                <label class="custom-control-label" for="community35">Malaysian</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community36" name="community[]" <?php if(in_array('Labinies',$community)){?> checked <?php } ?> value="Labinies">
                                                <label class="custom-control-label" for="community36">Labinies
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community37" name="community[]" <?php if(in_array('Spanish',$community)){?> checked <?php } ?> value="Spanish">
                                                <label class="custom-control-label" for="community37">Spanish
                                                </label>
                                            </div>


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community38" name="community[]" <?php if(in_array('Portuguese',$community)){?> checked <?php } ?> value="Portuguese">
                                                <label class="custom-control-label" for="community38">Portuguese</label>
                                            </div>


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input community" id="community39" name="community[]" <?php if(in_array('Thai',$community)){?> checked <?php } ?> value="Thai">
                                                <label class="custom-control-label" for="community39">Thai
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                             <?php
                                if(!empty($purpose_of_visit))
                                {
                                    $purpose_collapse_class = '';
                                    $purpose_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $purpose_collapse_class = 'collapsed';
                                    $purpose_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead9">
                                        <a href="#" class="btn btn-header-link <?php echo $purpose_collapse_class; ?>" data-toggle="collapse" data-target="#faq9" aria-expanded="true" aria-controls="faq9">Purpose of visit</a>
                                    </div>

                                    <div id="faq9" class="<?php echo $purpose_open_class; ?>" aria-labelledby="faqhead9" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input purpose_of_visit" id="customCheck12" name="purpose_of_visit[]" <?php if(in_array('tr',$purpose_of_visit)){?> checked <?php } ?> value="tr">
                                                <label class="custom-control-label" for="customCheck12">TR</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input purpose_of_visit" id="customCheck13" name="purpose_of_visit[]" <?php if(in_array('pr',$purpose_of_visit)){?> checked <?php } ?> value="pr">
                                                <label class="custom-control-label" for="customCheck13">PR</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input purpose_of_visit" id="customCheck14" name="purpose_of_visit[]" <?php if(in_array('change course',$purpose_of_visit)){?> checked <?php } ?> value="change course">
                                                <label class="custom-control-label" for="customCheck14">Change Course</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input purpose_of_visit" id="customCheck15" name="purpose_of_visit[]" <?php if(in_array('other services',$purpose_of_visit)){?> checked <?php } ?> value="other services">
                                                <label class="custom-control-label" for="customCheck15">Others</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                 <?php
                                if($start_completion_date != '' || $end_completion_date != '')
                                {
                                    $completion_collapse_class = '';
                                    $completion_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $completion_collapse_class = 'collapsed';
                                    $completion_open_class = 'collapse';
                                }
                                ?>


                                <div class="card">
                                    <div class="card-header" id="faqhead911">
                                        <a href="#" class="btn btn-header-link <?php echo $completion_collapse_class; ?>" data-toggle="collapse" data-target="#faq911" aria-expanded="true" aria-controls="faq911">Completion of Course</a>
                                    </div>

                                    <div id="faq911" class="<?php echo $completion_open_class; ?>" aria-labelledby="faqhead911" data-parent="#faq">
                                        <div class="card-body">
                                            
                                             <input type="date" name="start_completion_date" class="form-control completion_date" value="<?php if(isset($start_completion_date) && $start_completion_date != ''){ echo $start_completion_date; } ?>">
                                            <input type="date" name="end_completion_date" class="form-control completion_date" value="<?php if(isset($end_completion_date) && $end_completion_date != ''){ echo $end_completion_date; } ?>">                         

                                        </div>
                                    </div>
                                </div>


                                <?php
                                if($start_fees_due_date != '' || $end_fees_due_date != '')
                                {
                                    $fees_due_collapse_class = '';
                                    $fees_due_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $fees_due_collapse_class = 'collapsed';
                                    $fees_due_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead912">
                                        <a href="#" class="btn btn-header-link <?php echo $fees_due_collapse_class; ?>" data-toggle="collapse" data-target="#faq912" aria-expanded="true" aria-controls="faq912">Fees Due Date</a>
                                    </div>

                                    <div id="faq912" class="<?php echo $fees_due_open_class; ?>" aria-labelledby="faqhead912" data-parent="#faq">
                                        <div class="card-body">
                                            
                                             <input type="date" name="start_fees_due_date" class="form-control fees_due_date" value="<?php if(isset($start_fees_due_date) && $start_fees_due_date != ''){ echo $start_fees_due_date; } ?>">
                                            <input type="date" name="end_fees_due_date" class="form-control fees_due_date" value="<?php if(isset($end_fees_due_date) && $end_fees_due_date != ''){ echo $end_fees_due_date; } ?>">                         

                                        </div>
                                    </div>
                                </div>


                                <button type="button" class="btn showall">Show All Filter</button>

                                <div class="extra_filter d-none">

                                    <?php
                                if(!empty($student_type))
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead1">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">Student Type</a>
                                    </div>

                                    <div id="faq1" class="<?php echo $open_class; ?>" aria-labelledby="faqhead1" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input student_type" id="customCheck" <?php if(in_array(1,$student_type)){?> checked <?php } ?> name="student_type[]" value="1">
                                                <label class="custom-control-label" for="customCheck">Walking</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input student_type" id="customCheck2" <?php if(in_array(2,$student_type)){?> checked <?php } ?> name="student_type[]" value="2">
                                                <label class="custom-control-label" for="customCheck2">Converted</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <?php
                                if(!empty($register_type))
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead2">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2">Register Type</a>
                                    </div>

                                    <div id="faq2" class="<?php echo $open_class; ?>" aria-labelledby="faqhead2" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input register_type" id="customCheck3" <?php if(in_array(1,$register_type)){ ?> checked <?php } ?> name="register_type[]" value="1">
                                                <label class="custom-control-label" for="customCheck3">Self</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input register_type" id="customCheck4" <?php if(in_array(2,$register_type)) {?> checked <?php } ?> name="register_type[]" value="2">
                                                <label class="custom-control-label" for="customCheck4">Admin/Office</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <?php
                                if($start_pass_exp_date != '' || $end_pass_exp_date != '')
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead3">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">Passport Expiry Date</a>
                                    </div>

                                    <div id="faq3" class="<?php echo $open_class; ?>" aria-labelledby="faqhead3" data-parent="#faq">
                                        <div class="card-body">

                                            <input type="date" name="start_pass_exp_date" class="form-control pass_exp_date" value="<?php if(isset($start_pass_exp_date) && $start_pass_exp_date != ''){ echo $start_pass_exp_date; } ?>">
                                            <input type="date" name="end_pass_exp_date" class="form-control pass_exp_date" value="<?php if(isset($end_pass_exp_date) && $end_pass_exp_date != ''){ echo $end_pass_exp_date; } ?>">

                                        </div>
                                    </div>
                                </div>


                                


                                <?php
                                if(!empty($australian_id))
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead5">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5">Australian ID</a>
                                    </div>

                                    <div id="faq5" class="<?php echo $open_class; ?>" aria-labelledby="faqhead5" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck5" name="australian_id" <?php if(isset($australian_id) && $australian_id == 1){?> checked <?php } ?> value="1">
                                                <label class="custom-control-label" for="customCheck5">Have Australian ID</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                if(!empty($marital_status))
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead6">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq6" aria-expanded="true" aria-controls="faq6">Marital Status</a>
                                    </div>

                                    <div id="faq6" class="<?php echo $open_class; ?>" aria-labelledby="faqhead6" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck121" name="marital_status[]" <?php if(in_array('De Facto',$marital_status)){?> checked <?php } ?> value="De Facto">
                                                <label class="custom-control-label" for="customCheck121">De Facto</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck122" name="marital_status[]" <?php if(in_array('Divorced',$marital_status)){?> checked <?php } ?> value="Divorced">
                                                <label class="custom-control-label" for="customCheck122">Divorced</label>
                                            </div> 

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck123" name="marital_status[]" <?php if(in_array('Engaged',$marital_status)){?> checked <?php } ?> value="Engaged">
                                                <label class="custom-control-label" for="customCheck123">Engaged</label>
                                            </div>  

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck127" name="marital_status[]" <?php if(in_array('married',$marital_status)){?> checked <?php } ?> value="married">
                                                <label class="custom-control-label" for="customCheck127">Married</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck124" name="marital_status[]" <?php if(in_array('Never Married',$marital_status)){?> checked <?php } ?> value="Never Married">
                                                <label class="custom-control-label" for="customCheck124">Never Married</label>
                                            </div>  

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck125" name="marital_status[]" <?php if(in_array('Separated',$marital_status)){?> checked <?php } ?> value="Separated">
                                                <label class="custom-control-label" for="customCheck125">Separated</label>
                                            </div>  


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck126" name="marital_status[]" <?php if(in_array('Widowed',$marital_status)){?> checked <?php } ?> value="Widowed">
                                                <label class="custom-control-label" for="customCheck126">Widowed</label>
                                            </div> 
                                           
                                        </div>
                                    </div>
                                </div>


                                <?php
                                if(!empty($gender))
                                {
                                    $collapse_class = '';
                                    $open_class = 'collapse show in';
                                }
                                else
                                {
                                    $collapse_class = 'collapsed';
                                    $open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead7">
                                        <a href="#" class="btn btn-header-link <?php echo $collapse_class; ?>" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7">Gender</a>
                                    </div>

                                    <div id="faq7" class="<?php echo $open_class; ?>" aria-labelledby="faqhead7" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input gender" id="customCheck06" name="gender[]" <?php if(in_array('Male',$gender)){?> checked <?php } ?> value="Male">
                                                <label class="custom-control-label" for="customCheck06">Male</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input gender" id="customCheck07" name="gender[]" <?php if(in_array('Female',$gender)){?> checked <?php } ?> value="Female">
                                                <label class="custom-control-label" for="customCheck07">Female</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                if(!empty($referral))
                                {
                                    $referral_collapse_class = '';
                                    $referral_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $referral_collapse_class = 'collapsed';
                                    $referral_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead8">
                                        <a href="#" class="btn btn-header-link <?php echo $referral_collapse_class; ?>" data-toggle="collapse" data-target="#faq8" aria-expanded="true" aria-controls="faq8">Referral</a>
                                    </div>


                                    <div id="faq8" class="<?php echo $referral_open_class; ?>" aria-labelledby="faqhead8" data-parent="#faq">
                                        <div class="card-body">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck8" name="referral[]" <?php if(in_array('friend',$referral)){?> checked <?php } ?> value="friend">
                                                <label class="custom-control-label" for="customCheck8">Friend</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck9" name="referral[]" <?php if(in_array('website',$referral)){?> checked <?php } ?> value="website">
                                                <label class="custom-control-label" for="customCheck9">Website</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck10" name="referral[]" <?php if(in_array('advertisement',$referral)){?> checked <?php } ?> value="advertisement">
                                                <label class="custom-control-label" for="customCheck10">Advertisement</label>
                                            </div>

                                             <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck102" name="referral[]" <?php if(in_array('Social Media',$referral)){?> checked <?php } ?> value="Social Media">
                                                <label class="custom-control-label" for="customCheck102">Social Media</label>
                                            </div>


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck103" name="referral[]" <?php if(in_array('Google',$referral)){?> checked <?php } ?> value="Google">
                                                <label class="custom-control-label" for="customCheck103">Google</label>
                                            </div>                                            


                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input referral" id="customCheck11" name="referral[]" <?php if(in_array('others',$referral)){?> checked <?php } ?> value="others">
                                                <label class="custom-control-label" for="customCheck11">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               

                                <?php
                                if(!empty($college))
                                {
                                    $college_collapse_class = '';
                                    $college_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $college_collapse_class = 'collapsed';
                                    $college_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead10">
                                        <a href="#" class="btn btn-header-link <?php echo $college_collapse_class; ?>" data-toggle="collapse" data-target="#faq10" aria-expanded="true" aria-controls="faq10">College</a>
                                    </div>

                                    <div id="faq10" class="<?php echo $college_open_class; ?>" aria-labelledby="faqhead10" data-parent="#faq">
                                        <div class="card-body">

                                           <?php

                                           if($get_colleges)
                                           {
                                            $count = 16;
                                            foreach ($get_colleges as $key => $get_colleges_val)
                                            {
                                                
                                             $checked = '';
                                             if($college != '')
                                             {
                                             if (in_array($get_colleges_val->id, $college))
                                              {
                                                $checked = 'checked';
                                              }
                                              else
                                              {
                                                $checked = '';
                                              }
                                            }
                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" <?php echo $checked; ?> class="custom-control-input college" id="customCheck<?php echo $count; ?>" name="college[]"  value="<?php echo $get_colleges_val->id; ?>">
                                                <label class="custom-control-label" for="customCheck<?php echo $count; ?>"><?php echo $get_colleges_val->college_trading_name; ?></label>
                                            </div>
                                            <?php
                                            $count++;
                                            }
                                           }
                                            ?>                                         

                                        </div>
                                    </div>
                                </div>

                               

                                <?php
                                if($start_dob != '' || $end_dob != '')
                                {
                                    $dob_collapse_class = '';
                                    $dob_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $dob_collapse_class = 'collapsed';
                                    $dob_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead11">
                                        <a href="#" class="btn btn-header-link <?php echo $dob_collapse_class; ?>" data-toggle="collapse" data-target="#faq11" aria-expanded="true" aria-controls="faq11">Date of Birth</a>
                                    </div>

                                    <div id="faq11" class="<?php echo $dob_open_class; ?>" aria-labelledby="faqhead11" data-parent="#faq">
                                        <div class="card-body">
                                            <input type="date" placeholder="From" name="start_dob" class="form-control dob" value="<?php if(isset($start_dob) && $start_dob != ''){ echo $start_dob; } ?>">
                                            <input type="date" placeholder="To" name="end_dob" class="form-control end_dob" value="<?php if(isset($end_dob) && $end_dob != ''){ echo $end_dob; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if(!empty($country))
                                {
                                    $country_collapse_class = '';
                                    $country_open_class = 'collapse show in';
                                }
                                else
                                {
                                    $country_collapse_class = 'collapsed';
                                    $country_open_class = 'collapse';
                                }
                                ?>

                                <div class="card">
                                    <div class="card-header" id="faqhead12">
                                        <a href="#" class="btn btn-header-link <?php echo $country_collapse_class; ?>" data-toggle="collapse" data-target="#faq12" aria-expanded="true" aria-controls="faq12">Country</a>
                                    </div>

                                    <div id="faq12" class="<?php echo $country_open_class; ?>" aria-labelledby="faqhead12" data-parent="#faq">
                                        <div class="card-body">

                                            <?php
                                            if($get_country)
                                            {
                                                $count = 100;
                                                foreach ($get_country as $key => $get_country_val)
                                                {
                                                ?>

                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input country" id="customCheck<?php echo $count; ?>" name="country[]" <?php if(in_array($get_country_val->country,$country)){?> checked <?php } ?> value="{{$get_country_val->country}}">
                                                    <label class="custom-control-label" for="customCheck<?php echo $count; ?>">{{$get_country_val->country}}</label>
                                                </div>

                                                <?php
                                                $count++;
                                                }
                                            }
                                             ?>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn hideall">Hide Extra Filter</button>
                            </div>
                        </div>

                            <div class="btngro03">
                            <button type="submit" style="cursor:pointer;">Submit</button>
                            <button type="submit" name="excel" style="cursor:pointer;" value="excel">Excel</button>
                            <a href="{{url('admin/filtered_students')}}">Clear</a>
                        </div>

                        </div>

                    </div>


                <div class="col-md-9">
                <div class="studenttab">                   
                    <div id="prospect" class="tabcontent">                    
                        <div class="contentinner">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive studenttabless">      
                                <div class="table_scroll">
                                    <?php $hideclass = ''; ?>                                                           
                                    <table class="table table-striped table-bordered" id="filterd_data">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">S. No.</th>           
                                            <th scope="col">Name</th>
                                            <th scope="col">Staff Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone No.</th>
                                           <?php
                                            if($start_visa_exp_date != '' || $end_visa_exp_date != '')
                                            {
                                            ?>   
                                            <th scope="col">Visa Exp.</th>
                                        <?php } ?>
                                        <?php
                                            if($start_completion_date != '' || $end_completion_date != '')
                                            {
                                            ?> 
                                              <th scope="col">Course</th>
                                              <th scope="col">Course Completion</th>
                                        <?php } ?>
                                        <?php
                                        if($start_fees_due_date != '' || $end_fees_due_date != '')
                                        {
                                        ?>  
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Course</th>
                                    <?php } ?>

                                        <?php
                                        if($start_pass_exp_date != '' || $end_pass_exp_date != '')
                                        {
                                        ?> 
                                        <th scope="col">Passport Expire</th>
                                    <?php } ?>

                                    <?php
                                         if(Request::get('college') != '')
                                        {
                                        ?>
                                        <th>College</th>
                                    <?php } ?>

                                    <?php
                                    if(Request::get('offices') != '')
                                       {
                                     ?>
                                     <th scope="col">Office Name</th>
                                 <?php } ?>
                                            <th scope="col">Country</th>               
                                            <th scope="col">Type</th>               
                                            <th scope="col"></th>                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php //echo "<pre>"; print_r($students); exit;
                                            if($students ){ 
                                                foreach ($students as $key => $get_student) { ?>                                           
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                  
                                                    <td><a style="color: blue" href="{{url('admin/student-details/'.base64_encode($get_student->stid))}}">{{$get_student->first_name}} {{$get_student->middle_name}} {{$get_student->last_name}}
                                                    </a>
                                                    <?php
                                                    if($get_student->type == 1){
                                                        ?>
                                                    <i class='fa fa-times-circle' style='color:red'></i>
                                                    <?php } else { ?>
                                                        <i class="fa fa-check-circle" style="color:#39f358">
                                                    </i>
                                                    <?php } ?>
                                                       </td>

                                                    <td>{{$get_student->staff_name}} @if(Auth::user()->type==1 )  <?php if(isset($get_student->office_name)) {?>({{$get_student->office_name}}) <?php }?> @endif </td>

                                                    <td>{{$get_student->email}}</td>
                                                    <td>{{$get_student->phone}}</td>
                                                    <?php
                                                    if($start_visa_exp_date != '' || $end_visa_exp_date != '')
                                                    {
                                                        ?>  
                                                    <td>{{$get_student->visa_expiry_date}}</td>
                                                    <?php } ?>

                                                    <?php
                                            if($start_completion_date != '' || $end_completion_date != '')
                                            {
                                            ?> 
                                            <td>{{$get_student->course_name}}</td>
                                            <td>{{$get_student->course_completion_date}}</td>
                                        <?php } ?>

                                        <?php
                                        if($start_fees_due_date != '' || $end_fees_due_date != '')
                                        {
                                        ?> 
                                        <td>{{$get_student->fee_due_date}}</td>
                                        <td>{{$get_student->course_name}}</td>
                                        <?php } ?>

                                       <?php
                                        if($start_pass_exp_date != '' || $end_pass_exp_date != '')
                                        {
                                        ?>
                                        <td>{{$get_student->passport_expiry_date}}</td>
                                    <?php } ?>

                                    <?php
                                        if(Request::get('college') != '')
                                        {
                                        ?>
                                        <td>{{$get_student->college_trading_name}}</td>
                                    <?php } ?>

                                    <?php
                                    if(Request::get('offices') != '')
                                       {
                                     ?>
                                       <td>{{$get_student->office_name}}</td> 

                                 <?php } ?>

                                                    <td>{{$get_student->country}}</td>       
                                                    <td>
                                                        <?php if($get_student->added_by == 1){ ?>
                                                            Self
                                                        <?php } else {?>
                                                            Admin
                                                        <?php } ?>
                                                    </td>         
                                                    <td width="200"> 
                                                    <?php
                                                    if($get_student->type == 1){
                                                        ?>                             
                                                        <a href="javascript:void(0);" data-id="{{$get_student->stid}}" data-name="{{$get_student->first_name}}" data-phone="{{$get_student->phone}}"  data-dialcode="{{$get_student->phone_dialcode}}"  data-flag="{{$get_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_sms"><i style='font-size:22px !important' class="fa fa-comment-o"></i></a>    


                                                        <a href="javascript:void(0);" data-id="{{$get_student->stid}}" data-name="{{$get_student->first_name}}" data-phone="{{$get_student->phone}}"  data-dialcode="{{$get_student->phone_dialcode}}"  data-flag="{{$get_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_whatsapp"><i style='font-size:22px !important'  class="fa fa-whatsapp" aria-hidden="true"></i></a> 


                                                        <a href="javascript:void(0);" data-id="{{$get_student->stid}}" data-name="{{$get_student->first_name}}" data-phone="{{$get_student->phone}}" data-email="{{$get_student->email}}"  data-dialcode="{{$get_student->phone_dialcode}}"  data-flag="{{$get_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_mail"><i style='font-size:22px !important'  class="fa fa-envelope-o" aria-hidden="true"></i></a>    
                                                    <?php } ?>
                                                          
                                                      <?php if($get_student->type == 1){ ?>  
                                                    <div class="dropdown dropbtn">                                                       
                                                            <i class="fa fa-ellipsis-h" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-hidden="true"></i>                                                         
                                                          <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item message" data-id="{{$get_student->stid}}" href="javascript:void(0);" data-name="{{$get_student->first_name}}" data-toggle="modal" data-target="#myModal2">Client Notes</a>
                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#myModal_{{$get_student->stid}}">Checklist</a>
                                                            <a class="dropdown-item" href="{{url('admin/student-other-details/'.base64_encode($get_student->stid))}}">Convert to Client</a>             

                                                            <a class="dropdown-item" href="{{url('admin/student-deleted/'.base64_encode($get_student->stid))}}" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                                          </div>
                                                    </div>
                                                <?php } else if($get_student->type == 2){ ?>
                                                    <div class="dropdown dropbtn">
                                                         <!--  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                          </button> -->

                                                           <i class="fa fa-ellipsis-h" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-hidden="true"></i>

                                                          <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item message" data-id="{{$get_student->stid}}" href="javascript:void(0);" data-name="{{$get_student->first_name}}" data-toggle="modal" data-target="#myModal2">Comment</a>
                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#myModal_{{$get_student->stid}}">Checklist<a>
                                                            <a class="dropdown-item" href="{{url('admin/student-other-details/'.base64_encode($get_student->stid))}}">Add Additional Details</a>

                                                            <a class="dropdown-item" href="{{url('admin/student_payment_details/'.base64_encode($get_student->stid))}}">Payment Details</a>

                                                            <a class="dropdown-item" href="{{url('admin/student-deleted/'.base64_encode($get_student->stid))}}" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                                          </div>
                                                        </div>

                                                        <?php } ?>               
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>  
                                    </div>                                                        
                                </div>
                            </div>                           
                        </div>
                    </div>                                   
                </div>                
            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal -->

<div class="modal fade" id="send_sms" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send SMS to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_sms_to_student')}}" method="post" id="sms_form">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Phone Number <span style='color: red'>*</span></strong></label>
                <input type="text" name="phone_number" id="phone" class="form-control student_phone" value="">

                <span class="error_msg2"></span>
                <br>
                <p class="error-msg" id="error-msg"></p>
                <p class="valid-msg" id="valid-msg"></p>
                <input type="hidden" class="phone_flag" name="phone_flag" value="iti__in"/>
                <input type="hidden" class="phone_dialcode" name="phone_dialcode" value="+91"/>
                <br>
                <textarea name="sms_desc" rows="4" class="form-control smsdesc" maxlength="160"></textarea>
                <span class="length_error" style="color: red;"></span>
                <input type="hidden" name="student_id" class="student_id">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
      </div>
    </div>
  </div>



  <div class="modal fade" id="send_whatsapp" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send Whatsapp to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_whatsapp_to_student')}}" method="post" id="sms_form" enctype="multipart/form-data">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Phone Number <span style='color: red'>*</span></strong></label>
                <input type="text" name="whatsapp_number" id="whatsapp" class="form-control student_phone" value="">

                <span class="error_msg2"></span>
                <br>
                <p class="error-msg" id="error-msg"></p>
                <p class="valid-msg" id="valid-msg"></p>
                <input type="hidden" class="whatsapp_flag" name="whatsapp_flag" value="iti__in"/>
                <input type="hidden" class="whatsapp_dialcode" name="whatsapp_dialcode" value="+91"/>
                <br>
                <textarea name="whatsapp_desc" rows="4" class="form-control smsdesc" maxlength="160"></textarea>
                <span class="length_error" style="color: red;"></span>
                <input type="hidden" name="student_id" class="student_id">
                <br>
                <input type="file" name="whatsapp_attachment">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="send_mail" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send Mail to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_mail_to_student')}}" method="post" id="mail_form" enctype="multipart/form-data">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Email <span style='color: red'>*</span></strong></label>
                <input type="text" name="email" id="email" class="form-control student_email" value="" readonly>
                <br>
                
                <textarea name="mail_desc" rows="4" class="form-control" required></textarea>                
                <input type="hidden" name="student_id" class="student_id">                
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
      </div>
    </div>
  </div>


<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Add Comment for <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('adminAddComment')}}" method="post" id="comment_form">
        @csrf
            <div class="modal-body">
                <label><strong> Comment <span style='color: red'>*</span></strong></label>
                <textarea type="text" name="comment" class="form-control passcode"></textarea>             
                <input type="hidden" name="student_id" class="student_id">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Comment</button> 
            </div>
        </form>
      </div>
    </div>
  </div>



  <?php if($students){ 
   
    foreach ($students as $key => $get_student) { ?>

    <div class="modal fade" id="myModal_{{$get_student->stid}}" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">   
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2Label">Lead Status of {{$get_student->first_name}} {{$get_student->last_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>    
            <div class="modal-body">
                <p>
                    <strong>
                        Personal Details
                        <span class="float-right">
                            @if($get_student->email !='' && $get_student->is_verified==1 )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Passport
                        <span class="float-right">
                            @if($get_student->passport_number != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Visa
                        <span class="float-right">
                            @if($get_student->visa_type != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>
            
                <p>
                    <strong>
                        OSHC/OVHC
                        <span class="float-right">
                            @if($get_student->oshc_ovhc_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                 <p>
                    <strong>
                        IELTS / PTE Score
                        <span class="float-right">
                            @if($get_student->ielts_pte_score_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Education Details
                        <span class="float-right">
                            @if($get_student->ielts_pte_score_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                 <p>
                    <strong>
                        COES
                        <span class="float-right">
                            @if($get_student->coes != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>

            </div>        
          </div>      
        </div>
    </div>
        
<?php }}?>


<style type="text/css">
    .iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
    padding-right: 6px;
    padding-left: 95px !important;
    margin-left: 0;
    width: 386px !important;
}
</style>



<script src="{{ asset('admin/js/intlTelInput.js') }}"></script>
<link href="{{ asset('admin/css/intlTelInput.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/isValidNumber.css') }}" rel="stylesheet">


   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
   
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

<script type="text/javascript">
    $('#filterd_data').DataTable({
        /*dom: 'Bfrtip',*/
                responsive: false,
                "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 25,
                buttons: [
          
            {
                /*extend: 'excelHtml5',*/
                exportOptions: {
                    <?php
                    if($start_fees_due_date != '' || $end_fees_due_date != '' || Request::get('offices') != '')
                    {
                    ?> 
                   columns: [0,1,2,3,4,5,6,7]
               <?php } else { ?>
                columns: [0,1,2,3,4,5]
               <?php } ?>
                }
            },
           
          
        ]

    });
</script>

<script type="text/javascript">
var inputs_one1 = document.querySelector("#phone"),
  errorMsgs = document.querySelector("#error-msg"),
  validMsgs = document.querySelector("#valid-msg");


var errorMaps = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];


var itis1 = window.intlTelInput(inputs_one1, {
  utilsScript: "{{ asset('admin/js/intlTelInput.js') }}"
});

var reset = function() {
  inputs_one1.classList.remove("error"); 
};

$('.phone_number .thereismeta').addClass('<?php if(isset($get_student->phone_flag)){ echo $get_student->phone_flag; } ?>');
$('.phone_number .iti__selected-dial-code').html('<?php if(isset($get_student->phone_dialcode)){ echo $get_student->phone_dialcode; } ?>');


inputs_one1.addEventListener('blur', function() {

  reset();
  
  if (inputs_one1.value.trim()) {
    console.log(itis1.isValidNumber());

      var messages_code1 = itis1.selectedFlagInner.className;
      console.log(messages_code1);
      var res1 = messages_code1.replace("iti__flag","");

      var dialcode1 = itis1.selectedCountryData.dialCode;
     
       console.log('flag'+res1);
       console.log('dialcode'+dialcode1);
      $('.phone_flag').val(res1);
      $('.phone_dialcode').val(dialcode1);   
    
  }
});


inputs_one1.addEventListener('change', reset);
inputs_one1.addEventListener('keyup', reset);

 
</script>

<script type="text/javascript">
var inputs_two = document.querySelector("#whatsapp"),
  errorMsgs = document.querySelector("#error-msg"),
  validMsgs = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMaps = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var itis = window.intlTelInput(inputs_two, {
  utilsScript: "{{ asset('admin/js/intlTelInput.js') }}"
});

var reset = function() {
  inputs_two.classList.remove("error"); 
};

$('.whatsapp .thereismeta').addClass('<?php if(isset($get_student->whatsapp_flag)){ echo $get_student->whatsapp_flag; } ?>');
$('.whatsapp .iti__selected-dial-code').html('<?php if(isset($get_student->whatsapp_dialcode)){ echo $get_student->whatsapp_dialcode; }?>');

// on blur: validate
inputs_two.addEventListener('blur', function() {

  reset();
  
  if (inputs_two.value.trim()) {
    console.log(itis.isValidNumber());
  /*  if (itis.isValidNumber()) {
      alert('2');*/
      var messages_code = itis.selectedFlagInner.className;
      console.log(messages_code);
      var res = messages_code.replace("iti__flag","");

      var dialcode = itis.selectedCountryData.dialCode;
      //alert(res);
      //alert(dialcode);
       console.log('flag'+res);
       console.log('dialcode'+dialcode);
      $('.whatsapp_flag').val(res);
      $('.whatsapp_dialcode').val(dialcode);   
    
  }
});

// on keyup / change flag: reset
inputs_two.addEventListener('change', reset);
inputs_two.addEventListener('keyup', reset);

 



    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    $(document).on('click','.message',function(){       
        var student_id = $(this).attr("data-id");
        var student_name = $(this).attr("data-name");
        var student_phone = $(this).attr("data-phone");
        var student_email = $(this).attr("data-email");
        var student_flag = $(this).attr("data-flag");
        var student_dialcode = $(this).attr("data-dialcode");
        $('.student_id').val(student_id);
        $('.student_name').html(student_name);
        $('.student_phone').val(student_phone);        
        $('.student_email').val(student_email);        
        $('.phone_number .data1').removeClass('iti__in');
        $('.phone_number .data1').addClass(student_flag);
        $('.phone_number .iti__selected-dial-code').html(student_dialcode);
        
    })
</script>

<script>
    jQuery ('#comment_form').validate({

       rules: {
        comment: "required",         
           } ,
    
       messages: {
        comment:"Please type comment.",
       }     
    });



var maxLength = 160;
var len = 0;
$('.smsdesc').keyup(function(e) {
    var code = e.keyCode;
    if(len == maxLength && code != 8)
    {
        e.preventDefault();
        return false;
    }
  var textlen = maxLength - $(this).val().length;
  //$('#rchars').text(textlen);
  
  if(textlen == 0)
  {    
    $('.length_error').html('Maximum length is 160 for text message.');
  }
});



$(document).ready(function(){
    $(document).on('click', '.showall', function(){
        $('.extra_filter').removeClass('d-none');
        $('.showall').addClass('d-none');
});
    $(document).on('click', '.hideall', function(){
        $('.extra_filter').addClass('d-none');
         $('.showall').removeClass('d-none');
});
    });

 </script>



<style>
    textarea {

  height: 150px!important;
}





/*.tab button.active {
  background: #2b9ac9 !important;
}*/
.tab a.active {  
  background: #2b9ac9 !important;
  border: none;
  cursor: pointer;
  padding: 10px 25px;
  transition: 0.3s;
  font-size: 15px;
  float: left;
  color: #fff;
  border-radius: 5px;
  margin-right: 10px;
  margin-left: 10px;
}

.tab button, .tab a, .tablinks {
    background: #999;
    border: none;    
    cursor: pointer;
    padding: 10px 25px;
    transition: 0.3s;
    font-size: 15px;
    float: left;
    color: #fff;
    border-radius: 5px;
    margin-right: 10px;
}

.top-search {
    width: inherit;
}

.fa-whatsapp
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

.fa-comment-o
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

    .msgicons {
        float: left;
    margin: 0px 5px 0 0;
}


#filters {
background: #fff;
margin-left: 5%;
width: 95%;
padding: 10px;
}

#filters #faq .card {
margin: 0px;
border: 0;
background: #ffffff;
padding: 0 10px;
border: none;
border-radius: 0px;
box-shadow: 0 0px 0px rgb(0 0 0 / 10%)
}

#filters #faq .card .card-header {
border: 0;
box-shadow: none;
border-radius: 0px;
padding: 0;
}

#filters #faq .card .card-header .btn-header-link {
color: #fff;
display: block;
text-align: left;
background: #fff;
color: #212121;
padding: 10px 0px;
font-size: 14px;
outline: none!important;
}
#filters #faq .card .card-header .btn-header-link:hover, #filters #faq .card .card-header .btn-header-link:focus{
    outline: none!important;
    box-shadow: none!important;
}

#filters #faq .card .card-header .btn-header-link:after {
content: "\f107";
font-family: 'FontAwesome';
font-weight: 900;
float: right;
}

#filters #faq .card .card-header .btn-header-link.collapsed {
background: #fff;
color: #212121;
border-bottom: solid 1px #ccc;
box-shadow: none;
border-radius: 0;
font-size: 14px;
}

#filters #faq .card .card-header .btn-header-link.collapsed:after {
content: "\f106";
}

#filters #faq .card .collapsing {
background: #fff;
}

#filters #faq .card .collapse {
border: 0;
}

#filters #faq .card .collapse.show {
background: #fff;
color: #212121;
}
#filters #faq .card-body{
    padding-top: 0px;
}
#filters #faq .custom-control{
    margin: 5px 0;
}
#filters #faq .custom-control-label{
    line-height: 24px;
}

.btngro03{
    padding: 3px;
    margin-top:10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.btngro03 a{
display: inline-block;
border-radius: 5px;
padding: 6px 20px;
background: #1e94c7;
color: #fff;

}

.btngro03 button{
display: inline-block;
border-radius: 5px;
padding: 6px 20px;
background: #1e94c7;
color: #fff;
border: none;
}

.table_scroll
{
    overflow-x: scroll;
}

.table_scroll table{
    min-width: 1200px;
}

button.btn.showall {
    width: 250px;
    margin-top: 12px;
    background-color: #1e94c7;
    color: #fff;
}

button.btn.hideall {
    width: 250px;
    margin-top: 12px;
    background-color: #1e94c7;
    color: #fff;
}

div.dataTables_wrapper div.dataTables_length select
{
    width: 46px !important;
}

</style>
@endsection
