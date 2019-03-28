<?php
include "utilities.php";

$dbconn = dbconn();
$email = "chrstphrwthrs@googlemail.com";

$userInfoSTMT = $dbconn->prepare("SELECT * FROM UserInfo WHERE email=?;");
$userInfoSTMT->bind_param("s", $email);
$userInfoSTMT->execute();
$userInfo = $userInfoSTMT->get_result();
$userInfo = $userInfo->fetch_assoc();

$userAddressesSTMT = $dbconn->prepare("SELECT * FROM UserAddresses WHERE email=?;");
$userAddressesSTMT->bind_param("s", $email);
$userAddressesSTMT->execute();
$userAddresses = $userAddressesSTMT->get_result();

$userImagesSTMT = $dbconn->prepare("SELECT * FROM UserPhotos WHERE email=?");
$userImagesSTMT->bind_param("s", $email);
$userImagesSTMT->execute();
$userImages = $userImagesSTMT->get_result();
$numImages = $userImages->num_rows;


if(isset($_POST["action"]) && $_POST["action"] == "updatePassword") {

    $password = $_POST["edit_password"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $user_email = $_POST["user_email"];

    $passwordChangeSTMT = $dbconn->prepare("UPDATE UserInfo SET password=? WHERE email=?;");
    $passwordChangeSTMT->bind_param("ss", $hash, $user_email);
    $passwordChangeSTMT->execute();
    die();

}
else if(isset($_POST["action"]) && $_POST["action"] == "updateAddress"){

    $address_id = $_POST["address_id"];
    $address_name = $_POST["address_name_input"];
    $address_line1 = $_POST["address_line1_input"];
    $address_line2 = $_POST["address_line2_input"];
    $town = $_POST["town_input"];
    $country = $_POST["country_input"];
    $postcode = $_POST["postcode_input"];

    if($address_id === ""){

        $addressAddSTMT = $dbconn->prepare("INSERT INTO UserAddresses (email, address_name, address_line_1, address_line_2, town, country, postcode) VALUES (?,?,?,?,?,?,?);");
        $addressAddSTMT->bind_param("sssssss", $email, $address_name, $address_line1, $address_line2, $town, $country, $postcode);
        $addressAddSTMT->execute();

        header("Location:Edit2.php");
    }
    else {

        $addressChangeSTMT = $dbconn->prepare("UPDATE UserAddresses SET address_name=?, address_line_1=?, address_line_2=?, town=?, country=?, postcode=? WHERE address_id=?;");
        $addressChangeSTMT->bind_param("sssssss", $address_name, $address_line1, $address_line2, $town, $country, $postcode, $address_id);
        $addressChangeSTMT->execute();

        header("Location:Edit2.php");
    }

}
else if(isset($_POST["action"]) && $_POST["action"] == "updateInformation"){

    $forename = $_POST["forename_change"];
    $surname = $_POST["surname_change"];
    $mobile_number = $_POST["mobile_number_change"];
    $bio = $_POST["bio_change"];
    $user_email = $_POST["user_email"];

    $passwordChangeSTMT = $dbconn->prepare("UPDATE UserInfo SET forename=?, surname=?, mobile_number=?, bio=? WHERE email=?;");
    $passwordChangeSTMT->bind_param("sssss", $forename, $surname, $mobile_number, $bio,  $user_email);
    $passwordChangeSTMT->execute();

    die();


}
else if(isset($_POST["action"]) && $_POST["action"] == "deleteAddress"){

    $address_id_delete = $_POST["address_id_delete"];

    $deleteAddressSTMT = $dbconn->prepare("DELETE FROM UserAddresses WHERE address_id=?;");
    $deleteAddressSTMT->bind_param("s", $address_id_delete);
    $deleteAddressSTMT->execute();

    header("Location:Edit2.php");

}
else if(isset($_POST["action"]) && $_POST["action"] == "updateImage"){
    if(is_uploaded_file($_FILES['profile_pic_input']['tmp_name']) && getimagesize($_FILES['profile_pic_input']['tmp_name']) != false ){
        $id = $_POST['profile_pic_id'];
        $image = file_get_contents($_FILES['profile_pic_input']['tmp_name']);
        $user_email = $_POST["user_email"];
        if($id != null){
            $addPicSTMT = $dbconn->prepare("UPDATE UserPhotos SET photo=? WHERE photo_id=?;");
            $addPicSTMT->bind_param("ss", $image, $id);
            $addPicSTMT->execute();
        }
        else{
            $addPicSTMT = $dbconn->prepare("INSERT INTO UserPhotos (email, photo) VALUES (?,?);");
            $addPicSTMT->bind_param("ss", $user_email, $image);
            $addPicSTMT->execute();
        }
        header("Location:Edit2.php");
    }
}
else if(isset($_POST["action"]) && $_POST["action"] == "deleteImage"){
    $profile_pic_id = $_POST["profile_pic_id"];

    $addPicSTMT = $dbconn->prepare("DELETE FROM UserPhotos WHERE photo_id=?;");
    $addPicSTMT->bind_param("s", $profile_pic_id);
    $addPicSTMT->execute();

    header("Location:Edit2.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title>Edit Profile</title>

    <link rel="icon" sizes="192x192" href="img/car.png" />
    <link rel="apple-touch-icon" href="img/car.png" />
    <link rel="shortcut icon" href="img/car.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Normalize.css"/>
    <link rel="stylesheet" type="text/css" href="myStyle.css"/>



</head>

<body class="styling_edit">

<h1>EDIT YOUR PROFILE</h1>
<br>

<?php

$profile_image_1_src = null;
$profile_image_2_src = null;
$profile_image_3_src = null;
$profile_image_4_src = null;

$profile_image_1_id = null;
$profile_image_2_id = null;
$profile_image_3_id = null;
$profile_image_4_id = null;

if($uImage = $userImages->fetch_assoc()){
    $profile_image_1_src = $uImage['photo'];
    $profile_image_1_id = $uImage['photo_id'];
}
if($uImage = $userImages->fetch_assoc()) {
    $profile_image_2_src = $uImage['photo'];
    $profile_image_2_id = $uImage['photo_id'];
}
if($uImage = $userImages->fetch_assoc()){
    $profile_image_3_src = $uImage['photo'];
    $profile_image_3_id = $uImage['photo_id'];
}
if($uImage = $userImages->fetch_assoc()){
    $profile_image_4_src = $uImage['photo'];
    $profile_image_4_id = $uImage['photo_id'];
}

?>

<div id="deletePic" class="pop_up">
    <?php
    if($numImages > 0){
        ?>
        <form id="deleteImage1" name="deleteImage1" method="post" enctype="multipart/form-data">
            <input type="hidden" id = "profile_pic_id_1" name="profile_pic_id"  value="<?php echo $profile_image_1_id; ?>">
            <input type="hidden" name="action" value="deleteImage">
            <button id="delete_image_1" class="btn btn-lg btn-inverse btn-block pop_up_button">Delete Image 1</button>
        </form>
        <br>
        <?php
    }
    if($numImages > 1){
        ?>
        <form name="deleteImage2" method="post" enctype="multipart/form-data">
            <input type="hidden" id = "profile_pic_id_2" name="profile_pic_id"  value="<?php echo $profile_image_2_id; ?>">
            <input type="hidden" name="action" value="deleteImage">
            <button id="delete_image_2" class="btn btn-lg btn-inverse btn-block pop_up_button">Delete Image 2</button>
        </form>
        <br>
        <?php
    }
    if($numImages > 2){
        ?>
        <form name="deleteImage3" method="post" enctype="multipart/form-data">
            <input type="hidden" id = "profile_pic_id_3" name="profile_pic_id" style="visibility: hidden" value="<?php echo $profile_image_3_id; ?>">
            <input type="hidden" name="action" value="deleteImage">
            <button id="delete_image_3" class="btn btn-lg btn-inverse btn-block pop_up_button">Delete Image 3</button>
        </form>
        <br>
        <?php
    }
    if($numImages > 3){
        ?>
        <form name="deleteImage4" method="post" enctype="multipart/form-data">
            <input type="hidden" id = "profile_pic_id_4" name="profile_pic_id"  value="<?php echo $profile_image_4_id; ?>">
            <input type="hidden" name="action" value="deleteImage">
            <button id="delete_image_4" class="btn btn-lg btn-inverse btn-block pop_up_button">Delete Image 4</button>
        </form>
        <br>
        <?php
    }
    ?>
    <button id ="close_delete_pic" class="btn btn-lg btn-inverse btn-block pop_up_button">Close</button>
</div>

<div id ="editAddress" class="pop_up">
    <form name="editAddress" id="editAddress" method="post" enctype="multipart/form-data" onsubmit="return validateEditAddressData()">
        <h4>Edit Address</h4>
        <div id="address_input_wrapper" class="inputWrapper">
            <label>Name:</label>
            <input id="address_name_input" name="address_name_input" type="text" class="form-control" placeholder="Address Name" maxlength="12">
            <br>
            <label>Address:</label>
            <input id="address_line1_input" name="address_line1_input"  type="text" class="form-control" placeholder="Address Line 1" maxlength="50">
            <br>
            <input id="address_line2_input" name="address_line2_input" type="text" class="form-control" placeholder="Address Line 2" maxlength="50">
            <br>
            <input id="town_input" name="town_input" type="text" class="form-control" placeholder="Town" maxlength="20">
            <br>
            <input id="country_input" name="country_input" type="text" class="form-control" placeholder="Country" maxlength="20">
            <br>
            <input id="postcode_input" name="postcode_input" type="text" class="form-control" placeholder="Postcode" maxlength="8">
            <input type="hidden" name="address_id" id="address_id">
            <input type="hidden" name="user_email" id="user_email3" value="<?php echo $userInfo['email']; ?>">
        </div>
        <br>
        <button id ="submit_address_update" class="btn btn-lg btn-inverse btn-block pop_up_button">Submit</button>
        <input type="hidden" name="action" value="updateAddress">
        <br>
    </form>
    <form name="deleteAddress" method="post" enctype="multipart/form-data">
        <button id="delete_address" class="btn btn-lg btn-inverse btn-block pop_up_button">Delete</button>
        <input type="hidden" name="action" value="deleteAddress">
        <input type="hidden" name="address_id_delete" id="address_id_delete">
        <br>
    </form>
    <button id="close_edit_address" class="btn btn-lg btn-inverse btn-block pop_up_button">Close</button>
</div>

<div id="changePassword" class="pop_up">
    <form name="editPassword" id="editPassword" method="post" enctype="multipart/form-data">
        <h4>Change Password</h4>
        <br>
        <div id="password_input_wrapper" class="inputWrapper">
            <input id="edit_password" name="edit_password" type="password" class="form-control" placeholder="Password">
            <br>
            <input id="edit_password_verify" name="edit_password_verify" type="password" class="form-control" placeholder="Verify Password">
            <br>
            <input type="hidden" name="user_email" id="user_email1" value="<?php echo $userInfo['email']; ?>">
        </div>
        <button id="submit_change_password" class="btn btn-lg btn-inverse btn-block pop_up_button">Submit</button>
        <input type="hidden" name="action" value="updatePassword">
    </form>
    <br>
    <button id="close_change_password" class="btn btn-lg btn-inverse btn-block pop_up_button">Close</button>
</div>

<div id="editInfo" class="editProfileWrapper">

    <label>Profile Images</label>
    <div class="profileImages">
        <table>
            <tr>
                <th><img id="profile_image_1" name="profile_image_1" class= "profile_img" src="<?php if($profile_image_1_src != null){echo "data:image;base64,".base64_encode($profile_image_1_src);}else{echo "img/blankPic.png";} ?>" alt="Profile Image 1"></th>
                <th><img id="profile_image_2" name="profile_image_2" class= "profile_img" src="<?php if($profile_image_2_src != null){echo "data:image;base64,".base64_encode($profile_image_2_src);}else{echo "img/blankPic.png";} ?>" alt="Profile Image 2" ></th>
            </tr>
            <tr>
                <th><img id="profile_image_3" name="profile_image_3" class= "profile_img" src="<?php if($profile_image_3_src != null){echo "data:image;base64,".base64_encode($profile_image_3_src);}else{echo "img/blankPic.png";} ?>" alt="Profile Image 3"></th>
                <th><img id="profile_image_4" name="profile_image_4" class= "profile_img" src="<?php if($profile_image_4_src != null){echo "data:image;base64,".base64_encode($profile_image_4_src);}else{echo "img/blankPic.png";} ?>" alt="Profile Image 4"></th>
            </tr>
        </table>

        <br>
    </div>
    <br>

    <form name="changeImage1" id="changeImage1" method="post" enctype="multipart/form-data">
        <input type="hidden" name="profile_pic_id" id="profile_pic_1_id" value="<?php if($profile_image_1_id != null){echo $profile_image_1_id;} ?>">
        <input name="profile_pic_input" type="file" accept="image/" id="image_input_1" style="display: none;">
        <input type="hidden" name="action" value="updateImage">
        <input type="hidden" name="user_email" id="user_email4" value="<?php echo $userInfo['email']; ?>">
        <button id="submit_image_1" style="display:none;"></button>
    </form>

    <form name="changeImage2" id="changeImage2" method="post" enctype="multipart/form-data">
        <input type="hidden" name="profile_pic_id" id="profile_pic_2_id" value="<?php if($profile_image_2_id != null){echo $profile_image_2_id;} ?>">
        <input name="profile_pic_input" type="file" accept="image/" id="image_input_2" style="display: none;">
        <input type="hidden" name="action" value="updateImage">
        <input type="hidden" name="user_email" id="user_email5" value="<?php echo $userInfo['email']; ?>">
        <button id="submit_image_2" style="display:none;"></button>
    </form>

    <form name="changeImage3" id="changeImage3" method="post" enctype="multipart/form-data">
        <input type="hidden" name="profile_pic_id" id="profile_pic_3_id" value="<?php if($profile_image_3_id != null){echo $profile_image_3_id;} ?>">
        <input name="profile_pic_input" type="file" accept="image/" id="image_input_3" style="display: none;">
        <input type="hidden" name="action" value="updateImage">
        <input type="hidden" name="user_email" id="user_email6" value="<?php echo $userInfo['email']; ?>">
        <button id="submit_image_3" style="display:none;"></button>
    </form>

    <form name="changeImage4" id="changeImage4" method="post" enctype="multipart/form-data">
        <input type="hidden" name="profile_pic_id" id="profile_pic_4_id" value="<?php if($profile_image_4_id != null){echo $profile_image_4_id;} ?>">
        <input name="profile_pic_input" type="file" accept="image/" id="image_input_4" style="display: none;">
        <input type="hidden" name="action" value="updateImage">
        <input type="hidden" name="user_email" id="user_email7" value="<?php echo $userInfo['email']; ?>">
        <button id="submit_image_4" style="display:none;"></button>
    </form>

    <form name="editInfo" id="editInfo" method="post" enctype="multipart/form-data" onsubmit="validateUpdateInfoData()">
        <button id="delete_pic_button" type="button" class="btn btn-lg btn-inverse btn-block back_button">Delete Profile Picture</button>
        <br>

        <label>Name:</label>
        <input id='forename_change' name="forename_change" type='text' class='form-control' placeholder='Forename' value="<?php echo $userInfo['forename']; ?>" maxlength="25">
        <br>
        <input id='surname_change' name="surname_change" type='text' class='form-control' placeholder='Surname' value="<?php echo $userInfo['surname']; ?>" maxlength="25">
        <br>

        <label>Mobile Number:</label>
        <input id='mobile_number_change' name="mobile_number_change" type='text' class='form-control' placeholder='Mobile Number' value="<?php echo $userInfo['mobile_number']; ?>" maxlength='11'>
        <br>

        <input type="hidden" name="user_email" id="user_email2" value="<?php echo $userInfo['email']; ?>">

        <button id="password_change_button" type="button" class="btn btn-lg btn-inverse btn-block back_button">Change Password</button>
        <br>

        <div id="addressesWrapper">
            <br>
            <label>Addresses</label>
            <div id="address_list">
                <?php
                $counter = 0;
                $userAddresses->data_seek(0);

                if($userAddresses->num_rows > 0){
                    while($userAdd = $userAddresses->fetch_assoc()){
                        echo "<button id='address".$counter."' type='button' class='btn btn-lg btn-inverse btn-block back_button'>".$userAdd["address_name"]."</button>";
                        $counter++;
                    }
                }

                if($userAddresses->num_rows < 5){
                    echo "<button id='addressAdd' type='button' class='btn btn-lg btn-inverse btn-block back_button'>+</button>";
                }

                ?>
            </div>
        </div>

        <br>

        <textarea id="bio_change" name="bio_change" rows="8" cols="25" style="color: black; text-align: left;" placeholder="Biography" maxlength="255"><?php echo $userInfo['bio']; ?> </textarea>
        <br><br>

        <button id="submit_change_info" type="submit" class="btn btn-lg btn-inverse btn-block back_button">Submit Changes</button>
        <input type="hidden" name="action" value="updateInformation">
    </form>
    <br>
</div>

</body>

<footer>
    <!-- JQuery Plugins -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Our own Plugins -->
    <script src="EditProfile.js"></script>

</footer>

<?php

$userAddresses->data_seek(0);
if($userAddresses->num_rows > 0){
    echo '<script>';
    echo 'var addresses = [];';
    echo '</script>';

    while($userAdd = $userAddresses->fetch_assoc()){
        echo '<script>';
        echo 'var array = '.json_encode($userAdd).';';
        echo 'addAddress(array);';
        echo '</script>';
    }

}


?>

</html>

