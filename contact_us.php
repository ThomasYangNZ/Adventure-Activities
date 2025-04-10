<?php 
	session_start();

	// Store the title, description and div id (acts as background image) and send to head.php
	$title = "Adventure Kayak | Contact Page";
	$description = "This is the Contact Page of Adventure Kayak, kayak and canoe, service. We provide guided tours of natures most exhilarating sights. Apply to join one of our guided tours now!";
	$img = "contact-info-background";

	// Create a require statement for head.php
	require("includes/head.php"); 

	// Connect to the database via public connection
	include("includes/publicconnection.php");
?>
<!-- Div class content starts here -->
<div class="content">
	<p>If you wish to contact us, please message us using your personal messages, available on the seperate email website. If there is
	 a urgent matter to discuss. Please contact Joe Bloggs via text message.</p>
</div>
<!-- Div class content ends here -->
<?php
	// Require the file footer.php containing the website footer
	require("includes/footer.php");
?>