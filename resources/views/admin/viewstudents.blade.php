@extends('admin.layout.head')
@section('admin')
<?php $counter = 0; ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="studentsinfobg">
                <h4>{{$view_students->first_name}} {{$view_students->middle_name}} {{$view_students->last_name}} <span>{{ date('d-m-Y',strtotime($view_students->dob))}} {{$view_students->gender}}</span></h4>
                <ul>
                    <li>
                        <label for=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Email:</label> {{$view_students->email}}
                    </li>
                    <li>
                        <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Phone no.:</label> {{$view_students->phone}}
                    </li>
                    <li>
                        <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Whatsapp:</label> {{$view_students->whatsapp}}
                    </li>
                    <li>
                        <label for=""><i class="fa fa-map-marker" aria-hidden="true"></i> Address:</label> {{$view_students->address}}
                    </li>
                    <li>
                        <label for=""><i class="fa fa-globe" aria-hidden="true"></i> Country:</label> {{$view_students->country}}
                    </li>
                    <li>
                        <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Emergency Phone:</label> {{$view_students->emergency_phone}}
                    </li>
                </ul>

                <hr>

                <ul>
                    @if ($view_students->purpose !='')
                    <li>
                        <label for="">Purpose of visit  :</label> {{$view_students->purpose}}&nbsp;&nbsp;
                        @if ($view_students->purpose == 'Other Services')
                        <label>Specific :</label>{{$view_students->other_purpose}}
                        @endif
                    </li>
                    @endif

                    @if ($view_students->referral !='')
                    <li>
                        <label for="">Referral :</label> {{$view_students->referral}}&nbsp;&nbsp;
                        @if ($view_students->referral == 'Others Specified')
                        <label>Specific :</label>{{$view_students->other_referral}}
                        @endif
                    </li>
                    @endif

                    @if ($view_students->referral !='')
                    <li>
                       <label for="">Assigned To :</label> {{$staff_first_name}} {{$staff_last_name}} 
                   </li>
                   @endif

                   @if ($view_students->referral !='')
                   <li>
                    <label for="">Priority :</label> @if ($view_students->priority == '1') Highest @elseif ($view_students->priority == '2') Medium @else Low @endif
                </li>   
                @endif

                @if($view_students->first_name)

                @if ($view_students->passport_number !='')
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <label class="labelheading" for=""><strong>Passport No. :</strong></label> {{$view_students->passport_number}}<a href="{{url('/files/passport/'.$view_students->passport_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                        @if($view_students->passport_file != '')
                        <?php $info = pathinfo($view_students->passport_file);
                        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                            { ?>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passport_one">Preview</button>

                                <div class="modal fade" id="passport_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Passport View</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                             <div class="iframediv">
                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/passport/'.$view_students->passport_file); ?>&embedded=true" style="width:100%; height:500px;"  title="passport file"></iframe>
                                            </div>
                                        </div>                                                  
                                    </div>
                                </div>
                            </div>


                            <?php
                        }
                        else
                        {
                            ?>



                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passport_two">Preview</button>

                            <div class="modal fade" id="passport_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Passport View</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="iframediv">
                                                <iframe src="{{url('/files/passport/'.$view_students->passport_file)}}" style="width:100%; height:500px;" title="passport file"></iframe>
                                            </div>
                                        </div>                                                  
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                        @endif 
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="labelheading" for=""><strong>Passport Expiry Date :</strong>
                            {{date('d-m-Y',strtotime($view_students->passport_expiry_date))}}
                        </label>
                    </div>
                    @endif


                    @if ($view_students->visa_type !='')

                    <div class="col-lg-6 col-md-6">
                        <label for="labelheading"><strong>Type of VISA :</strong></label> {{$view_students->visa_type}}<a href="{{url('/files/visa/'.$view_students->visa_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                        @if($view_students->visa_file != '')
                        <?php $info = pathinfo($view_students->visa_file);
                        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                            { ?>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visa_one">Preview</button>

                                <div class="modal fade" id="visa_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Visa View</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="iframediv">
                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/visa/'.$view_students->visa_file); ?>&embedded=true" style="width:100%; height:500px;" title="visa file"></iframe>
                                            </div>
                                        </div>                                                  
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        else
                        {
                            ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visa_two">Preview</button>

                            <div class="modal fade" id="visa_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Visa View</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                           <div class="iframediv">
                                            <iframe src="{{url('/files/visa/'.$view_students->visa_file)}}" style="width:100%; height:500px;" title="visa file"></iframe>
                                        </div>
                                    </div>                                                  
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    @endif 
                </div>
                <div class="col-lg-6 col-md-6">
                    <label class="labelheading" for=""><strong>Visa Expiry Date :</strong>
                        {{date('d-m-Y',strtotime($view_students->visa_expiry_date))}}
                    </label>
                </div>

            </div>
            @endif

            @if ($view_students->oshc_ovhc_file !='')

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label for="labelheading"><strong>OSHC/OVHC :</strong></label> <a href="{{url('/files/others/'.$view_students->oshc_ovhc_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                    @if($view_students->oshc_ovhc_file != '')
                    <?php $info = pathinfo($view_students->oshc_ovhc_file);
                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                        { ?>

                         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#oshc_ovhc_one">Preview</button>

                         <div class="modal fade" id="oshc_ovhc_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">OSHC OVHC View</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$view_students->oshc_ovhc_file); ?>&embedded=true" style="width:100%; height:500px;"  title="oshc_ovhc file"></iframe>
                                    </div>                                              
                                </div>
                            </div>
                        </div>


                        <?php
                    }
                    else
                    {
                        ?>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#oshc_ovhc_two">Preview</button>

                        <div class="modal fade" id="oshc_ovhc_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">OSHC OVHC View</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="iframediv">
                                        <iframe src="{{url('/files/others/'.$view_students->oshc_ovhc_file)}}" style="width:100%; height:500px;" title="oshc_ovhc file"></iframe>
                                    </div>                             
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    @endif 
                </div>
                @endif

                @if ($view_students->ielts_pte_score_file !='')

                <div class="col-lg-6 col-md-6">
                    <label for="labelheading"><strong> IELTS/PTE SCORE :</strong></label> <a href="{{url('/files/others/'.$view_students->ielts_pte_score_file)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                    @if($view_students->ielts_pte_score_file != '')
                    <?php $info = pathinfo($view_students->ielts_pte_score_file);
                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                        { ?>

                         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IELTS_PTE_one">Preview</button>

                         <div class="modal fade" id="IELTS_PTE_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">IELTS/PTE View</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="iframediv">
                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$view_students->ielts_pte_score_file); ?>&embedded=true" style="width:100%; height:500px;"  title="ielts_pte_score file"></iframe>
                                    </div>                  
                                </div>
                            </div>
                        </div>


                        <?php
                    }
                    else
                    {
                        ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IELTS_PTE_two">Preview</button>

                        <div class="modal fade" id="IELTS_PTE_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">IELTS/PTE View</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="iframediv">
                                        <iframe src="{{url('/files/others/'.$view_students->ielts_pte_score_file)}}" style="width:100%; height:500px;" title="ielts_pte_score file"></iframe>
                                    </div>                 
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    @endif 
                </div>
            </div>
            @endif

            @if ($view_students->australian_id !='')
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label for="labelheading"><strong> Australian ID :</strong></label> <a href="{{url('/files/others/'.$view_students->australian_id)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                    @if($view_students->australian_id != '')
                    <?php $info = pathinfo($view_students->australian_id);
                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                        { ?>


                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#australian_id_one">Preview</button>

                            <div class="modal fade" id="australian_id_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Australian ID View</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="iframediv">
                                            <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$view_students->australian_id); ?>&embedded=true" style="width:100%; height:500px;"  title="australian_id file"></iframe>
                                        </div>   
                                    </div>
                                </div>
                            </div>



                            <?php
                        }
                        else
                        {
                            ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#australian_id_two">Preview</button>

                            <div class="modal fade" id="australian_id_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Australian ID View</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="iframediv">
                                            <iframe src="{{url('/files/others/'.$view_students->australian_id)}}" style="width:100%; height:500px;" title="australian_id file"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                        @endif 
                    </div>
                    @endif


                    <?php if($view_coes_details){
                        $coes = '';
                        $coes_one = $view_coes_details->file_one;
                        ?>
                        <div class="col-lg-6 col-md-6">
                            <label for="labelheading"><strong> COES :</strong></label> 

                            <label for="">Start date  :</label> {{$view_coes_details->start_date_one}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$view_coes_details->end_date_one}} 

                            <a href="{{url('/files/others/'.$coes_one)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                            @if($coes_one != '')
                            <?php $info = pathinfo($coes_one);
                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>

                                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_one">Preview</button>

                                   <div class="modal fade" id="coes_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="iframediv">
                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_one); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                            <?php  }else{ ?>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_two">Preview</button>

                                <div class="modal fade" id="coes_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="iframediv">
                                                <iframe src="{{url('/files/others/'.$coes_one)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div> 



                            <?php } ?>
                            @endif 
                        </div>
                        <?php 
                    }                                     
                    ?> 

                    <?php if($view_coes_details){
                        $coes = '';
                        $coes_two = $view_coes_details->file_two;
                        ?>
                        <div class="col-lg-6 col-md-6">
                            <label for="labelheading"><strong> COES :</strong></label>
                            <label for="">Start date  :</label> {{$view_coes_details->start_date_two}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$view_coes_details->end_date_two}} <a href="{{url('/files/others/'.$coes_two)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                            @if($coes_two != '')
                            <?php $info = pathinfo($coes_two);
                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                { ?>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_three">Preview</button>

                                    <div class="modal fade" id="coes_three" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="iframediv">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_two); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 


                                <?php  }else{ ?>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_four">Preview</button>

                                    <div class="modal fade" id="coes_four" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="iframediv">
                                                    <iframe src="{{url('/files/others/'.$coes_two)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                <?php } ?>
                                @endif 
                            </div>
                            <?php 
                        }                                     
                        ?> 

                        <?php if($view_coes_details){
                            $coes = '';
                            $coes_three = $view_coes_details->file_three;
                            ?>
                            <div class="col-lg-6 col-md-6">
                                <label for="labelheading"><strong> COES :</strong></label>
                                <label for="">Start date  :</label> {{$view_coes_details->start_date_three}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$view_coes_details->end_date_three}} <a href="{{url('/files/others/'.$coes_three)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($coes_three != '')
                                <?php $info = pathinfo($coes_three);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_five">Preview</button>

                                        <div class="modal fade" id="coes_five" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="iframediv">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_three); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 


                                    <?php  }else{ ?>

                                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_six">Preview</button>

                                     <div class="modal fade" id="coes_six" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="iframediv">
                                                    <iframe src="{{url('/files/others/'.$coes_three)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                <?php } ?>
                                @endif 
                            </div>
                            <?php 
                        }                                     
                        ?> 

                        <?php if($view_coes_details){
                            $coes = '';
                            $coes_four = $view_coes_details->file_four;
                            ?>
                            <div class="col-lg-6 col-md-6">
                                <label for="labelheading"><strong> COES :</strong></label>
                                <label for="">Start date  :</label> {{$view_coes_details->start_date_four}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$view_coes_details->end_date_four}} <a href="{{url('/files/others/'.$coes_four)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($coes_four != '')
                                <?php $info = pathinfo($coes_four);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>

                                       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_seven">Preview</button>

                                       <div class="modal fade" id="coes_seven" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="iframediv">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_four); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                     
                                <?php  }else{ ?>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_eight">Preview</button>

                                    <div class="modal fade" id="coes_eight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>                                                   
                                                <div class="iframediv">
                                                    <iframe src="{{url('/files/others/'.$coes_four)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 



                                <?php } ?>
                                @endif 
                            </div>
                            <?php 
                        }                                     
                        ?> 

                        <?php if($view_coes_details){
                            $coes = '';
                            $coes_five = $view_coes_details->file_five;
                            ?>
                            <div class="col-lg-6 col-md-6">
                                <label for="labelheading"><strong> COES :</strong></label> 
                                <label for="">Start date  :</label> {{$view_coes_details->start_date_five}} &nbsp;&nbsp;&nbsp; <label for="">End Date  :</label> {{$view_coes_details->end_date_five}}<a href="{{url('/files/others/'.$coes_five)}}" target="_blank"> <i class="fa-sharp fa-solid fa-download"></i></a>
                                @if($coes_five != '')
                                <?php $info = pathinfo($coes_five);
                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                    { ?>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_nine">Preview</button>

                                        <div class="modal fade" id="coes_nine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>                                                   
                                                    <div class="iframediv">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$coes_five); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 


                                    <?php  }else{ ?>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_ten">Preview</button>

                                        <div class="modal fade" id="coes_ten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>                                                   
                                                    <div class="iframediv">
                                                        <iframe src="{{url('/files/others/'.$coes_five)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                    </div>
                                                </div>
                                            </div>
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

                @if($view_students->first_name)
                <?php if (isset($view_education_details->ten_marksheet) && $view_education_details->ten_marksheet != '')
                {
                    ?> 
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
                                <?php if (isset($view_education_details->ten_marksheet) && $view_education_details->ten_marksheet != '')
                                {
                                    ?>
                                    <td>10th</td>
                                    <td>{{$view_education_details->ten_school_college}}</td>
                                    <td>{{$view_education_details->ten_percentage}}</td>
                                    <td>{{$view_education_details->ten_session}}</td>
                                    <td>{{$view_education_details->ten_board_university}}</td>
                                    <td><a href="" data-toggle="modal" data-target="#exampleModal1_{{$view_education_details->student_id}}" data-src="{{$view_education_details->ten_marksheet}}" class="ten_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$view_education_details->student_id}}="true"></i></a></td>
                                    <td><a href="{{url('/files/education/'.$view_education_details->ten_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                <?php } ?>
                                
                                

                            </tr>
                            <tr>
                                <?php if (isset($view_education_details->twelve_marksheet) && $view_education_details->twelve_marksheet != '')
                                {
                                    ?>
                                    <td>12th</td>
                                    <td>{{$view_education_details->twelve_school_college}}</td>
                                    <td>{{$view_education_details->twelve_percentage}}</td>
                                    <td>{{$view_education_details->twelve_session}}</td>
                                    <td>{{$view_education_details->twelve_board_university}}</td>
                                    <td><a href="" data-toggle="modal" data-target="#exampleModal2_{{$view_education_details->student_id}}" data-src="{{$view_education_details->twelve_marksheet}}" class="twelve_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$view_education_details->student_id}}="true"></i></a></td>
                                    <td><a href="{{url('/files/education/'.$view_education_details->twelve_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                <?php }?>

                            </tr>
                            <tr>
                                @if ($view_education_details->diploma_school_college != '')
                                <td>Diploma</td>
                                <td>{{$view_education_details->diploma_school_college}}</td>
                                <td>{{$view_education_details->diploma_percentage}}</td>
                                <td>{{$view_education_details->diploma_session}}</td>
                                <td>{{$view_education_details->diploma_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal3_{{$view_education_details->student_id}}" data-src="{{$view_education_details->diploma_marksheet}}" class="diploma_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$view_education_details->diploma_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                @endif

                            </tr>
                            <tr>
                                @if ($view_education_details->bachelors_school_college != '')
                                <td>Bachelors</td>
                                <td>{{$view_education_details->bachelors_school_college}}</td>
                                <td>{{$view_education_details->bachelors_percentage}}</td>
                                <td>{{$view_education_details->bachelors_session}}</td>
                                <td>{{$view_education_details->bachelors_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal4_{{$view_education_details->student_id}}" data-src="{{$view_education_details->bachelors_marksheet}}" class="bachelors_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$view_education_details->bachelors_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                @endif

                            </tr>
                            <tr>
                                @if ($view_education_details->masters_school_college != '')
                                <td>Masters</td>
                                <td>{{$view_education_details->masters_school_college}}</td>
                                <td>{{$view_education_details->masters_percentage}}</td>
                                <td>{{$view_education_details->masters_session}}</td>
                                <td>{{$view_education_details->masters_board_university}}</td>
                                <td><a href="" data-toggle="modal" data-target="#exampleModal5_{{$view_education_details->student_id}}" data-src="{{$view_education_details->masters_marksheet}}" class="masters_mark"> <i class="fa fa-eye fa-lg"  aria-hidden{{$view_education_details->student_id}}="true"></i></a></td>
                                <td><a href="{{url('/files/education/'.$view_education_details->masters_marksheet)}}" target="_blank" ><i class="fa-sharp fa-solid fa-download"></i></a></td>
                                @endif

                            </tr>
                        </table>

                    </div>
                <?php } ?>



                <?php if ($view_fee_count>0)
                {  ?>
                    <div class="feesdetails">

                     @if ($message = Session::get('warning_message'))
                     <div class="alert alert-danger alert-block col-sm-12">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block col-sm-12">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>

                    @endif

                    <h3>Admission Fees</h3>


                    <table class="table table-hover">                            
                        <tr>                                
                            <th>#</th>                                    
                            <th>Fees</th>
                            <th>Paid</th>
                            <th>Income</th>
                            <th>Remaining</th>                                
                            <th>Received Date</th>                                
                            <th>Comment</th>                              
                            <th>Pay Fees</th>                                
                        </tr>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?php echo $view_curr_course->fees; ?></td>
                                <td><?php echo $view_curr_course->rec_admission_fees; ?></td>
                                <td><?php echo $view_curr_course->admission_fees_income; ?></td>
                                <td><?php echo $view_curr_course->fees-$view_curr_course->rec_admission_fees; ?></td>
                                <td><?php echo $view_curr_course->admission_fees_rec_date; ?></td>
                                <td><?php echo $view_curr_course->admission_fees_comment; ?></td>
                                <td><?php if($view_curr_course->fees == $view_curr_course->rec_admission_fees){?> <button class="btn btn-success myBtn">Received</button> <?php } else { ?><button class="btn btn-default myBtn" data-toggle="modal" data-target="#feesModal{{$view_curr_course->id}}" data-id="{{$view_curr_course->id}}">Pay Fees</button><?php } ?></td>
                            </tr>
                        </tbody>
                    </table>





                    <h3>Material Fees</h3>


                    <table class="table table-hover">                            
                        <tr>                                
                            <th>#</th>                                    
                            <th>Fees</th>                            
                            <th>Paid</th>
                            <th>Income</th>
                            <th>Remaining</th>                                
                            <th>Received Date</th>                                
                            <th>Comment</th>                              
                            <th>Pay Fees</th>                                
                        </tr>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?php echo $view_curr_course->material_fees; ?></td>
                                <td><?php echo $view_curr_course->rec_material_fees; ?></td>
                                <td><?php echo $view_curr_course->material_fees_income; ?></td>
                                <td><?php echo $view_curr_course->material_fees-$view_curr_course->rec_material_fees; ?></td>
                                <td><?php echo $view_curr_course->material_fees_rec_date; ?></td>
                                <td><?php echo $view_curr_course->material_fees_comment; ?></td>
                                <td><?php if($view_curr_course->material_fees == $view_curr_course->rec_material_fees){?> <button class="btn btn-success myBtn">Received</button> <?php } else { ?><button class="btn btn-default myBtn" data-toggle="modal" data-target="#materialModal{{$view_curr_course->id}}" data-id="{{$view_curr_course->id}}">Pay Fees</button><?php } ?></td>
                            </tr>
                        </tbody>
                    </table>





                    <h3>Fees Details</h3>

                    <?php //echo "<pre>"; print_r($view_all_courses); exit; ?>
                    @if($view_all_courses)
                    @foreach($view_all_courses as $course_key => $course_data)

                    <?php
                    if($course_data->current_college_course == 1)
                    {
                        $color = '#5486d5';
                        $text_color = '#ffffff';
                        $padding = '5px';
                    }
                    else
                    {
                        $color = '';
                        $text_color = '';
                        $padding = '';
                    }
                    ?>

                    <ul style="padding: <?php echo $padding; ?>; background-color: <?php echo $color; ?>; color: <?php echo $text_color; ?>;">
                        <li><strong>@if($course_data->current_college_course==1) Current Course @endif</strong></li>
                        <li><strong>Admission Fees :</strong></li>
                        <li>${{$course_data->fees}}</li>

                        <?php 
                        if($course_data->discount_type == '1' || $course_data->discount_type == '2')
                        {
                         if($course_data->discount_type =='1'){ ?>
                            <li><strong>Discount :</strong></li>
                            <li>${{$course_data->discount}}</li>
                        <?php }?>

                        <?php if($course_data->discount_type =='2') { ?>
                            <li><strong>Discount :</strong></li>
                            <li>{{$course_data->discount}}%</li> 
                        <?php  } } ?>                               


                        <li><strong>Payable Amount :</strong></li>
                        <li>${{$course_data->total_payable_amount}}</li>

                        @if ($course_data->college_trading_name !='')
                        <li><strong>College :</strong></li>
                        <li>{{$course_data->college_trading_name}}</li>
                        @endif

                        @if ($course_data->course_name !='')
                        <li><strong>Course :</strong></li>
                        <li>{{ $course_data->course_name}}</li>
                        @endif

                        @if ($course_data->intake_date !='')
                        <li><strong>Intake Date :</strong></li>
                        <li>{{ $course_data->intake_date}}</li>
                        @endif 

                        @if ($course_data->bonus !='')
                        <li><strong>Bonus :</strong></li>
                        <li>{{ $course_data->bonus}}</li>
                        @endif   


                    </ul>
                    @endforeach
                    @endif

                    <table class="table table-hover">                            
                        <tr>                                
                            <th>Installment</th>
                            <th>Due Date</th>
                            <th>Paid</th>
                            <th>Remaining</th>                                
                            <th>Received By</th>                                
                            <th>Received Date</th>                                
                            <th>Comment</th> 
                            <th>Discount</th>
                            <th>Commission</th>
                            <th style="text-align: center !important;">Action</th>                                
                        </tr>                                                         
                        <?php
                        $count=0;
                                //echo "<pre>"; print_r($view_fee_details); exit;
                               /* if($curr_fee_count > 0)
                               {*/
                                if($view_fee_details){
                                    foreach ($view_fee_details as $key => $view_fee_detail) { 
                                        $counter++;  

                                        $amount_paid = (float)str_replace(',','',$view_fee_detail->received_amount)+(float)str_replace(',','',$view_fee_detail->discount);
                                        $total_amount = (float)str_replace(',','',$view_fee_detail->amount);

                                        ?>
                                        <tr>
                                            <td id="amount_due">$<?php echo number_format($view_fee_detail->amount,2); ?></td>                               
                                            <td>{{date('d-m-Y',strtotime($view_fee_detail->due_date))}}</td>
                                            <td><?php echo number_format($view_fee_detail->received_amount,2); ?></td>
                                            <td class="remaining_amount_{{$view_fee_detail->id}}">
                                                <?php echo number_format($view_fee_detail->remaining_amount,2); ?></td>
                                                <td>{{$view_fee_detail->staff_name}}</td>
                                                <td>@if($view_fee_detail->payment_received_date !=''){{date('d-m-Y',strtotime($view_fee_detail->payment_received_date))}}@endif</td>
                                                <td>{{$view_fee_detail->comment}}</td>
                                                <td>{{$view_fee_detail->discount}}</td>
                                                <td><?php $commission = str_replace(',','',$view_fee_detail->commission); 
                                                echo number_format($commission,2);
                                            ?> </td>

                                            <td><?php /*if($view_fee_detail->received_amount == null && $count==0 ){*/
   

                                                   if($view_fee_detail->received_amount != 0)
                                                   {
                                                     ?>

                                                      <button style="position:relative;" class="btn btn-default send_reciept reciept_button{{$view_fee_detail->id}}" data-student_id="{{$view_fee_detail->student_id}}" data-college_id="{{$view_fee_detail->college_id}}" data-course_id="{{$view_fee_detail->course_id}}" data-fee_id="{{$view_fee_detail->id}}">Send Reciept <span id="loading{{$view_fee_detail->id}}" class="d-none" style="position:absolute;width: 100%; height: 100%;left: 0;top: 0;z-index: 99;"><img src="{{url('admin/images/loading-gif.gif')}}" width="30%"></span></button>

                                                 <?php  }

                                                if($view_fee_detail->payment_proof!=''){ ?>
                                                   <!--  <a href="{{url('/payment/'.$view_fee_detail->payment_proof)}}" target="_blank"><i class="fa-sharp fa-solid fa-download"></i></a> -->
                                                   <a href="{{url('/payment_proof/'.$view_fee_detail->id)}}" target="_blank"><i class="fa-sharp fa-solid fa-download"></i></a>

                                                   <?php
                                               }
                                               $amountpaind = str_replace('"','',$amount_paid);
                                               $totalamount = str_replace('"','',$total_amount);                                          

                                               if(($amountpaind != $totalamount) && $count==0 ){

                                            //echo $view_fee_detail->received_amount+$view_fee_detail->discount.'-->'.$view_fee_detail->amount.'-->'.$count;

                                                   ?>

                                                   


                                                   <?php     

                                                   if($view_fee_detail->received_amount != 0)
                                                   {
                                                      ?>



                                                      <button class="btn btn-default edit_rec_fees" data-toggle="modal" data-target="#edit_rec_fees" data-id="{{$view_fee_detail->id}}">Edit</button>



                                                  <?php } ?>

                                                  <button class="btn btn-default discount_btn" data-toggle="modal" data-target="#discountModal" data-id="{{$view_fee_detail->id}}" data-amount="{{$view_fee_detail->amount}}" data-remaining_amount="{{$view_fee_detail->remaining_amount}}"  data-discount="{{$view_fee_detail->discount}}">Discount</button>

                                                  <button class="btn btn-default myBtn" data-toggle="modal" data-target="#exampleModal_fees" data-id="{{$view_fee_detail->id}}" data-amount="{{$view_fee_detail->amount}}" data-remaining_amount="{{$view_fee_detail->remaining_amount}}">Fees</button>

                                              </td>


                                              <?php $count++; } ?>


                                          </tr>                                    
                                      <?php  } } /*}*/?>                                                            
                                  </table>
                              </div>
                          <?php } ?>

                          <div class="feesdetails">
                            <h3>Student Communication Log</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Comment</th>
                                        <th>Updated On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($view_communication_logs){ 
                                        foreach ($view_communication_logs as $view_communication_log => $logs_data ) { ?>                                           
                                            <tr>
                                                <td>{{$view_communication_log+1}} </td>
                                                <td>{{$logs_data->comment}} </td>
                                                <td>{{ date('d-m-Y H:i:s',strtotime($logs_data->created_at))}} </td>
                                            </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                            </div>
                            @endif


                            <div class="feesdetails">
                                <h3>Student Messages Log</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Message</th>
                                            <th>Media</th>
                                            <th>Type</th>
                                            <th>Updated On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($view_msg_logs){ 
                                            foreach ($view_msg_logs as $key => $view_msg_log ) { ?>                                           
                                                <tr>
                                                    <td>{{ $view_msg_logs->firstItem() + $key }} </td>
                                                    <td><?php echo $view_msg_log->message; ?> </td>
                                                    <td><?php if($view_msg_log->attachement != '' && $view_msg_log->message_type == 2){ ?><a href="{{url('images/whatsapp_attachment/'.$view_msg_log->attachement)}}">Download</a><?php } else{ ?> Not Available <?php } ?></td>
                                                    <td><?php if($view_msg_log->message_type == 1){ echo 'Text Message'; } else if($view_msg_log->message_type == 2) { echo 'Whatsapp Message'; } else if($view_msg_log->message_type == 3){ echo "Mail"; } ?></td>
                                                    <td>{{ date('d-m-Y H:i:s',strtotime($view_msg_log->created_at))}} </td>
                                                </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>

                                    <div class="paginationsbg">
                                        {{$view_msg_logs->links('pagination::bootstrap-4')}}                        
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>




                    <div class="modal fade" id="exampleModal_fees" tabindex="-1" role="dialog" aria-labelledby="exampleModal_fees" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Amount Received</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('adminPayFee')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                                        @csrf
                                        <label for="amount"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
                                        <input type="text" class="form-control max_amount" min="0" max="" id="amount" name="amount" required><br>

                                        <label for="payment_proof"><strong>Payment Proof :</strong></label><br>
                                        <input type="file" class="form-control" id="payment_proof" name="payment_proof"><br>

                                        <label for="amount"><strong>Payment Type : <span style='color: red'>*</span></strong></label><br>
                                        <input type="radio" name="payment_type" value="1" checked>Cash                      
                                        <input type="radio" name="payment_type" value="2">Bank<br><br>

                                        <label for="comment"><strong>Comment :</strong></label><br>
                                        <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea> 


                                        <input type="hidden" class="fee_id" value="" name="fee_id">
                                        <input type="hidden" class="amt_due" value="" name="amt_due">
                                        <input type="hidden" class="campus_id" value="<?php if(isset($view_fee_detail)) { echo $view_fee_detail->campus_id; } ?>" name="campus_id">


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Receive Amount</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Discount Amount</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('adminPayFee_discount')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                                        @csrf
                                        <label for="dicount"><strong>Discount : </strong></label><br>
                                        <input type="number" min="0" max="" class="form-control discount_max" id="
                                        " name="discount" value="" step=".01"><br>

                                        <input type="hidden" class="fee_id" value="" name="fee_id">
                                        <input type="hidden" class="amt_due" value="" name="amt_due">
                                        <input type="hidden" class="campus_id" value="<?php if(isset($view_fee_detail)) { echo $view_fee_detail->campus_id; } ?>" name="campus_id">


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="modal fade" id="edit_rec_fees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Amount Received</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('edit_recieve_fees')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                                        @csrf

                                        <div class="row_amount"></div>

                                        <div class="installment_fees_parts"></div>

                                        <input type="hidden" class="fee_id" value="" name="fee_id">


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->



                    <!-- Modal2 -->


                    <!-- Admission Fees modal Start here -->
                    <?php if($view_curr_course_count > 0){ ?>

                     <div class="modal fade" id="feesModal{{$view_curr_course->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Amount Received</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admissionPayFee')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                                        @csrf
                                        <label for="amount"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
                                        <input type="number" class="form-control" id="amount" name="amount" min="1" max="<?php echo $view_curr_course->fees-$view_curr_course->rec_admission_fees; ?>" required><br>

                                        <label for="amount"><strong>Actual Income : <span style='color: red'>*</span></strong></label><br>
                                        <input type="number" class="form-control" id="admission_fees_income" name="admission_fees_income" min="1" max="<?php echo $view_curr_course->fees-$view_curr_course->rec_admission_fees; ?>"><br>

                                        <label for="payment_proof"><strong>Payment Proof :</strong></label><br>
                                        <input type="file" class="form-control" id="payment_proof" name="payment_proof"><br>

                                        <label for="amount"><strong>Payment Type : <span style='color: red'>*</span></strong></label><br>
                                        <input type="radio" name="payment_type" value="1" checked>Cash                      
                                        <input type="radio" name="payment_type" value="2">Bank<br><br>

                                        <label for="comment"><strong>Comment :</strong></label><br>
                                        <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea> 


                                        <input type="hidden" class="fee_id" value="<?php echo $view_curr_course->id ?>" name="fee_id">
                                        <input type="hidden" class="fee_type" value="admission_fees" name="fees_type">
                                        <input type="hidden" class="amt_due" value="" name="amt_due">

                                        <input type="hidden" class="campus_id" value="<?php if(isset($view_curr_course)) { echo $view_curr_course->campus_id; } ?>" name="campus_id">


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Receive Amount</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Admission Fees modal End Here -->



                <!-- Material Fees modal Start here -->
                <?php if($view_curr_course_count > 0){ ?>

                 <div class="modal fade" id="materialModal{{$view_curr_course->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Amount Received</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admissionPayFee')}}" method="post" id="pay_fee" enctype='multipart/form-data'>
                                    @csrf
                                    <label for="amount"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
                                    <input type="number" class="form-control" id="amount" name="amount" min="1" max="<?php echo $view_curr_course->material_fees-$view_curr_course->rec_material_fees; ?>" required><br>

                                    <label for="amount"><strong>Actual Income : <span style='color: red'>*</span></strong></label><br>
                                        <input type="number" class="form-control" id="material_fees_income" name="material_fees_income" min="1" max="<?php echo $view_curr_course->material_fees-$view_curr_course->rec_material_fees; ?>"><br>

                                    <label for="payment_proof"><strong>Payment Proof :</strong></label><br>
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof"><br>

                                    <label for="amount"><strong>Payment Type : <span style='color: red'>*</span></strong></label><br>
                                    <input type="radio" name="payment_type" value="1" checked>Cash                      
                                    <input type="radio" name="payment_type" value="2">Bank<br><br>

                                    <label for="comment"><strong>Comment :</strong></label><br>
                                    <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea> 


                                    <input type="hidden" class="fee_id" value="<?php echo $view_curr_course->id ?>" name="fee_id">
                                    <input type="hidden" class="fee_type" value="material_fees" name="fees_type">
                                    <input type="hidden" class="amt_due" value="" name="amt_due">

                                    <input type="hidden" class="campus_id" value="<?php if(isset($view_curr_course)) { echo $view_curr_course->campus_id; } ?>" name="campus_id">


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Receive Amount</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <!-- Material Fees modal End Here -->


            @if($view_education_details)


            <div class="modal fade" id="exampleModal1_{{$view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> 10th Marksheet</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if($view_education_details->ten_marksheet != '')
                    <?php $info = pathinfo($view_education_details->ten_marksheet);
                    if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                        { ?>
                            <div class="iframediv">
                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->ten_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="iframediv">
                                <iframe src="{{url('/files/education/'.$view_education_details->ten_marksheet)}}" title="passport file"></iframe>
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


      <!-- Modal2 -->


      @if($view_education_details)


      <div class="modal fade" id="exampleModal2_{{$view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> 12th Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if($view_education_details->twelve_marksheet != '')
            <?php $info = pathinfo($view_education_details->twelve_marksheet);
            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                { ?>
                    <div class="iframediv">
                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->twelve_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="iframediv">
                        <iframe src="{{url('/files/education/'.$view_education_details->twelve_marksheet)}}" title="passport file"></iframe>
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


<!-- Modal2 -->


@if($view_education_details)


<div class="modal fade" id="exampleModal3_{{$view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Diploma Marksheet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($view_education_details->diploma_marksheet != '')
        <?php $info = pathinfo($view_education_details->diploma_marksheet);
        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
            { ?>
                <div class="iframediv">
                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->diploma_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$view_education_details->diploma_marksheet)}}" title="passport file"></iframe>
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


<!-- Modal2 -->


@if($view_education_details)


<div class="modal fade" id="exampleModal4_{{$view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Bachelors Marksheet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($view_education_details->bachelors_marksheet != '')
        <?php $info = pathinfo($view_education_details->bachelors_marksheet);
        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
            { ?>
                <div class="iframediv">
                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->bachelors_marksheet); ?>&embedded=true"  title="passport file"></iframe>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="iframediv">
                    <iframe src="{{url('/files/education/'.$view_education_details->bachelors_marksheet)}}" title="passport file"></iframe>
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


<!-- Modal2 -->


@if($view_education_details)


<div class="modal fade" id="exampleModal5_{{$view_education_details->student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Masters Marksheet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($view_education_details->masters_marksheet != '')
        <?php $info = pathinfo($view_education_details->masters_marksheet);
        if ($info["extension"] == "doc" || $info["extension"] == "docx" )
            { ?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masters_marksheet_one">Preview</button>

                <div class="modal fade" id="masters_marksheet_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Master Marksheet View</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="iframediv">
                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->masters_marksheet); ?>&embedded=true" style="width:100%; height:500px;"  title="australian_id file"></iframe>
                            </div>   
                        </div>
                    </div>
                </div>
                <?php
            }
            else
            {
                ?> 

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masters_marksheet_two">Preview</button>

                <div class="modal fade" id="masters_marksheet_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Master Marksheet View</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="iframediv">
                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$view_education_details->masters_marksheet); ?>&embedded=true" style="width:100%; height:500px;"  title="australian_id file"></iframe>
                            </div>   
                        </div>
                    </div>
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










{{-- <script>
    $(document).on('click','.ten_mark',function(){
        var src = $(this).attr("data-src");
        alert(src);
            // $('.fee_id').val(fee)
    })
</script> --}}





<script>
    $(document).on('click','.myBtn',function(){

        var fee = $(this).attr("data-id");
        var amount = $(this).attr("data-amount");
        var remaining_amount = $(this).attr("data-remaining_amount");
        $('.fee_id').val(fee);
        $('.max_amount').addClass('maxamount_val'+fee);            

        if(remaining_amount != '')
        {
           $('.maxamount_val'+fee).attr('max',remaining_amount);
       }
       else
       {
        $('.maxamount_val'+fee).attr('max',amount);
    }

});


    $(document).on('click','.discount_btn',function(){
        var fee = $(this).attr("data-id");
        var amount = $(this).attr("data-amount");
        var remaining_amount = $(this).attr("data-remaining_amount");
        var discount = $(this).attr("data-discount");
        $('.discount_max').val(discount);

        var max_discount = parseFloat(remaining_amount) + parseFloat(discount);

        $('.fee_id').val(fee);
        if(remaining_amount != '')
        {


            $(".discount_max").attr({"max" : max_discount});
        }
        else
        {
            $(".discount_max").attr({"max" : amount});
        }

    });


    $(document).on('click','.edit_rec_fees',function(){
        var fee_id = $(this).attr("data-id");
        $('.fee_id').val(fee_id);

        $.ajax({
            type:'POST',
            url:"{{ route('edit_rec_fees') }}",
            data:{"_token": "{{ csrf_token() }}",fee_id:fee_id},
            success:function(data)
            {  
                $('.installment_fees_parts').html(data);
            }

        });

    });


    $(document).on('click','.update_rec_amt',function(){
        var fee_emi_id = $(this).attr("id");
        var feedetail_id = $(this).data("feedetail_id");
        var amount = $('.amount'+fee_emi_id).val();

            //alert(amount);

        $.ajax({
            type:'POST',
            url:"{{ route('edit_recieve_fees') }}",
            data:{"_token": "{{ csrf_token() }}",fee_emi_id:fee_emi_id,amount:amount,feedetail_id:feedetail_id},
            success:function(data)
            {  
                if(data == 'not_allowed')
                {
                    $('.row_amount').html('<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button> <strong>Total installment amount can not be greater than installment amount!</strong></div>');
                }
                else if(data == 'updated')
                {
                    window.location.href = window.location.href;
                }
            }
        });

    });



    $(document).on('click','.send_reciept',function(){
        var student_id = $(this).attr("data-student_id");
        var college_id = $(this).attr("data-college_id");
        var course_id = $(this).attr("data-course_id");
        var fee_id = $(this).attr("data-fee_id");

        $.ajax({
            type:'POST',
            url:"{{ route('fees_reciept') }}",
            data:{"_token": "{{ csrf_token() }}",course_id:course_id,college_id:college_id,student_id:student_id,fee_id:fee_id},


            beforeSend: function(){
                $("#loading"+fee_id).removeClass('d-none');
                $(".reciept_button"+fee_id).prop( "disabled", true );
            },

            success:function(data)
            { 
             if(data == 1)
             {
                swal("Success", "Mail Has been Sent.", "success");
             } 
            },

            complete: function(){
                $("#loading"+fee_id).addClass('d-none');
                $(".reciept_button"+fee_id).prop( "disabled", false );
            }

        });

    });    


</script>



<script>
    $('#pay_fee').validate({

        rules: {
            amount: {required: true,number:true}
        } ,
        messages: {
            amount:{required: "Please enter amount.",number:"Please enter numbers only."}
        }     
    });
</script>



@endsection       