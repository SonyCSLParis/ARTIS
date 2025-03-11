<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL | E_STRICT);
ini_set('session.gc_maxlifetime', 36000);

// each client should remember their session id for EXACTLY 1 hour
//session_set_cookie_params(36000);
$base_dir = "/artis/";

$url_python="http://93.147.158.9:5002/";


function connetti($QRY){
$mysqli = new mysqli('192.168.1.150', 'usr_remote', '4sr0m4-2001', 'artisdb');

// Oh no! A connect_errno exists so the connection attempt failed!
if ($mysqli->connect_errno) {
    // The connection failed. What do you want to do? 
    // You could contact yourself (email?), log the error, show a nice page, etc.
    // You do not want to reveal sensitive information

    // Let's try this:
    echo "Sorry, this website is experiencing problems.";

    // Something you should not do on a public site, but this example will show you
    // anyways, is print out MySQL error related information -- you might log this
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    
    // You might want to show them something nice, but we will simply exit
    exit;
}
$rs = mysqli_query($mysqli,$QRY);
if (!$rs){
  	echo("Error description: " . mysqli_error($mysqli));
  }else{
	
	return $rs;
  }
}





?>