<?php
include "utilities.php";
if(!loggedIn()){
    header("Location: Index.php");
    die();
}
if(!validToken()){
    header("Location: Logout.php?token=invalid");
    die();
}
if (isset($_GET["otherEmail"]) && user_exists($_GET["otherEmail"])) {

    $name = getUserName($_GET["otherEmail"]);

    echo("<script>var otherEmail = '" . $_GET["otherEmail"] . "'</script>");
    echo("<script>var currentUserEmail = '" . $_SESSION["email"] . "'</script>");
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
    <link rel="stylesheet" type="text/css" href="Chat.css"/>

</head>
<nav id="my_navbar" class="nav_buttons">
    <div id="nav_container">
        <table>
            <form action="ChatInbox.php">
                <button id="nav_left" class="borderlessButtons">
                    <span class="glyphicon glyphicon-chevron-left icon_style"></span>
                </button>
            </form>
            <h2> <h4 id = "name">Chat with <?php echo $name; ?></h4></h2>

        </table>
    </div>
</nav>
<br>
<body>

    <main>
        <div id="chatHistoryDiv"></div>
        <div id="chatFormDiv">
            <form id="chatForm">
                <label for="messageText"></label><input type="text" id="messageText" autocomplete="off"/>
                <input type ="submit" id ="postButton" value ="Post"/>
            </form>
        </div>
    </main>
    <footer>
        <!-- JQuery Plugins -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Our plugins -->
        <script src="ChatModel.js"></script>
        <script src="ChatView.js"></script>
        <script src="ChatController.js"></script>
    </footer>
</body>
</html>
<?php}
else{
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
    <link rel="stylesheet" type="text/css" href="Chat.css"/>

</head>



<body>
    <h1 id = "fail">Sorry, something went wrong</h1>
</body>
</html>
<?php
}?>