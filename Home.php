<?php
include "HomeUtilities.php";
$_SESSION['swipe_number'] = 0;

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
    <link rel="stylesheet" type="text/css" href="StyleSheet.css"/>
    <link rel="stylesheet" type="text/css" href="SearchMapStyleSheet.css"/>

</head>

<script>
    function getUsertype() {

        // window.location.href = "SearchMap.php?type=rider";
        var options = document.createElement("div");
        options.setAttribute("id", "typeChooserDiv");
        document.getElementById("bodyBody").appendChild(options);

        var choiceInfoDiv = document.createElement("div");
        choiceInfoDiv.setAttribute("id", "choiceInfoDiv");
        options.appendChild(choiceInfoDiv);
        var choiceInfo = document.createElement("span");
        choiceInfo.innerHTML = "Are you a Rider or Driver today?";
        choiceInfo.setAttribute("id", "choiceInfo");
        choiceInfoDiv.appendChild(choiceInfo);

        var button1 = document.createElement("button");
        button1.setAttribute("class", "choiceButton");
        button1.innerHTML = "Rider";
        options.appendChild(button1);
        button1.addEventListener('click', function () { window.location.href = "SearchMap.php?type=rider&email"});

        var button2 = document.createElement("button");
        button2.setAttribute("class", "choiceButton");
        button2.innerHTML = "Driver";
        options.appendChild(button2);
        button2.addEventListener('click', function () {
            var routeInfoDiv = document.createElement("div");
            routeInfoDiv.setAttribute("id", "routeInfoDiv");
            options.appendChild(routeInfoDiv);
            var fromInfo = document.createElement("textarea");
            fromInfo.setAttribute("class", "driverInfoText");
            fromInfo.setAttribute("placeholder", "Origin");
            routeInfoDiv.appendChild(fromInfo);
            var toInfo = document.createElement("textarea");
            toInfo.setAttribute("class", "driverInfoText");
            toInfo.setAttribute("placeholder", "Destination");
            routeInfoDiv.appendChild(toInfo);
            var ToD = document.createElement("textarea");
            ToD.setAttribute("class", "driverInfoText");
            ToD.setAttribute("placeholder", "Time of Departure");
            routeInfoDiv.appendChild(ToD);
            options.removeChild(button1);
            button2.innerHTML = "Confirm";
            var button3 = button2.cloneNode(true);
            button2.parentNode.replaceChild(button3, button2);
            button3.addEventListener('click', function () { window.location.href = "SearchMap.php?type=driver&from="+fromInfo.value+"&to="+toInfo.value+"&tod="+ToD.value;  });
            choiceInfo.innerHTML = "Enter the details of your journey today.";
            var enterInfo = choiceInfo.cloneNode(true);
            choiceInfo.parentNode.replaceChild(enterInfo, choiceInfo);
        });

        return false;
    }
</script>

<body id="bodyBody">
<div id="bodyDiv">
    <nav id="my_navbar" class="nav_buttons">
        <div id="nav_container">
            <table>
                <form onsubmit="return getUsertype()">
                    <button id="nav_left" class="borderlessButtons">
                        <span class="glyphicon glyphicon-search icon_style"></span>
                    </button>
                </form>
                <label id="nav_center"><h3 id="headder">Select a Rider</h3></label>
                <form action="ViewProfile.php">
                    <button id="nav_right" class="borderlessButtons">
                        <span class="glyphicon  glyphicon-user icon_style"></span>
                    </button>
                </form>
            </table>
        </div>
    </nav>

    <div id="card_moreDetails"></div>
    <table>
        <h5>Change Mode:</h5>
        <div id="slider_container">
            <button id="isDriverSlider"></button>
        </div>
    </table>
    <br>

    <div id="card_status"></div>
    <div id="frontCard"></div>
    <div id="card_reject" class="card_reject"></div>
    <div id="card_accept" class="card_accept"></div>

    <div id="status_bar">
        <table id="wrapper_table">
            <div id="status_bar_container">
                <tr>
                    <td>
                        <div id="cirlce_yes" class="circle">
                            <button id="status_bar_yes" class="borderlessButtons">
                                <span class=" glyphicon glyphicon-thumbs-up icon_style"></span>
                            </button>
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div id="cirlce_no" class="circle">
                            <button id="status_bar_no" class="borderlessButtons">
                                <span class="glyphicon glyphicon-thumbs-down icon_style"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            </div>
            <tr>
                <td></td>
                <td>
                    <div id="cirlce_redo" class="circle">
                        <button id="status_bar_back" class="borderlessButtons">
                            <span class="glyphicon glyphicon-repeat icon_style"></span>
                        </button>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <form action="Logout.php" id = "logout">
        <input type="submit" value="Logout" class="logout">
    </form>
</div>
<br>

<footer>
    <!-- Our own Plugins -->
    <script type="text/babel" src="Home.jsx"></script>
    <!-- JQuery Plugins -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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