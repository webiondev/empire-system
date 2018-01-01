<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $idcourse = $_GET["courseid"];
    $iduser=$_GET["userid"];
    $idclass = $_GET["classid"];
    $idtraining=$_GET["trainingid"];
    $idrecruit=$_GET["recruitid"];
    

   
      if($idcourse){

      	$dbcon->exec("DELETE FROM course WHERE idcourse = ".quote_smart($idcourse));
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
      else if ($idtraining){

         $dbcon->exec("DELETE FROM training WHERE idtraining = ".quote_smart($idtraining));
         header("location:traininglist.php?trainingid=".$idtraining."&success='".urlencode($idtraining)."' deleted.");
      }

        else if ($idrecruit){

         $dbcon->exec("DELETE FROM recruit WHERE idrecruit = ".quote_smart($idrecruit));
         header("location:recruitlist.php?recruitid=".$idrecruit."&success='".urlencode($idrecruit)."' deleted.");
      }
      
      
    
?>



