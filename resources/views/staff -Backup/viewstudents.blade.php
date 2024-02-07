@extends('staff.layout.head')
@section('staff')
<?php $counter = 0; ?>
<div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                    <div class="studentsinfobg">
                        <h4>{{$staff_view_students->first_name}} {{$staff_view_students->middle_name}} {{$staff_view_students->last_name}} 
                            <span class="paddate">{{date ('d-m-Y', strtotime  ($staff_view_students->dob))}} <label class="dateganrate"> {{$staff_view_students->gender}}</label></span></h4>
                        <ul>
                            
                            <li>
                                <label for=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Email:</label> {{$staff_view_students->email}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Phone no.:</label> {{$staff_view_students->phone}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-map-marker" aria-hidden="true"></i> Address:</label> {{$staff_view_students->address}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-globe" aria-hidden="true"></i> Country:</label> {{$staff_view_students->country}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Emergency Phone:</label> {{$staff_view_students->emergency_phone}}
                            </li>
                        </ul>

                        <hr>

                        <ul>
                           
                            
                            @if($staff_view_students->purpose !='')
                            <li>
                                <label for="">Purpose of visit :</label> {{$staff_view_students->purpose}}
                                &nbsp;
                                @if ($staff_view_students->purpose == 'Other Services')
                                    <label>Specific :</label>{{$staff_view_students->other_purpose}}
                                @endif
                            </li>
                            @endif

                            @if($staff_view_students->referral!='') 
                            <li>
                                <label for="">Referral :</label> {{$staff_view_students->referral}}
                                &nbsp;
                                @if ($staff_view_students->referral == 'Others Specified')
                                    <label>Specific :</label>{{$staff_view_students->other_referral}}
                                @endif
                            </li>
                            @endif

                            @if($staff_view_students->user_id!='') 
                            <li>
                                <label for="">Assigned To :</label> {{$staff_first_name}} {{$staff_last_name}}
                            </li>
                            @endif

                            @if($staff_view_students->priority!='') 
                            <li>
                                <label for="">Priority : </label> @if ($staff_view_students->priority == '1') Highest @elseif ($staff_view_students->priority == '2') Medium @else Low @endif 
                            </li>
                            @endif

                            @if($staff_view_students->first_name)

                            @if($staff_view_students->passport_number!='') 
                             <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <label class="labelheading" for=""><strong>Passport No. :</strong></label> {{$staff_view_students->passport_number}}<a href="{{url('/files/passport/'.$staff_view_students->passport_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                    @if($staff_view_students->passport_file != '')
                                    <?php $info = pathinfo($staff_view_students->passport_file);
                                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>
                                        <div class="iframediv">
                                            <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/passport/'.$staff_view_students->passport_file); ?>&embedded=true"  title="passport file"></iframe>
                                        </div>
                                    <?php  }else{ ?>
                                        <div class="iframediv">
                                        <iframe src="{{url('/files/passport/'.$staff_view_students->passport_file)}}" title="passport file"></iframe>
                                        </div>
                                        <?php } ?>
                                    
                                    @endif 
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label class="labelheading" for=""><strong>Passport Expiry Date :</strong>
                                        {{date('d-m-Y',strtotime($staff_view_students->passport_expiry_date))}}
                                    </label>
                                    </div>
                                
                            @endif

                            @if($staff_view_students->visa_type!='')
                               <div class="col-lg-6 col-md-6">
                                <label class="labelheading" for=""><strong>Type of VISA :</strong></label> {{$staff_view_students->visa_type}}<a href="{{url('/files/visa/'.$staff_view_students->visa_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($staff_view_students->visa_file != '')
                                <?php $info = pathinfo($staff_view_students->visa_file);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/visa/'.$staff_view_students->visa_file); ?>&embedded=true"  title="visa file"></iframe>
                                    </div>
                                <?php  }else{ ?>
                                    <div class="iframediv">
                                    <iframe src="{{url('/files/visa/'.$staff_view_students->visa_file)}}" title="visa file"></iframe>
                                    </div>
                                    <?php } ?>
                                @endif 
                               </div>
                               <div class="col-lg-6 col-md-6">
                                <label class="labelheading" for=""><strong>Visa Expiry Date :</strong>
                                    {{date('d-m-Y',strtotime($staff_view_students->visa_expiry_date))}}
                                </label>
                                </div>
                             </div>
                            @endif

                            @if ($staff_view_students->oshc_ovhc_file !='')
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                <label class="labelheading" for=""><strong>OSHC/OVHC :</strong></label> <a href="{{url('/files/others/'.$staff_view_students->oshc_ovhc_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($staff_view_students->oshc_ovhc_file != '')
                                <?php $info = pathinfo($staff_view_students->oshc_ovhc_file);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$staff_view_students->oshc_ovhc_file); ?>&embedded=true"  title="oshc_ovhc file"></iframe>
                                    </div>
                                <?php  }else{ ?>
                                    <div class="iframediv">
                                    <iframe src="{{url('/files/others/'.$staff_view_students->oshc_ovhc_file)}}" title="oshc_ovhc file"></iframe>
                                    </div>
                                    <?php } ?>
                                @endif 
                               </div>
                            @endif

                            @if ($staff_view_students->ielts_pte_score_file !='')
                              <div class="col-lg-6 col-md-6">
                                <label class="labelheading" for=""><strong> IELTS/PTE SCORE :</strong></label> <a href="{{url('/files/others/'.$staff_view_students->ielts_pte_score_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($staff_view_students->ielts_pte_score_file != '')
                                <?php $info = pathinfo($staff_view_students->ielts_pte_score_file);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$staff_view_students->ielts_pte_score_file); ?>&embedded=true"  title="ielts_pte_score file"></iframe>
                                    </div>
                                <?php  }else{ ?>
                                    <div class="iframediv">
                                    <iframe src="{{url('/files/others/'.$staff_view_students->ielts_pte_score_file)}}" title="ielts_pte_score file"></iframe>
                                    </div>
                                    <?php } ?>
                                @endif 
                               </div>
                            </div>
                            @endif

                            @if ($staff_view_students->australian_id !='')
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                <label class="labelheading" for=""><strong> Australian ID :</strong></label> <a href="{{url('/files/others/'.$staff_view_students->australian_id)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($staff_view_students->australian_id != '')
                                <?php $info = pathinfo($staff_view_students->australian_id);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$staff_view_students->australian_id); ?>&embedded=true"  title="australian_id file"></iframe>
                                    </div>
                                <?php  }else{ ?>
                                    <div class="iframediv">
                                    <iframe src="{{url('/files/others/'.$staff_view_students->australian_id)}}" title="australian_id file"></iframe>
                                    </div>
                                    <?php } ?>
                                @endif 
                               </div>
                            @endif


                            <?php if($staff_view_coes_details){
                                $coes = '';
                                $coes_one = $staff_view_coes_details->file_one;
                              ?>
                            <div class="col-lg-6 col-md-6">
                                <label for="labelheading"><strong> COES :</strong></label> 

                                 <label for="">Start date  :</label> {{$staff_view_coes_details->start_date_one}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$staff_view_coes_details->end_date_one}} 

                                <a href="{{url('/files/others/'.$coes_one)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($coes_one != '')
                                <?php $info = pathinfo($coes_one);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>
                                <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_one); ?>&embedded=true"  title="coes file"></iframe>
                                 </div>
                                <?php  }else{ ?>
                                    <div class="iframediv">
                                    <iframe src="{{url('/files/others/'.$coes_one)}}" title="coes file"></iframe>
                                    </div>
                                    <?php } ?>
                                @endif 
                                </div>
                                <?php 
                            }                                     
                            ?> 

                                <?php if($staff_view_coes_details){
                                    $coes = '';
                                    $coes_two = $staff_view_coes_details->file_two;
                                ?>
                                <div class="col-lg-6 col-md-6">
                                    <label for="labelheading"><strong> COES :</strong></label>
                                    <label for="">Start date  :</label> {{$staff_view_coes_details->start_date_two}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$staff_view_coes_details->end_date_two}} <a href="{{url('/files/others/'.$coes_two)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                    @if($coes_two != '')
                                    <?php $info = pathinfo($coes_two);
                                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>
                                    <div class="iframediv">
                                            <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_two); ?>&embedded=true"  title="coes file"></iframe>
                                    </div>
                                    <?php  }else{ ?>
                                        <div class="iframediv">
                                        <iframe src="{{url('/files/others/'.$coes_two)}}" title="coes file"></iframe>
                                        </div>
                                        <?php } ?>
                                    @endif 
                                    </div>
                                    <?php 
                                }                                     
                                ?> 

                                                                
                                <?php if($staff_view_coes_details){
                                    $coes = '';
                                    $coes_three = $staff_view_coes_details->file_three;
                                ?>
                                <div class="col-lg-6 col-md-6">
                                    <label for="labelheading"><strong> COES :</strong></label>
                                    <label for="">Start date  :</label> {{$staff_view_coes_details->start_date_three}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$staff_view_coes_details->end_date_three}} <a href="{{url('/files/others/'.$coes_three)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                    @if($coes_three != '')
                                    <?php $info = pathinfo($coes_three);
                                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>
                                    <div class="iframediv">
                                            <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_three); ?>&embedded=true"  title="coes file"></iframe>
                                    </div>
                                    <?php  }else{ ?>
                                        <div class="iframediv">
                                        <iframe src="{{url('/files/others/'.$coes_three)}}" title="coes file"></iframe>
                                        </div>
                                        <?php } ?>
                                    @endif 
                                    </div>
                                    <?php 
                                }                                     
                                ?> 

                                    <?php if($staff_view_coes_details){
                                        $coes = '';
                                        $coes_four = $staff_view_coes_details->file_four;
                                    ?>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="labelheading"><strong> COES :</strong></label>
                                        <label for="">Start date  :</label> {{$staff_view_coes_details->start_date_four}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$staff_view_coes_details->end_date_four}} <a href="{{url('/files/others/'.$coes_four)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                        @if($coes_four != '')
                                        <?php $info = pathinfo($coes_four);
                                        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                        { ?>
                                        <div class="iframediv">
                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_four); ?>&embedded=true"  title="coes file"></iframe>
                                        </div>
                                        <?php  }else{ ?>
                                            <div class="iframediv">
                                            <iframe src="{{url('/files/others/'.$coes_four)}}" title="coes file"></iframe>
                                            </div>
                                            <?php } ?>
                                        @endif 
                                        </div>
                                        <?php 
                                    }                                     
                                    ?> 

                                        <?php if($staff_view_coes_details){
                                            $coes = '';
                                            $coes_five = $staff_view_coes_details->file_five;
                                        ?>
                                        <div class="col-lg-6 col-md-6">
                                            <label for="labelheading"><strong> COES :</strong></label> 
                                            <label for="">Start date  :</label> {{$staff_view_coes_details->start_date_five}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$staff_view_coes_details->end_date_five}}<a href="{{url('/files/others/'.$coes_five)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                            @if($coes_five != '')
                                            <?php $info = pathinfo($coes_five);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                            <div class="iframediv">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_five); ?>&embedded=true"  title="coes file"></iframe>
                                            </div>
                                            <?php  }else{ ?>
                                                <div class="iframediv">
                                                <iframe src="{{url('/files/others/'.$coes_five)}}" title="coes file"></iframe>
                                                </div>
                                                <?php } ?>
                                            @endif 
                                            </div>
                                            <?php 
                                        }                                     
                                        ?> 

                            </div>
                           

                        @endif               
                        </ul>
                    </div>
                       
                    @if($staff_view_students->first_name)
                    <?php if (isset($staff_view_education_details->ten_marksheet) && $staff_view_education_details->ten_marksheet !='')
                    {  ?>
                    <div class="feesdetails">
                        <h3>Education Details</h3>

                        <table >
                            <tr>
                                <th>Class</th>
                                <th>School/College</th>
                                <th>Percentage</th>
                                <th>Session</th>
                                <th>Board/University</th>
                                <th>Marksheet Preview</th>
                                <th>Marksheet Download</th>
                            </tr>
           
                            <tr>
                                <?php if (isset($staff_view_education_details->ten_marksheet) && $staff_view_education_details->ten_marksheet != '')
                                {
                                    ?>
                                <td>10th</td>
                                <td>{{$staff_view_education_details->ten_school_college}}</td>
                                <td>{{$staff_view_education_details->ten_percentage}}</td>
                                <td>{{$staff_view_education_details->ten_session}}</td>
                                <td>{{$staff_view_education_details->ten_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal1_{{$staff_view_education_details->student_id}}" data-src="{{$staff_view_education_details->ten_marksheet}}" class="ten_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$staff_view_education_details->student_id}}="true"></i></a></td>

                                <td><a href="{{url('/files/education/'.$staff_view_education_details->ten_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                              <?php }?>
                               
                            </tr>
                            <tr>
                                <?php if (isset($staff_view_education_details->twelve_marksheet) && $staff_view_education_details->twelve_marksheet != '')
                                {
                                    ?>
                                <td>12th</td>
                                <td>{{$staff_view_education_details->twelve_school_college}}</td>
                                <td>{{$staff_view_education_details->twelve_percentage}}</td>
                                <td>{{$staff_view_education_details->twelve_session}}</td>
                                <td>{{$staff_view_education_details->twelve_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal2_{{$staff_view_education_details->student_id}}" data-src="{{$staff_view_education_details->twelve_marksheet}}" class="ten_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$staff_view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$staff_view_education_details->twelve_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                <?php }?>
                                
                            </tr>
                            <tr>
                                <?php if (isset($staff_view_education_details->diploma_marksheet) && $staff_view_education_details->diploma_marksheet != '')
                                {
                                    ?>
                                <td>Diploma</td>
                                <td>{{$staff_view_education_details->diploma_school_college}}</td>
                                <td>{{$staff_view_education_details->diploma_percentage}}</td>
                                <td>{{$staff_view_education_details->diploma_session}}</td>
                                <td>{{$staff_view_education_details->diploma_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal3_{{$staff_view_education_details->student_id}}" data-src="{{$staff_view_education_details->diploma_marksheet}}" class="diploma_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$staff_view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$staff_view_education_details->diploma_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                 <?php }?>
                                
                            </tr>
                            <tr>
                                <?php if (isset($staff_view_education_details->bachelors_marksheet) && $staff_view_education_details->bachelors_marksheet != '')
                                {
                                    ?>
                                <td>Bachelors</td>
                                <td>{{$staff_view_education_details->bachelors_school_college}}</td>
                                <td>{{$staff_view_education_details->bachelors_percentage}}</td>
                                <td>{{$staff_view_education_details->bachelors_session}}</td>
                                <td>{{$staff_view_education_details->bachelors_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal4_{{$staff_view_education_details->student_id}}" data-src="{{$staff_view_education_details->bachelors_marksheet}}" class="diploma_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$staff_view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$staff_view_education_details->bachelors_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                <?php }?>
                                
                            </tr>
                            <tr>
                                <?php if (isset($staff_view_education_details->masters_marksheet) && $staff_view_education_details->masters_marksheet != '')
                                {
                                    ?>
                                <td>Masters</td>
                                <td>{{$staff_view_education_details->masters_school_college}}</td>
                                <td>{{$staff_view_education_details->masters_percentage}}</td>
                                <td>{{$staff_view_education_details->masters_session}}</td>
                                <td>{{$staff_view_education_details->masters_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal5_{{$staff_view_education_details->student_id}}" data-src="{{$staff_view_education_details->masters_marksheet}}" class="diploma_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$staff_view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$staff_view_education_details->masters_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                <?php } ?>
                                
                            </tr>
                        </table>
                       
                    </div>
                    <?php }?>

                    <?php if ($staff_view_fee_count>0)
                        {  ?>
                    <div class="feesdetails">
                        <h3>Fees Details</h3>
                        <ul>
                           <li><strong>Fees :</strong></li>
                           <li>${{$staff_view_students->fees}}</li>

                           <?php if($staff_view_students->discount_type =='1'){ ?>
                            <li><strong>Discount :</strong></li>
                            <li>${{$staff_view_students->discount}}</li>
                            <?php }?>

                            <?php if($staff_view_students->discount_type =='2'){ ?>
                            <li><strong>Discount :</strong></li>
                            <li>{{$staff_view_students->discount}}%</li>
                            <?php }?>

                           @if($staff_view_students->college!='')
                           <li><strong>College :</strong></li> 
                           <li>{{$college_name}}</li>
                           @endif

                           @if($staff_view_students->course!='')
                           <li><strong>Course :</strong></li> 
                           <li>{{$course_name}}</li>
                           @endif

                           @if ($staff_view_students->intake_date !='')
                           <li><strong>Intake Date :</strong></li>
                           <li>{{ $staff_view_students->intake_date}}</li>
                           @endif  
                        </ul>


                        <table >
                            <tr>
                                <th>Installment</th>
                                    <th>Due Date</th>
                                    <th>Paid</th>
                                    <th>Remaining</th>                                
                                    <th>Received By</th>
                                    <th>Received Date</th>                                
                                    <th>Comment</th>                                
                                    <th>Pay Fees</th>
                            </tr>
                            <?php
                            $count=0;
                                if($staff_view_fee_details){
                                    foreach ($staff_view_fee_details as $key => $staff_view_fee_detail) { 
                                        $counter++;  
                                        ?>
                                <tr>
                                    <td id="amount_due">${{$staff_view_fee_detail->amount}}</td>                               
                                    <td>{{date('d-m-Y',strtotime($staff_view_fee_detail->due_date))}}</td>
                                    <td>{{$staff_view_fee_detail->received_amount}}</td>
                                    <td>{{$staff_view_fee_detail->remaining_amount}}</td>
                                    <td>{{$staff_view_fee_detail->staff_name}}</td>
                                    <td>@if($staff_view_fee_detail->payment_received_date !=''){{date('d-m-Y',strtotime($staff_view_fee_detail->payment_received_date))}}@endif</td>
                                    <td>{{$staff_view_fee_detail->comment}}</td>
                                    <td><?php if($staff_view_fee_detail->received_amount == null && $count==0 ){  ?>
                                        <button class="btn btn-default myBtn" data-toggle="modal" data-target="#exampleModal" data-id="{{$staff_view_fee_detail->id}}">Pay Fees</button></td>
                                        <?php $count++; }else{ if($staff_view_fee_detail->payment_proof!=''){ ?>
                                            <a href="{{url('/payment/'.$staff_view_fee_detail->payment_proof)}}" target="_blank"><i class="fa-sharp fa-solid fa-download"></i></a>
                                        <?php } } ?>  
                                </tr>
                              <?php }  }?>
                            
                        </table>
                       
                    </div>
                    <?php }?>

                    <div class="feesdetails">
                        <h3>Student Communication Log</h3>

                        <table >
                            <thead>
                                
                            <tr>
                                <th>Sr. No.</th>
                                <th>Comment</th>
                                <th>Updated On</th>
                             </tr>
                            </thead>
                            <tbody>
                           <?php foreach ($staff_view_communication_logs as $staff_view_communication_log => $log_data ) { ?>                                           
                            <tr>
                                <td>{{$staff_view_communication_log+1}} </td>
                                <td>{{$log_data->comment}} </td>
                                <td>{{date('d-m-Y H:i:s', strtotime($log_data->created_at))}} </td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                          
                    </div>
      @endif
            </div>
         </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Amount Received</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('staffPayFee')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                    @csrf
                        <label for="amount"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
                        <input type="text" class="form-control" id="amount" name="amount"><br>

                        <label for="payment_proof"><strong>Payment Proof :</strong></label><br>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof"><br><br>

                        <label for="comment"><strong>Comment :</strong></label><br>
                        <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea>                       

                        <input type="hidden" class="fee_id" value="" name="fee_id">
                        <input type="hidden" class="amt_due" value="" name="amt_due">

                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Receive Amount</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 1 -->

    @if($staff_view_education_details)
 
  
    <div class="modal fade" id="exampleModal1_{{$staff_view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if($staff_view_education_details->ten_marksheet != '')
                <?php $info = pathinfo($staff_view_education_details->ten_marksheet);
                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$staff_view_education_details->ten_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$staff_view_education_details->ten_marksheet)}}" title="passport file"></iframe>
                    </div>
                    <?php } ?>
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
    @endif 

    <!-- Modal 2 -->


    @if($staff_view_education_details)
 
  
    <div class="modal fade" id="exampleModal2_{{$staff_view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if($staff_view_education_details->twelve_marksheet != '')
                <?php $info = pathinfo($staff_view_education_details->twelve_marksheet);
                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$staff_view_education_details->twelve_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$staff_view_education_details->twelve_marksheet)}}" title="passport file"></iframe>
                    </div>
                    <?php } ?>
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
    @endif 
    

    <!-- Modal 3 -->

    @if($staff_view_education_details)
 
  
    <div class="modal fade" id="exampleModal3_{{$staff_view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if($staff_view_education_details->diploma_marksheet != '')
                <?php $info = pathinfo($staff_view_education_details->diploma_marksheet);
                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$staff_view_education_details->diploma_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$staff_view_education_details->diploma_marksheet)}}" title="passport file"></iframe>
                    </div>
                    <?php } ?>
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
    @endif 
    <!-- Modal 4 -->

    @if($staff_view_education_details)
 
  
    <div class="modal fade" id="exampleModal4_{{$staff_view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if($staff_view_education_details->bachelors_marksheet != '')
                <?php $info = pathinfo($staff_view_education_details->bachelors_marksheet);
                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$staff_view_education_details->bachelors_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$staff_view_education_details->bachelors_marksheet)}}" title="passport file"></iframe>
                    </div>
                    <?php } ?>
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
    @endif 
    <!-- Modal 5 -->

    @if($staff_view_education_details)
 
  
    <div class="modal fade" id="exampleModal5_{{$staff_view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if($staff_view_education_details->masters_marksheet != '')
                <?php $info = pathinfo($staff_view_education_details->masters_marksheet);
                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$staff_view_education_details->masters_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$staff_view_education_details->masters_marksheet)}}" title="passport file"></iframe>
                    </div>
                    <?php } ?>
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
    @endif
    <!-- Modal 6 -->














    <script>
        $(document).on('click','.myBtn',function(){
            var fee = $(this).attr("data-id");
            $('.fee_id').val(fee)
        })
    </script>
       
    <script>
        <?php if($counter >0){ ?>
        $(document).on('change keyup','#amount',function(){
            var installment = <?php echo $staff_view_fee_detail->amount; ?>;
            var amount = $(this).val();
            if(amount>installment)
            {
                alert('Received amount can not be greater than installment amount');
                $('#amount').val('');
            }
        })
        <?php } ?>
    </script>

    <script>
        $('#pay_fee').validate({

        rules: {
            amount: {required: true,
                number:true}
            } ,
            messages: {
                amount:{required: "Please enter amount.",
                number:"Please enter numbers only."}
        }     
        });
    </script>





@endsection       