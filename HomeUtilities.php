<?php
/**
 * Created by IntelliJ IDEA.
 * User: nellieoliver
 * Date: 2019-03-27
 * Time: 11:59
 */
session_start();
include "utilities.php";

$choice = "rider";

if(!loggedIn()){
    header("Location: Index.php", true, 301);
    exit();
}

if(isset($_POST['unset'])){
    session_unset();
    session_destroy();
}

if(isset($_POST['save'])){
    if($_POST['save']==="yes"){
        $_SESSION["previous"] = $_SESSION["current"];

    }
    else if($_POST['save'] === "reset"){
        unset($_SESSION['previous']);
    }
}

if(isset($_POST['update'])){
    //this must be where it is breaking
    $user =selectUser($choice,$_SESSION["email"]);
    echo $user;



}

if(isset($_POST['rewind'])){
    if(isset($_SESSION["previous"])) {
        echo json_encode( $_SESSION["previous"]);
        unset($_SESSION['previous']);
    }else{
        $u = $_SESSION["current"] ;
        $u->name = "no";
        echo json_encode($u);
    }
}

if(isset($_POST['liked'])){
    addLinkedUser($_POST['liked'],$_SESSION["email"]);
}

if(isset($_POST['change'])){
    if($_POST['change'] == "driver"){
        $choice = "driver";
    }else{
        $choice = "rider";
    }
}

class User{
    public $email;
    public $name;
    public $age;
    public $coverImg;
    public $photo1;
    public $photo2;
    public $photo3;
    public $photo4;
    public $bio;
};



function addLinkedUser($user,$email){

    $conn = dbconn();
    $sql = "INSERT INTO LinkedUsers (Email1, Email2) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$email,$user);

    $stmt->execute();
}


function getAllUsers($choice,$email){
    $dbconn = dbconn();
    /*
     * SELECT * FROM UserInfo WHERE Rider = 1 AND email <> 'a@a.com' AND email NOT IN (SELECT Email1 FROM LinkedUsers WHERE 'a@a.com' = Email1)
     * AND email NOT IN (SELECT Email2 FROM LinkedUsers WHERE 'a@a.com' = Email2)
     */

    $innersql1 = "email NOT IN (SELECT Email1 FROM LinkedUsers WHERE '".$email . "' = Email1)";
    $innersql2 = "email NOT IN (SELECT Email2 FROM LinkedUsers WHERE '". $email."' = Email2)";

    $sql = "SELECT * FROM UserInfo WHERE Rider = 1 AND email <> '" .$email ."' AND ". $innersql1 . " AND " . $innersql2;


    if($choice == "driver"){
        $sql = "SELECT * FROM UserInfo WHERE Driver = 1 AND email <> '" .$email ."' AND ". $innersql1 . " AND " . $innersql2;
    }

    $result = $dbconn->query($sql);
    $users = array();
    $user = new User();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $user->name = $row["forename"]." ".$row["surname"];
            $user->bio = $row["bio"];
            $today = new DateTime();
            $dob = new DateTime($row["date_of_birth"]);
            $difference = ($today->diff($dob));
            $user->age = $difference->format('%y');
            $user->email =  $row["email"];

            $conn = dbconn();

            $photoStmt = $conn->query("SELECT * FROM Photo WHERE email = '".$row['email']."'");
            $loop = 0;

            if($photoStmt->num_rows > 0) {
                while ($photoRow = $photoStmt->fetch_assoc()) {
                    if($loop == 0){
                        $user->coverImg = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
                    }
                    else if($loop == 1){
                        $user->photo1 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
                    }
                    else if($loop == 2){
                        $user->photo2 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
                    }
                    else if($loop == 3){
                        $user->photo3 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
                    }
                    else if($loop == 4){
                        $user->photo4 = "data:image/jpg;base64, ".base64_encode($photoRow['photo']);
                    }

                    $loop++;
                }
                if($loop<1){
                    $user->photo1 = null;
                    $user->photo2 = null;
                    $user->photo3 = null;
                    $user->photo4 = null;
                }

                if($loop<2){
                    $user->photo2 = null;
                    $user->photo3 = null;
                    $user->photo4 = null;
                }

                if($loop<3){
                    $user->photo3 = null;
                    $user->photo4 = null;
                }

                if($loop<4){
                    $user->photo4 = null;
                }
            }

            array_push($users,$user);
            $user = new User();
        }
    }
    $dbconn->close();

    return $users;
}


function selectUser($choice,$email){
    header('Content-Type: application/json');

    $users = getAllUsers($choice,$email);
    $index = floor(rand(0,sizeof($users)-1));
    $_SESSION["current"] =  $users[$index];
    $current = $users[$index];

   // $e = 2;

    return json_encode($current);
}