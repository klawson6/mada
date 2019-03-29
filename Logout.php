<?php
session_start();
setcookie("email","",time()-3600);
setcookie("smsCode","",time()-3600);
session_unset();
session_destroy();
if(isset($_GET["token"]) && $_GET["token"]=="invalid"){
    header("Location: Index.php?token=invalid");
    die();
}
header("Location: Index.php");
die();
?>