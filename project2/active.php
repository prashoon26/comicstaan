<!DOCTYPE html>
<html>
<head>
	<title>ActivateP</title>
</head>
<body style:"background-color:red;">
<?php 
 
session_start();
include 'dbconnection.php';
echo "<p align='center'> <font color=blue align='center' size='5pt'> Please find verification link sent on your email address and use the same to log in. </font> </p>";

if(isset($_GET['token'])){
 $token=$_GET['token'];
 $update = "Update registration set status='active' where token='$token'"; //SQL
 $updatequery = mysqli_query($connection,$update);
 if($updatequery)
 {
  if(isset($_SESSION['message']))
  {
    $_SESSION['message']="Account activated";
    header('location:login.php');
    $_SESSION['msg']=NULL;
  }
  else {
    {
        $_SESSION['message']="Logged out"; //if session variable does not
        header('location:login.php');
        $_SESSION['msg']=NULL;
      }
  }
}
  else{
    $_SESSION['message']="Account not activated";
    header('location:registration.php');
    $_SESSION['msg']=NULL;
  }
}

 
 ?>
 </body>
 </html>
