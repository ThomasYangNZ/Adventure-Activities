<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Set the title of the page as variable $title -->
		<title><?php echo $title; ?></title>

		<!-- Set the description of the page as variable $description -->
		<meta name="description" content="<?php echo $description; ?>">
		<link href="css/styles4.css" rel="stylesheet">
		
		<!-- Call Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">


	</head>
	<body>
	<!-- Javscript starts here -->
	<!-- Javascrip is used from https://codepen.io/jhiam/pen/woZaKZ -->
		<script>
window.onscroll = () => {
  const nav = document.querySelector('#nav_bar');
  if(this.scrollY <= 10) nav.className = ''; else nav.className = 'scroll';
};
		</script>
	<!-- Javascrip is used from https://codepen.io/jhiam/pen/woZaKZ -->
	<!-- Javascript ends here -->
		
		<!-- Main image starts here, file name in variable $img-->
		<div id="<?php echo $img; ?>">
			<!-- header starts here -->
			<header id="nav_bar">
				<!-- img Logo as an anchor starts here -->
				<a href="index.php" ><img src="img/logoipsum-236.svg" alt="A placeholder image representing a placeholder logo retrieved from Logoipsum" id="logo"></a>
				<!-- img Logo ends here -->
				<!-- nav starts here -->
				<nav>
					<ul>
						<!-- Provide a login/logout link depending if the user is logged in -->
						<?php
							if(!isset($_SESSION['UserType'])) {
								echo "<li><a href='login.php'>LOGIN</a></li>";
							} elseif(isset($_SESSION['UserType'])) {
								echo "<li><a href='logout.php'>LOGOUT</a></li>";
							}
						?>
						<li><a href="contact_us.php">CONTACT US</a></li>
						<li><a href="trips.php">TRIPS</a></li>
						<li><a href="index.php">HOME</a></li>
					</ul>
				</nav>
				<!-- nav ends here -->
			</header>
			<!-- header ends here -->
		</div>
	<!-- main image ends here -->
