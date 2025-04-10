<?php 
	session_start();

	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Homepage";
	$description = "This is the homepage of Adventure Kayak, kayak and canoe, service. We provide guided tours of natures most exhilarating sights. Apply to join one of our guided tours now!";
	$img = "main-img-index";

	// create a require statement for head.php
	require("includes/head.php"); 

	// connect to the database via public connection
	include("includes/publicconnection.php");
?>
<?php 
	// Check if an error message has been set, if so inform user and reset
	if(isset($_SESSION['Error'])) {
		echo "<div class=error><p>".$_SESSION['Error']."</p></div>";
		unset($_SESSION['Error']);
	}
?>
<!-- h1 starts here -->
<h1 id="main-img-desc">This could be you!</h1>
<!-- h1 ends here -->
<!-- div main-section-2 starts here -->
<div id="main-section-2">
	<p>Welcome to Adventure Kayak Services! This website is created to allow people to particpate in 
	kayaking tours all across New Zealand! All of our Team Leaders are extremely friendly and have years 
	of experience in the field. We have multiple trips running at multiple times this, and next year, from the Abel Tasman trip, Marlborough, and even the Solomon Islands! If you wish to particpate now, simply register to our website, and sign up to any of the many trips avaliable. If you have another queries, questions or simply want more information, 
	feel free to contact either our amazing Team Leaders, or Joe Bloggs.</p>
	<!-- div triangle starts here -->
	<div id="left-triangle">
		<!-- h1 triangle starts here -->
		<h1 id="triangle-title">How Do I Join?</h1>
		<!-- h1 triangle ends here -->
	</div>
	<!-- div triangle ends here -->
</div>
<!-- div main-section-2 ends here -->
<!-- div main-section-3 starts here -->
<div id="main-section-3">
	<!-- h1 title class starts here -->
	<h1 class="title">Our Team Leaders!</h1>
	<!-- h1 title class ends here -->
	<!-- images starts here -->
	<div class="picture-border"><img src="img/team_leader.gif" alt="This is an image of one of our three trip leader's account's avatar. Feel free to message them"></div>
	<div class="picture-border"><img src="img/team_leader.gif" alt="This is an image of our second of our three trip leader's account's avatar. Feel free to message them"></div>
	<div class="picture-border"><img src="img/team_leader.gif" alt="This is an image of our third of our three trip leader's account's avatar. Feel free to message them"></div>
	<!-- images ends here -->
	<p>Hello there! These are some of the fine, amazing people that we have that will be guiding you on your journey of freedom! 
	We are all proud of the amount of experience each individual has on our team, they are the best in the business! Oh Team Leaders 
	are extremely special individuals! They come from the area of New Vegas, where the terrain is rough and the locals are rougher! But don't worry, 
	they have a sweet spot for helping people! Whereas Johnny English, is a very experienced individual. He has been all around the world from the 
	coldest peaks of Europe, to the hottest climates in Africa! All of our Team Leaders have been with us for a long, long time and have our upmost trust placed 
	in them! However, if you suspect that our Team Leaders have acted irresponsible, or illegally, please contact the owner Andy Blake directly.</p>
</div>
<!-- div main-section-3 ends here -->
<?php
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>

<!-- PASSWORDS -->

<!-- Administrator Username: admin | Administrator Password: -w#f?J6bjPRe,H6U
	 Trip Leader 1 Username: trip_leader_1 | Trip Leader 1 Password: r$3s!5ZFeeWzxwfe
	 Trip Leader 2 Username: trip_leader_2 | Trip Leader 2 Password: XWc#5Z_p6PAbj4:-
	 Trip Leader 3 Username: trip_leader_3 | Trip Leader 3 Password: g~v8.@pSnP?)"yf7
	 Member 1 Username: member_1 | Member 1 Password: R!-zSKnqpJ!4kk^5
	 Member 2 Username: member_2 | Member 2 Password: 36s^3CG+w=Kbpbsq
-->