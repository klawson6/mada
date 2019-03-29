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

if (isset($_GET["from"])) {
    $from = $_GET["from"];
} else {
    die("Route origin not given");
}
if (isset($_GET["to"])) {
    $to = $_GET["to"];
} else {
    die("Route destination not given");
}
if (isset($_GET["tod"])) {
    $tod = $_GET["tod"];
} else {
    die("Route ToD not given");
}


function getFname($emailToCheck)
{
    $host2 = "devweb2018.cis.strath.ac.uk";
    $user2 = "cs317mada";
    $pass2 = "lu3Eengaewis";
    $dbname2 = "cs317mada";

    $conn2 = new mysqli($host2, $user2, $pass2, $dbname2);

    if ($conn2->connect_error) {
        die("Connection failed : " . $conn2->connect_error); //FIXME remove once working
    }
//Issue the query
    $sql2 = 'SELECT * FROM `UserInfo`';
    $result2 = $conn2->query($sql2);

    if (!$result2) {
        die("Query failed ") . $conn2->error; //FIXME remove once working
    }

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) { // For each row in the links table
            if ($row2["email"] == $emailToCheck) { // If the users email is in this row
                return $row2["forename"];
            }
        }
    }
}

function getSname($emailToCheck)
{
    $host3 = "devweb2018.cis.strath.ac.uk";
    $user3 = "cs317mada";
    $pass3 = "lu3Eengaewis";
    $dbname3 = "cs317mada";

    $conn3 = new mysqli($host3, $user3, $pass3, $dbname3);

    if ($conn3->connect_error) {
        die("Connection failed : " . $conn3->connect_error); //FIXME remove once working
    }
//Issue the query
    $sql3 = 'SELECT * FROM `UserInfo`';
    $result3 = $conn3->query($sql3);

    if (!$result3) {
        die("Query failed ") . $conn3->error; //FIXME remove once working
    }

    if ($result3->num_rows > 0) {
        while ($row3 = $result3->fetch_assoc()) { // For each row in the links table
            if ($row3["email"] == $emailToCheck) { // If the users email is in this row
                return $row3["surname"];
            }
        }
    }
}



//Connect to MySQL
$host = "devweb2018.cis.strath.ac.uk";
$user = "cs317mada";
$pass = "lu3Eengaewis";
$dbname = "cs317mada";


$conn = new mysqli($host, $user, $pass, $dbname);

$fname = getFname($email);
$sname = getSname($email);

if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error); //FIXME remove once working
}


$sql = "INSERT INTO CurrentRides (Email, Source, Destination, ToD, CurrentLat, CurrentLng, Forename, Surname)
VALUES ('$email', '$from', '$to', '$tod', 0, 0, '$fname', '$sname')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


////Issue the query
//$sql = 'SELECT * FROM `CurrentRides`';
//$result = $conn->query($sql);
//
//if (!$result) {
//    die("Query failed ") . $conn->error; //FIXME remove once working
//}
//
////Handle the results
//
//if ($result->num_rows > 0) {
//    $pos = array();
//    while ($row = $result->fetch_assoc()) { // For each row in the links table
//        if ($row["Email"] == $email) { // If the users email is in this row
//            $pos[0] = $row["Source"];
//            $pos[1] = $row["Destination"];
//            $pos[2] = $row["ToD"];
//            $pos[3] = $row["CurrentLat"];
//            $pos[4] = $row["CurrentLng"];
//            $pos[5] = $row["Forename"];
//            $pos[6] = $row["Surname"];
//            echo json_encode($pos);
//        }
//    }
//}
////Disconnect
//$conn->close();
?>
