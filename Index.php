<?php
include "utilities.php";
$errorMessage = null;
if(isset($_GET["action"]) && $_GET["action"]=="logIn"){
    $email = null;
    $password = null;
    if(isset($_POST["email"]) && isset($_POST["password"]) && $_POST["email"]!=="" && $_POST["password"]!==""){
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
        }
        else{
            echo json_encode(["result" => "invalidEmail"]);
        }
        $password = $_POST["password"];
        if(authentication($email,$password)){
            setcookie("email", $_POST["email"], time() + (10 * 365 * 24 * 60 * 60));
            echo json_encode(["result" => "success"]);
        }
        else{
            //echo json_encode(["result" => "success"]);
            echo json_encode(["result" => "invalid"]);
        }
    }
    else{
        echo json_encode(["result" => "invalidForm"]);
    }
    die();
}
if(loggedIn()){
    header("Location: Home.php");
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
    <form method="post" id = "sign_up_form" class="form-horizontal" action="Index.php?action=logIn">
        <h1>Sign In</h1><br>
        <div class="col-xs-12 col-sm-12">
            <div class="form-group string required">
                <input name="email" id="email_input"  type="email" class="form-control" placeholder="Email Address">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12">
            <div class="form-group string required">
                <input name="password" id="password_input"  type="password" class="form-control" placeholder="Password">
            </div></div>
        <br>
        <div style="display:none" id="invalid" class="alert alert-warning"></div>
        <button id="sign_up_button" class="btn btn-lg btn-inverse btn-block" value="LOGIN"  type="submit">
            Sign In
        </button>
    </form>
    <form action="Register.php" >
        <button id="register_button" class="btn btn-lg btn-inverse btn-block"  value="REGI" type="submit">
            Register
        </button>
    </form>
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

            document.getElementById("email_input").addEventListener("click",function(){
                this.style.backgroundColor = "#ffffff";
            });
            document.getElementById("password_input").addEventListener("click",function(){
                this.style.backgroundColor = "#ffffff";
            });

            $( "#sign_up_form" ).on( "submit", function( event ) {
                event.preventDefault();
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        result = JSON.parse(this.responseText);
                        console.log(result);
                        if(result.result=="success"){
                            document.getElementById("invalid").style.display="none";
                            window.location.replace("SMSVerification.php");
                        }
                        else {
                            document.getElementById("invalid").style.display="block";
                            document.getElementById("invalid").innerText=result;
                            if (result.result == "invalid") {
                                document.getElementById("invalid").innerText = "Invalid Email / Password Combination";
                            }
                            if (result.result == "invalidForm") {
                                document.getElementById("email_input").style.backgroundColor = "#ff6c4a";
                                document.getElementById("password_input").style.backgroundColor = "#ff6c4a";
                                document.getElementById("invalid").innerText = "Both Email and Password must be set";
                            }
                            if (result.result == "invalidEmail") {
                                document.getElementById("email_input").style.backgroundColor = "#ff6c4a";
                                document.getElementById("invalid").innerText = "Email must be valid";
                            }
                        }
                    }
                };
                xhttp.open("POST", "Index.php?action=logIn", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send($(this).serialize());
            });
        });
    </script>

</footer>
</html>