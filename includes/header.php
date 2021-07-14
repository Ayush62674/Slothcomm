<?php
require 'config\config.php';

if(isset($_SESSION['username'])){
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($conn,"SELECT * FROM users WHERE username = '$userLoggedIn'");
	$users = mysqli_fetch_array($user_details_query );
}
else{
	header("Location: register.php");
}
?>
<html lang="en">
<head>
    <title>demo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="includes/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head> 
<body>
	<div class="nav_bar">
		<div class="icon">
			 <a href="index.php"><img src="assets/images/Logo/Picture1.png"></a> 	
		</div>
		<nav>
			<a href="<?php echo $userLoggedIn ?>">
				<?php 
					echo $users['first_name'];
				?>
			</a>
			<a href="#" data-tooltip="Home"><i class="fa fa-home" style="font-size: 1.5em"></i></a>
			<a href="#" data-tooltip="Messages"><i class="fa fa-envelope" style="font-size: 1.5em"></i></a>
			<a href="#" data-tooltip="Notifications"><i class="fa fa-bell" style="font-size: 1.5em"></i></a>
			<a href="#" data-tooltip="Friend Requests"><i class="fa fa-users" style="font-size: 1.5em"></i></a>
			<a href="#" data-tooltip="Settings"><i class="fa fa-cog" style="font-size: 1.5em"></i></a>
			<a href="includes/handlers/logout.php" data-tooltip="Log-out"><i class="fa fa-sign-out" style="font-size: 1.5em"></i></a>
		</nav>


	</div>



	<div class="container">