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


//Connect to MySQL
$host = "devweb2018.cis.strath.ac.uk";
$user = "cs317mada";
$pass = "lu3Eengaewis";
$dbname = "cs317mada";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error); //FIXME remove once working
}
//Issue the query
$sql = 'SELECT * FROM `LinkedUsers`';
$result = $conn->query($sql);

if (!$result) {
    die("Query failed ") . $conn->error; //FIXME remove once working
}

//Handle the results

if ($result->num_rows > 0) {
    $links = array();
    $rowCount = 0;
    while ($row = $result->fetch_assoc()) { // For each row in the links table
        if ($row["Email1"] == $email && checkMutual($row["Email2"], $email)) { // If the users email is in this row
            if (!in_array($row["Email2"], $links)) {// If the associated other email in this row is not already in the links array
                $temp = $row["Email2"];
                $stmt = $conn->prepare("SELECT * FROM `UserInfo` WHERE email = ?"); // Request user rider/driver status of bi-directionally liked user
                $stmt->bind_param("s", $row["Email2"]);
                $stmt->execute();
                $result2 = $stmt->get_result(); // Get user rider/driver status of bi-directionally liked user
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row2["Driver"] && $row2["OfferingRides"]) { // If the bi-directionally liked user is a driver and is offering lifts
                            $links[$rowCount] = $row["Email2"]; // Add the associated other email to the links array
                            $rowCount++;
                        }
                    }
                }
            }
        } else if ($row["Email2"] == $email && checkMutual($row["Email1"], $email)) { // bi directional coverImg
            if (!in_array($row["Email1"], $links)) {// If the associated other email in this row is not already in the links array
                $temp = $row["Email1"];
                $stmt = $conn->prepare("SELECT * FROM `UserInfo` WHERE email = ?"); // Request user rider/driver status of bi-directionally liked user
                $stmt->bind_param("s", $row["Email1"]);
                $stmt->execute();
                $result2 = $stmt->get_result(); // Get user rider/driver status of bi-directionally liked user
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row2["Driver"] && $row2["OfferingRides"]) { // If the bi-directionally liked user is a driver and is offering lifts
                            $links[$rowCount] = $row["Email1"]; // Add the associated other email to the links array
                            $rowCount++;
                        }
                    }
                }
            }
        }
    }
//    $links[$rowCount] = $email;
    echo json_encode($links);
}

function checkMutual($emailToCheck, $email)
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
    $sql2 = 'SELECT * FROM `LinkedUsers`';
    $result2 = $conn2->query($sql2);

    if (!$result2) {
        die("Query failed ") . $conn2->error; //FIXME remove once working
    }

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) { // For each row in the links table
            if ($row2["Email1"] == $emailToCheck) { // If the users email is in this row
                if ($row2["Email2"] == $email){
                    return true;
                }
            } else if ($row2["Email2"] == $emailToCheck) { // bi directional coverImg
                if ($row2["Email1"] == $email){
                    return true;
                }
            }
        }
    }
    return false;
}
//Disconnect
$conn->close();
?>
