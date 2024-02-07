@extends('staff.layout.head')
@section('staff')

   <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                    <div class="studentsinfobg">
                        <h1>{{$staff_view_colleges->college_trading_name}}</h1>
                        <ul>
                            <li>
                                <label for=""></i> By:</label> {{$staff_view_colleges->college_company_name}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa fa-map-marker" aria-hidden="true"></i> Address:</label> {{$staff_view_colleges->campus_address_1}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa fa-link" aria-hidden="true"></i> Website: </label><a href="{{$staff_view_colleges->website}}">{{$staff_view_colleges->website}}</a>
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> RTO No. :</label> {{$staff_view_colleges->rto_number}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Cricos No.:</label> {{$staff_view_colleges->cricos_number}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> Admission Email Address:</label> {{$staff_view_colleges->admission_email}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> PEO Email Address:</label> {{$staff_view_colleges->peo_email}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> Marketing Email Address:</label> {{$staff_view_colleges->marketing_email}}
                            </li>
                            {{-- <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Circos No.:</label> {{$staff_view_colleges->website}}
                            </li> --}}
                        </ul>
                      
                        
                    </div>
            </div>
        </div>
   </div>
   
                    
@endsection       