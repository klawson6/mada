
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
        <form>
            <h1>Register</h1>
            <br>
            <div class="inputWrapper">

                <label>Name: </label>
                <input id="name_input"  type="text" class="form-control" placeholder="Name">
                <br><br>

                <label>E-Mail: </label>
                <input id="email_input"  type="text" class="form-control" placeholder="example@mail.com">
                <br><br>

                <label>Date of Birth: </label>
                <input id="dob_input"  type="text" class="form-control" placeholder="xx/xx/xx">
                <br><br>

                <label>Password: </label>
                <input id="name_input"  type="text" class="form-control" placeholder="Password">
                <br>
                <input id="name_input"  type="text" class="form-control" placeholder="Re-Type Password">
                <br><br>

                <label>Home Address: </label>
                <input id="address_line1_input"  type="text" class="form-control" placeholder="Address Line 1">
                <br>
                <input id="address_line2_input"  type="text" class="form-control" placeholder="Address Line 2">
                <br>
                <input id="town_input"  type="text" class="form-control" placeholder="Town">
                <br>
                <input id="country_input"  type="text" class="form-control" placeholder="Country">
                <br>
                <input id="postcode_input"  type="text" class="form-control" placeholder="Postcode">
            </div>
            <br>
            <button id="create_account_button" class="btn btn-lg btn-inverse btn-block create_account_button" type="submit">Create Account</button>
            <br>
        </form>
        <form>
            <button id = "back" class="btn btn-lg btn-inverse btn-block back_button" type="submit">Back</button>
            <br><br>
        </form>
    </div>

</body>

<footer>
    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</footer>

</html>