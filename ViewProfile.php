

<?php
include "utilities.php";

/*if (!loggedIn()){
    header('Location: Index.php');
    die();
} */

$conn = dbconn();

$name = null;
$bio = null;
$phone = null;

$email = "chrstphrwthrs@googlemail.com";

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

<body class="body">
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
    <div id="bio">
        <h2>Bio</h2>
        <?php echo $bio ?>
    </div>
    <h2>E-Mail:</h2>
            <?php echo $email?>

    <h2>Phone Number:</h2>
    <?php echo $phone ?>
        <div id = "AddressWrapper">
            <label>Address:</label>
            <?php
                $addressResult = $conn->query("SELECT * FROM UserAddresses WHERE email = '$email'");
                if ($addressResult->num_rows > 0){
                    while($addressRow = $addressResult->fetch_assoc()){
                        ?>
                        <button onclick=showAndHide(<?php echo $addressRow['address_id'] ?>)><?php echo $addressRow['address_name'] ?></button>

            <br>
                        <div style="display: none" id=<?php echo $addressRow['address_id'] ?>>
            <label>Town:</label>
                        <div><?php echo $addressRow['town'] ?></div>
            <br>
            <label>Country:</label>
                        <div><?php echo $addressRow['country'] ?></div>
            <label>Postcode:</label>
                        <div><?php echo $addressRow['postcode'] ?></div>
            <br><br>
                        </div>
                    <?php
                    }
                }
            ?>
        </div>
   </div>
   <br>
    <button id="editProfileButton" class="btn btn-lg btn-inverse btn-block back_button" onclick="location.href = 'Edit2.php';">Edit</button>
    <form action="Home.php">
       <button id = "back_home" class="btn btn-lg btn-inverse btn-block back_button" type="submit">Back</button>
   </form>
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