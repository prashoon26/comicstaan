<?php 

 //session_start(); 

include 'dbconnection.php'; 

$r = rand(1,1000);
$json_string = file_get_contents("https://xkcd.com/${r}/info.0.json"); 

$json_array=json_decode($json_string, true);

$link =  $json_array["img"]; //link of image

//downloading image
$url_to_image = $link;
$my_save_dir = 'C:\comics/';
$filename = basename($url_to_image);
$complete_save_loc = $my_save_dir . $filename;

file_put_contents($complete_save_loc, file_get_contents($url_to_image));

//start of mail with attachment
//$emailq = "select email from registration";
//$query = mysqli_query($connection,$emailq);

if(isset($_GET['email']))
{
$to = $_GET['email'] ; 
$from = 'prashoo00n@gmail.com'; 
$fromName = 'Prashoon'; 
$subject = 'Comic';  
 
// Attachment file 
$file = $complete_save_loc;

// Email body content 
$htmlContent = '<h3>Comic</h3> <p>This email is sent from the PHP script with attachment. </p>
<img src = "$complete_save_loc"> '; 

$headers = "From: $fromName"." <".$from.">"; 

$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  

if(!empty($file) > 0){ 
  if(is_file($file)){ 
      $message .= "--{$mime_boundary}\n"; 
      $fp =    @fopen($file,"rb"); 
      $data =  @fread($fp,filesize($file)); 

      @fclose($fp); 
      $data = chunk_split(base64_encode($data)); 
      $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
      "Content-Description: ".basename($file)."\n" . 
      "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
      "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
  } 
}
 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 

$mail = mail($to, $subject, $message, $headers, $returnpath);

if($mail)
{
  echo "<h1>You have been subscribed! You'll receive a new comic every 5 minutes</h1>";
  echo "<h2>Click here to unsubscribe: </h2>"; ?>
<html>
<form action="" method="post">
<input type="submit" name="Unsub" value="Unsubscribe"> </input>
</html>

    <?php
} 
if (!$mail)
{
echo  'Mail not sent';
}

if(isset($_POST['Unsub']))
{
$test = $to;
echo $to;
$updateactivity = "Update registration set status='inactive' where email='${test}'"; //SQL
$updateactivityquery = mysqli_query($connection,$updateactivity);
if($updateactivityquery)
{
  ob_end_clean();
  echo 'You have been Unsubscribed. Log in again to subscribe.';?>
 <html>
 <form action="login.php">
 <input type="submit" name="login" value="Login"> </input>
 </html>
 <?php 
}
else{
  echo 'still subscribed';
}
}
}

?>

<script>
//setTimeout(function () { window.location.reload(); }, 5*60*1000);

//document.write(new Date());
//</script>





