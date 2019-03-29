<?php
include "utilities.php";

if (isset($_GET["email"])) {
    $email = $_GET["email"];
    if ($email === "SELF"){
        if (!loggedIn()) {
            header("Location: Index.php");
            die();
        }
        if (!validToken()) {
            header("Location: Logout.php?token=invalid");
            die();
        }

        $email = $_SESSION["email"];
    }
} else {
    die("User email not given");
}


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
$sql = 'SELECT * FROM `CurrentRides`';
$result = $conn->query($sql);

if (!$result) {
    die("Query failed ") . $conn->error; //FIXME remove once working
}

//Handle the results

if ($result->num_rows > 0) {
    $pos = array();
    while ($row = $result->fetch_assoc()) { // For each row in the links table
        if ($row["Email"] == $email) { // If the users email is in this row
            $pos[0] = $row["Source"];
            $pos[1] = $row["Destination"];
            $pos[2] = $row["ToD"];
            $pos[3] = $row["CurrentLat"];
            $pos[4] = $row["CurrentLng"];
            $pos[5] = $row["Forename"];
            $pos[6] = $row["Surname"];
            $pos[7] = $row["RiderEmail"];
            $pos[8] = $row["RiderLat"];
            $pos[9] = $row["RiderLng"];
            $pos[10] = $row["Accepted"];
            $pos[11] = $row["Begin"];

            echo json_encode($pos);
        }
    }
}
//Disconnect
$conn->close();
?>
