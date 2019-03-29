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

function addNewPost($post, $user1, $user2){
    $dbconn = dbconn();
    $stmt = $dbconn->prepare("INSERT INTO Messages(msg, user1, user2) VALUES(?,?,?)");
    $stmt->bind_param("sss", $post, $user1, $user2);
    $stmt->execute();
//    if (!$stmt->execute()){
//        die("Query failed: %s".$stmt->error);
//    }
}

if(loggedIn()) {
    if (validToken()) {
        if (isset($_POST["msg"]) && isset($_POST["otherEmail"])) {
// echo("Done");
            $post = $_POST["msg"];
            $userA = $_SESSION["email"];
            $userB = urldecode($_POST["otherEmail"]);
            //echo("Before Send");
            addNewPost($post, $userA, $userB);
            //echo("Done");
        } //echo "$id";
//}
    }
}