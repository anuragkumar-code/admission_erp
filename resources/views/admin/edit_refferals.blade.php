@extends('admin.layout.head')

@section('admin')



    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Edit Refferal</h1>

                            </div>

                        </div>

                    </div>                    

                </div>



                <section id="main-content">

                    <div class="row">                        

                        <div class="col-lg-12">

                            <div class="card">                               

                                <form action="{{url('/admin/edit_refferals')}}" method="post" enctype="multipart/form-data">

                                    @csrf  

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for="first_name"><strong>Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="<?php echo $referrals_data->name; ?>" placeholder="Enter Name" name="name">
                                            <p class="text-danger">@error('name') {{$message}}@enderror</p>
                                        </div>

                                        <div class=" col-sm-6 form-group">
                                            <label for="email"><strong>Email <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="<?php echo $referrals_data->email; ?>" placeholder="Enter Email" name="email">
                                        </div>


                                           <div class=" col-sm-6 form-group">
                                            <label for="mobile"><strong>Mobile <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="<?php echo $referrals_data->phone; ?>" placeholder="Enter mobile" name="phone">
                                    </div>           
                                    </div>                                                              
                                    <input type="hidden" name="id" value="<?php echo $referrals_data->id; ?>">

                                    <div class="row padsubmit">                              
                                        <button type="submit" class="btn btn-outline-info">Update Referral</button>
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





