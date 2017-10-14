<?php
//include config file
require_once ('includes/config.php');


//include header template
require ('layout/header.php');


//if form has been submitted process it
if(isset($_POST['submit'])){
	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
	}
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}
	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}
	//if no errors have been created carry on
	if(!isset($error)){
		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
		
		try {
			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO users (username,password,email) VALUES (:username, :password, :email)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email']
				
			));
			$id = $db->lastInsertId('user_id');
			
			header('Location: index.php?action=joined');
			exit;
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}


      //check to see if user is already logged in
//if logged in redirect to members page
if ($user->is_logged_in()) {
	header('Location: memberpage.php');
}

?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
<form role="form" method="post" action="" autocomplete="off">

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful.</h2>";
				}
				?>

		<h1 class="text-center"> Do you have what it takes to learn the Truth about Oral Health? </h1>
		<h2 class="text-center"><em>Enter if you Dare!</em></h2>
	<button type="button" value="login" class="btn btn-primary btn-block btn-lg" onClick="window.location ='login.php'">Login</button>
	<img src="style/icon8.png"/>
		<h2 class="text-center">If this is your first time here, please register below to begin.</h2>	
	
	<div class="form-group">
		<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if (isset($error)) {echo $_POST['username'];}?>" tabindex = "1">
	</div>
	<div class="form-group">
		<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="<?php if (isset($error)) {echo $_POST['email'];}?>" tabindex="2">
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
			</div><!--closes form-group-->
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
			</div><!--closes form-group-->
		</div>
	</div><!--closes row-->

	 <div class="row">
         <div class="col-xs-6 col-md-6">
            <input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
          </div>
      </form> 
      </div>
      </div>
      </div> 
	
      <?php

     //include header template
require('layout/footer.php');
?>

