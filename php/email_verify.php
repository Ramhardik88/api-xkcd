
<?php

require_once 'config/dbh.config.php';
require_once 'includes/functions.inc.php';
$message = '';

if(isset($_GET["code"]))                                       //check activation code is set in url or not.. if not redirect to the index pages
{
 $user_activation_code = $_GET["code"];

     if(isset($_POST["submit"]))
     {
          // $user_otp = ($_POST["opt_code"]);
           $user_otp = filter_input(INPUT_POST,'opt_code',FILTER_SANITIZE_NUMBER_INT);
           if(emptyInputotp($user_otp)!== false)
           {
             $message = 'Empty OTP Number';
             
           }
           if(otpChecking($conn,$user_otp,$user_activation_code)!== false){
             $message = 'Invalid OTP Number';
         
           }
       
     }
}
else
{
header("Location:index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="../css/style.css">
 <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
 <script language="javascript" type="text/javascript">
	window.history.forward();
    </script>
 <title>Document</title>
</head>
<body>

<div class="content-body">
   <div class="form-wrapper">
     <form class="bg-white" method="post">
       <h1 class="text-title">One Step away please enter the Otp</h1>
     
       <div   class="field-group">
         <label class="label" for="txt-otp">OTP</label>
         <input class="input" type="text" id="txt-otp" name="opt_code" placeholder="one time password" />
       </div>
       <div class="field-group">
         <input class="btn-submit" name="submit" type="submit" value="Verify" />
       </div>
       <h2 class="text-title-error" > <?php echo $message; ?> </h2> 
     </form>
   </div>
 </div>
</body>
</html>