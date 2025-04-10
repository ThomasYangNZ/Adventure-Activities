<?php 
	session_start();

	// If there is no GET submit bounce back to index 
	if(!isset($_GET['trip_detail_id'])) {
		$_SESSION['Error'] = "Please select a valid trip!";
		header("Location: index.php");
		exit();
	// Check if the user is logged in
	} elseif(!isset($_SESSION['UserType'])) {
		header("Location: index.php");
		$_SESSION['Error'] = "Error! Login to view this page";
		exit();
	} 

	// connect to the database via public connection
	include("includes/publicconnection.php");
		
	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Trip Members";
	$description = "This is page of registered members of an upcoming kayaking trip ran by yakity yaks! We have services all over New Zealand!";
	$img = "trip-members-background";

	// create a require statement for head.php
	require("includes/head.php"); 
	

	// Santize user input
	$trip_detail_id = trim($_GET['trip_detail_id']);
		
	// Created a more prepared SQL Statement
	$trip_member_query = "SELECT `MemberTripId`, `MemberFirstName`, `MemberLastName`, `MemberEmail`, `MemberTrips`.`TripId`, `TripTypeId`, `UserId`, `Date` 
	FROM `MemberTrips`, `Trips` 
	WHERE `Trips`.`TripId`=`MemberTrips`.`TripId` 
	AND `MemberTrips`.`TripId`= ?";

	$trip_member_stmt = mysqli_prepare($dbc, $trip_member_query);
	mysqli_stmt_bind_param($trip_member_stmt, "i", $trip_detail_id);
	mysqli_stmt_execute($trip_member_stmt);

	$trip_member_result = mysqli_stmt_get_result($trip_member_stmt);
	// Check if the SQL statement has any results
	$num_rows = mysqli_num_rows($trip_member_result);
	if($num_rows == 0){
		echo "<p class='error'>No one has signed up to this trip yet!</p>";
		exit;
	}


?>
<!-- div class content starts here -->
<div class="content">
		<!-- table starts here -->
		<table>
		<?php while($results_rows=mysqli_fetch_assoc($trip_member_result)) {?>
		<tr class="members">
			<td><?php echo $results_rows['MemberFirstName']; ?></td>
			<td><?php echo $results_rows['MemberLastName']; ?></td>
			<td><?php echo $results_rows['MemberEmail']; ?></td>
		</tr>
		<?php } ?>
	</table>
	<!-- table ends here -->
</div>
<!-- div class content ends here -->
<?php
	// Close sql
	mysqli_stmt_close($trip_member_stmt);
	// require the footer file to display on all webpages
	require("includes/footer.php");
?>