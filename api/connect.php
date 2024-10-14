<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "voting";

// Create connection
$connect = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>