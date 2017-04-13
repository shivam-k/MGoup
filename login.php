<?php
  session_start();
   if($_SESSION['username']) {
       header ("Location: index.php");
   }

?>

<!DOCTYPE html>
<html>

<head>

  <title>Asking Shivam to Mail</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
body .container{
  height: 100%;
}
.container {
  margin-top: 10%;
  vertical-align: center;
}


  </style>

</head>

<?php
$error = "";
session_start();
if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(!empty($username) && !empty($password)) {
		if($username == 'sudo' && $password == 'anonymous') {
			$_SESSION['username'] = $username;
			?> <script> window.location="index.php"; </script> <?php 
		}
		else {
			$error = "Wrong Combination of Username and Password";
		}
	}
  else {
    $error = "Empty box... Hey, Stop kidding me !!";
  }
}

?>


<?php

  if(empty($error)) {
    echo '<style type="text/css">
           #error {
                display: none;
           }
           </style>';
    }

 ?>




<body>
<div class="container col-sm-6 col-sm-offset-3" >
<div class="well well-lg " style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
  <h2 class="text-center"><kbd>Login form</kbd></h2><br />
  <!-- alert for danger =========== -->
   <div class="alert alert-danger" id="error">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <p class="text-center"> <strong><?php echo $error; ?></strong></p>
   </div>
  <form class="form-horizontal" role="form" method="POST">
    <div class="form-group">
      <label class="control-label col-sm-2 col-sm-offset-1" for="email">Username:</label>
      <div class="col-sm-8">
         <input type="text" class="form-control input-lg" id="text" placeholder="Enter username" name="username" value="<?php echo $username; ?>"  />
      </div> 
    </div>
    <div class="form-group" >
      <label class="control-label col-sm-2 col-sm-offset-1" for="pwd">Password:</label>
      <div class="col-sm-8">
         <input type="password" class="form-control input-lg" id="pwd" placeholder="Enter password" name="password" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
         <button type="submit" class="btn btn-primary btn-block btn-lg" name="submit">Submit</button>
      </div>
    </div>
  </form>
 </div>
</div>


</body>

</html>
