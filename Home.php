<?php
include "HomeUtilities.php"
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

<nav id="my_navbar" class="nav_buttons">
    <div id="nav_container">
        <table>
        <form action="SearchMap.html">
            <button id = "nav_left"  class="borderlessButtons">
                <span class="glyphicon glyphicon-search icon_style"></span>
            </button>
        </form>
            <label id = "nav_center"><h3 id = "headder">Select a Rider</h3></label>
        <form action="EditProfile.html">
            <button id = "nav_right"  class="borderlessButtons">
                <span class="glyphicon  glyphicon-user icon_style"></span>
            </button>
        </form>
        </table>
    </div>
</nav>

<div id = "card_moreDetails"></div>
<table>
<h5>Change Mode:</h5>
<div id = "slider_container">
    <button id="isDriverSlider">  </button>
</div>
</table>
<br>

<div id = "card_status"></div>
<div id = "frontCard"></div>
<div id = "card_reject" class = "card_reject"></div>
<div id = "card_accept" class ="card_accept"></div>

<div id ="status_bar">
    <table id = "wrapper_table">
    <div id="status_bar_container">
        <tr>
            <td>
                <div id = "cirlce_yes" class="circle">
                    <button id = "status_bar_yes"  class="borderlessButtons">
                        <span class=" glyphicon glyphicon-thumbs-up icon_style"></span>
                    </button>
                </div>
            </td>
            <td></td>
            <td>
                    <div id = "cirlce_no" class="circle">
                        <button id = "status_bar_no" class="borderlessButtons">
                            <span class="glyphicon glyphicon-thumbs-down icon_style"></span>
                        </button>
                    </div>
            </td>
        </tr>
    </div>
        <tr>
            <td></td>
            <td>
            <div id = "cirlce_redo"  class="circle">
                <button id = "status_bar_back" class="borderlessButtons">
                     <span class="glyphicon glyphicon-repeat icon_style"></span>
                </button>
            </div>
         </td>
            <td></td>
        </tr>
    </table>
</div>
<form action="Logout.php">
    <input type="submit" class="btn btn-lg btn-inverse btn-block back_button" value="Logout">
</form>
</body>

<footer>
    <!-- Our own Plugins -->
    <script type="text/babel" src="Home.jsx"></script>
    <!-- JQuery Plugins -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!--React Plugins-->
    <script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
</footer>
</html>