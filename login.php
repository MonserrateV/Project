
<?php
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 
//process login form if submitted
if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($user->login($username,$password)){ 
        $_SESSION['username'] = $username;
        header('Location: memberpage.php');
        exit;
    
    } else {
        $error[] = 'Wrong username or password or your account has not been activated.';
    }

}
//include header template
require('layout/header.php'); 
?>
<div class="container">
<form role="form" method="post" action="" autocomplete="off">

<?php
                //check for any errors
                if(isset($error)){
                    foreach($error as $error){
                        echo '<p class="bg-danger">'.$error.'</p>';
                    }
                }
               
?>
    <div class="form-group">
        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
    </div>

    <div class="form-group">
        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
    </div>
    
    
    <hr>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
    </div>
</form>
</div>
/*<?php

/*Next attempt to log the user in. Collect the username and password from the form pass them to the users object in the login method this internally will fetch the users hash by looking for the username in the database once the hash is returned it's then passed to password_verify if the hash and user's hash match it returns true which in turns sets a session $_SESSION['loggedin'] to true otherwise false is returned.*/

 function login($username,$password){

    $row = $this->get_user_hash($username);

    if($this->password_verify($password,$row['password']) == 1){

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];
        return true;
    }
};

//end if submit
//include header template
require('layout/footer.php'); 
?>