<?php include 'links.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>SIGN UP</title>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <?php include 'links.php'; ?>
   
    
</head>
<body>
     <form action="" method="post">
     	<h2>Create an account</h2>

        
         <?php
         
         include 'dbconnection.php'; 
         
         if (isset($_POST['submit'])) { 
             $name = mysqli_real_escape_string($connection , $_POST['name']);
             $email = mysqli_real_escape_string($connection , $_POST['email']);
             $password = mysqli_real_escape_string($connection , $_POST['password']);
             $rpassword = mysqli_real_escape_string($connection ,$_POST['rpassword']);

             $enc_password = password_hash($password, PASSWORD_BCRYPT);
             $enc_rpassword = password_hash($rpassword, PASSWORD_BCRYPT);

             $token= bin2hex(random_bytes(20));

             $equery = "select * from registration where email='$email'";
             $emailquery= mysqli_query($connection,$equery);
             $ecount= mysqli_num_rows($emailquery);
             if($ecount>0)
             {
                echo '<script>alert("Email ID already in use!")</script>';
             }else{
                 if($password === $rpassword){
                  $iquery= "Insert into registration(name, email, password, rpassword, token, status) values ('$name','$email','$enc_password',
                           '$enc_rpassword', '$token','Inactive')";
                  $insertquery = mysqli_query($connection,$iquery);
                  if($insertquery)
                  {
                       $subject = "Email Verification";
                       $body = "Dear $name, click on this link to activate your account
                       http://localhost/project2/active.php?token=$token";
                       $sentby = "From: prashoo00n@gmail.com";

                       mail($email, $subject, $body, $sentby);
                     
                       if (mail($email, $subject, $body, $sentby)) {
                        $_SESSION['message'] = "Please find verification link sent on your email address $email";
                        header('location:active.php');
                        }
                        
                        else {
                           echo "Email sending failed...";  
                        }       
                }
                else
                {
                    echo '<script>alert("Insert operation failed!")</script>';
                }
                  
                }
                 else
                 {
                    echo '<script>alert("Re-entered password does not match the password")</script>';
                 }
             }


         }
             ?>
     	
    
          <label>Enter Name</label>
          <?php if (isset($_GET['name'])) { ?>
               <input type="text" 
                      name="name" 
                      placeholder="Name"
                      value="<?php echo $_GET['name'];  ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="name" 
                      placeholder="Name" required><br>
          <?php }?>

          <label>Enter Email</label>
          <?php if (isset($_GET['email'])) { ?>
               <input type="text" 
                      name="name" 
                      placeholder="Email"
                      value="<?php echo $_GET['email']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="email" 
                      placeholder="Email" required><br>
          <?php }?>


     	<label>Enter Password</label>
     	<input type="password" 
                 name="password" 
                 placeholder="Password" required><br>

          <label>Re-Enter Password</label>
          <input type="password" 
                 name="rpassword" 
                 placeholder="Re_Password" required><br>

     	<button type="submit" name="submit">Sign Up</button>
          <p class="already"> Already have an account?<a href= 'login.php'> Log In</a></p>
     </form>
</body>
</html>

