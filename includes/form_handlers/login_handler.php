<?php

if (isset($_POST['login_button'])) {
		$e_mail = filter_var($_POST["log_email"], FILTER_SANITIZE_EMAIL);//sanitize email

		$_SESSION["log_email"] = $e_mail;//store email into session variable
		$pass = md5($_POST["log_pass"]);//matches password in the encrypted form

		$check_database_query = mysqli_query($conn,"SELECT * FROM users WHERE email='$e_mail' AND password = '$pass'");
		$check_login_query = mysqli_num_rows($check_database_query);

		if($check_login_query == 1){
			$row = mysqli_fetch_array($check_database_query);
			$username = $row['username'];

			$user_closed_query = mysqli_query($conn,"SELECT * FROM users WHERE email = '$e_mail' AND user_closed = 'yes'");
			if(mysqli_num_rows($user_closed_query)==1){
				$reopen_account = mysqli_query($conn,"UPDATE users SET user_closed = 'no' WHERE email = '$e_mail'");
			}

			$_SESSION['username'] = $username;
			header("Location: index.php");
			exit();
		}
		else{
			array_push($error_array, "<br>E-mail or password is wrong<br>");
		}
}

?>