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




<!-- ************************* ================= PHP for get right button ========================== ******************** -->

<?php
$error_grp = "";
$success_grp = "";
if(isset($_POST['get_right'])) {
  $grp_list = $_POST['grp_list'];
  if(!empty($grp_list)) {
    $success_grp = "grp_list = $grp_list";
    $_SESSION["grp_list"] = $grp_list;

  }
  else {
    $error_grp = "Please select atleast one group";
    $_SESSION["grp_list"] = "";
  }
}
else {
}

?>

<?php
$result_list = $_SESSION["grp_list"];
if(empty($result_list)) {
	$result_list = "";
	echo '<style type="text/css">
           #grp_info {
                display: none;
           }
           </style>';
}
else {
	
}

?>

<!-- ************************* ================= PHP for get send button ========================== ******************** -->

<?php
   $error = "";
   $success = "";
   if(isset($_POST['send'])) {
    $email = $_POST['email'];
    if(!empty($email)) {
    	if($result_list == 'subscriber' || $result_list == 'register') {  
            $error = "<b>' Shivam '</b> does not give you right to add emails in this list";
    	}
       else {	
          $sql = "SELECT * FROM `$result_list` WHERE `email` = '$email'";
          $run_query = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon)); 
          if(mysqli_num_rows($run_query) > 0) {
              $error = "<b>$email</b> is already in  <b>$result_list</b> group..";
          }
          else {
             // echo "good to go";
             $sql = "INSERT INTO `$result_list` (`email`) VALUES ('$email')";
             if(mysqli_query($dbcon, $sql) > 0) {
                $success = "<b>$email</b> has been successfuly saved $result_list group.";
             }
          }
      }
   }
    else {
      $error = "<b>Empty box</b>...Are you kidding me??";
    }

  
     
   }

?>

<!-- ********************** ========= PHP for error and success message ========= ****************** -->

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
    if(empty($error_grp)) {
    echo '<style type="text/css">
           #error_grp {
                display: none;
           }
           </style>';
    }

    if(empty($success_grp)) {
    echo '<style type="text/css">
           #success_grp {
                display: none;
           }
           </style>';
    }

?>


<!-- ================= html for navigation bar =============================== -->

<div class="container-fluid">
    <div class="btn-group btn-group-justified">
        <a href="index.php" class="btn btn-primary ">Send Mail</a>
        <a href="#" class="btn btn-primary active">Add Mail</a>
        <a href="make-group.php" class="btn btn-primary">Create New Mail Group</a>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $username ?> <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="logout.php">Logout</a></li>
              <li><a href="#"></a></li>
            </ul>
        </div>
    </div>
</div><br /><br />



<!-- ==================== selecting option for group of emails =============== -->

<div class="container">
  <div class="form-group well col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
      <h2 class="text-center"><kbd>List of all groups</kbd></h2> <br />
       <!-- alert for danger =========== -->
       <div class="alert alert-danger" id="error_grp">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="text-center"><?php echo $error_grp; ?></p>
       </div>
       <!-- alert for success ============== -->
       <div class="alert alert-success" id="success_grp">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="text-center"><?php echo $success_grp; ?></p>
       </div>
      <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <label for="sel1">Select the group name :</label>
           <select class="form-control input-lg" id="sel1" style="cursor: pointer" name="grp_list">
                <option value="0">Select Option</option>
              <?php
                     $sql = "SELECT mail_grp_name FROM mail_grp_list";
                     $run_query = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon)); 
                     if(mysqli_num_rows($run_query) > 0) {
                         while($row = mysqli_fetch_assoc($run_query)) {
                          $mail_grp_name = $row['mail_grp_name'];
                          ?>
                               <option value="<?php echo $mail_grp_name; ?>"><?php echo $mail_grp_name; ?></option>
                          <?php
                         }
                     }
                     else {
                        echo "Problem in connecting to mail_grp_list database";
                     }
              ?>
           </select><br />
        <button type="submit" class="btn btn-primary btn-md col-sm-offset-5 col-sm-2" name="get_right">Get the thing</button>
      </form> </div><br />
  </div><br />
</div>




<!-- ============================= html for getting right to edit after selecting group ========================= -->
  <div class="container" id="grp_info">
    <div class="well" style=" box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
      <h2 class="text-center"><kbd>Add emails in "<?php echo $result_list; ?>" group</kbd></h2>
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
      <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control input-lg" id="email" placeholder="Enter email" name="email" />
          </div>
           <button type="submit" class="btn btn-primary input-lg col-sm-2 col-sm-offset-5" name="send">Submit</button><br /><br />
      </form>
    </div>


    <!-- ===================== modal =========================== -->
  <div class="well" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-warning active btn-lg btn-block" data-toggle="modal" data-target="#myModal" name="show_emails" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">Click to see all emails in "<?php echo $result_list; ?>" group</button>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Emails in <?php echo $result_list; ?> group</h4>
        </div>
        <div class="modal-body">
                <table class="table table-striped table-bordered ">
                    <tr>
                      <th>S.no</th>
                      <th>Email</th>
                      <?php
                      if($result_list == 'testing') {
                          ?>
                              <th>Delete</th> 
                          <?php 
                      }
                      ?>
                    </tr>
                    <?php
                       $sql = "SELECT * FROM $result_list";
                       $run_query = mysqli_query($dbcon, $sql);
                       if(mysqli_num_rows($run_query)) {
                        while($row = mysqli_fetch_assoc($run_query)){
                          $id = $row['id'];
                          $email = $row['email'];
                          ?>
                              <tr>
                                <td><?php echo "<p style='font-family: Arial, Helvetica, sans-serif;'>$id</p>"; ?></td>
                                <td><?php echo "<p style='font-family: Arial, Helvetica, sans-serif;'>$email</p>"; ?></td>
                               <?php if($result_list == 'testing') { ?>  <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td> <?php } ?> 
                              </tr>

                          <?php
                        }
                       }
                    ?>
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</div>


</body>


</html>