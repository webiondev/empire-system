<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $idcourse = $_GET["courseid"];
    $iduser=$_GET["userid"];
    $idclass = $_GET["classid"];
    $idtraining=$_GET["trainingid"];
    $idinterview=$_GET["interviewid"];
    $idattendance=$_GET["attendanceid"];
    $idleave=$_GET["leaveid"];
    $idenquiry=$_GET["enquiryid"];
    $idemployment_notif=$_GET["idemployment_notif"];
    $idrequest=$_GET["requestid"];
     $idrequest_r=$_GET["requestid_r"];
   
      if($idcourse){

      	$dbcon->exec("DELETE FROM course WHERE idcourse = ".quote_smart($idcourse));
      	  header("location: courselist.php?courseid=".$idcourse."&success='".urlencode($idcourse)."' deleted.");
      }	

      else if ($iduser){

      	$dbcon->exec("DELETE FROM user WHERE iduser = ".quote_smart($iduser));
      	 var_dump($iduser);
         header("location: userlist.php?userid=".$iduser."&success='".urlencode($iduser)."' deleted.");
      }	

       else if ($idclass){

      	 $dbcon->exec("DELETE FROM class WHERE idclass = ".quote_smart($idclass));
      	 header("location:classlist.php?classid=".$idclass."&success='".urlencode($idclass)."' deleted.");
      }
      else if ($idtraining){

         $dbcon->exec("DELETE FROM training WHERE idtraining = ".quote_smart($idtraining));
         header("location:traininglist.php?trainingid=".$idtraining."&success='".urlencode($idtraining)."' deleted.");
      }

     else if ($idinterview){

         $dbcon->exec("DELETE FROM interview WHERE idinterview = ".quote_smart($idinterview));
         header("location:interviewlist.php?interviewid=".$idinterview."&success='".urlencode($idinterview)."' deleted.");
      }

    else if ($idattendance){

         $dbcon->exec("DELETE FROM attendance WHERE idattendance = ".quote_smart($idattendance));
         header("location:attendancelist.php?attendanceid=".$idattendance."&success='".urlencode($idattendance)."' deleted.");
      }
    
    else if ($idleave){

         $dbcon->exec("DELETE FROM leave WHERE idleave = ".quote_smart($idleave));
         header("location:leavelist.php?leaveid=".$idleave."&success='".urlencode($idleave)."' deleted.");
      }
     else if ($idenquiry){

         $dbcon->exec("DELETE FROM enquiry WHERE idenquiry = ".quote_smart($idenquiry));
         header("location:enquirylist.php?enquiryid=".$idenquiry."&success='".urlencode($idenquiry)."' deleted.");
      }

    else if ($idemployment_notif){

         $dbcon->exec("DELETE FROM employer_notification WHERE idnotification = ".quote_smart($idemployment_notif));
         header("location:requestlist.php?idemployment_notif=".$idemployment_notif."&success='".urlencode($idemployment_notif)."' deleted.");
      }
    else if ($idrequest){//employer reject recruit request

         $dbcon->exec("DELETE FROM recruitrequest WHERE idrequest = ".quote_smart($idrequest));
         header("location:recruitrequestlist.php?idrequest=".$idrequest."&success='".urlencode($idrequest)."' deleted.");
      }  
     
    else if ($idrequest_r){//recruit reject his/her request

         $dbcon->exec("DELETE FROM recruitrequest WHERE idrequest = ".quote_smart($idrequest_r));
         header("location:myrequestlist.php?idrequest_r=".$idrequest_r."&success='".urlencode($idrequest_r)."' deleted.");
      }   
?>



