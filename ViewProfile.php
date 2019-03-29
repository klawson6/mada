

<?php
include "utilities.php";

if (!loggedIn()){
    header('Location: Index.php');
    die();
}

$conn = dbconn();

$name = null;
$bio = null;
$phone = null;

$email = $_SESSION['email'];

$result = $conn->query("SELECT * FROM UserInfo WHERE email = '$email'");

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $name = $row['forename'] . " " . $row['surname'];
        $bio = $row['bio'];
        $phone = $row['mobile_number'];
    }
}
?>

<!DOCTYPE html>
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
    <style>
        *{
            overflow: auto;
        }
    </style>
</head>

<nav id="my_navbar" class="nav_buttons">
    <div id="nav_container">
        <table>
            <form action="Home.php">
                <button id="nav_left" class="borderlessButtons">
                    <span class="glyphicon glyphicon-home icon_style"></span>
                </button>
            </form>
            <form action="ChatInbox.php">
                <button id="nav_right" class="borderlessButtons">
                    <span class="glyphicon glyphicon-envelope icon_style"></span>
                </button>
            </form>
        </table>
    </div>
</nav>

<body class="viewP">
    <h1><?php echo $name ?></h1>
    <br>
    <h2>Profile Images</h2>
    <div id = "profileImages">
        <?php
        $img = $conn->query("SELECT * FROM Photo WHERE email = '$email'");
        if ($img->num_rows > 0){
            while ($imgRow = $img->fetch_assoc()){
                ?>
                <img class='profile_img' src="<?php echo "data:image;base64,".base64_encode($imgRow['photo']) ?>">
                <?php
            }
        }
        ?>
    </div>

    <div id="bio" class="bioSeg">
        <?php
            if($bio!=null){
                ?>
                <h3>Bio</h3>
                <?php echo $bio ?>
                <?php
            }else{
                ?>
                <h3>No Set Bio</h3>
                <?php
            }

        ?>

    </div>
    <br>
    <div id = "email" class="bioSeg">
        <h3>E-Mail:</h3>
        <h4><?php echo $email?></h4>
    </div>
    <br>
    <div id = "phone" class="bioSeg">
    <h4>Phone Number:</h4>
    <h4><?php echo $phone ?></h4>
    </div>
    <br>
    <div id = "AddressWrapper" class="bioSeg">
        <h3><label>Address:</label></h3>
        <?php
        $addressResult = $conn->query("SELECT * FROM UserAddresses WHERE email = '$email'");
        if ($addressResult->num_rows > 0){
            while($addressRow = $addressResult->fetch_assoc()){
                ?>
                <button class="addr_button" onclick=showAndHide(<?php echo $addressRow['address_id'] ?>)><?php echo $addressRow['address_name'] ?></button>
                <br>
                <div style="display: none" id=<?php echo $addressRow['address_id'] ?>>
                    <h4><label>Town:</label></h4>
                    <div>
                        <h5><?php echo $addressRow['town'] ?></h5>
                    </div>
                <br>
                    <h4><label>Country:</label></h4>
                    <div><h5><?php echo $addressRow['country'] ?></h5></div>
                    <h4> <label>Postcode:</label></h4>
                    <div><h5><?php echo $addressRow['postcode'] ?></h5></div>
                <br><br>
                </div>
                <?php
            }
        }
        ?>
    </div>
   <br>
    <button id="editProfileButton" class="btn btn-lg btn-inverse btn-block back_button" type="submit" onclick="location.href = 'Edit2.php';">Edit</button>

</body>

<script>
    function showAndHide(id) {
        var x = document.getElementById(id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<footer>
   <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </footer>
</html>