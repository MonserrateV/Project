<?php
require_once('includes/config.php');
require('layout/header.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){
 header('Location: login.php');
  } 
else{
  //include header template
}

?>

<div class="container text-center">
<h1>Members only page</h1>
<H2>Welcome</H2>
<p class="logout"><a href='logout.php'>Logout</a></p>
</div>
<?php 
//include header template
require('layout/footer.php'); 
?>