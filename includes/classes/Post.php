<?php 
class Post{
	private $user;
	private $conn;

	public function __construct($conn, $user){
		$this->conn = $conn;
		$this->user_obj = new User($conn,$user);
	}
	public function submit_post($body, $user_to){
		$body = strip_tags($body);//remove html tags
		$body = mysqli_real_escape_string($this->conn, $body);//its used if we insert '' between so it should not consider that as diff. string while loading to database
		$check_empty = preg_replace('/\s+/','',$body);//deletes all spaces

		if ($check_empty!= "") {
			//current date and time
			$date_added = date("Y-m-d H:i:s");
			//Get username
			$added_by = $this->user_obj->getfirstandlastname();
			//if user is in its own profile then user_to is none
			if($user_to == $added_by){
				$added_by = "none";
			}
			//insert post
			$query = mysqli_query($this->conn, "INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0')");
			$returned_id = mysqli_insert_id($this->conn);
			//insert notification

			//update post count for user
			$num_posts = $this->user_obj->getNumPosts();
			$num_posts++;
			$update_query = mysqli_query($this->conn,"UPDATE users SET num_posts = '$num_posts' WHERE username = '$added_by'");
		}
	}
	public function loadpostfriend(){
		$str = ""; //string to return
		$data = mysqli_query($this->conn,"SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC");

		while ($row = mysqli_fetch_array($data)){
			$id = $row['id'];
			$body = $row['body'];
			$added_by = $row['added_by'];
			$date_time = $row['date_added'];
			//store user_to string even if it is done to self

			if($row['user_to'] == "none"){
				$user_to = "";
			}
			else{
				$user_to_obj = new User($this->conn,$row['user_to']);
				$user_to_name = $user_to_obj->getfirstandlastname();
				$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
			}
			//check if the user who posted, has their account closed
			$added_by_obj = new User($this->conn,$added_by);
			if($added_by_obj->isClosed()){
				continue;
			}
			
			$user_details_query = mysqli_query($this->conn, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
			$user_row = mysqli_fetch_array($user_details_query);
			$first_name = $user_row['first_name'];
			$last_name = $user_row['last_name'];
			$profile_pic = $user_row['profile_pic'];

			//time frame
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($date_time); //time of post
			$end_date = new DateTime($date_time_now);//current time 
			$interval = $start_date->diff($end_date); //diffrence in time
			if($interval->y >= 1){
				if ($interval == 1) {
					$time_message = $interval->y . " year ago" ;//1 year ago
				}
				else{
					$time_message = $interval->y . " years ago" ;//1+ year ago
				}
			}
			else if ($interval->m >= 1) {
				if ($interval->d == 0){
					$days = " ago";
				}
				else if($interval->d == 1){
					$days = $interval->d ." day ago";
				}
				else {
					$days = $interval->d ." days ago";
				}

				if ($interval->m == 1) {
					$time_message = $interval->m . " month" . $days;
				}
				else {
					$time_message = $interval->m . " months" . $days;
				}
			}
			else if ($interval->d >= 1) {
				if($interval->d == 1){
					$time_message = "yesterday";
				}
				else {
					$time_message = $interval->d ." days ago";
				}
			}
			else if ($interval->h >= 1) {
				if($interval->h == 1){
					$time_message = $interval->h ." hour ago";
				}
				else {
					$time_message = $interval->h ." hours ago";
				}
			}
			else if ($interval->i >= 1) {
				if($interval->i == 1){
					$time_message = $interval->i ." minute ago";
				}
				else {
					$time_message = $interval->i ." minutes ago";
				}
			}
			else {
				if($interval->s == 30){
					$time_message = "Just now";
				}
				else {
					$time_message = $interval->s ." seconds ago";
				}
			}
			$str .= "<div class='status_post'>
						<div class='post_profile_pic'>
							<img src ='$profile_pic' width='50'>
						</div>
						<div class='posted_by' style='color:#ACACAC;'>
							<a href='$added_by'>$first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
						</div>
						<div id='post_body'>
						$body
						<br>
						</div>	
					</div>";
		}
		echo $str;
	} 
}
 ?>