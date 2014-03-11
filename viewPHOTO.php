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
			<?php
				$pID = $_REQUEST['pID'];
				$proj3 = new mysqli('localhost', 'sreyem92', 'a1l2e3x4', 'info230_SP13_sreyem92');
				$query = "SELECT aID FROM picTOalbum WHERE pID = " . $pID;
				$result1 = mysqli_query($proj3, $query);
				$q = mysqli_fetch_assoc($result1);
				$aID = $q['aID'];
			?>
			<div class = "breadcrumbs" id = "viewalbum">
				<div class = "navi">
					<h2 class = "headline" ><a href = "login.php">Login</a>  >  <a href = "index.php">Albums Home</a>  >  <a href = "view.php?aID=<?php echo $aID;?>">View Album</a>  >  View Photo </h2>
				</div><!--end navi-->
				<div class = "search">
					<h2>
						<form action="search.php" class = "headline" method = "post">
						  Search Photos: <input type="search" name="photosearch">
						  <input type="submit" name = "search">
						  <a href = "login.php">Log Out</a>
						</form>
					</h2>
				</div>
			</div><!--breadcrumbs-->
			
			<div class = "main">
				<?php
						if(isset($_POST['submit'])){
							$caption = $_POST['photocaption'];
							$month = $_POST['month'];
							$day = $_POST['day'];
							$year = $_POST['year'];
							$date = "$year-$month-$day";
						
							$updatePIC = "UPDATE Pictures SET caption= '" .$caption . "', date='" . $date . "' WHERE pID = '" . $pID . "'";
							
							$resultUPDATE = mysqli_query($proj3, $updatePIC);
							
							if(!$resultUPDATE){
								print("<p>There was an error updating the photo information. Please try again.</p>");
							} else {
								$dateTODAY = date("Y-m-d");
								$queryUPDATEALBUM = "UPDATE Albums SET dateMODIFIED = '" . $dateTODAY . "' WHERE aID = '" . $aID . "'";
								$resultALBUM = mysqli_query($proj3, $queryUPDATEALBUM);
								if(!$resultALBUM){
									print("Album Modified Date could not update.");
								}
								print("<p>Photo Update successful!</p>");
							}
							if ($proj3->errno) {
								echo $proj3->error;
							}
							
							
							if ($proj3->errno) {
								echo $proj3->error;
							}
						}//end if submit
						
						if(isset($_POST['copy'])){
							$query4 = "INSERT INTO picTOalbum (pID, aID) VALUES ('" . $pID . "', '" . $_POST['otheralbum'] . "')";
							$result4 = mysqli_query($proj3, $query4);
							
							if(!$result4){
								print("<p>There was an error inserting the album ID and picture ID into picTOalbum. Please try again.</p>");
							} else {
								$dateTODAY = date("Y-m-d");
								$queryUPDATEALBUM = "UPDATE Albums SET dateMODIFIED = '" . $dateTODAY . "' WHERE aID = '" . $aID . "'";
								$resultALBUM = mysqli_query($proj3, $queryUPDATEALBUM);
								if(!$resultALBUM){
									print("Album Modified Date could not update.");
								}
								print("<p>Copy photo successful!</p>");
							}
							
							if ($proj3->errno) {
								echo $proj3->error;
							}
						
						}//if copy	
						
						$query1 = "SELECT caption, date FROM Pictures WHERE pID = " . $pID;
						$result1 = mysqli_query($proj3, $query1);
						$q = mysqli_fetch_array($result1);
						
						
						
						print("<h1>$q[caption]</h1>				
						<h2>Date Taken: $q[date]</h2>");
						
						
							
						$query = "SELECT caption, url, pID FROM Pictures NATURAL JOIN Albums NATURAL JOIN picTOalbum WHERE pID = " . $pID;
						
						$result = mysqli_query($proj3, $query);
						
						$p = mysqli_fetch_assoc($result);

						$url = $p['url'];
						$caption = $p['caption'];
						$pID = $p['pID'];	
						
						print("<img src = " . $url . " id = ". $pID . "class = \"fullPHOTO\" alt = " . $caption . "/></a>");
						
						$query2 = "SELECT * FROM `Albums` WHERE aID <> ". $aID;
						$result2 = mysqli_query($proj3, $query2);
						
						
					
		if(isset($_SESSION['admin'])){			
			if($_SESSION['admin']){	
				print("<form action=\"viewPHOTO.php?pID=$pID\" method=\"post\">
					<fieldset class = 'addPHOTO'>
					<legend>Copy Photo</legend>
					<p>If you would like this photo to be available in another album, please select it from the dropdown menu and click \"Copy\".</p>
					<span class = 'albumMOVE' >Albums: </span><select name=\"otheralbum\">");
					
						while ($r = mysqli_fetch_assoc($result2)){
							$newaID = $r['aID'];
							$newTITLE = $r['title'];
							print("<option value=" . $newaID . ">" . $newTITLE);
						}//end while
					
					print("</select>
					<input type=\"submit\" name = \"copy\" value=\"Copy\" />
					</fieldset>
					
					
					<fieldset class = 'addPHOTO'>
					<legend>Fill in the form below if you would like to modify photo information.</legend>
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
						<input type=\"submit\" name = \"submit\" value=\"Update\" />
						</fieldset>
				</form>");
				
					}//end if Session admin
		}//end if SESSION admin isset
		?>
			<form action="view.php?aID=<?php echo $aID;?>"" method="post">
				<fieldset class = 'addPHOTO'>
				<input type="submit" name = "delete" value="Click to Delete the Photo" />
				<input type = "hidden" name = "albumID" value = "<?php echo $aID;?>" />
				<input type = "hidden" name = "pictureID" value = "<?php echo $pID;?>" />
				</fieldset>
			</form>	
			</div><!--end main-->
		</div><!--end contain-->
	</body>
	
	
	
</html>

<?php
}//end if login
?>