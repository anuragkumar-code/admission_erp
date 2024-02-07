@extends('admin.layout.head')
@section('admin')

   <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                    <div class="studentsinfobg">
                        <h1>{{$view_colleges->college_trading_name}}</h1>
                        <ul>
                            <li>
                                <label for=""></i> By:</label> {{$view_colleges->college_company_name}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa fa-map-marker" aria-hidden="true"></i> Address:</label> {{$view_colleges->campus_address_1}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa fa-link" aria-hidden="true"></i> Website: </label><a href="{{$view_colleges->website}}">{{$view_colleges->website}}</a>
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> RTO No. :</label> {{$view_colleges->rto_number}}
                            </li>
                            <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Cricos No.:</label> {{$view_colleges->cricos_number}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> Admission Email Address:</label> {{$view_colleges->admission_email}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> PEO Email Address:</label> {{$view_colleges->peo_email}}
                            </li>
                            <li>
                                <label for=""><i class="fa-solid fa-envelope" aria-hidden="true"></i> Marketing Email Address:</label> {{$view_colleges->marketing_email}}
                            </li>
                            {{-- <li>
                                <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Circos No.:</label> {{$view_colleges->website}}
                            </li> --}}
                        </ul>
                      
                        
                    </div>
            </div>
        </div>
   </div>
   
                    
@endsection       