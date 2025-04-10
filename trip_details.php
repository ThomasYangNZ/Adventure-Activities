<?php 
	session_start();

	// If there is no GET submit bounce back to index 
	if(!isset($_GET['trip_id'])) {
		$_SESSION['Error'] = "Please select a valid trip!";
		header("Location: index.php");
		exit();
	}
	// connect to the database via public connection (note use the lowest privilege connection where possible)
	include("includes/publicconnection.php");

	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Trip Details";
	$description = "This is the trip details of a specific trip that the Adventure Kayak service is running now! We run services all around New Zealand!";
	$img = "trip-details-background";

	// create a require statement for head.php
	require("includes/head.php"); 



	// santize input
	$trip_id = trim($_GET['trip_id']);


	// create a more secure prepared statement
	$trip_detail_query = "SELECT `TripId`, `TripName`, `Days`, `MaxPeople`, `Price`, `Difficulty`, `Date`, `UserFirstName`, `UserLastName`, `UserEmail`
					FROM `trips`, `TripTypes`, `difficulties`, `Users`
					WHERE `trips`.`TripTypeId`=`triptypes`.`TripTypeId`
					AND `triptypes`.`DifficultyId`=`difficulties`.`DifficultyId`
					AND `trips`.`UserId`=`users`.`UserId`
					AND `trips`.`TripId`= ?" ;

	$trip_detail_stmt = mysqli_prepare($dbc, $trip_detail_query);
	mysqli_stmt_bind_param($trip_detail_stmt, "i", $trip_id);
	mysqli_stmt_execute($trip_detail_stmt);

	$trip_detail_result = mysqli_stmt_get_result($trip_detail_stmt);
	
	// Check if there was any results present in query
	$num_rows = mysqli_num_rows($trip_detail_result);
	if($num_rows == 0){
		echo "<div class='error'><p>Error! No results were found</p></div>";
		exit;
	}
?>
<!-- div class content starts here -->
<div class="content">
	<!-- table starts here -->
	<table>
		<!-- create a while loop to create the table columns -->
		<?php while($results_rows=mysqli_fetch_assoc($trip_detail_result)) {?>
		<tr class="trips">
			<td><?php echo $results_rows['TripName']; ?></td>
			<td><?php echo $results_rows['Days']." Days"; ?></td>
			<td><?php echo $results_rows['MaxPeople']; ?></td>
			<td><?php echo "$".number_format($results_rows['Price']); ?></td>
			<td><?php echo $results_rows['Difficulty']; ?></td>
			<td><?php echo $results_rows['Date']; ?></td>
		</tr>
	</table>
	<!-- table ends here -->
<?php
		// If user is logged in, give them additional options
		if(isset($_SESSION['UserType'])) {
			echo "<form name='view_members' method='get' action='trip_members.php'>
					<input type='hidden' name='trip_detail_id' value='".$results_rows['TripId']."'>
					<input type='submit' name='submit' value='View Enrolled Members'>
				</form>
				<form name='join_trip' method='post' action='process_edits.php'>
					<input type='hidden' name='trip_id' value='".$results_rows['TripId']."'>
					<input type='submit' name='submit' value='Join Now!'>
				</form>";
			// If user is logged in and is admin or trip leader, give them more options
			if($_SESSION['UserType'] == "Admin" || $_SESSION['UserType'] == "Trip Leader") {
				echo "<form name='edit_trip' method='get' action='trip_edit.php'>
						<input type='hidden' name='trip_edit_id' value='".$results_rows['TripId']."'>
						<input type='submit' name='submit' value='Edit Trip Details'>
					  </form>";
			}
		} 
	}
?>
</div>
<!-- div class content ends here -->
<?php
	// Close sql
	mysqli_stmt_close($trip_detail_stmt);
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>