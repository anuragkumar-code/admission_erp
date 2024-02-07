@extends('admin.layout.head')

@section('admin')



    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Add New Refferal</h1>

                            </div>

                        </div>

                    </div>                    

                </div>



                <section id="main-content">

                    <div class="row">                        

                        <div class="col-lg-12">

                            <div class="card">                               

                                <form action="{{url('/admin/add_refferals')}}" method="post" enctype="multipart/form-data">

                                    @csrf  

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for="first_name"><strong>Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Name" name="name">
                                            <p class="text-danger">@error('name') {{$message}}@enderror</p>
                                        </div>

                                        <div class=" col-sm-6 form-group">
                                            <label for="email"><strong>Email <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="{{old('email')}}" placeholder="Enter Email" name="email">
                                            <!-- <p class="text-danger">@error('email') {{$message}}@enderror</p> -->
                                        </div>


                                           <div class=" col-sm-6 form-group">
                                            <label for="mobile"><strong>Mobile <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="{{old('phone')}}" placeholder="Enter mobile" name="phone">
                                            <!-- <p class="text-danger">@error('phone') {{$message}}@enderror</p> -->       
                                    </div>           
                                    </div>                                                             

                                    <div class="row padsubmit">                              
                                        <button type="submit" class="btn btn-outline-info">Add Referral</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>



    

<script type="text/javascript">

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;

    }

    $(".jjj").change(function() {
        var user = $(this).val();
        if (user == 2){
            $(".rights").removeClass('d-none');
        }
        else{
            $(".rights").addClass('d-none');
        }
                

        });
</script>



<script type="text/javascript">

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {

            input.attr("type", "text");

                } else {

                    input.attr("type", "password");

                }

    });

</script>



    

@endsection





