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
$clear = false;
$request = "norequest";
$response = "noresponse";
$drEmail = "";

if (isset($_GET["clear"])) {
    if ($_GET["clear"] == "clear") {
        $clear = true;
    }
} else {
    die("Clear param wrong!");
}

if (isset($_GET["response"])) {
    $response = $_GET["response"];
} else {
    die("response param wrong!");
}

if (isset($_GET["request"])) {
    $request = $_GET["request"];
} else {
    die("request param wrong!");
}

if (isset($_GET["drEmail"])) {
    $drEmail = $_GET["drEmail"];
} else {
    die("drEmail param wrong!");
}

if (isset($_GET["begin"])) {
    $begin = $_GET["begin"];
} else {
    die("Begin param wrong!");
}

if ($clear == true){
    if ($drEmail === ""){
        //Connect to MySQL
        $host = "devweb2018.cis.strath.ac.uk";
        $user = "cs317mada";
        $pass = "lu3Eengaewis";
        $dbname = "cs317mada";


        $conn = new mysqli($host, $user, $pass, $dbname);

        if ($conn->connect_error) {
            die("Connection failed : " . $conn->connect_error); //FIXME remove once working
        }


        $sql = "DELETE FROM CurrentRides WHERE email = '$email'";

        if ($conn->query($sql) === TRUE) {
            echo "Deleted ride successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        //Connect to MySQL
        $host = "devweb2018.cis.strath.ac.uk";
        $user = "cs317mada";
        $pass = "lu3Eengaewis";
        $dbname = "cs317mada";


        $conn = new mysqli($host, $user, $pass, $dbname);

        if ($conn->connect_error) {
            die("Connection failed : " . $conn->connect_error); //FIXME remove once working
        }


        $sql = "DELETE FROM CurrentRides WHERE email = '$drEmail'";

        if ($conn->query($sql) === TRUE) {
            echo "Deleted ride successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }


} else if ($response === "accept"){
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET Accepted = 1 WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Accepted field set as 1 successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else if ($response === "decline") {
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET RiderEmail = '', RiderLat = null, RiderLng = null WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Removed request from current ride";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else if ($request === "request"){
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET RiderEmail = '$email' WHERE email = '$drEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Accepted field set as 1 successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else if ($begin === "begin"){
    //Connect to MySQL
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs317mada";
    $pass = "lu3Eengaewis";
    $dbname = "cs317mada";


    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error); //FIXME remove once working
    }


    $sql = "UPDATE CurrentRides SET Begin = 1 WHERE email = '$drEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Accepted field set as 1 successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
