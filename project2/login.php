<?php
session_start();

  include 'dbconnection.php'; 
  
if(isset($_POST['login']))
{

       $email= $_POST['email'];
       $password= $_POST['password'];
       
             $searchemail = "select * from registration where email='$email '";
             $emailquery= mysqli_query($connection,$searchemail);
             $emailcount= mysqli_num_rows($emailquery);
             if($emailcount>0)
             {
               $emailpass = mysqli_fetch_assoc($emailquery);
               $dbpass = $emailpass['password']; //pwd of $email
               $decodepass = password_verify($password,$dbpass); //checks if decoded regidtered password matches the entered pwd
            if($decodepass)
            {
                echo "Logged In Succesfully!";
                header("location:http://localhost/project2/attachment.php?email=${email}");
            }
            else{
                echo "Incorrect Password entered";
            }
            }
            else {
                echo "Email ID not registered. Please create an account.";
            }
            }
?>
<html>
   
   <head>

      <title>Login Page</title>
      <link rel='stylesheet' type='text/css' href='style.css' />
      <?php include 'links.php'; ?> 
      <body>
      <form action="" method="post">
     	<h2>Log In</h2>
        
          <label>Enter Email</label>
          <?php if (isset($_GET['uname'])) { ?>
               <input type="text" 
                      name="name" 
                      placeholder="Email"
                      value="<?php echo $_GET['uname']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="email" 
                      placeholder="Email" required><br>
          <?php }?>


     	<label>Enter Password</label>
     	<input type="password" 
                 name="password" 
                 placeholder="Password" required><br>

     	<button type="submit" name="login">Log In</button>
          <p class="already"> Don't have an account?<a href= 'registration.php'> Register Now </a></p>
     </form>
</body>
</html>

