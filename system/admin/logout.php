<?php
include_once("inc/cDbcon.php");
$dbcon->close();
$dbcon2->close();
var_dump ($_SESSION);
setcookie ("username", "", time() - 3600, "/");
setcookie ("userID", "", time() - 3600, "/");
setcookie ("logon", "", time() - 3600, "/");
var_dump ($_SESSION);

header("Location: ./");
exit();
?>