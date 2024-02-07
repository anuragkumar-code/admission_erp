<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<link href='https://fonts.googleapis.com/css?family=Poppins:400,500,600' rel='stylesheet'>
<title>RMS</title>

</head>
<?php
$back_url = url('/admin/dashboard'); 

$path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .=$_SERVER["SERVER_NAME"]. dirname($_SERVER["PHP_SELF"]);  

?>
<body style='padding:0px; margin:0px; font-family: 'Poppins', sans-serif; vertical-align:middle;'>


<div style='width: 540px; margin: 0px auto; display: table;'>
    <div style='width: 100%; float: left; background-color: #fff; border: solid 1px #d5d5d5; padding: 20px 30px; margin: 30px 0;'>

        <div style='width: 100%; margin: 10px 0px 15px; text-align: center; float: left;'>
        <img src=<?php echo $path."/admin/images/logo.png"; ?> style='padding: 0px 6px 0px 12px;width:300px' border='0' alt=' />
        </div>
       <div style='clear:both'>&nbsp;</div>
       <div><a href="<?php echo $back_url; ?>" style='background: #1d94c7; color: #fff; padding: 15px 0px; text-decoration: none; font-weight: 600; text-align: center; font-size: 16px; border-radius: 4px; width: 20%; float: left; margin: 20px 0px 0px 216px;'>Back</a></div>



        <h2 style='color: #1d94c7; text-align: center; font-size: 30px; font-weight: 500; margin: 5px 0px 10px; width: 100%; float: left;'>Thank You for allowed staff login.</h2>

        <p style='width: 100%; float: left; text-align: center; color: #000; font-weight: 500;'> Copyright 2022 Student Management panel. All Rights Reserved.</p>
            
    </div>    
</div>


</body>
</html>  
