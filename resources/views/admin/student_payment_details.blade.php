@extends('admin.layout.head')
@section('admin')


<?php $counter=1; ?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Student Payment Details</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <?php 

                                //echo "<pre>"; print_r($studentCourseCampusArray); exit;

                                echo "<h3>Student Name : -".$student_name->first_name."</h3>";
                                $sum = 0; 
                                if($studentCourseCampusArray)
                                {
                                    foreach ($studentCourseCampusArray as $course_key => $view_fee_detail_array) 
                                    { 

                                        foreach($view_fee_detail_array as $campus_key => $view_fee_detail)
                                        {
                                            $total_rec_commission = 0;

                                            if($view_fee_detail->current_college_course == 1)
                                            {
                                                $activeClass = 'current_course';
                                            }
                                            else
                                            {
                                                $activeClass = '';
                                            }

                                        if(isset(($studentCourseArray[$course_key][$campus_key])))
                                        { ?>
                                  <br><br>       
                               <h5>College Name: - <?php echo $studentCourseArray[$course_key][$campus_key][0]->college_trading_name; ?></h5>
                               <h5>Course Name: - <?php echo $studentCourseArray[$course_key][$campus_key][0]->course_name; ?></h5>                                
                               <h5>Campus name :- {{$view_fee_detail->campus_name}}</h5>
                               <table class="table table-hover <?php echo $activeClass; ?>">  
                               <thead>                          
                                <tr>                                
                                    <th>Installment</th>
                                    <th>Due Date</th>
                                    <th>Paid</th>
                                    <th>Remaining</th>                                
                                    <th>Received By</th>                                
                                    <th>Received Date</th>                                
                                    <th>Comment</th>                                     
                                    <th>Commission</th>                                          
                                    <th>Rec. Commission</th>                                          
                                </tr>
                                </thead>
                                <tbody>            
                                                                                 
                                <?php
                               
                                //echo "<pre>"; print_r($view_fee_detail); exit;

                                    foreach($studentCourseArray[$course_key][$campus_key] as $course_key => $course_data)
                                            {
                                        $counter++;
                                        $total_rec_commission+=$course_data->rec_commission;  
                                   
                                    
                                        ?>
                                        
                                <tr>
                                    <td id="amount_due">$<?php echo number_format($course_data->amount,2); ?></td>                               
                                    <td>{{date('d-m-Y',strtotime($course_data->due_date))}}</td>
                                    <td><?php echo number_format($course_data->received_amount,2); ?></td>
                                    <td class="remaining_amount_{{$course_data->id}}">
                                        <?php echo number_format($course_data->remaining_amount,2); ?></td>
                                    <td>{{$course_data->staff_name}}</td>
                                    <td>@if($course_data->payment_received_date !=''){{date('d-m-Y',strtotime($course_data->payment_received_date))}}@endif</td>
                                    <td>{{$course_data->comment}}</td>
                                    <td><?php $commission = str_replace(',','',$course_data->commission);  echo number_format($commission,2); ?> </td>

                                    <td><?php echo $course_data->rec_commission; ?> </td>

                                </tr>                                
                                                            
                               <?php } ?>
                               <tr>
                                   <td colspan="7">Total Commission received</td>
                                   <td colspan="2">{{$total_rec_commission}}</td>
                               </tr>

                               <tr>
                                   <td colspan="1">Total Bonus is:- </td>
                                   <td colspan="4">{{$view_fee_detail->bonus}}</td>
                                   <td colspan="3">Total Bonus Claimed :-</td>
                                   <td colspan="2">{{$view_fee_detail->bonus_claimed}}</td>
                               </tr>
                                </tbody>
                            </table> 

                           

                            <?php  } else { ?>
                                <br>
                               <span>No Payment Received, Course never made as current course. </span> 
                               <p>College name :- {{$view_fee_detail->college_trading_name}}
                               <br>Course name :- {{$view_fee_detail->course_name}}
                               <br>
                               Campus name :- {{$view_fee_detail->campus_name}}
                               </p>
                               <p>Total Fees Pending: {{$view_fee_detail->total_payable_amount}}</p>
                             <?php } } } } ?> 

                            </div>
                        </div>
                    </div>

                                
                </section> 
            </div>
        </div>            
    </div>  

@endsection

<style type="text/css">
    table.table.table-hover tr
    {
        border-bottom: 1px solid #e7e7e7;
    }
    table.table.table-hover.current_course
    {
        background-color: #bad3fa;
    }
</style>