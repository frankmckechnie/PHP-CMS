<?php 
require_once 'core/init.php';

if(!$postId = Input::get('post')){
	Redirect::to('index.php');
}else{
	$posts = DB::getInstance()->get('posts', array('id', '=', $postId));
	$results = $posts->results();
	foreach ($results as $post) {
		if(!$post->public == 1){
			Redirect::to('posts.php');
		}
?>
		<h1><?php echo escape($post->title); ?></h1>
		<h2>Post By <a href="profile.php?user=<?php echo escape($post->username); ?>"><?php echo escape($post->username); ?></a> (<?php echo escape($post->gender); ?>)</h2>
		<P><?php echo escape($post->timeStamp); ?></P>

<?php

	}

	$images = DB::getInstance()->get('images', array('postID', '=', $postId));
	$imgResults = $images->results();
	

	foreach ($imgResults as $image ) {
?>
		<strong><?php echo $image->addedTitle; ?></strong><br>
		<img src="<?php echo $image->filePath; ?>"><br>


<?php
	}

}