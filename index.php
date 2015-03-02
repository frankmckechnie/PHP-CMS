<?php
require_once 'core/init.php';
$user = new User();
if($user->isLoggedIn()){

$posts = DB::getInstance()->get('posts', array('userID', '=',$user->data()->id ));

?>
	<p>hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>
	<h2>Users Options</h2>
	<ul>
		<li><a href="logout.php">Log Out</a></li>
		<li><a href="update.php">Update Details</a></li>
		<li><a href="changepassword.php">Change Password</a></li>
		<li><a href="addPost.php">Add new post</a></li>
	</ul>

	<h2>Navigation</h2>

	<ul>
		<li><a href="posts.php">Public Posts</a></li>	
	</ul>

	<h2>My Posts</h2>
<?php 

	if (!$posts->count()){
		echo 'no posts';
	}else{
		echo "<ul>";
		foreach ($posts->results() as $post) {
?>
			<li>
				<a href="viewPost.php?post=<?php echo escape($post->id); ?>"><?php echo escape($post->title); ?></a>
				<?php echo escape($post->timeStamp); ?>
				<br> By <a href="profile.php?user=<?php echo escape($post->username); ?>"><?php echo escape($post->username); ?></a>
				Gender = <?php echo escape($post->gender);  ?><br>
				<a href="delete.php?post=<?php echo escape($post->id); ?>">Delete</a>
			</li>
<?php
		}
		echo "</ul>";
		echo "<h3>Your Goals</h3>";

	}

	if($user->hasPermission('admin')){
		echo "you have admin";
	}
	if (Session::exists('home')){
		echo '<p>' . Session::flash('home') . '</p>';
	}

}else{
	echo '<p>you need to <a href="login.php" >login</a> or <a href="register.php">register</a> </p>';
}