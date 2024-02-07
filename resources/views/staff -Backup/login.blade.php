<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Staff - Login</title>





    <!-- Styles -->

    <link href="{{asset('admin/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/themify-icons.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/helper.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />





</head>



<body>



    <div class="unix-login">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-5">

                    <div class="login-content">

                        <div class="login-logo">
                            <img src="{{url('admin/images/logo.png')}}" alt="">
                            

                            {{-- <a href="#"><img src="images/jobhub-logo.svg" alt=""></a> --}}

                        </div>

                        <div class="login-form">

                            <span class="headtxt"><h2>Staff Login</h2></span>

                            @if(session()->has('error'))

                            <div class="alert alert-danger" id="myDIV" role="alert" style="width: 100%; float: left;">

                                <strong>{{session()->get('error')}}</strong>                                

                            </div>

                            @endif



                            <form action="{{route('staffloggedin')}}" method="post">

                                @csrf

                                <div class="form-group">

                                    <label for="">Email :</label>                                   

                                    <input type="email" name="email" class="form-control" placeholder="Email">

                                    <p class="text-danger">@error('email') {{$message}}@enderror</p>

                                </div>

                                <div class="input-box pwdview"> 

                                    <label for="">Password :</label>                              

                                    <input type="password"  name="password" class="form-control" id= "myInput"placeholder="Password">

                                    <span class="eye eyeicons" onclick="myFunction()">                                        

                                        <i id ="hide1" class="fa fa-eye"></i>

                                        <i id="hide2" class="fa fa-eye-slash"></i>                                   

                                    </span>

                                    <p class="text-danger">@error('password') {{$message}}@enderror</p>

                                </div>                              

                                <button type="submit" class="btn btn-primary btn-flat m-b-10 m-t-10">Sign in</button>                                

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



</body>



</html>



<script>

    function myFunction(){

        var x = document.getElementById("myInput");

        var y = document.getElementById("hide1");

        var z = document.getElementById("hide2");

        if(x.type === 'password'){

            x.type = "text";

            y.style.display = "block";

            z.style.display = "none";

        }

          else {

            x.type = "password";

            y.style.display = "none";

            z.style.display = "block";





          }     



    }

</script>



<style>

.eye{

    position: absolute;

  }

  #hide1{

    display: none;

  }

</style>

