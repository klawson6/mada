<?php
/**
 * Created by IntelliJ IDEA.
 * User: nellieoliver
 * Date: 2019-03-27
 * Time: 11:59
 */

include "utilities.php";

if(isset($_POST['update'])){
    echo selectUser();
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

$current = new User();
$previousUser =$current;

function getAllUsers(){
    $dbconn = dbconn();

    $result = $dbconn->query("SELECT * FROM UserInfo");
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


function selectUser(){
    header('Content-Type: application/json');
    $users = getAllUsers();
    $index = floor(rand(0,sizeof($users)-1));

    $current = $users[$index];

    return json_encode($current);
}