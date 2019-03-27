<?php
include "utilities.php";
include "testingSMS.php";

function genRandomCode(){
    $digits = 5;
    return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
}

$errorMessage = null;
if(isset($_GET["action"]) && $_GET["action"]=="requestSMS"){
    if(isset($_POST["phone_number"]) && $_POST["phone_number"]!==""){
        if(!is_numeric($_POST["phone_number"])){
            echo json_encode(["result" => "stringPhone"]);
        }
        else{
            if(loggedIn()) {
                $code = genRandomCode();
                $dbconn = dbconn();
                $stmt = $dbconn->prepare("INSERT INTO SMSCode (email,smsCode,phoneNumber) VALUES (?,?,?) ON DUPLICATE KEY UPDATE smsCode = ?, phoneNumber = ?");
                $stmt->bind_param("sssss", $_SESSION["email"], $code,$_POST["phone_number"],$code,$_POST["phone_number"]);
                $stmt->execute();
                sendSMSCode($_POST["phone_number"], $code);
                echo json_encode(["result" => "smsSent"]);
                die();
            }
            else{
                echo json_encode(["result" => "notLoggedIn"]);
            }
        }
    }
    else{
        echo json_encode(["result" => "invalidForm"]);
    }
    die();
}
if(isset($_GET["action"]) && $_GET["action"]=="sendCode"){
    if(isset($_POST["sent_code"]) && $_POST["sent_code"]!==""){
        if(!is_numeric($_POST["sent_code"])){
            echo json_encode(["result" => "stringCode"]);
        }
        else{
            if(loggedIn()) {
                $code = genRandomCode();
                $dbconn = dbconn();
                $stmt = $dbconn->prepare("SELECT phoneNumber FROM SMSCode WHERE smsCode = ? AND email = ?");
                $stmt->bind_param("ss", $_POST["sent_code"],$_SESSION["email"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $phoneNumber = $row["phoneNumber"];
                    $stmt = $dbconn->prepare("UPDATE UserInfo SET mobile_number = ? WHERE email = ?");
                    $stmt->bind_param("ss", $phoneNumber,$_SESSION["email"]);
                    $stmt->execute();
                    echo json_encode(["result" => "success"]);
                }
                else{
                    echo json_encode(["result" => "invalid"]);
                }
                die();
            }
            else{
                echo json_encode(["result" => "notLoggedIn"]);
            }
        }
    }
    else{
        echo json_encode(["result" => "invalidForm"]);
    }
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title>Co-Rider</title>

    <link rel="icon" sizes="192x192" href="img/car.png" />
    <link rel="apple-touch-icon" href="img/car.png" />
    <link rel="shortcut icon" href="img/car.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Normalize.css"/>
    <link rel="stylesheet" type="text/css" href="StyleSheet.css"/>
</head>
<body class="intro_styling_login">
<video autoplay muted loop id="introVideo">
    <source src="img/video2.mp4" type="video/mp4">
</video>

<div id = "sign_up">
    <form method="post" id="sign_up_form" class="form-horizontal" action="Index.php?action=logIn">
        <h1>Enter Phonenumber</h1><br>
        <div class="col-xs-12 col-sm-12">
            <div class="form-group string required">
                <input name="phone_number" id="phone_number"  type="number" class="form-control" placeholder="Phone Number">
            </div>
        </div>
        <div style="display:none" id="invalid" class="alert alert-warning"></div>
        <input type="submit" id="numberSubmit" value="Request SMS Code">
    </form>
    <div id="sendCodeForm" style="display:none">
    <form method="post" id="sendCode" class="form-horizontal" action="Index.php?action=logIn">
        <h1>Enter Code</h1><br>
        <div class="col-xs-12 col-sm-12">
            <div class="form-group string required">
                <input name="sent_code" id="sent_code"  type="number" minlength="5" maxlength="5" class="form-control" placeholder="Code">
            </div>
        </div>
        <div style="display:none" id="invalidCode" class="alert alert-warning"></div>
        <input type="submit" id="codeSubmit" value="Request SMS Code">
    </form>
    </div>
</div>
</body>

<footer>


    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Our own Plugins -->
    <script src="Controller.js"></script>
    <script>
        $(document).ready(function(){
            $( "#sign_up_form" ).on( "submit", function( event ) {
                event.preventDefault();
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        result = JSON.parse(this.responseText);
                        console.log(result);
                        if(result.result=="smsSent"){
                            document.getElementById("invalid").style.display="none";
                            document.getElementById("numberSubmit").style.display="none";
                            document.getElementById("sendCodeForm").style.display="block";
                        }
                        else {
                            document.getElementById("invalid").style.display="block";
                            document.getElementById("invalid").innerText=result.result;
                            if (result.result == "invalid") {
                                document.getElementById("invalid").innerText = "Invalid Email / Password Combination";
                            }
                            if (result.result == "invalidForm") {
                                document.getElementById("invalid").innerText = "Both Email and Password must be set";
                            }
                            if (result.result == "invalidEmail") {
                                document.getElementById("invalid").innerText = "Email must be valid";
                            }
                            if (result.result == "notLoggedIn") {
                                document.getElementById("invalid").innerText = "Not Logged In";
                            }
                        }
                    }
                };
                xhttp.open("POST", "SMSVerification.php?action=requestSMS", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send($(this).serialize());
            });

            document.getElementById("sendCode").addEventListener( "submit", function( event ) {
                event.preventDefault();
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        result = JSON.parse(this.responseText);
                        console.log(result);
                        if(result.result=="success"){
                            document.getElementById("invalidCode").style.display="none";
                            window.location.replace("Home.php");

                        }
                        else {
                            document.getElementById("invalidCode").style.display="block";
                            if (result.result == "invalidCode") {
                                document.getElementById("invalidCode").innerText = "Invalid Email / Password Combination";
                            }
                        }
                    }
                };
                xhttp.open("POST", "SMSVerification.php?action=sendCode", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send($(this).serialize());
            });


        });


        function receivedText(code){
            window.alert(code);
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    result = JSON.parse(this.responseText);
                    console.log(result);
                    if(result.result=="success"){
                        document.getElementById("invalidCode").style.display="none";
                        window.location.replace("Home.php");

                    }
                    else {
                        document.getElementById("invalidCode").style.display="block";
                        if (result.result == "invalidCode") {
                            document.getElementById("invalidCode").innerText = "Invalid Email / Password Combination";
                        }
                    }
                }
            };
            xhttp.open("POST", "SMSVerification.php?action=sendCode", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("sent_code=" + code);
        }


    </script>
</footer>
</html>