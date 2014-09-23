<?php
ob_start();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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
  

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>

</head>


<?php



include ('database_connection.php');
if (isset($_POST['formsubmitted'])) {
    // Initialize a session:
session_start();
    $error = array();//this array will store all error messages
  

    if (empty($_POST['e-mail'])) {//if the email supplied is empty 
        $error[] = 'You forgot to enter your E-mail ';
    } else {


        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['e-mail'])) {
           
            $Email = $_POST['e-mail'];
        } else {
             $error[] = 'Your E-Mail Address is invalid!  ';
        }


    }


    if (empty($_POST['Password'])) {
        $error[] = 'Please Enter Your Password ';
    } else {
        $Password = $_POST['Password'];
    }


       if (empty($error))//if the array is empty , it means no error found
    { 

       

        $query_check_credentials = "SELECT * FROM members WHERE (Email='$Email' AND password='$Password') AND Activation IS NULL";
   
        

        $result_check_credentials = mysqli_query($dbc, $query_check_credentials);
        if(!$result_check_credentials){//If the QUery Failed 
            echo 'Query Failed ';
        }

        if (@mysqli_num_rows($result_check_credentials) == 1)//if Query is successfull 
        { // A match was made.

           


            $_SESSION = mysqli_fetch_array($result_check_credentials, MYSQLI_ASSOC);//Assign the result of this query to SESSION Global Variable
           
            header("Location: page.php");
          

        }else
        { 
            
            $msg_error= 'Either Your Account is inactive or Email address /Password is Incorrect';
        }

    }  else {
        
        

echo '<br><br><div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button> <ol>';
        foreach ($error as $key => $values) {
            
            echo '	<li>'.$values.'</li>';


       
        }
        echo '</ol></div>';

    }
    
    
    if(isset($msg_error)){
        
        echo '<br><br><div class="lert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button><br>'.$msg_error.' <br><br></div>';
    }
    /// var_dump($error);
    mysqli_close($dbc);

} // End of the main Submit conditional.



?>
<body>

<br><br><br>

 <div class="col-md-3"></div>
  <div class="col-md-6">
  <br>
  <br>

<form action="login.php" method="post" class="form-horizontal">
  <fieldset>
    <legend><center><u><b>Log In</b></u></legend></center>
    <br>
    
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">E-mail:</label>
      <div class="col-lg-8">
      <div class="input-group">
        <input type="text" class="form-control" id="e-mail" name="e-mail" size="235" placeholder="Enter Email">
        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span></div>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password:</label>
      <div class="col-lg-8">
         <div class="input-group">
        <input type="password" class="form-control" id="Password" name="Password" size="25" placeholder="Enter Password">
          <span class="input-group-addon"><span class="glyphicon glyphicon-certificate"></span></span></div>
       
      </div>
    </div>
    <center>
    <br>
        <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span>&nbspReset</button>&nbsp&nbsp&nbsp
        <input type="hidden" name="formsubmitted" value="TRUE" />
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span>&nbsp&nbspLogin</button></center>
        <br>
        <br>
      </div>
    </div>
  </fieldset>
</form>
</div>
 

<div class="col-md-3"></div>



   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
