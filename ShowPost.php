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

function getPosts($currentUser, $user2,$msgID){
    $dbconn = dbconn();
    $showChats = $dbconn->prepare("SELECT msgID,msg,user1,user2 FROM Messages where ((user1=? AND user2=?) OR (user1=? AND user2=?)) AND msgID > ?");
    $showChats->bind_param("ssssi", $currentUser, $user2,$user2,$currentUser,$msgID);
    if($showChats->execute()) {
        $result = $showChats->get_result();
        if ($result->num_rows > 0) {
            $comments = array();
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
            $result->close();
            echo json_encode($comments);
        } else{
            die("Query failed no messages");
        }
    }else{
        die("Query failed: %s ". $showChats->error);
    }
}


header("Content-Type:text/plain");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


if (loggedIn()){
    if(validToken()) {
        //$currentUser = $_COOKIE["email"];
        //$secondUser =  connectOrDie()->real_escape_string($_GET["secondUser"]);
        $currentUser = $_SESSION["email"];
        $secondUser = $_GET["otherEmail"];
        //$firstID = isset($_GET["startID"]) ? $mysqli->real_escape_string($_GET["startID"]) : 0;
        getPosts($currentUser, $secondUser, $_GET["msgID"]);
    }
}
