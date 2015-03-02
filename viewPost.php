<?php 
require_once 'core/init.php';
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
<?php
include 'includes/nav.php';
if(!$postId = Input::get('post')){
	Redirect::to('index.php');
}else{
	$images = DB::getInstance()->get('images', array('postID', '=', $postId));
	$imgResults = $images->results();

	if(!$images->count()){
		Session::flash('home', 'There was no images!');
		Redirect::to('index.php');
	}

	$user = new User();
	$data = $user->data();

	$posts = DB::getInstance()->get('posts', array('id', '=', $postId));
	$results = $posts->results();
	foreach ($results as $post) {
		if($post->public == 0){
			if($data->id !== $post->userID){
				Session::flash('home', 'You cannot access that post!');
				Redirect::to('posts.php');
			}
		}
?>
		<h1><?php echo escape($post->title); ?></h1>
		<h2>Post By <a href="profile.php?user=<?php echo escape($post->username); ?>"><?php echo escape($post->username); ?></a> (<?php echo escape($post->gender); ?>)</h2>
		<P><?php echo escape($post->timeStamp); ?></P>
<?php

	}
		foreach ($imgResults as $image ) {
?>
			<strong><?php echo $image->addedTitle; ?></strong><br>
			<img src="<?php echo $image->filePath; ?>"><br>
<?php
	}

}
?>
</body>
</html>