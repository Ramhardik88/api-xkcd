<?php
session_start();                                        //session started
require_once '../config/dbh.config.php';
require_once 'functions.inc.php';

if(isset($_POST['submit']))
{
 $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
 $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
 $_SESSION['email'] = $email;                            //add email to session variables
                                                        //template to call the function check the user inputs
 if(emptyInputRegister($name,$email) !== false){
     header("Location: ../index.php?error=emptyinput");
     exit();
 }

 if(invalidUid($name) != false){
     header("Location: ../index.php?error=invaliduid");
     exit();
 }

 if(invalidEmail($email) !== false ){
    header("Location: ../index.php?error=invalidemail");
    exit();
 }

 if(uidExists($conn,$name,$email)!== false ){
    header("Location: ../index.php?error=usernametaken");
    exit();
}
createUser($conn,$name,$email);

}else{
    header("Location: ../index.php");
}