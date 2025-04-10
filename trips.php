<?php 
	session_start();

	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Trips";
	$description = "This is the trips page of the Adventure Kayak service, we display all of our current planned trips to travel places all around New Zealand!";
	$img = "trips-background";

	// create a require statement for head.php
	require("includes/head.php"); 

	// connect to the database via public connection
	include("includes/publicconnection.php");

	// prepare an SQL statement
	$trip_query = "SELECT `TripId`, `TripName`, `Days`, `MaxPeople`, `Price`, `Difficulty`, `Date`
				   FROM `trips`, `triptypes`, `difficulties`
				   WHERE `trips`.`TripTypeId`=`triptypes`.`TripTypeId`
				   AND `triptypes`.`DifficultyId`=`difficulties`.`DifficultyId`
				   ORDER BY `TripName` ASC";
	
	$trip_result = mysqli_query($dbc, $trip_query);
?>
<!-- div class content starts here -->
<div class="content">
	<!-- all-trips div starts here -->
	<div id="all-trips">
		<!-- table starts here -->
			<table>
				<!-- thead starts here -->
				<thead>
					<tr>
						<th colspan="7">Avaliable Trips!</th>
					</tr>
				</thead>
				<!-- thead ends here -->
					<tr>
						<!-- table heads starts here -->
						<td>LOCATION</td>
						<td>DURATION</td>
						<td>MAXIMUM PEOPLE</td>
						<td>PRICE</td>
						<td>DIFFICULTY</td>
						<td>DATE</td>
						<td></td>
						<!-- table heads ends here -->
					</tr>
				<!-- php while loops starts here -->
				<?php while($results_row=mysqli_fetch_assoc($trip_result)) {?>
				<tr class="trips">
					<!-- form starts here -->
					
						<td><?php echo $results_row['TripName']; ?></td>
						<td><?php echo $results_row['Days']." Days"; ?></td>
						<td><?php echo $results_row['MaxPeople']; ?></td>
						<td><?php echo "$".number_format($results_row['Price']); ?></td>
						<td><?php echo $results_row['Difficulty']; ?></td>
						<td><?php echo $results_row['Date']; ?></td>
						<td><form name="details" method="get" action="trip_details.php"><input type="hidden" value="<?php echo $results_row['TripId']; ?>" name="trip_id"><input type="submit" name="submit" value="View Details"></form></td>
			            <?php
				            // If the user is logged in as admin or trip leader, provide a delete trip option
				            if (isset($_SESSION['UserType'])) {
				                if ($_SESSION['UserType'] == "Admin" || $_SESSION['UserType'] == "Trip Leader") {
				                    echo '<td>
				                            <form name="delete_trip" method="post" action="process_edits.php">
				                                <input type="hidden" value="' . $results_row['TripId'] . '" name="trip_id">
				                                <input type="submit" name="submit" value="Delete Trip">
				                            </form>
				                          </td>';
				                }
				            }
			            ?>
					<!-- form ends here -->
				</tr>
				<?php } ?>
		</table>
		<!-- table ends here -->
	<?php
		// If the user is logged in as admin or trip leader provide them with add trip option
		if(isset($_SESSION['UserType'])) {
			if($_SESSION['UserType'] == "Admin" || $_SESSION['UserType'] == "Trip Leader") {
				echo '<a href="trip_add.php">Add A Trip</a>';
			}
		} 
	?>
	</div>
<!-- div class content ends here -->
</div>
<?php
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>