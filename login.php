<?php
session_start();
if(isset($_SESSION['login'])||isset($_SESSION['admin'])){
	unset($_SESSION['login']);
	unset($_SESSION['admin']);
	session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login</title>
		<link rel = "stylesheet" type="text/css" href = "styles/style.css" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />
	<!--	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="scripts/script.js"></script>
		<link rel="shortcut icon" href="photos/favicon.ico" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />  -->
	</head>
	
	<body>
		<div class = "contain">
			<div class = "breadcrumbs" id = "login">
				<div class = "navi">
					<h2>Login</h2>
				</div><!--end navi-->
			</div><!--breadcrumbs-->
			
			<div class = "main">
				<h1>Login Page</h1>
			
				<form action = "index.php" method="post">
					<label class = "login">Username:</label>
					<input type = 'text' name = 'username' />
					<label class = "login">Password:</label>
					<input type = 'password' name = 'password' />
					<input type = 'submit' name = 'admin' class = "button" value = "Click to Log In" /><br />
					<input type = 'submit' name = 'guest' class = "buttonguest" value = "Click to View as Guest" />
				</form>
			</div><!--end main-->
			
		</div><!--end contain-->

	</body>
	
	
	
</html>