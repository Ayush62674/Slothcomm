<?php
//variables
$fname = "";//First name
$lname = "";//Last name
$em = "";//email
$em2 = "";//email 2 
$pass = "";//password
$pass2 = "";//password 2
$date = "";//signup date
$error_array = array();//Holds error message

if (isset($_POST['register_button'])) {
	//Register form values
	//First name
	$fname = strip_tags($_POST['reg_fname']);//remove html tags
	$fname = str_replace(' ', '', $fname);//remove spaces
	$fname = ucfirst(strtolower($fname));//Uppercase first letter
	$_SESSION['reg_fname'] = $fname;//stores value in session value
	//Last name
	$lname = strip_tags($_POST['reg_lname']);//remove html tags
	$lname = str_replace(' ', '', $lname);//remove spaces
	$lname = ucfirst(strtolower($lname));//Uppercase first letter
	$_SESSION['reg_lname'] = $lname;//stores value in session value
	//E-mail
	$em = strip_tags($_POST['reg_email']);//remove html tags
	$em = str_replace(' ', '', $em);//remove spaces
	$em = ucfirst(strtolower($em));//Uppercase first letter
	$_SESSION['reg_email'] = $em;//stores value in session value
	//E-mail 2
	$em2 = strip_tags($_POST['reg_email2']);//remove html tags
	$em2 = str_replace(' ', '', $em2);//remove spaces
	$em2 = ucfirst(strtolower($em2));//Uppercase first letter
	$_SESSION['reg_email2'] = $em2;//stores value in session value

	//password
	$pass = strip_tags($_POST['reg_pass']);//remove html tags
	//password 2
	$pass2 = strip_tags($_POST['reg_pass2']);//remove html tags
 	
 	$date = date("Y-m-d");//current date

if($em==$em2){
	if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

		$em = filter_var($em, FILTER_VALIDATE_EMAIL);

		//Check if email already exists 
		$e_check = mysqli_query($conn, "SELECT email FROM users WHERE email='$em'");

		//Count the number of rows returned
		$num_rows = mysqli_num_rows($e_check);

		if($num_rows > 0) {
			array_push($error_array,"E-mail is already in use<br>") ;
		}
	}
	else{
	 	array_push($error_array,"Enter valid e-mail<br>");
	}
}
else{
	array_push($error_array,"E-mail doesn't match<br>");
}
if(strlen($fname) >25 || strlen($fname) < 2){
	array_push($error_array,"Your first name must be between 2 and 25 characters<br>");
}
if(strlen($lname) >25 || strlen($lname) < 2){
	array_push($error_array,"Your last name must be between 2 and 25 characters<br>");
}
if($pass != $pass2){
	array_push($error_array, "Password doesn't match<br>");
}
else{
	if(preg_match('/[^A-Za-z0-9]/', $pass)){
		array_push($error_array, "Your password can only contain numbers or password<br>");
	}
}
if (strlen($pass)>30 || strlen($pass)<6) {
	array_push($error_array, "Your password must be between 6 and 30 letters<br>");
}
if(empty($error_array)){
	$pass = md5($pass);//encrypted password before sending to database

	//generating username by concatenating first and last name
	$username = strtolower($fname . "_" . $lname);
	$check_username_query = mysqli_query($conn,"SELECT username FROM users WHERE username = '$username'");
	$i = 0;
	//if username exists add number to username
	while (mysqli_num_rows($check_username_query)!=0){
		$i++;
		$username = $username . $i;
		$check_username_query = mysqli_query($conn,"SELECT username FROM users WHERE username = '$username'");
	}
	//profile pic assignment
	$rand = rand(1,2);
	 switch ($rand) {
	 	case '1':
			$profile_pic = "assets/images/profile_pic/default/head_alizarin.png";
			break;
		case '2':
			$profile_pic = "assets/images/profile_pic/default/head_amethyst.png";
			break;
	 	case '3':
	 		$profile_pic = "assets/images/profile_pic/default/head_belize_hole.png";
	 		break;
		case '4':
			$profile_pic = "assets/images/profile_pic/default/head_carrot.png";
			break;
	 	case '5':
			$profile_pic = "assets/images/profile_pic/default/head_deep_blue.png";
			break;
		case '6':
	 		$profile_pic = "assets/images/profile_pic/default/head_emerald.png";
			break;
	 	case '7':
			$profile_pic = "assets/images/profile_pic/default/head_green_sea.png";
	 		break;
	 	case '8':
			$profile_pic = "assets/images/profile_pic/default/head_nephritis.png";
			break;
	 	case '9':
	 		$profile_pic = "assets/images/profile_pic/default/head_pete_river.png";
	 		break;
	 	case '10':
	 		$profile_pic = "assets/images/profile_pic/default/head_pomegranate.png";
			break;
	 	case '11':
	 		$profile_pic = "assets/images/profile_pic/default/head_pumpkin.png";
	 		break;
	 	case '12':
			$profile_pic = "assets/images/profile_pic/default/head_red.png";
			break;
		case '13':
			$profile_pic = "assets/images/profile_pic/default/head_sun_flower.png";
			break;
	 	case '14':
			$profile_pic = "assets/images/profile_pic/default/head_turqoise.png";
	 		break;
	 	case '15':
	 		$profile_pic = "assets/images/profile_pic/default/head_wet_asphalt.png";
	 		break;
		case '16':
	 		$profile_pic = "assets/images/profile_pic/default/head_wisteria.png";
			break;
	}
	$query = mysqli_query($conn,"INSERT INTO users VALUES ('','$fname','$lname','$username','$em','$pass','$date','$profile_pic','0','0','no',',')");
	array_push($error_array, "<span style='color : #14C800';>You are all set! Go ahead and login</span><br>");
	//clear session variables
	$_SESSION['reg_fname'] = "";
	$_SESSION['reg_lname'] = "";
	$_SESSION['reg_email'] = "";
	$_SESSION['reg_email2'] = "";
}
}
?>