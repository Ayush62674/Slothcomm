<?php
	include("includes\header.php");
	include("includes\classes\User.php");
	include("includes\classes\Post.php");

	if(isset($_POST['post'])){
		$post = new Post($conn,$userLoggedIn);
		$post->submit_post($_POST['post_text'],'none');
	}




?>
		<div class="user_details column">
			<a href="<?php echo $userLoggedIn ?>"><img src="<?php echo $users['profile_pic']?>"></a>
			<div class="users_details_left_right">
			<a href="<?php echo $userLoggedIn ?>">
			<?php
				echo "<br>".$users['first_name']." ". $users['last_name']."<br>";
			?>
			</a>
			<?php
				echo "Posts:"." ".$users['num_posts']."<br>";
				echo "Likes:"." ".$users['num_likes'];
			?>
		</div>
	</div>
	<div class="main_column column">
		<form class="post_form" action="index.php" method"=POST">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea><br>
			<input type="submit" name="post" id="post_button" value="Post"><br>
		</form>
		<?php 
			$post = new Post($conn,$userLoggedIn);
			$post->loadpostfriend();

		 ?>
	</div>
</div>
</body>
</html>