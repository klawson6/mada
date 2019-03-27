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

function getAllUsers(){
    $dbconn = dbconn();

    $result = $dbconn->query("SELECT * FROM UserInfo");

    $users = array();
    $user = new User();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $user->name = $row["forename"]." ".$row["surname"];
            $user->bio = $row["bio"];
            $user->age = 18; //todo add proper age calculator
            $user->email =  $row["email"];
            array_push($users,$user);
        }
    }
    $dbconn->close();

    return $users;
}


function selectUser(){
    header('Content-Type: application/json');
    $users = getAllUsers();
    $index = floor(rand(0,sizeof($users)));
    $selected = $users[$index];
    return json_encode($selected);
}