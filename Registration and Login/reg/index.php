<?php



include ('database_connection.php');
if (isset($_POST['formsubmitted'])) {
    $error = array();//Declare An Array to store any error message  
    if (empty($_POST['name'])) {//if no name has been supplied 
        $error[] = 'Please Enter a name ';//add to array "error"
      } else {
        $name = $_POST['name'];//else assign it a variable
      }


 if (empty($_POST['sap'])) {//if no sap has been supplied 
        $error[] = 'Please Enter SAP ID ';//add to array "error"
      } else {
         if(strlen($_POST['sap'])!=11)
        {
          $error[]='Please Enter correct SAP number';
        }
        else

        $SAP = $_POST['sap'];//else assign it a variable
      }


 if (empty($_POST['mob'])) {//if no mob has been supplied 
        $error[] = 'Please Enter Mobile Number ';//add to array "error"
      } else {
        if(strlen($_POST['mob'])!=10)
        {
          $error[]='Please Enter correct mobile number';
        }
        else

        $Mob = $_POST['mob'];//else assign it a variable
      }



      if (empty($_POST['e-mail'])) {
        $error[] = 'Please Enter your E-mail ';
      } else {


        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['e-mail'])) {
           //regular expression for email validation
          $Email = $_POST['e-mail'];
        } else {
         $error[] = 'Your E-Mail Address is invalid  ';
       }


     }


     if (empty($_POST['Password'])) {
      $error[] = 'Please Enter Your Password ';
    } else {
      $Password = $_POST['Password'];
    }

    $Dept=$_POST['Dept'];
    $Year=$_POST['Year'];
  	$College=$_POST['College'];
  
   

    if (empty($error)) //send to Database if there's no error '

    { // If everything's OK...

        // Make sure the email address is available:
    $query_verify_email = "SELECT * FROM members  WHERE Email ='$Email'";
    $result_verify_email = mysqli_query($dbc, $query_verify_email);
        if (!$result_verify_email) {//if the Query Failed ,similar to if($result_verify_email==false)
          echo ' Database Error Occured ';
        }


$query_verify_sap = "SELECT * FROM members  WHERE SAP ='$SAP'";
    $result_verify_sap = mysqli_query($dbc, $query_verify_sap);
        if (!$result_verify_sap) {//if the Query Failed ,similar to if($result_verify_sap==false)
          echo ' Database Error Occured ';
        }




        if (mysqli_num_rows($result_verify_email) == 0 && mysqli_num_rows($result_verify_sap) == 0) { // IF no previous user is using this email or sap .


            // Create a unique  activation code:
          $activation = md5(uniqid(rand(), true));


          $query_insert_user = "INSERT INTO `members` ( `Username`, `Email`, `Password`,`Dept`,`Year`,`SAP`,`Mob`,`College`,`Activation`) VALUES ( '$name', '$Email', '$Password','$Dept','$Year','$SAP','$Mob','$College','$activation')";
         

          $result_insert_user = mysqli_query($dbc, $query_insert_user);
          if (!$result_insert_user) {
            echo 'Query Failed ';
          }

            if (mysqli_affected_rows($dbc) == 1) { //If the Insert Query was successfull.


                // Send the email:
              $message = " To activate your account, please click on this link:\n\n";
              $message .= WEBSITE_URL . '/activate.php?email=' . urlencode($Email) . "&key=$activation";
              mail($Email, 'Registration Confirmation', $message, 'From: djtrinity@gmail.com');




    




                // Flush the buffered output.


                // Finish the page:
echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">×</button>Thank you for
registering! A confirmation email
has been sent to '.$Email.' Please click on the Activation Link to Activate your account </div>';


            } else { // If it did not run OK.
              echo '<div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>You could not be registered due to a system
              error. We apologize for any
              inconvenience.</div>';
            }

        } else { // The email address is not available.
          echo '<div class="alert alert-dismissable alert-danger">
          <button type="button" class="close" data-dismiss="alert">×</button>That email
          address or SAP ID has already been registered.
        </div>';
      }

    } else {//If the "error" array contains error msg , display them



    echo '<div class="alert alert-dismissable alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button> <ol>';
    foreach ($error as $key => $values) {

      echo '	<li>'.$values.'</li>';



    }
    echo '</ol></div>';

  }
  
    mysqli_close($dbc);//Close the DB Connection

} // End of the main Submit conditional.



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Registration Form</title>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->




    </head>
    <body>
    <br><br>

     
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <br>
      <br>

      <form action="index.php" method="post" class="form-horizontal">
        <fieldset>
          <legend><center><u><b>Registration Form</b></u></legend></center>
          <br>
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Name:</label>
            <div class="col-lg-8">
              <div class="input-group">
                <input type="text" class="form-control" id="name" name="name" size="235" placeholder="Enter your full name.">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span></div>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">E-mail:</label>
              <div class="col-lg-8">
                <div class="input-group">

                  <input type="email" class="form-control" id="e-mail" name="e-mail" size="235" placeholder="Enter Email ID.">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span></div>
                </div>
              </div>


               <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">SAP ID:</label>
              <div class="col-lg-8">
                <div class="input-group">

                  <input type="number" class="form-control" id="sap" name="sap" size="235" placeholder="Enter your SAP ID.">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span></div>
                </div>
              </div>





              <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label">Password:</label>
                <div class="col-lg-8">
                  <div class="input-group">
                    <input type="password" class="form-control" id="Password" name="Password" size="25" placeholder="Enter Password.">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-certificate"></span></span></div>
                  </div>
                </div>



                   <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Mobile No:</label>
              <div class="col-lg-8">
                <div class="input-group">

                  <input type="number" class="form-control" id="mob" name="mob" size="10" placeholder="Enter your mobile no.">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span></div>
                </div>
              </div>




            <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">College:</label>
            <div class="col-lg-8">
              <div class="input-group">
                <input type="text" class="form-control" id="College" name="College" size="235" placeholder="Enter college name.">
                <span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span></div>
              </div>
            </div>
<!--
 			<div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Year:</label>
            <div class="col-lg-8">
              <div class="input-group">
                <input type="text" class="form-control" id="Year" name="Year" size="235" placeholder="Eg: Second Year">
                <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span></div>
              </div>
            </div>


-->


           <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Dept:</label>
      <div class="col-lg-7">
        <select class="form-control" id="Dept" name="Dept">
          <option value="IT">Information Technology</option>
          <option value="COMPS">Computer Engineering</option>
          <option value="EXTC">Electronics and Telecommunication Engineering</option>
          <option value="ELEX">Electronics Engineering</option>
          <option value="MECH">Mechanical Engineering</option>
          <option value="CHEM">Chemical Engineering</option>
          <option value="BIOPROD">Bio-Prod Engineering</option>
          <option value="OTHER">Other</option>
           <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span></div>
        </select>
        </div>
       </div>





       <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Year:</label>
      <div class="col-lg-7">
        <select class="form-control" id="Year" name="Year">
          <option value="First Year">First Year</option>
          <option value="Second Year">Second Year</option>
          <option value="Third Year">Third Year</option>
          <option value="Fourth Year">Fourth Year</option>
           <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span></div>
        </select>
        </div>
       </div>





                <center>
                  <br>
                  <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span>&nbspReset</button>&nbsp&nbsp&nbsp
                  <input type="hidden" name="formsubmitted" value="TRUE" />
                  <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span>&nbsp&nbspSubmit</button></center>
                  <br>
                  <br>
                </div>
              </div>
            </fieldset>
          </form>
        </div>


        <div class="col-md-3"></div>


        <br><br>
       

       
        <br><br>





        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
      </body>
      </html>
