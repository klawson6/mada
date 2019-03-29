<?php

include "utilities.php";

if (!loggedIn()) {
    header("Location: Index.php");
    die();
}
if (!validToken()) {
    header("Location: Logout.php?token=invalid");
    die();
}

$email = $_SESSION["email"];
$parEmail = "";
$lat = null;
$lng = null;
$type = "rider";

if (isset($_GET["email"])) {
    if ($_GET["email"] === "") {
        $parEmail = $email;
        $type = "driver";
    } else {
        $parEmail = $_GET["email"];
    }
} else {
    die("Email param wrong!");
}

if (isset($_GET["lat"])) {
    $lat = $_GET["lat"];
} else {
    die("Lat param wrong!");
}

if (isset($_GET["lng"])) {
    $lng = $_GET["lng"];
} else {
    die("Lng param wrong!");
}

if ($type === 'rider'){
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET RiderLat = '$lat', RiderLng = '$lng' WHERE email = '$parEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Updated rider loc successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else if ($type === 'driver'){
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET CurrentLat = '$lat', CurrentLng = '$lng' WHERE email = '$parEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Updated driver loc successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    die("BAD send of location");
}



?>
