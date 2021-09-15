<?php
session_start();
if(isset($_SESSION["email"]))   //check the session is set with register user if not redirect to index pages 
{
	session_unset();            // function frees all session variables currently registered
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<link
			href="https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap"
			rel="stylesheet"
		/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="../css/main.css" />
		<script language="javascript" type="text/javascript">
	window.history.forward();
    </script>
		<title>Landing Page</title>
	</head>
	<body>
		<header>
			<div class="logo-container">
				<img src="../images/img/logo.svg" alt="logo" />
				<h4 class="logo">XKCD-Comics</h4>
			</div>
		</header>

		<main>
			<section class="presentation">
				<div class="introduction">
					<div class="intro-text">
						<h1>XKCD-Comics</h1>
						<h3>
							Thank You
					        Your subscription has been confirmed. You've been added to our list and You will get comics mail every 5 minutes.
						</h3>
						<p>
							xkcd, sometimes styled XKCD, is a webcomic created in 2005 by American author Randall Munroe. The comic's tagline describes it as "a webcomic of romance, sarcasm, math, and language". Munroe states on the comic's website that the name of the comic is not an initialism but "just a word with no phonetic pronunciation".
						</p>
					</div>
					
				</div>
				<div class="cover">
					<img src="../images/img/xkcdLogo_transparent.jpg" alt="XkcdLogo" />
				</div>
			</section>

			<div class="comics-select">
				<img src="../images/img/arrow-left.svg" alt="" />
				<img src="../images/img/dot.svg" alt="" />
				<img src="../images/img/dot-full.svg" alt="" />
				<img src="../images/img/dot-full.svg" alt="" />
				<img src="../images/img/arrow-right.svg" alt="" />
			</div>

			<img class="big-circle" src="../images/img/big-eclipse.svg" alt="" />
			<img class="medium-circle" src="../images/img/mid-eclipse.svg" alt="" />
			<img class="small-circle" src="../images/img/small-eclipse.svg" alt="" />
		</main>
	</body>
</html>
<?php
}
else
{
	session_destroy();                            // destroys all of the data associated with the current session.
header("Location:index.php?error=accessDenied");

}
?>


