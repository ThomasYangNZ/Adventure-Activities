<?php 
	session_start();

	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Login";
	$description = "This is the homepage of Adventure Kayak, kayak and canoe, service. We provide guided tours of natures most exhilarating sights. Apply to join one of our guided tours now!";
	$img = "login-background";

	// create a require statement for head.php
	require("includes/head.php");

	// connect to the database via public connection
	include("includes/publicconnection.php");
?>
<!-- div class content starts here -->
<div class="content">
	<!-- div triangle starts here -->
	<div id="right-triangle">
	</div>
	<!-- div triangle ends here -->
	
<?php
	// Echo the input form
	echo '<form name="login" action="process_edits.php" method="post" id="login-form-input">
			Username: <br>
		  <input type="text" name="username" required><br><br>
		  	Password: <br>
		  <input type="password" name="password" required><br><br>
		  <input type="submit" name="submit" value="Log In">
		  </form>';


	// If there is a set message, display and unset variable
	if(isset($_SESSION['LoginMessage'])){
		$LoginMessage = $_SESSION['LoginMessage'];
		echo "<div class='error'><p>$LoginMessage</p></div>";
		unset($_SESSION['LoginMessage']);
	}
?>
</div>
<!-- div class content ends here -->
<?php 
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>