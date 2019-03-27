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

function authentication($email,$password){
    $dbconn = dbconn();
    $stmt = $dbconn->prepare("SELECT password FROM UserInfo WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $dbconn->close();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        if(password_verify($password,$row["password"])){
            return 1;
        }
    }
    return 0;
}

function loggedIn()
{
    if (!isset($_SESSION["email"]) && isset($_COOKIE["email"])) {

        $email = $_COOKIE["email"];
        $dbconn = dbconn();
        $stmt = $dbconn->prepare("SELECT email FROM UserInfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["email"] = $email;
            return True;
        }
    }
    else if(isset($_SESSION["email"])){
        return True;
    }
    return False;
}