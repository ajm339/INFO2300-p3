<?php
session_start();
$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92'); 

if((!isset($_POST['guest'])) &&  (!isset($_POST['admin'])) && (!isset($_SESSION['login']))){
	print("<p>You must log in before viewing this page.  Go to the <a href=\"login.php\">login page.</a></p>");
	$_SESSION['login'] = false;
	$_SESSION['admin'] = false;
}else if(isset($_SESSION['admin'])&&isset($_SESSION['login'])){
		if(($_SESSION['admin'])&&($_SESSION['login'])){
			$_SESSION['login']=true;
			$_SESSION['admin']=true;
		} else{
			$_SESSION['login']=true;
			$_SESSION['admin']=false;
		}//end else
} else {
	
	if(isset($_POST['admin'])){
	
		if(!isset($_POST['username']) || !isset($_POST['password'])){
			print("<p>Either the username or password is empty. Try again. </p>");
			$_SESSION['admin'] = false;
			$_SESSION['login'] = false;
		} else{
			if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $_POST["username"])){
				$_POST["username"] = "Nope";
			}
			if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $_POST["password"])){ 
				$_POST["password"] = "Nope";
			}
						
			$query5 = "SELECT username, password FROM Login";
							
			$result5 = mysqli_query($proj3, $query5);
			
			$numRows = mysqli_num_rows($result5);
			if($numRows != 1){ 
				print("Error: Only one admin.");
			}else{
				$array = mysqli_fetch_assoc($result5);
				$password = $array['password'];
				$username = $array['username'];
			}
			
			if( $_POST["username"] != $username || $_POST["password"] != $password){
				print("Wrong username or password. Please try again at the <a href=\"login.php\">login page</a>");
				$_SESSION['login'] = false;
				$_SESSION['admin'] = false;
			}else{
				$_SESSION['admin'] = true;
				$_SESSION['login'] = true;
			}
		}
	} else {
		$_SESSION['login'] = true;
		$_SESSION['admin'] = false;
	}
}

if(!isset($_SESSION['login'])){
	print("<p>You must log in before viewing this page.  Go to the <a href=\"login.php\">login page.</a></p>");
}
else{

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
					<h2><a href = "login.php">Login</a>  >  Albums Home</a> </h2>
				</div><!--end navi-->
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
					$query1 = "SELECT title, aID FROM Albums GROUP BY aID";
					$result1 = mysqli_query($proj3, $query1);
					
					print("<h1>Albums Home</h1>
					<h2>Click the thumbnail to view the album</h2>");
					
						if($_SESSION['admin']){		
							if($_SESSION['admin']){
							print("<div class= 'addALBUMbutton'>");
								print("<form action = \"addALBUM.php\" method=\"post\">	
									<input type = \"submit\" class = \"buttonguest\" value = \"Click to Add an Album\" />
								</form>");
							print("</div><!--end addalbumbutton-->");
							}//end if SESSION admin true
						}//end if SESSION admin isset
				?>
				<div class = "albumsCONTAIN">
				<?php
				
				if($_SESSION['login']){ //Allow user to see content
				
					while ($p = mysqli_fetch_assoc($result1)){
						$aID = $p['aID'];
						$title = $p['title'];
						?>
						<div class = "albumsHOME">
							<div class = "icon">
						<?php
							print("<a href = \"view.php?aID=" . $aID . "\"><img src = pictures/orange_folder.png alt = $title width = '200' height = '200'/></a>");
							
							if($_SESSION['admin']){		
								if($_SESSION['admin']){
									print("<form action = \"modifyALBUM.php?aID=" . $aID . "\" method=\"post\">	
									<input type = \"submit\" class = 'modify' value = \"Click to Modify the Album\" />
								</form>");
								}//end if SESSION admin true
							}//end if SESSION admin isset
						?>
							</div><!--end icon-->
							<div class = "iconTITLE">
						<?php
							print("<p>$title</p>");	
						?>
							</div><!--end iconTITLE-->
						</div><!--end albumsHOME-->
						<?php
					}//end while

					if ($proj3->errno) {
						echo $proj3->error;
					}
				}//end if SESSION login
				?>
				</div><!--end albumsCONTAIN-->
			</div><!--end main-->
		</div><!--end contain-->
	</body>
</html>
<?php
}//end if login
?>