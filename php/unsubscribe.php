<?php
$message = '';
if(isset($_GET["error"])){
    if($_GET["error"] == "emptyinput"){
    	$message = "<p>Fill in all the fields!</p>";
    }
	elseif($_GET["error"] == "invalidemail"){
		$message = "<p>Choose a proper email</p>";
	}
	elseif($_GET["error"] == "emailNotFound"){
		$message = "You are not yet subscribed!</p>";
	}
	elseif($_GET["error"] == "stmtfailed"){
		$message = "<p>Something went wrong, tryagain later</p>";
	}
}

?>
<?php
require 'includes/functions.inc.php';
require 'config/dbh.config.php';

if(isset($_POST['submit']))
{
 $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);

    if(emptyInputEmail($email)!== false){
        header("Location: unsubscribe.php?error=emptyinput");
        exit();
    }

    if(invalidEmail($email) !== false ){
        header("Location: unsubscribe.php?error=invalidemail");
        exit();
     }

     if(checkIfExists($conn,$email) !== false){
        header("Location: unsubscribe.php?error=emailNotFound");
        exit();
     }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="follow,index">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<script language="javascript" type="text/javascript">
	window.history.forward();
    </script>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="content-body">
		<div class="form-wrapper">
			<form  method="post" class="bg-white">
				<h1 class="text-title">Please Enter email</h1>
				<div class="field-group">
					<label class="label" for="txt-email">Email address</label>
					<input class="input" type="text" id="txt-email" name="email" placeholder="johndoe@gmail.com" />
				</div>
				<div class="field-group">
					<input class="btn-submit" type="submit" name="submit" value="Register" />
				</div>
				<h2 class="text-title-error" > <?php echo $message; ?> </h2> 
			</form>
		</div>
	</div>
</body>
</html>

