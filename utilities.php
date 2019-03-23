<?php
function dbconn()
{
$servername = "devweb2018.cis.strath.ac.uk";
$username = "cs317mada";
$password = "lu3Eengaewis";
$db = "cs317mada";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
return $conn;
}