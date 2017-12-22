<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $idcourse = $_GET["courseid"];
    $iduser=$_GET["userid"];
    $idclass = $_GET["classid"];
    

   
      if($idcourse){

      	$dbcon->exec("DELETE FROM course WHERE id = ".quote_smart($id));
      	  header("location: courselist.php?courseid=".$idcourse."&success='".urlencode($idcourse)."' deleted.");
      }	

      else if ($iduser){

      	$dbcon->exec("DELETE FROM user WHERE iduser = ".quote_smart($iduser));
      	 header("location: userlist.php?userid=".$iduser."&success='".urlencode($iduser)."' deleted.");
      }	

       else if ($idclass){

      	$dbcon->exec("DELETE FROM class WHERE idclass = ".quote_smart($idclass));
      	 header("location:classlist.php?classid=".$idclass."&success='".urlencode($idclass)."' deleted.");
      }

      else

      	 header("location: index.php"."&error=An error occur while processing. Please try again.");

      
    
?>



