<?php 
	session_start();

	// Check if a valid trip id has been submitted 
	if(!isset($_GET['trip_edit_id'])) {
		$_SESSION['Error'] = "Please select a valid trip!";
		header("Location: index.php");
		exit();
	// Check that the user is either admin or trip leader
	} elseif($_SESSION['UserType'] != "Admin" && $_SESSION['UserType'] != "Trip Leader") {
		$_SESSION['Error'] = "You are unauthorized to view this page!";
		header("Location: index.php");
		exit();
	}
	// connect to the database via public connection
	include("includes/publicconnection.php");

	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Trip Edits";
	$description = "This is the page for editing trip details of a specific trip that the Adventure Kayak service is running now! We run services all around New Zealand!";
	$img = "edit-background";

	// create a require statement for head.php
	require("includes/head.php"); 

	// santize input
	$trip_id = trim($_GET['trip_edit_id']);


	// create a more secure prepared statement
	$trip_detail_query = "SELECT `TripId`, `TripName`, `Days`, `MaxPeople`, `Price`, `Difficulty`, `Date`, `UserFirstName`, `UserLastName`, `UserEmail`, `trips`.`UserId`, `trips`.`TripTypeId`
		FROM `trips`
		JOIN `triptypes` ON `trips`.`TripTypeId`=`triptypes`.`TripTypeId`
		JOIN `difficulties` ON `triptypes`.`DifficultyId`=`difficulties`.`DifficultyId`
		JOIN `users` ON `trips`.`UserId`=`users`.`UserId`
		WHERE `TripId`=?";
	$trip_detail_stmt = mysqli_prepare($dbc, $trip_detail_query);
	mysqli_stmt_bind_param($trip_detail_stmt, "i", $trip_id);
	mysqli_stmt_execute($trip_detail_stmt);
	$trip_detail_result = mysqli_stmt_get_result($trip_detail_stmt);
	// Save results
	$current_trip_data = mysqli_fetch_assoc($trip_detail_result);

	// Create a sql statement to gather all results from all possible trip difficulties
	$difficulty_query = "SELECT `Difficulty`, `DifficultyId` FROM `difficulties`";
	$difficulty_results = mysqli_query($dbc, $difficulty_query);


	// Create a sql statement to gather all results that have trip leader or admin
	$leader_query = "SELECT `UserFirstName`, `UserLastName`, `users`.`PermissionId`, `UserId`
					FROM `users`, `permissions`
					WHERE `users`.`PermissionId`=`permissions`.`PermissionId`
					AND (`users`.`PermissionId`=1
     				OR `users`.`PermissionId`=3)";
	
	$leader_results = mysqli_query($dbc, $leader_query);

	// Check that there are results from the statement
	$num_rows = mysqli_num_rows($trip_detail_result);
	$leader_rows = mysqli_num_rows($leader_results);
	if($num_rows == 0 || $leader_rows == 0){
		echo "<div class='error'><p>Error! No results were found</p></div>";
		exit;
	}



	// Create a sql statement to gather all information about all triptypes
	$triptype_query = "SELECT `TripTypeId`, `TripName`, `Days`, `MaxPeople`, `Price`, `Difficulty`
						FROM `triptypes`, `difficulties`
						WHERE `triptypes`.`DifficultyId`=`difficulties`.`DifficultyId`";

	$triptype_results = mysqli_query($dbc, $triptype_query);

	// Check that there are results from the statement
	$num_rows_triptype = mysqli_num_rows($triptype_results);
	if($num_rows_triptype == 0){
		echo "<div class='error'><p>Error! No results were found</p></div>";
		exit;
	}
	$current_triptypes_data = mysqli_fetch_assoc($triptype_results);


?>
<!-- div class content starts here -->
<div class="content">
	<p>Please select which trip you are running</p>
	<form id="update_trip_form_1" action='process_edits.php' method='post'>
	    <select id="change_trip_type" name="trip_type_id">
	        <?php
	        mysqli_data_seek($triptype_results, 0);
	        while ($trip = mysqli_fetch_assoc($triptype_results)) {
				if($trip['TripTypeId'] == $current_trip_data['TripTypeId']){
					echo "<option value='{$trip['TripTypeId']}' selected>{$trip['TripName']}</option>";
				} else{
					echo "<option value='{$trip['TripTypeId']}'>{$trip['TripName']}</option>";
				}
	        }
	        ?>
	    </select>
	    <input type="hidden" name="trip_id" value="<?php echo htmlspecialchars($trip_id); ?>">
	    <input type="submit" name='submit' value='Update Trip Type'>
	</form>

	<br>Days: <span id="days">Loading...</span><br>
	Max People: <span id="maxPeople">Loading...</span><br>
	Price: $<span id="price">Loading...</span><br>
	Difficulty: <span id="difficulty">Loading...</span>

	<script>
	    document.getElementById("change_trip_type").addEventListener("change", function() {
	        let tripId = this.value;

	        // Fetch trip details dynamically when selection changes
	        fetch(`includes/fetch_trip_details.php?trip_id=${tripId}`)
	            .then(response => response.json())
	            .then(data => {
	                document.getElementById("days").textContent = data.Days;
	                document.getElementById("maxPeople").textContent = data.MaxPeople;
	                document.getElementById("price").textContent = parseFloat(data.Price).toFixed(2);
	                document.getElementById("difficulty").textContent = data.Difficulty;
	            })
	            .catch(error => console.error("Error fetching data:", error));
	    });

	    // Auto-load the first trip's details on page load
	    document.getElementById("change_trip_type").dispatchEvent(new Event("change"));
	</script>
<?php
	echo "<P>Please enter in the changed date and trip leader</p>";
	// Create a form and an option menu to allow the user to input information
	echo "<form name='update_trip_form' action='process_edits.php' method='post'>"; // CHANGE THE FORM NAME
	echo sprintf("<input type='hidden' name='UpdateTripId' value='%d'>
	<input type='date' name='Date' value='%s'><select name='new_leader'>", $current_trip_data['TripId'], $current_trip_data['Date']);
	// Create a while statement to select the already selected Trip leader
	while($current_leaders = mysqli_fetch_assoc($leader_results)){
		if($current_trip_data['UserId'] == $current_leaders['UserId']){
			echo "<option value=".$current_leaders['UserId']." selected>".$current_leaders['UserFirstName']." ".$current_leaders['UserLastName']."</option>";
		} else{
			echo "<option value=".$current_leaders['UserId'].">".$current_leaders['UserFirstName']." ".$current_leaders['UserLastName']."</option>";
		}
	}
	echo "</select>
	<input type='submit' name='submit' value='Update Trip'>
	</form>";
?>
</div>
<!-- div class content ends here -->
<?php
	// Close sql
	mysqli_stmt_close($trip_detail_stmt);
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>