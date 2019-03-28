 <?php
 include "utilities.php";

/**
 * Created by IntelliJ IDEA.
 * User: chloe.johnston29
 * Date: 24/03/2019
 * Time: 18:40
 */

function connectOrDie(){

    $mysqli = dbconn();
    if($mysqli->connect_errno){
        die("Connect failed: %s ". $mysqli->connect_error);
    }
    return $mysqli;
}

function addNewPost($post, $postID, $user1, $user2){
    $mysqli = dbconn()->prepare("INSERT INTO Messages(msgID, msg, user1, user2) VALUES(?,?,?,?)");
    $mysqli->bind_param("isss", $postID, $post, $user1, $user2);
    if (!$mysqli->execute()){
        die("Query failed: %s".$mysqli->error);
    }
}

if (loggedIn()) {

    $mysqli = connectOrDie();
    $post = $mysqli->real_escape_string(urldecode($_POST["msg"]));
    $postID = $mysqli->real_escape_string(urldecode($_POST["msgID"]));
    $userA = "chloe@yahoo.com";
    $userB = "kyle@yahoo.com";

    addNewPost($post, $postID, $userA, $userB);
    //echo "$id";
}