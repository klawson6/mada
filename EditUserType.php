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
if (isset($_GET["type"])) {
    $type = $_GET["type"];
} else {
    die("Type not given");
}
$email = $_SESSION["email"];

$host = "devweb2018.cis.strath.ac.uk";
$user = "cs317mada";
$pass = "lu3Eengaewis";
$dbname = "cs317mada";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error); //FIXME remove once working
}
//Issue the query
$sql = 'SELECT * FROM `UserInfo`';
$result = $conn->query($sql);

if (!$result) {
    die("Query failed ") . $conn->error; //FIXME remove once working
}

if ($type == "Rider"){
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { // For each row in the links table
            if ($row["email"] == $email) { // If the users email is in this row
                $sql = "UPDATE UserInfo SET $type = 1 WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    echo "Rider field changed successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            }
        }
    }
} else if ($type == "Driver"){
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { // For each row in the links table
            if ($row["email"] == $email) { // If the users email is in this row
                $sql = "UPDATE UserInfo SET $type = 1 WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    echo "Driver field changed successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $sql = "UPDATE UserInfo SET OfferingRides = 1 WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    echo "OfferingRides field changed successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            }
        }
    }
} else {
    die("Valid type not given");
}


?>