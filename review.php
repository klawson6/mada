<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 21/03/2019
 * Time: 14:36
 */
include "utilities.php";

if(!loggedIn()){
    header("Location: Index.php");
    die();
}

if(!validToken()){
    header("Location: Logout.php?token=invalid");
    die();
}

$userEmail = $_SESSION["email"];

if (isset($_SESSION['rider'])){
    $rider = true;
    $driver = false;

} elseif (isset($_SESSION['driver'])){
    $driver = true;
    $rider = false;
}

$driver =false;
$rider = true;

$dbconn = dbconn();


if (isset($_POST['submit'])){
    $userEmail = "michaeldavie182@gmail.com";
    $revieweeEmail = "biggie@gmail.com";
    $id = null;

    if ($driver) {
        $riderPersonality = $_POST['p'];
        $riderCleanliness = $_POST['c'];
        $riderTimeliness = $_POST['t'];
        $reviewInsert = $dbconn->prepare("INSERT INTO reviewsAboutRiders(reviewsAboutRiders.reviewID, reviewsAboutRiders.reviewerEmail, reviewsAboutRiders.revieweeEmail, reviewsAboutRiders.personality, reviewsAboutRiders.cleanliness, reviewsAboutRiders.timeliness) VALUES (?,?,?,?,?,?)");
        $reviewInsert->bind_param("issiii", $id, $userEmail, $revieweeEmail, $riderPersonality, $riderCleanliness, $riderTimeliness);
        $reviewInsert->execute();
    } elseif ($rider) {
        $driverPersonality = $_POST['p'];
        $driverCleanliness = $_POST['c'];
        $driverAbility = $_POST['d'];
        $driverTimeliness = $_POST['t'];
        echo nl2br($driverPersonality);
        echo nl2br($driverCleanliness);
        echo nl2br($driverAbility);
        echo nl2br($driverTimeliness);
        $reviewInsert = $dbconn->prepare("INSERT INTO reviewsAboutDrivers(reviewsAboutDrivers.reviewID, reviewsAboutDrivers.reviewerEmail, reviewsAboutDrivers.revieweeEmail, reviewsAboutDrivers.cleanliness, reviewsAboutDrivers.personality, reviewsAboutDrivers.drivingAbility, reviewsAboutDrivers.timeliness) VALUES (?,?,?,?,?,?,?)");
        $reviewInsert->bind_param("issiiii", $id, $userEmail, $revieweeEmail, $driverCleanliness, $driverPersonality, $driverAbility, $driverTimeliness);
        $reviewInsert->execute();
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
<body id="reviewBody">
<form id="reviewForm" method="post" name="review">
<div id="stars" style="text-align: center">

    <script>
        var cleanliness = 3;
        var driving = 3;
        var personality = 3;
        var timeliness = 3;

        function setStar(value, cat) {
            console.log('Star ' , value);
            console.log('Category ', cat);
            if (cat === 'c'){
                cleanliness = value;
            }
            if (cat === 'd'){
                driving = value;
            }
            if (cat === 'p'){
                personality = value;
            }
            if (cat === 't'){
                timeliness = value;
            }
            for (let i = 5; i > 0; i--){
                let id = cat + i;
                if (i > value){
                    document.getElementById(id).src = "img/star_empty.png"
                } else {
                    document.getElementById(id).src = "img/star.png"
                }
            }
        }
    </script>


    <div class="starGroup">
        <h1>Review your experience</h1>
        <div className="allReviews">
            <?php if($rider){?>
            <div className="reviews">
                <h4>Cleanliness</h4>
                <img id="c1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 'c')">
                <img id="c2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 'c')">
                <img id="c3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 'c')">
                <img id="c4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 'c')">
                <img id="c5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 'c')">
            </div>
            <div className="reviews">
                <h4>Personality</h4>
                <img id="p1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 'p')">
                <img id="p2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 'p')">
                <img id="p3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 'p')">
                <img id="p4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 'p')">
                <img id="p5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 'p')">
            </div>
            <div className="reviews">
                <h4>Driving Ability</h4>
                <img id="d1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 'd')">
                <img id="d2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 'd')">
                <img id="d3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 'd')">
                <img id="d4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 'd')">
                <img id="d5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 'd')">
            </div>
                <div className="reviews">
                    <h4>Timeliness</h4>
                    <img id="t1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 't')">
                    <img id="t2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 't')">
                    <img id="t3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 't')">
                    <img id="t4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 't')">
                    <img id="t5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 't')">
                </div>
            <?php } elseif($driver){
                ?>
            <div className="reviews">
                <h4>Cleanliness</h4>
                <img id="c1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 'c')">
                <img id="c2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 'c')">
                <img id="c3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 'c')">
                <img id="c4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 'c')">
                <img id="c5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 'c')">
            </div>
            <div className="reviews">
                <h4>Personality</h4>
                <img id="p1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 'p')">
                <img id="p2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 'p')">
                <img id="p3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 'p')">
                <img id="p4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 'p')">
                <img id="p5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 'p')">
            </div>
            <div className="reviews">
                <h4>Timeliness</h4>
                <img id="t1" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(1, 't')">
                <img id="t2" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(2, 't')">
                <img id="t3" class="starRate" src="img/star.png" alt="emptyStar" onClick="setStar(3, 't')">
                <img id="t4" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(4, 't')">
                <img id="t5" class="starRate" src="img/star_empty.png" alt="emptyStar" onClick="setStar(5, 't')">
            </div>
            <?php }?>
        </div>
    </div>

</div>
    <p>
    <input class="btn btn-outline-dark" type="submit" name="submit">
    <input class="btn btn-outline-dark" type="button" value="Skip">
    </p>
</form>

</body>

<footer>
    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <!--React Plugins-->
    <script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <?php if($rider){ ?>
    <script>
    $(document).ready(function(){
    $( "form" ).on( "submit", function( event ) {
    event.preventDefault();
    var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                console.log(JSON.parse(this.responseText));
            }
        };
    xhttp.open("POST", "review.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("submit=true&c=" + cleanliness + "&d=" + driving + "&p=" + personality + "&t=" + timeliness);
    });
    });
    </script>
    <?php } elseif($driver){ ?>
    <script>
        $(document).ready(function(){
            $( "form" ).on( "submit", function( event ) {
                event.preventDefault();
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        console.log(JSON.parse(this.responseText));
                    }
                };
                xhttp.open("POST", "review.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("submit=true&c=" + cleanliness + "&p=" + personality + "&t=" + timeliness);
            });
        });
    </script>
    <?php } ?>
</footer>
</html>