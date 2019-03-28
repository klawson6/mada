<?php
session_start();

include "utilities.php";

if(loggedIn()){
    header("Location: Home.php");
}


$forename = null;
$surname = null;
$email = null;
$dob = null;
$password = null;
$mobile_number = null;
$address_name = null;
$address_line_1 = null;
$address_line_2 = null;
$town = null;
$country = null;
$postcode = null;

if(isset($_POST["action"]) && $_POST["action"] == "submit") {

    $forename = $_POST["forename"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $mobile_number = 0;
    $address_name = $_POST["address_name"];
    $address_line_1 = $_POST["address_line_1"];
    $address_line_2 = $_POST["address_line_2"];
    $town = $_POST["town"];
    $country = $_POST["country"];
    $postcode = $_POST["postcode"];

    if(!user_exists($email)){
        $dbconn = dbconn();
        $stmt = $dbconn->prepare("INSERT INTO UserInfo (forename, surname, email, date_of_birth, password, mobile_number) VALUES (?,?,?,?,?,?);");
        $stmt->bind_param("ssssss", $forename, $surname, $email, $dob, $hash, $mobile_number);
        $stmt->execute();

        $stmt1 = $dbconn->prepare("INSERT INTO UserAddresses (email, address_name, address_line_1, address_line_2, town, country, postcode) VALUES (?,?,?,?,?,?,?);");
        $stmt1->bind_param("sssssss", $email, $address_name, $address_line_1, $address_line_2, $town, $country, $postcode);
        $stmt1->execute();

        setcookie("email", $_POST["email"], time() + (10 * 365 * 24 * 60 * 60));
        $_SESSION["email"] = $_POST["email"];
        header("Location:SMSVerification.php");
        //var_dump($_COOKIE);
        die();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <title>Register</title>

    <link rel="icon" sizes="192x192" href="img/car.png"/>
    <link rel="apple-touch-icon" href="img/car.png" />
    <link rel="shortcut icon" href="img/car.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Normalize.css"/>
    <link rel="stylesheet" type="text/css" href="myStyle.css"/>


</head>

<body class="intro_styling_regi">

    <video autoplay muted loop id="introVideo">
        <source src="img/video2.mp4" type="video/mp4">
    </video>
    <div id="sign_up" class="form-group">
        <form name="Register" method="post" enctype="multipart/form-data" onsubmit="return ValidateRegisterFormData()">
            <h1>Register</h1>
            <br>
            <div class="inputWrapper">

                <label>Name: </label>
                <input id="first_name_input" name="forename" type="text" class="form-control" <?php if($forename!=null){echo "value='$forename'";}?> placeholder="First Name" maxlength="25" />
                <br>
                <input id="surname_input"  name="surname" type="text" class="form-control"  <?php if($surname!=null){echo "value='$surname'";}?> placeholder="Surname" maxlength="25" />
                <br><br>

                <label>E-Mail: </label>
                <input id="email_input" name="email" type="text" class="form-control"  <?php if($email!=null){echo "value='$email'";}?> placeholder="example@mail.com" maxlength="255" />
                <br><br>

                <label>Date of Birth: </label>
                <input id="dob_input" name="dob" type="date" class="form-control"  <?php if($dob!=null){echo "value='$dob'";}?> placeholder="xx/xx/xx" />
                <br><br>

                <label>Password: </label>
                <input id="password_input" name="password" type="password" class="form-control" value="" placeholder="Password" />
                <br>
                <input id="passwordVer_input"  type="password" class="form-control" value="" placeholder="Re-Type Password" />
                <br><br>

<!--                <label>Mobile Number</label>-->
<!--                <input id="mobile_number_input" name="mobile_number" type="text" class="form-control" --><?php //if($mobile_number!=null){echo "value='$mobile_number'";}?><!-- placeholder="Mobile Number" maxlength="11" />-->
<!--                <br><br>-->

                <label>Home Address: </label>
                <input id="address_name_input" name="address_name" type="text" class="form-control"  <?php if($address_name!=null){echo "value='$address_name'";}?> placeholder="Address Name" maxlength="12" />
                <br>
                <input id="address_line1_input" name="address_line_1" type="text" class="form-control"  <?php if($address_line_1!=null){echo "value='$address_line_1'";}?> placeholder="Address Line 1" maxlength="50" />
                <br>
                <input id="address_line2_input" name="address_line_2" type="text" class="form-control"  <?php if($address_line_2!=null){echo "value='$address_line_2'";}?> placeholder="Address Line 2" maxlength="50" />
                <br>
                <input id="town_input" name="town" type="text" class="form-control"  <?php if($town!=null){echo "value='$town'";}?> placeholder="Town" maxlength="20" />
                <br>
                <input id="country_input" name="country" type="text" class="form-control"  <?php if($country!=null){echo "value='$country'";}?> placeholder="Country" maxlength="20" />
                <br>
                <input id="postcode_input" name="postcode" type="text" class="form-control"  <?php if($postcode!=null){echo "value='$postcode'";}?>placeholder="Postcode" maxlength="8" />
            </div>
            <br>
            <label for="agreeTerms">Accept Conditions: </label>
            <input type="checkbox" class="form-control" id="agreeTerms" name="agreeTerms" />
            <br><br>
            <div>
                <button id="create_account_button" class="btn btn-lg btn-inverse btn-block create_account_button" type="submit">Create Account</button>
                <input type="hidden" name="action" value="submit" />
            </div>
            <br>
        </form>
        <form action="Index.php">
            <button id = "back_button" class="btn btn-lg btn-inverse btn-block back_button" type="submit">Back</button>
            <br><br>
        </form>
    </div>

<?php
if(isset($_POST["action"]) && $_POST["action"] == "submit") {
    if(user_exists($_POST["email"])){
        echo ("<script> 
                var inp = document.getElementById('email_input');
                inp.style.backgroundColor = 'yellow';
                inp.value = '';
                inp.placeholder = 'EMAIL TAKEN'
              </script>");
    }
}
?>
</body>

<footer>
    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!--mine-->
    <script src="FormValidation.js"></script>

</footer>

</html>