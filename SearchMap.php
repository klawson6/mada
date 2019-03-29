<?php

if(isset($_GET["type"])){
    echo "<script>var type='" . $_GET["type"] . "';</script>";
    if($_GET["type"] == "driver"){
        if(isset($_GET["from"])){
            echo "<script>var from='" . $_GET["from"] . "';</script>";
        }

        if(isset($_GET["to"])){
            echo "<script>var to='" . $_GET["to"] . "';</script>";
        }

        if(isset($_GET["tod"])){
            echo "<script>var tod='" . $_GET["tod"] . "';</script>";
        }
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

    <title>Co-Rider</title>

    <link rel="icon" sizes="192x192" href="img/car.png"/>
    <link rel="apple-touch-icon" href="img/car.png"/>
    <link rel="shortcut icon" href="img/car.png" type="image/x-icon"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Normalize.css"/>
    <link rel="stylesheet" type="text/css" href="SearchMapStyleSheet.css"/>

    <style>


    </style>
</head>

<body id="map_home">
<div id="daddyDiv">
    <div id="map_my_navbar" class="nav_buttons">
        <div id="nav_container">
            <table>
                <form action="Home.php">
                    <button id="nav_left" class="borderlessButtons">
                        <span class="glyphicon glyphicon-home icon_style"></span>
                    </button>
                </form>
                <label id="nav_center"><h3>Find a Driver</h3></label>
                <form action="Edit2.php">
                    <button id="nav_right" class="borderlessButtons">
                        <span class="glyphicon  glyphicon-user icon_style"></span>
                    </button>
                </form>
            </table>
        </div>
    </div>
    <div id="nonNav">
        <div id="map_parent">
            <div id="map_container"></div>
            <!--<div id="testProfile">-->
            <!--<div id="profilePicTest">-->
            <!--<img id="profilePicTestPic" src="img/woman.jpeg"/>-->
            <!--</div>-->
            <!--<div id="profileInfoTest">-->
            <!--<span id="nameTest"></span>-->
            <!--<div class="ratings" id="rating1">-->
            <!--<span id="rating1text">Personality</span>-->
            <!--<img class="ratingPic" src="img/star_empty.png"/>-->
            <!--</div>-->
            <!--<div class="ratings" id="rating2">-->
            <!--<span id="rating2text">Driving Ability</span>-->
            <!--<img class="ratingPic" src="img/star_empty.png"/>-->
            <!--</div>-->
            <!--<div class="ratings" id="rating3">-->
            <!--<span id="rating3text">Cleanliness</span>-->
            <!--<img class="ratingPic" src="img/star_empty.png"/>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
        </div>
        <span id="sliderVal"></span>
        <div id="radiusSliderDiv">
            <span class="sliderLims">500m</span>
            <input type="range" min="0" max="100" value="30.103" step="0.001" class="slider" id="radiusSlider">
            <span class="sliderLims">5km</span>
        </div>
        <div id="searchDiv">
            <button id="searchButton">Find Co-Ride</button>
        </div>
    </div>
</div>

</body>

<footer>

    <!-- Our own Plugins -->
    <script type="text/babel" src="Home.jsx"></script>
    <script src="SearchMap.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlQsPmRWWEbCLqHpdoseu58mWjODqeIaQ&callback=initMap"
            async defer></script>
    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <!--React Plugins-->
    <script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>


</footer>
</html>