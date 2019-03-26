<?php

if (isset($_GET["email"])) {
    $email = $_GET["email"];
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
$sql = 'SELECT * FROM `LinkedUsers`';
$result = $conn->query($sql);

if (!$result) {
    die("Query failed ") . $conn->error; //FIXME remove once working
}

//Handle the results
// echo "<p>".$result->num_rows." rows found</p>";

if ($result->num_rows > 0) {
    $links = array();
    $rowCount = 0;
    while ($row = $result->fetch_assoc()) { // For each row in the links table
        if ($row["Email1"] == $email) { // If the users email is in this row
            if (!in_array($row["Email2"], $links)) { // If the associated other email in this row is not already in the links array
                $links[$rowCount] = $row["Email2"]; // Add the associated other email to the links array
                $rowCount++;
            }
        } else if ($row["Email2"] == $email) { // bi directional link
            if (!in_array($row["Email1"], $links)) {
                $links[$rowCount] = $row["Email1"];
                $rowCount++;
            }
        }
    }
    echo json_encode($links);
}
//Disconnect
$conn->close();
?>
