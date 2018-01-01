<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Profile Updated";
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];


    if ($password != $confirmpassword)
    {
      header("location: updateprofile.php?error=password does not match.");
      exit();
    }
    else
    {
        if ($password)
        {
          $password = bCrypt($password,12);
          $data[password]=$password;
          $data[date_updated]=date('Y-m-d\TH:i:s');
          $dbcon->update("tbluser",$data,"id = ".quote_smart($logon_UserID));
        }


        header("location: updateprofile.php?success=Profile updated.");
        exit();
    }


?>



