<?php
require 'config\config.php';
require 'includes\form_handlers\register_handler.php';
require 'includes\form_handlers\login_handler.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to </title>
	<link rel="stylesheet" type="text/css" href="assets\css\register_style.css">
</head>
<body>
	<div class="container">
		<div class="container1">
			<form action="register.php" method="POST">
				<input type="email" name="log_email" placeholder="E-mail Address" value="<?php 
				if(isset($_SESSION['log_email'])){
					echo $_SESSION['log_email'];
				}
				?>" required>
				<input type="password" name="log_pass" placeholder="Password">
				<input type="submit" name="login_button" value="Login">
				<?php
					if(in_array("<br>E-mail or password is wrong<br>", $error_array)){
						echo "<br>E-mail or password is wrong<br>";
					}
				?>
			</form>
		</div>
		<div class="container2">
			<div class="create">
					<h1>Create an account</h1>
				</div>
			<div class="name">
				<form action="register.php" method="POST">
				<input type="text" name="reg_fname" placeholder="Full Name" value="<?php 
				if(isset($_SESSION['reg_fname'])){
					echo $_SESSION['reg_fname'];
				}
				?>" required>
				<?php
					if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)){
						echo "Your first name must be between 2 and 25 characters<br>";
					}
				?>
				<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
				if(isset($_SESSION['reg_lname'])){
					echo $_SESSION['reg_lname'];
				}
				?>" required>
				<br>
				<?php
					if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)){
						echo "Your last name must be between 2 and 25 characters<br>";
					}
				?>
				</div>
				<div class="e_mail">
				<input type="e-mail" name="reg_email" placeholder="E-mail" value="<?php 
				if(isset($_SESSION['reg_email'])){
					echo $_SESSION['reg_email'];
				}
				?>"  required>
				<br>
				<input type="e-mail" name="reg_email2" placeholder="Confirm E-mail" value="<?php 
				if(isset($_SESSION['reg_email2'])){
					echo $_SESSION['reg_email2'];
				}
				?>" required>
				<br> 
				<?php
					if(in_array("E-mail is already in use<br>", $error_array)){
						echo "E-mail is already in use<br>";
					}
				else if(in_array("Enter valid e-mail<br>", $error_array)){
						echo "Enter valid e-mail<br>";
					}
				else if(in_array("E-mail doesn't match<br>", $error_array)){
						echo "E-mail doesn't match<br>";
					}
				?>
				<input type="password" name="reg_pass" placeholder="Password" required>
				<br>
				<input type="password" name="reg_pass2" placeholder="Confirm Password" required>
				<br>
				<?php
					if(in_array("Password doesn't match<br>", $error_array)){
						echo "Password doesn't match<br>";
					}
				else if(in_array("Your password can only contain numbers or password<br>", $error_array)){
						echo "Your password can only contain numbers or password<br>";
					}
				else if(in_array("Your password must be between 6 and 30 letters<br>", $error_array)){
						echo "Your password must be between 6 and 30 letters<br>";
					}
				?>
				</div>
				<input type="submit" name="register_button" value="Create an account"><br>
				<?php
					if(in_array("<span style='color : #14C800';>You are all set! Go ahead and login</span><br>", $error_array)){
						echo "<span style='color : #14C800';>You are all set! Go ahead and login</span><br>";
					}
					?>
			</form>
		</div>
	</div>
</body>
</html>