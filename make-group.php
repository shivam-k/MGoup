<?php
include("mailcon.php");
session_start();
   if($_SESSION['username']) {
        $username = $_SESSION['username'];
   }
   else {
      header("Location: login.php");
   }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Ask Shivam to Mail</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>

  <body>

<?php

if(isset($_POST['add_grp'])) {
	$name = $_POST['name'];
function replaceAll($text) { 
    $text = strtolower(htmlentities($text)); 
    $text = str_replace(get_html_translation_table(), "-", $text);
    $text = str_replace(" ", "-", $text);
    $text = preg_replace("/[-]+/i", "-", $text);
    return $text;
}
replaceAll($name);
echo "$name";

	if(!empty($name)) {
		 $sql = "SELECT mail_grp_name FROM mail_grp_list WHERE mail_grp_name = '$name' ";
         $run_query = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon)); 
         if(mysqli_num_rows($run_query) > 0) {
            $error = "There is already a group with name '<b>$name</b>' in database..Choose other name";
         }
         else {
         	$sql = "INSERT INTO mail_grp_list (mail_grp_name) VALUES ('$name')";
             if(mysqli_query($dbcon, $sql) > 0) {
             	$table = "CREATE TABLE $name (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				email VARCHAR(50),
				reg_date TIMESTAMP)";
                if (mysqli_query($dbcon, $table)) {
				     $success = "Group '<b>$name</b>'' has been successfuly created.";
				} else {
				    echo "Error creating table: " . mysqli_error($dbcon);
				}
               
             }
         }
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

    if(empty($success)) {
    echo '<style type="text/css">
           #success {
                display: none;
           }
           </style>';
    }
   ?>

   <!-- ================= html for navigation bar =============================== -->

<div class="container-fluid">
    <div class="btn-group btn-group-justified">
        <a href="index.php" class="btn btn-primary ">Send Mail</a>
        <a href="add-mail.php" class="btn btn-primary ">Add Mail</a>
        <a href="#" class="btn btn-primary active">Create New Mail Group</a>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $username ?> <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="logout.php">Logout</a></li>
              <li><a href="#"></a></li>
            </ul>
        </div>
    </div>
</div><br /><br />

<!-- ******************** ======================== html for group name box ====================== ***************** -->

<div class="container">
  <div class="form-group well col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
      <h2 class="text-center"><kbd>Start a new Group</kbd></h2>
<p class="text-center" style="color: #FF4A56">" White Space is not allowed in group name "</p>
 <br />
       <!-- alert for danger =========== -->
       <div class="alert alert-danger" id="error">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="text-center"><?php echo $error; ?></p>
       </div>
       <!-- alert for success ============== -->
       <div class="alert alert-success" id="success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="text-center"><?php echo $success; ?></p>
       </div>
      <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		       <label for="usr">Group Name :</label>
		       <input type="text" class="form-control input-lg" id="usr" placeholder="Enter group name" name="name" value="<?php echo $sgn_name; ?>"  required/>
		  </div>
        <button type="submit" class="btn btn-primary btn-lg col-sm-offset-5 col-sm-2" name="add_grp">Start Group</button>
      </form> </div><br />
  </div><br />
</div>


  </body>
  </html>


