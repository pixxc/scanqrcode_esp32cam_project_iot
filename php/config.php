<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "qrcodeweb";

$con = mysqli_connect("localhost","root","","qrcodeweb");

if (mysqli_connect_errno()){
    die ("Couldn't connect" . mysqli_connect_error());
}

?>