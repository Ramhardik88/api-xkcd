<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
	<script language="javascript" type="text/javascript">
	window.history.forward();
    </script>
    <title>Welcome</title>
</head>
<body>
<?php
$message = '';
if(isset($_GET["error"])){
    if($_GET["error"] == "emptyinput"){
    	$message = "<p>Fill in all the fields!</p>";
    }
	elseif($_GET["error"] == "invaliduid"){
		$message = "<p>Choose a proper username</p>";
	}
	elseif($_GET["error"] == "invaliduid"){
		$message = "<p>Choose a proper username</p>";
	}
	elseif($_GET["error"] == "invalidemail"){
		$message = "<p>Choose a proper email</p>";
	}
	elseif($_GET["error"] == "usernametaken"){
		$message = "User-email already taken!</p>";
	}
	elseif($_GET["error"] == "stmtfailed"){
		$message = "<p>Something went wrong, tryagain later</p>";
	}
	elseif($_GET["error"] == "Failedtosend"){
		$message = "<p>OtpNotSend, Please check your email id</p>";
	}
	elseif($_GET["error"] == "accessDenied"){
		$message = "<p>Wrong way, AccessDenied</p>";
	}
}
?>
<div class="content-body">
		<div class="form-wrapper">
			<form action="includes/register.inc.php" method="post" class="bg-white">
				<h1 class="text-title">Please Register</h1>
                <div class="field-group">
					<label class="label" for="txt-username">Username</label>
					<input class="input" type="text" id="txt-username" name="name" placeholder="Enter UserName" />
				</div>
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

