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
					<h2><a href = "index.php">Albums Home</a></h2>
				</div>
					<div class = "search">
					<h2>
						<form action="search.php" class = "headline" method = "post">
						  Search Photos: <input type="search" name="photosearch">
						  <input type="submit">
						  <a href = "login.php">Log Out</a>
						</form>
					</h2>
					 </div>
				
				
			</div><!--breadcrumbs-->
			
			<div class = "main">
				<?php						
						if (!isset($_POST["photosearch"])) {
							print("<h1>error: The search was never submitted</h1>");
						}
						else{
						
							$input = $_POST["photosearch"];
							
							if(!preg_match("/^[A-Za-z0-9\" \"]{1,40}$/", $input)){ 
								$_POST["photosearch"] = "NoMatch";
							}
							
							$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92');
							$query1 = $query = "SELECT * FROM Pictures NATURAL JOIN Albums NATURAL JOIN picTOalbum WHERE caption LIKE '%" . $input . "%'";
							$result1 = mysqli_query($proj3, $query1);
							
							$numRows = mysqli_num_rows($result1);
							if($numRows== 0){ 
								print("<p>No Results Found.</p>");
							}
							
							while ($p = mysqli_fetch_assoc($result1)){
								$url = $p['url'];
								$caption = $p['caption'];
								$pID = $p['pID'];	
								
								print("<a href = \"viewPHOTO.php?pID=" . $pID . "\" class = \"thumbnail2\" id = ". $pID . " ><img src = " . $url . " class = \"thumb2\" alt = " . $caption . "/></a>");
							
							
							}//end while
						}
				?>
				
			</div><!--end main-->
		</div><!--end contain-->
	</body>
	
	
	
</html>