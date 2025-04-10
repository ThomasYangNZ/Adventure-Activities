<?php 
    session_start();

    // Check if a valid trip id has been submitted 
    if(!isset($_GET['trip_id'])) {
        $_SESSION['Error'] = "Please select a valid trip!";
        header("Location: index.php");
        exit();
    // Check that the user is either admin or trip leader
    } elseif($_SESSION['UserType'] != "Admin" && $_SESSION['UserType'] != "Trip Leader") {
        $_SESSION['Error'] = "You are unauthorized to view this page!";
        header("Location: index.php");
        exit();
    }

    // santize input
    $trip_id = trim($_GET['trip_id']);

	// connect to the database via public connection
	include("publicconnection.php"); 

    // Query the details regarding a specific Trip Type
    $trip_detail_update_query = "SELECT `Days`, `MaxPeople`, `Price`, `Difficulty`
                  FROM `triptypes`
                  JOIN `difficulties` ON `triptypes`.`DifficultyId` = `difficulties`.`DifficultyId`
                  WHERE `TripTypeId` = ?";

    $trip_detail_update_stmt = mysqli_prepare($dbc, $trip_detail_update_query);
    mysqli_stmt_bind_param($trip_detail_update_stmt, "i", $trip_id);
    mysqli_stmt_execute($trip_detail_update_stmt);
    $result = mysqli_stmt_get_result($trip_detail_update_stmt);
    // If there are no results, exit
    if (!$result) {
        exit;
    }
    // If there is access the trip
    $trip = mysqli_fetch_assoc($result);
    if (!$trip) {
        exit;
    }
    // Return the details encoded in json
    echo json_encode($trip);
?>