<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Index</title>
		<link rel = "stylesheet" type="text/css" href = "styles/style.css" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />
	<!--	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="scripts/script.js"></script>
		<link rel="shortcut icon" href="photos/favicon.ico" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />  -->
	</head>
	
	<body>
		<div class = "contain">
			<div class = "breadcrumbs" id = "viewalbum">
				<div class = "navi">
					<h2><a href = "login.php">Login</a>  > <a href = "index.php">Albums Home</a>   >  Add Album </h2>
				</div><!--end navi-->
				
				<div class = "search">
					<h2><a href = "login.php">Log Out</a></h2>
				</div>
				
			</div><!--breadcrumbs-->
			
			<div class = "main">
				
				<h1>Add Albums</h1>
				<h2>Fill out the form to create a new album</h2>
				
					<?php
					$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92');  	

					if ($proj3->errno) {
						echo $proj3->error;
					}
					
					if(isset($_POST['submit'])){
		
						$title = $_POST['addalbum'];
						if(preg_match("/^[A-Za-z0-9\" \"]{1,40}$/", $title)){
							if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $title)){
								print("Album must only contain letters and numbers.");
							}
						} 

						$query = "INSERT INTO Albums (title, dateCREATED, dateMODIFIED) VALUES ('" . $title . "', '" . date("Y-m-d") . "', '" . date("Y-m-d") ."')";
					
						$result = mysqli_query($proj3, $query);
						
						if($result){
							print("<p>The album was added successfully.</p>");
						}
						if(!$result){
							print("There was an error processing your album request. Please try again.");
						}
					
				}
				
				?>
			
				
				<form action="addALBUM.php" method="post">
					<fieldset class = 'addPHOTO'>
					Album Title: <input type="text" name="addalbum" />
					<input type="submit" name = "submit" value="Submit" />
					</fieldset>
				</form>
		
				
			
			</div><!--end main-->
		</div><!--end contain-->
	</body>
	
	
	
</html>