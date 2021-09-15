<?php
// require '../aws-ses/SimpleEmailService.php';
// require '../aws-ses/SimpleEmailServiceMessage.php';
// require '../aws-ses/SimpleEmailServiceRequest.php';





                                                  // functions used to validate the user inputs
function emptyInputRegister($name,$email){        //user try to login without enter name and email               
    $result;
    if(empty($name) || empty($email)){
        $result = true;
    }else{
        $result =  false;
    }
    return $result;
}
function invalidUid($name)                              // validate username
{
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $name)) {
        $result  = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidEmail($email)                            // validate email
    {
        $result;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result  = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function uidExists($conn, $name, $email)                   //validate user email already found in database or not 
    {                                                          // Here using prepared statement to prevent the sql injection 
                                                               // technically using mysqli with prepared Statements.
        $sql = "SELECT * FROM users WHERE 	User_name = ? OR User_email = ?;";       //sending the query without variables
        $stmt = mysqli_stmt_init($conn);                                             //create the database connection  
        if (!mysqli_stmt_prepare($stmt, $sql)) {                 
            header("Location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);     //sending the variables and bind them
        mysqli_stmt_execute($stmt);                                 //execute the query inside database

        $resultData =  mysqli_stmt_get_result($stmt);               //get the result in the variable
        if ($row = mysqli_fetch_assoc($resultData)) {

            return $row;
        } else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);                                  // close the database connection                   
    } 
    function sendEmailOtp($email,$user_otp){                       //sending otp to email using this function
        //require_once '../config/aws.config.php';                   // use data inside the aws config file
        require '../config/aws.config.php'; 
        require '../config/dbh.config.php';
        require '../aws-ses/SimpleEmailService.php';
        require '../aws-ses/SimpleEmailServiceMessage.php';
        require '../aws-ses/SimpleEmailServiceRequest.php';
        $sender = $mail_id;                                        
        $senderName = $name;                                     
        $recipient =  $email;

        $m = new SimpleEmailServiceMessage();
        $m->addTo($recipient);
        $m->setFrom($sender);
        $m->setSubject('Confirm Your XKCD-Comics Account Email Address');
        $m->setMessageFromString('to verify');

        $ses = new SimpleEmailService($AccessKey, $SecretKey);
        $bodyHtml =                                                  
        "<table align='center' cellpadding='0' cellspacing='0' border='0' width='100%'bgcolor='#f0f0f0'>"
        ."<tr>"
        ."<td style='padding: 30px 30px 20px 30px;'>"
            ."<table cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#ffffff' style='max-width: 650px; margin: auto;'>"
            ."<tr>"
                ."<td colspan='2' align='center' style='background-color: #333; padding: 40px;'>"
                    ."<img src='https://xkcd.com/s/0b7742.png' border='0' style='width: 150px; height=150px;' />"
                ."</td>"
            ."</tr>"
            ."<tr>"
                ."<td colspan='2' align='center' style='padding: 50px 50px 0px 50px;'>"
                    ."<h1 style='padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;'>Email OTP"
                    ."</h1>"
                ."</td>"
            ."</tr>"
            ."<tr>"
                ."<td style='text-align: left; padding: 0px 50px;' valign='top'>"
                    ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
                        Welcome,"
                    ."</p>"
                    ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
                        Please use this one time password $user_otp to sign in to your application"
                    ."</p>"
                ."</td>"
            ."</tr>"
            ."<tr>"
                ."<td style='text-align: left; padding: 30px 50px 50px 50px' valign='top'>"
                    ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;'>
                        Thank you"
                    ."</p>"
                ."</td>"
            ."</tr>"
            ."<tr>"
                ."<td colspan='2' align='center' style='padding: 20px 40px 40px 40px;' bgcolor='#f0f0f0'>"
                ."</td>"
            ."</tr>"
            ."</table>"
        ."</td>"
    ."</tr>"
."</table>"
;  
         $m->setMessageFromString(null, $bodyHtml);
         return  $ses->sendEmail($m);
    
}
//require '../config/dbh.config.php';
function createUser($conn, $name, $email)
{
    require '../config/dbh.config.php';
    $user_activation_code = md5(rand());           //to generate a random and unique alphanumeric string

    $user_otp = rand(100000, 999999);              // to generate the 6 digit random code 

     if(sendEmailOtp($email,$user_otp) == true){        // check wheather the email with onetimepassword is sending or not
            $email_status='not verified';              // Here using prepared statement to prevent the sql injection 
            $sql = "INSERT INTO users(User_name,User_email,User_activation_code,User_email_status,User_otp) VALUES (?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);                 //create the database connection  
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.php?error=stmtfaileduser");
                        exit();
                    }  
                                                       //sending the variables and bind them
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $user_activation_code,$email_status,$user_otp);
            mysqli_stmt_execute($stmt);                //execute the query
            mysqli_stmt_close($stmt);                  //close the database connection
            header("Location: ../email_verify.php?code=".$user_activation_code); // redirect to the next page
   }else{
        header("Location: ../index.php?error=Failedtosend");             //if email not send redirect to the index page
        exit();
   }
}
 function emptyInputotp($user_otp){                                  //empty user input
        if(empty($user_otp) ){
            $result = true;
        }else{
            $result =  false;
        }
        return $result;
    }
    function otpChecking($conn,$user_otp,$user_activation_code){      // this function checks user enter otp is correct or not            

        $sql  = "SELECT * FROM users WHERE User_otp  = ? AND User_activation_code = ?;";  //Created a template
        $stmt = mysqli_stmt_init($conn);                                  //Create a prepared statement
            if(!mysqli_stmt_prepare($stmt,$sql)){                         // prepare the prepared statement
                header("Location: email_verify.php?error=stmtfailed");
                exit();
            }
              mysqli_stmt_bind_param($stmt,"is",$user_otp,$user_activation_code);  //Bind parameters to the placeholder
              mysqli_stmt_execute($stmt);                                     //Run parameters inside database
              mysqli_stmt_store_result($stmt);                                
              $rowCount = mysqli_stmt_num_rows($stmt);                        //checks no of rows found in the database
                if($rowCount > 0){
                     $email_status = 'verified';
                $sql = "UPDATE users SET User_email_status = ? WHERE User_activation_code = ?;";  //Created a template
                $stmt = mysqli_stmt_init($conn);                                         //Create a prepared statement
                    if (!mysqli_stmt_prepare($stmt, $sql)) {                             // prepare the prepared statement
                        header("Location: email_verify.php?error=stmtfailed");
                        exit();
                    }
                    mysqli_stmt_bind_param($stmt, "ss",$email_status, $user_activation_code);//Bind parameters to the placeholder
                   if(mysqli_stmt_execute($stmt)){                                            
                    header('Location: welcome_in.php?value=success');      //if otp matches redirect to the welcome page
                    exit();
                   } 
            }
            else{
                $result = true;
                return $result;
            }
        
         mysqli_stmt_close($stmt);                       //close the database connection

    }


    //function in unsubscribe
    function emptyInputEmail($email){
        $result;
        if(empty($email) ){
            $result = true;
        }else{
            $result =  false;
        }
        return $result;
    }

    function checkIfExists($conn,$email)
    {
        $sql = "SELECT * FROM users  WHERE User_email = ?;";           //Created a template
        $stmt  =  mysqli_stmt_init($conn);                             //Create a prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {                       // prepare the prepared statement
            header("Location: unsubscribe.php?error=stmtfaileda");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$email);                      //bind parameters to the placeholder
        mysqli_stmt_execute($stmt);                                    //Run parameters inside database
        mysqli_stmt_store_result($stmt);
        $rowCount = mysqli_stmt_num_rows($stmt);                       //count the number of rows
        if($rowCount > 0){
            $sql = "DELETE FROM users where User_email= ?;";
            $stmt  =  mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: unsubscribe.php?error=stmtfailedb");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);                              // if email matches the delete and redirect to the next pages
            header("Location: welcome_out.php");
		    exit();
        }else{
            $result = true;
            return $result;
        }
        mysqli_stmt_close($stmt);                                        //close the database connection


    }
