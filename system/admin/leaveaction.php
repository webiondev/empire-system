<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

 $dbcon->connect();


if( $_SERVER['HTTP_REFERER']=='http://localhost:8000/askleave.php'){
//if( $_SERVER['HTTP_REFERER']=='http://portal.empireincholdings.com/system/admin/askleave.php'){


    $scriptMsg = "Ask Leave";
    //$leaveid = $_POST["id"];
    $userid=$_POST["userid"];
    $name=$_POST["name"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $reason=$_POST["reason"];
   

if($start=="" || $end=="" || $reason==""){

    header("location: leave.php?leaveid=".$leaveid."&error=All Fields Required");
   exit();


}
    
else {
    $data[user_id]=quote_check($userid); 
    $data[start]=quote_check($start);
    $data[end]=quote_check($end);
    $data[reason]=quote_check($reason);

    $leaveid=$dbcon->insert("leave_", $data);
   
 

   header("location: leave.php?leaveid=".$leaveid."&success='".urlencode($name)."'\'s leave request sent.");
         exit();
  }

}



else {


    $scriptMsg = "Leave Updated";
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

   } 



?>