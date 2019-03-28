<?php
include "utilities.php";
/**
 * Created by IntelliJ IDEA.
 * User: chloe.johston29
 * Date: 24/03/2019
 * Time: 19:46
 */


function connectOrDie(){
    $mysqli = dbconn();
    if($mysqli->connect_errno){
        die("Connect failed: %s ". $mysqli->connect_error);
    }
    return $mysqli;
}

function getPosts($currentUser, $user2){
    $showChats = dbconn()->prepare("SELECT msg FROM Messages where user1=? AND user2=?");
    $showChats->bind_param("ss", $currentUser, $user2);
    if($showChats->execute()) {
        $result = $showChats->get_result();
        if ($result->num_rows > 0) {
            $comments = array();
            while ($row = $result->fetch_assoc()["msg"]) {
                $comments[] = $row;
            }
            $result->close();
            return $comments;
        } else{
            die("Query failed: %s ". $showChats->error);
        }
    }else{
        die("Query failed: %s ". $showChats->error);
    }
}


header("Content-Type:text/plain");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


if (loggedIn()){
    //$currentUser = $_COOKIE["email"];
    //$secondUser =  connectOrDie()->real_escape_string($_GET["secondUser"]);
    $currentUser = "chloe@hotmail.com";
    $secondUser = "kyle@yahoo.com";
    //$firstID = isset($_GET["startID"]) ? $mysqli->real_escape_string($_GET["startID"]) : 0;
    $lines = getPosts($currentUser, $secondUser);
    foreach($lines as $line){
        echo json_encode($line)."\n";
    }
}
