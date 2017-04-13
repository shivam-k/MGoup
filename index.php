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
$error = "";
$success = "";
  if(isset($_POST['send'])) {
      $msg = $_POST['msg'];
      $pass = $_POST['pass'];
      $sgn_name = $_POST['sgn_name'];
      $sgn_mbno = $_POST['sgn_mbno'];
      $sgn_email = $_POST['sgn_email'];
      $sgn_position = $_POST['sgn_position'];
      $mailto = $_POST['mailto'];
        echo "mailto = $mailto";
      if(!empty($msg) && !empty($pass) && !empty($sgn_name) && !empty($sgn_position) && !empty($mailto)) {
        // echo "<script>alert('not empty')</script>";
        if($pass == 'ask@shivam') {
          // echo "<script>alert('Correcr pass')</script>";
           $sql = "SELECT email FROM $mailto";
               $run_query = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon)); 
               if(mysqli_num_rows($run_query) > 0) {
                              $subject = 'NATIONAL STUDENT SPACE CHALLENGE 2016, IIT Kharagpur';
                              $headers = "From: " . "info@nssc.in" . "\r\n";
                              $headers .= "Reply-To: ". "info@nssc.in" . "\r\n";
                             // $headers .= "CC: shivamkumar30013@gmail.com\r\n";
                              $headers .= "MIME-Version: 1.0\r\n";
                              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                              $i = 0;
                   while($row = mysqli_fetch_assoc($run_query)) {
                               $email = $row['email'];
                               $to = $email;
                               $message = '<html><body>';
                               $message .= "<pre style='color: #333333; font-size: 15px; font-family: Arial, Helvetica, sans-serif;'> $msg </pre>";
                               $message .= "--<br />";
                               $message .= "<p style='margin-bottom: 0;background:linear-gradient(-135deg,white 15%,#4c4c4c 0%);color:white;display:inline-block;padding:5px 30px 5px 5px;font-weight:bold'>Thanks and Regards,</p>";
                               $message .= "<br /><br /><span style='color:rgb(71,71,71);font-family:&quot;Playfair Display&quot;,serif;font-size:25px'> $sgn_name </span>";
                               $message .= "<br /><span style='color:rgb(100,100,100);font-family:&quot;Josefin Slab&quot;,serif;font-size:12.8px'> $sgn_position </span>";
                               $message .= "<br /><img src='https://ci5.googleusercontent.com/proxy/pMnsFBGvXuIL62u40oDLNJEJ6DlDbDsNR_u7ZUajPG429rxF78hJ77h3rcvzWcyBapLoc8akgRjsN_VJTCeai-vvzfx8=s0-d-e1-ft#https://www.wescoturf.com/img/cms/telephone.png' style='font-size:12.8px;color:rgb(0,0,0);width:15px;height:15px'> <span style='margin-left: 10px'>$sgn_mbno</span>";
                               $message .= "<br /><img src='https://ci6.googleusercontent.com/proxy/TeNOI-fioCXxlzsmVr8iVtVFNl42gdyb2tUMcSqqMrMUmhwv_8Muc0FpKJ6e5NCABJSkXoaO5viKegv8ItBgbg2A6Kt8_BL7tUZ8OQrBxFtOraaWsova1g-bD_L9Kz4rjJz5PLkAV9s=s0-d-e1-ft#https://image.freepik.com/free-icon/black-back-closed-envelope-shape_318-53807.png' style='font-size:12.8px;color:rgb(0,0,0);width:15px;height:15px'> <span style='margin-left: 10px'>$sgn_email</span>";
                               $message .= "</body></html>";

                               $send_mail = mail($to,$subject,$message,$headers);
                               if($send_mail) {
                                  $i++;
                                  $emails[$i] = $email;
                               }
                  }
                           echo $i;
                           $success = "$i emails has been successfully sent.  <button type='button' class='btn btn-info active btn-md' data-toggle='modal' data-target='#myModal'>See List</button>";
                           ?>

                           <div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">You just mailed to these emails</h4>
							      </div>
							      <div class="modal-body">
							         <table class="table table-striped table-bordered ">
									    <thead>
									      <tr>
									        <th>S.No.</th>
									        <th>Email</th>
									      </tr>
									    </thead>
									    <tbody>
									        <?php
                                               for($y = 1; $y <= $i; $y++) {
                                               	  ?>
                                               	    <tr> 
                                               	      <td><?php echo $y; ?></td>
                                               	      <td><?php echo $emails[$y]; ?></td>
                                               	    </tr>
                                               	  <?php
                                               }
									        ?>
									    </tbody>
									 </table>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>

							  </div>
							</div>

                           <?php
               }  
        }
        else {
          // echo "<script>alert('Not correct password')</script>";
          $error = "Huh !! Not Correct Password";
        }
      }
      else {
        $error = "found empty box...make sure you have selected right option in last??";
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



<div class="container">
    <div class="btn-group btn-group-justified">
        <a href="#" class="btn btn-primary active">Send Mail</a>
        <a href="add-mail.php" class="btn btn-primary">Add Mail</a>
        <a href="make-group.php" class="btn btn-primary">Create New Mail Group</a>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $username ?> <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="logout.php">Logout</a></li>
              <li><a href="#"></a></li>
            </ul>
        </div>
    </div>
</div><br />
 <div class="container">
        <form role="form" method="POST">
           <h2 class="text-center"><kbd>Send Mail</kbd></h2> <br />
           <!-- alert for danger =========== -->

		           <div class="alert alert-danger" id="error">
		                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                <p class="text-center"><strong><?php echo $error; ?></strong></p>
		           </div>
		           <!-- alert for success ============== -->
		           <div class="alert alert-success" id="success">
		                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                <p class="text-center"><strong><?php echo $success; ?></strong></p>
		           </div>
		       
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		              <label for="pwd">Password :</label>
		              <input type="password" class="form-control input-lg" id="pwd" name="pass" placeholder="Enter password"  required/>
		           </div>
		      
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		               <label for="comment">Mail Content :</label>
		               <textarea class="form-control" id="comment" rows="10" id="comment" name="msg" placeholder="type your mail content here...you can use html tag"  required><?php echo $msg; ?></textarea>
		           </div>
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		                <label for="usr">Sendor's Name :</label>
		                <input type="text" class="form-control input-lg" id="usr" placeholder="Enter name" name="sgn_name" value="<?php echo $sgn_name; ?>"  required/>
		           </div>
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		                <label for="usr">Sendor's Position :</label>
		                <input type="text" class="form-control input-lg" id="usr" placeholder="Enter name" name="sgn_position" value="<?php echo $sgn_position; ?>"  required/>
		           </div>
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		                <label for="email">Sendor's Email :</label>
		                <input type="email" class="form-control input-lg" id="email" placeholder="Enter email" name="sgn_email" value="<?php echo $sgn_email; ?>"  required/>
		           </div>
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
		                <label for="number">Sendor's Mobile Number :</label>
		                <input type="number" class="form-control input-lg" id="number" placeholder="Enter mobile number with +91" name="sgn_mbno" value="<?php echo $sgn_mbno; ?>"  required/>
		           </div>
		           <div class="well form-group col-sm-offset-2 col-sm-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">
						  <label for="sel1">Select the option you want to send email to :</label>
						   <select class="form-control input-lg" id="sel1" style="cursor: pointer" name="mailto">
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
						                echo "Not Connecting to mail_grp_list database";
						             }
							    ?>
	                      </select>
					</div><br />
		            <button type="submit" class="btn btn-primary btn-lg col-sm-offset-4 col-sm-4" name="send">Send</button>
        </form>
</div>

<br /><br /><br /><br /><br />


  </body>

</html>