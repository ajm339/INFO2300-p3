<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Modify Album</title>
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
					<h2><a href = "login.php">Login</a>  > <a href = "index.php">Albums Home</a>   >  Modify Album</h2>
				</div><!--end navi-->
				
				<div class = "search">
					<h2><a href = "login.php">Log Out</a></h2>
				</div>
				
			</div><!--breadcrumbs-->
			
			<div class = "main">
				
				<h1>Modify Album</h1>
				<h2>Fill out the form to modify the album content.</h2>
				
					<?php
					$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92');  	

					if ($proj3->errno) {
						echo $proj3->error;
					}
					
					$aID = $_REQUEST['aID'];
					
					
					if(isset($_POST['change'])){
						
						$title = $_POST['changetitle'];
						if(preg_match("/^[A-Za-z0-9\" \"]{1,40}$/", $title)){
							if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $title)){
								print("Album must only contain letters and numbers.");
							}
						} 
						$dateTODAY = date("Y-m-d");
						
						
						$query = "UPDATE Albums SET title ='" . $title . "', dateMODIFIED ='" . $dateTODAY ."' WHERE aID ='" . $aID . "'";
					
					
						$result = mysqli_query($proj3, $query);
						
						if($result){
							print("<p>The album was modified successfully.</p>");
						}
						if(!$result){
							print("<p>There was an error processing your album request. Please try again.</p>");
						}
						
					}
					
					if(isset($_POST['delete'])){
						$aIDdelete = $_POST['albumID'];
						$queryDELETE = "DELETE FROM Albums WHERE aID='" . $aIDdelete . "'";
						$resultDELETE = mysqli_query($proj3, $queryDELETE);
						
						if(!$resultDELETE){
							print("<p>There was an error while trying to delete the album.  Please try again.</p>");
						} else {
							print("<p>The album deletion was successful.</p>");
						}
						if ($proj3->errno) {
							echo $proj3->error;
						}	
					}//end delete
				
				?>
				
				<form action="modifyALBUM.php?aID=<?php echo $aID;?>" method="post">
			
					<fieldset class = 'addPHOTO'>
					Album Title: <input type="text" name="changetitle" />
					<input type="submit" name = "change" value="Change" />
					</fieldset>
				</form>
				<form action="modifyALBUM.php?aID=<?php echo $aID;?>" method="post">
					<fieldset class = 'addPHOTO'>
					<input type="submit" name = "delete" value="Click to Delete the Album" />
					<input type = "hidden" name = "albumID" value = "<?php echo $aID;?>" />
					</fieldset>
				</form>
		
				
			
			</div><!--end main-->
		</div><!--end contain-->
	</body>
	
	
	
</html>