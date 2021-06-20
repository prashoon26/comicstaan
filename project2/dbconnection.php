<?php

$server= "127.0.0.1";
$user= "root";
$password = "";

$dbname = "signup";

$connection = mysqli_connect($server, $user, $password, $dbname);

if ($connection) {
    echo '<script>alert("Connection successful!")</script>';
}
else
{
    echo '<script>alert("Connection failed!")</script>';
}
?>