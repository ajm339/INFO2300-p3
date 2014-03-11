<?php
session_start();

if(!isset($_SESSION['login'])){
	print("<p>You must log in before viewing this page.  Go to the <a href=\"login.php\">login page.</a></p>");
}
else{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>View Album</title>
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
					<h2><a href = "login.php">Login</a>  >  <a href = "index.php">Albums Home</a>   >  View Album</h2>
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
							
					$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92');  	
					
					$aID = $_REQUEST['aID'];
					$_SESSION['aID'] = $aID;
					
					if(isset($_POST['delete'])){
						$aIDdelete = $_POST['albumID'];
						$pIDdelete = $_POST['pictureID'];
						$queryDELETE = "DELETE FROM picTOalbum WHERE aID='" . $aIDdelete . "' AND pID='" . $pIDdelete . "'";
						$resultDELETE = mysqli_query($proj3, $queryDELETE);
						
						if(!$resultDELETE){
							print("<p>There was an error while trying to delete the picture.  Please try again.</p>");
						} else {
							print("<p>The picture deletion was successful.</p>");
						}
						if ($proj3->errno) {
							echo $proj3->error;
						}	
					}//end delete 
					
					if (isset($_POST['submit'])) {
						if ($_FILES['newpic']['error'] == 0) {
							$temp = $_FILES['newpic']['tmp_name'];
							$newloc = "pictures/" . $_FILES['newpic']['name'];
							move_uploaded_file($temp, $newloc);
							
							$url = $newloc;
							$caption = $_POST['photocaption'];
							
							if(preg_match("/^[A-Za-z0-9\" \"]{1,40}$/", $caption)){
								if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $caption)){
									print("Captions must only contain letters and numbers.");
								}
							}
							
							$month = $_POST['month'];
							$day = $_POST['day'];
							$year = $_POST['year'];
							$date = "$year-$month-$day";
							
							
							
							$query1 = "INSERT INTO Pictures (`caption`, `url`, `date`) VALUES ('" . $caption . "', '" . $url. "', '" . $date . "')";
							$result1 = mysqli_query($proj3, $query1);
					
							if(!$result1){
								print("<p>There was an error processing your picture request. Please try again.</p>");
							}
							
							if ($proj3->errno) {
								echo $proj3->error;
							}

							$query3 = "SELECT MAX(pID) FROM Pictures";
							$result3 = mysqli_query($proj3, $query3);
							
							$numRows = mysqli_num_rows($result3);
							if($numRows != 1){ 
								print("<p>There was an error processing the picture ID. Please try again.</p>");
							}
						
							if ($proj3->errno) {
								echo $proj3->error;
							}
							
							$array = mysqli_fetch_array($result3);
							$newpID = $array[0];
				
							$query4 = "INSERT INTO picTOalbum (pID, aID) VALUES ('" . $newpID . "', '" . $aID . "')";
							$result4 = mysqli_query($proj3, $query4);
							
							if(!$result4){
								print("<p>There was an error inserting the album ID and picture ID into picTOalbum. Please try again.</p>");
							}
							
							if ($proj3->errno) {
								echo $proj3->error;
							}
							
							print("<p>The file ".$_FILES['newpic']['name']." was uploaded successfully.</p>\n");
							
						} else {
						print("The file ".$_FILES['newphoto']['name']." was not
						uploaded.\n");
						}
					}
				
			
					$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92'); 
					$query1 = "SELECT title, dateCREATED, dateMODIFIED FROM Albums WHERE aID = " . $aID;
					$result1 = mysqli_query($proj3, $query1);
					$q = mysqli_fetch_array($result1);
					
					$queryDATE = date("y-m-d");
					
							
					print("<h1>$q[title]</h1>				
					<h2>Date Created: $q[dateCREATED]</h2>
					<h2>Date Modified: $q[dateMODIFIED]</h2>
					<h2>Click the thumbnail to view the album</h2>");
					
					$query = "SELECT caption, url, pID, dateCREATED, dateMODIFIED FROM Pictures NATURAL JOIN Albums NATURAL JOIN picTOalbum WHERE aID = " . $aID;
					
					$result = mysqli_query($proj3, $query);
					
					if(mysqli_num_rows($result)==0){
						print("<p>This album has no photos.</p>");
					}else{
						while ($p = mysqli_fetch_assoc($result)){
							$url = $p['url'];
							$caption = $p['caption'];
							$pID = $p['pID'];	
							
							print("<a href = \"viewPHOTO.php?pID=" . $pID . "\" class = \"thumbnail2\" id = ". $pID . " ><img src = " . $url . " class = \"thumb2\" alt = " . $caption . "/></a>");
							
							
						}//end while
					}//end else
					
					if ($proj3->errno) {
						echo $proj3->error;
					}
				
			if(isset($_SESSION['admin'])){	
				if($_SESSION['admin']){
					print("<form action=\"view.php?aID=$aID\" method=\"post\" enctype=\"multipart/form-data\">	
						<fieldset class = 'addPHOTO'>
						<legend>Add a photo to this album.</legend>
						Photo: <input type=\"file\" name=\"newpic\" accept='image/*'/>
						Photo Caption: <input type = \"text\" name = \"photocaption\" />
						Date Taken: <select name=\"month\">
										<option value=\"01\">January
										<option value=\"02\">February
										<option value=\"03\">March
										<option value=\"04\">April
										<option value=\"05\">May
										<option value=\"06\">June
										<option value=\"07\">July
										<option value=\"08\">August
										<option value=\"09\">September
										<option value=\"10\">October
										<option value=\"11\">November
										<option value=\"12\">December
									</select>
									<select name=\"day\">
										<option value=\"01\">1
										<option value=\"02\">2
										<option value=\"03\">3
										<option value=\"04\">4
										<option value=\"05\">5
										<option value=\"06\">6
										<option value=\"07\">7
										<option value=\"08\">8
										<option value=\"09\">9
										<option value=\"10\">10
										<option value=\"11\">11
										<option value=\"12\">12
										<option value=\"13\">13
										<option value=\"14\">14
										<option value=\"15\">15
										<option value=\"16\">16
										<option value=\"17\">17
										<option value=\"18\">18
										<option value=\"19\">19
										<option value=\"20\">20
										<option value=\"21\">21
										<option value=\"22\">22
										<option value=\"23\">23
										<option value=\"24\">24
										<option value=\"25\">25
										<option value=\"26\">26
										<option value=\"27\">27
										<option value=\"28\">28
										<option value=\"29\">29
										<option value=\"30\">30
										<option value=\"31\">31
									</select>
									<select name=\"year\">");
								
									$today = getdate();
									$yearTODAY = $today['year'];
									for($i=$yearTODAY; $i>=1960; $i--){
										print("<option value=\"$i\">$i");
									}
								print("</select>
							<input type=\"submit\" name = \"submit\" value=\"Submit\" />
							</fieldset>
					</form>");
				}//end if SESSION admin true
			}//end if SESSION admin isset
			?>
			
			</div><!--end main-->
		</div><!--end contain-->
	</body>
</html>
<?php
}//end if login
?>