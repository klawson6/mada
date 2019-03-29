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

function getUserName($email){
    $dbconn = dbconn();
    $stmt = $dbconn->prepare("SELECT forename, surname FROM UserInfo WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row["forename"] . " " . $row["surname"];
    }
    $dbconn->close();
    return null;
}

function user_exists($email){
    $dbconn = dbconn();
    $stmt = $dbconn->prepare("SELECT email FROM UserInfo WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $dbconn->close();
        return 1;
    }
    $dbconn->close();
    return 0;
}

function validToken(){
    $dbconn = dbconn();
    if(isset($_COOKIE["smsCode"])){
        $stmt = $dbconn->prepare("SELECT email FROM SMSCode WHERE email = ? AND smsCode = ?");
        $stmt->bind_param("ss", $_SESSION["email"],$_COOKIE["smsCode"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return True;
        }
    }
    return False;
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

function getReviewAvg($email, $reviewType){

    $dbconn = dbconn();

    $avgRider = 0;
    $avgDriver = 0;
    $divi = 0;

    $reviewDriver = $dbconn->query("SELECT * FROM reviewsAboutDrivers WHERE revieweeEmail = '" . $email . "'");

    if ($reviewDriver->num_rows > 0) {

        $totalDriving = 0;
        $i = 0;

        while ($rr = $reviewDriver->fetch_assoc()) {
            $totalDriving += $rr[$reviewType];
            $i++;
        }

        $avgDriver = $totalDriving / $i;

        if ($reviewType == "drivingAbility"){
            return round($avgDriver);
        }
        $divi++;
    }

    $reviewRider = $dbconn->query("SELECT * FROM reviewsAboutRiders WHERE revieweeEmail = '" . $email . "'");
    if ($reviewRider->num_rows > 0) {
        $totalRider = 0;
        $j = 0;

        while ($reviewRow = $reviewRider->fetch_assoc()) {
            $totalRider += $reviewRow[$reviewType];
            $j++;
        }
        $avgRider = $totalRider / $j;
        $divi++;
    }

    if ($divi > 0){
        $finalAvg = ($avgDriver + $avgRider) / $divi;

        return round($finalAvg);
    } else {
        return 0;
    }
}