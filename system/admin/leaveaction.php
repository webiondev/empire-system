<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

 $dbcon->connect();

    $scriptMsg = "Training Added";
    $leaveid = $_POST["id"];
    $userid=$_POST["userid"];
    $name=$_POST["name"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $reason=$_POST["reason"];
    $status=$_POST["status"];

    

    $data[start]=quote_check($start);
    $data[end]=quote_check($end);
    $data[status]=quote_check($status);

    $dbcon->update("leave_", $data,"idleave = ".quote_smart($leaveid));
   

   header("location: leavelist.php?leaveid=".$leaveid."&success='".urlencode($name)."'\'s leave status updated.");
         exit();

?>