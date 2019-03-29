<?php
include "utilities.php";
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 29/03/2019
 * Time: 01:51
 */

if (isset($_GET["email"])) {
    $email = $_GET["email"];
} else {
    die("User email not given");
}

$array = array();

$conn = dbconn();

$result = $conn->query("SELECT * FROM UserInfo WHERE email = '$email'");
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $forename = $row['forename'];
        $array[0] = $forename;
        $surname = $row['surname'];
        $array[1] = $surname;
    }
}

$imgResult = $conn->query("SELECT * FROM Photo WHERE email = '$email' LIMIT 1");
if ($imgResult->num_rows > 0){
    while ($rowImg = $imgResult->fetch_assoc()){
        $image = $rowImg['photo'];
        //echo base64_encode($image);
        $array[2] = base64_encode($image);
    }
}

$personality = getReviewAvg($email, "personality");
$cleanliness = getReviewAvg($email, "cleanliness");
$timeliness = getReviewAvg($email, "timeliness");
$driving = getReviewAvg($email, "drivingAbility");

$array[3] = $personality;
$array[4] = $cleanliness;
$array[5] = $timeliness;
$array[6] = $driving;

echo json_encode($array);

$conn->close();

