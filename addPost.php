<?php
require_once 'core/init.php';

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'pTitle' => array(
				'required' => true,
				'min' => 2,
				'max' => 20
			)
		));

		if($validation->passed()){
			$user = new User();
			echo $user->data()->gender;
			$public = (Input::get('public') === 'on') ? 1 : 0;
			try {

				$user->create('post','posts',array(
					'userID' => $user->data()->id,
					'title' => Input::get('pTitle'),
					'timeStamp' => date('Y-m-d H:i:s'),
					'public' => $public,
					'username' => $user->data()->username,
					'gender' => $user->data()->gender,

				));

				Session::flash('home', 'Post Added');
				Redirect::to('index.php');

			} catch(Exception $e){
				die($e->getMessage());
			}

		}else{
			foreach ($validation->errors() as $error) {
				echo "$error<br>";
			}
			
		}
	}
}

?>
<h1>New post!</h1>
<form action="" method="post">
	<div class="field">
		<label for="pTitle">Post Title</label>
		<input type="text" name="pTitle" id="pTitle" value="" >
	</div>

	<div class="field">
		<label for="public">
			<input type="checkbox" name="public" id="public" > Click on to make your post public ? 
		</label>
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
	<input type="submit" value="Create">
</form>

