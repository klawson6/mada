<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 21/03/2019
 * Time: 14:36
 */
include "utilities.php";

if (isset($_SESSION['email'])){
    $userEmail = $_SESSION['email'];
}

if (isset($_SESSION['rider'])){
    $rider = true;
    $driver = false;
} elseif (isset($_SESSION['driver'])){
    $driver = true;
    $rider = false;
}

$dbconn = dbconn();

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
<body id="reviewBody">
<b>Review</b>
<form method="post" name="review">
<!--
<textarea id="reviewInput" name="reviewInput" placeholder="<?php echo $loggedIn ? "Write your review here..." : "Sign in to leave a review..."?>" style="height:200px" <?php echo $loggedIn ? "" : "disabled"?>></textarea>
-->
<p>
</p>

<div id="stars">

</div>
    <input class="btn btn-outline-dark" type="submit" name="submit" <?php //echo $loggedIn ? "" : "disabled"?>>
</form>

<div class="form-group">

<?php
    if (isset($_POST['submit']) && isset($_SESSION['email'])){
    $repeatReviewSQL = $dbconn->prepare("SELECT * FROM Reviews WHERE email = ?");
    $repeatReviewSQL->bind_param("s", $_SESSION['email']);
    $repeatReviewSQL->execute();
    $repeatCheck = $repeatReviewSQL->get_result();
        if(mysqli_num_rows($repeatCheck) === 0){
        $inputReview = trim($_POST['reviewInput']);
        $stars = $_POST['stars'];
        $id = null;
        if ($driver){
            $reviewInsert = $dbconn->prepare("INSERT INTO reviewsAboutRiders(Reviews.review_id, Reviews.email, Reviews.review, Reviews.star, Reviews.company_id) VALUES (?,?,?,?,?)");
            $reviewInsert->bind_param("issii", $id, $userEmail, $inputReview, $stars, $compID);
            $reviewInsert->execute();
        } elseif ($rider) {
            $reviewInsert = $dbconn->prepare("INSERT INTO reviewsAboutDrivers(Reviews.review_id, Reviews.email, Reviews.review, Reviews.star, Reviews.company_id) VALUES (?,?,?,?,?)");
            $reviewInsert->bind_param("issii", $id, $userEmail, $inputReview, $stars, $compID);
            $reviewInsert->execute();
        }
    }
    } else { ?>
        <?php
    }
?>

</body>

<footer>

    <!-- Our own Plugins -->
    <script type="text/babel" src="review.jsx"></script>

    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</footer>
</html>