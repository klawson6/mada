<?php
/**
 * Created by IntelliJ IDEA.
 * User: nellieoliver
 * Date: 2019-03-27
 * Time: 11:59
 */
session_start();
include "utilities.php";

$choice = "rider";

if(!loggedIn()){
    header("Location: Index.php", true, 301);
    exit();
}
if(!validToken()){
    header("Location: Logout.php?token=invalid",true,301);
    die();
}

if(isset($_POST['unset'])){
    session_unset();
    session_destroy();
}


if(isset($_POST['update'])){
    if($_POST['update']==="yes"){
        $_SESSION["previous"] = $_SESSION["current"];
    }
    else if($_POST['update'] === "reset"){
        unset($_SESSION['previous']);
    }

    $user =selectUser($choice,$_SESSION["email"]);
    echo $user;
}

if(isset($_POST['rewind'])){
    if(isset($_SESSION["previous"])) {
        echo json_encode( $_SESSION["previous"]);

        unset($_SESSION['previous']);
    }else{
        $u = $_SESSION["current"] ;
        $u->name = "no";
        echo json_encode($u);
    }
}

if(isset($_POST['liked'])){
    addLinkedUser($_POST['liked'],$_SESSION["email"]);
}

if(isset($_POST['change'])){
    if($_POST['change'] == "driver"){
        $choice = "driver";
    }else{
        $choice = "rider";
    }
}

class User{
    public $email;
    public $name;
    public $age;
    public $coverImg;
    public $photo1;
    public $photo2;
    public $photo3;
    public $photo4;
    public $bio;
    public $cleanliness;
    public $personality;
    public $timeliness;
    public $drivingAbility;
    };



function addLinkedUser($user,$email){

    $conn = dbconn();
    $sql = "INSERT INTO LinkedUsers (Email1, Email2) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$email,$user);

    $stmt->execute();
}


function getAllUsers($choice,$email){
    $dbconn = dbconn();

    $innersql1 = "email NOT IN (SELECT Email1 FROM LinkedUsers WHERE '".$email . "' = Email1)";
    $innersql2 = "email NOT IN (SELECT Email2 FROM LinkedUsers WHERE '". $email."' = Email2)";

    $sql = "SELECT * FROM UserInfo WHERE Rider = 1 AND email <> '" .$email ."' AND ". $innersql1 . " AND " . $innersql2;


    if($choice == "driver"){
        $sql = "SELECT * FROM UserInfo WHERE Driver = 1 AND email <> '" .$email ."' AND ". $innersql1 . " AND " . $innersql2;
    }

    $result = $dbconn->query($sql);
    $users = array();
    $user = new User();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $user->name = $row["forename"]." ".$row["surname"];
            $user->bio = $row["bio"];
            $today = new DateTime();
            $dob = new DateTime($row["date_of_birth"]);
            $difference = ($today->diff($dob));
            $user->age = $difference->format('%y');
            $user->email =  $row["email"];

            $user = getPhotos($user);
            $user = getReviews($user);

            array_push($users,$user);
            $user = new User();
        }
    }
    $dbconn->close();

    return $users;
}

function getReviews($user){

    $conn = dbconn();

            $avgCleanlinessRider = 0;
            $avgPersonalityRider = 0;
            $avgTimelinessRider = 0;

            $avgPersonalityDriver = 0;
            $avgCleanlinessDriver = 0;
            $avgTimelinessDriver = 0;

            //-----------
            //connect to get reviews
            $reviewDriver = $conn->query("SELECT * FROM reviewsAboutDrivers WHERE revieweeEmail = '" . $user->email . "'");
            if ($reviewDriver->num_rows > 0) {
                $totalPersonalityDriving = 0;
                $totalCleanlinessDriving = 0;
                $totalTimelinessDriving = 0;
                $totalDrivingAbility = 0;
                $i = 0;

                while ($reviewRow = $reviewDriver->fetch_assoc()) {
                    $totalPersonalityDriving += $reviewRow['personality'];
                    $totalCleanlinessDriving += $reviewRow['cleanliness'];
                    $totalDrivingAbility += $reviewRow['drivingAbility'];
                    $totalTimelinessDriving += $reviewRow['timeliness'];
                    $i++;
                }
                $avgPersonalityDriver = $totalPersonalityDriving / $i;
                $avgCleanlinessDriver = $totalCleanlinessDriving / $i;
                $avgTimelinessDriver = $totalTimelinessDriving / $i;
                $avgDrivingAbiityDriver = $totalDrivingAbility / $i;
                $user->drivingAbility = round($avgDrivingAbiityDriver);
            }

            $reviewRider = $conn->query("SELECT * FROM reviewsAboutRiders WHERE revieweeEmail = '" . $user->email . "'");
            if ($reviewRider->num_rows > 0) {
                $totalPersonalityRiding = 0;
                $totalCleanlinessRiding = 0;
                $totalTimelinessRiding = 0;
                $j = 0;
                while ($riderReviewRow = $reviewRider->fetch_assoc()) {
                    $totalPersonalityRiding += $riderReviewRow['personality'];
                    $totalCleanlinessRiding += $riderReviewRow['cleanliness'];
                    $totalTimelinessRiding += $riderReviewRow['timeliness'];
                    $j++;
                }
                $avgCleanlinessRider = $totalPersonalityRiding / $j;
                $avgPersonalityRider = $totalPersonalityRiding / $j;
                $avgTimelinessRider = $totalTimelinessRiding / $j;
            }

            $finalAvgClean = ($avgCleanlinessDriver + $avgCleanlinessRider) / 2;
            $user->cleanliness = round($finalAvgClean);

            $finalAvgPerson = ($avgPersonalityDriver + $avgPersonalityRider) / 2;
            $user->personality = round($finalAvgPerson);

            $finalAvgTime = ($avgTimelinessDriver + $avgTimelinessRider) / 2;
            $user->timeliness = round($finalAvgTime);

    return $user;
}

function getPhotos($user){
    $conn = dbconn();

    $photoStmt = $conn->query("SELECT * FROM Photo WHERE email = '".$user->email."'");
    $loop = 0;

    if($photoStmt->num_rows > 0) {
        while ($photoRow = $photoStmt->fetch_assoc()) {
            if($loop == 0){
                $user->coverImg = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
            }
            else if($loop == 1){
                $user->photo1 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
            }
            else if($loop == 2){
                $user->photo2 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
            }
            else if($loop == 3){
                $user->photo3 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
            }
            else if($loop == 4){
                $user->photo4 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
            }

            $loop++;
        }
        if($loop<1){
            $user->photo1 = null;
            $user->photo2 = null;
            $user->photo3 = null;
            $user->photo4 = null;
        }

        if($loop<2){
            $user->photo2 = null;
            $user->photo3 = null;
            $user->photo4 = null;
        }

        if($loop<3){
            $user->photo3 = null;
            $user->photo4 = null;
        }

        if($loop<4){
            $user->photo4 = null;
        }
    }
    return $user;
}

function selectUser($choice,$email){
    header('Content-Type: application/json');

    $users = getAllUsers($choice,$email);
    $index = floor(rand(0,sizeof($users)-1));
    $_SESSION["current"] =  $users[$index];
    $current = $users[$index];
    return json_encode($current);
}