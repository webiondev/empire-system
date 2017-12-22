<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "User Added";
    $classid = $_POST["id"];
    $code=$_POST["classcode"];
    $building = $_POST["building"];
    $level = $_POST["level"];
    echo $classid;

    // echo $name.$email.$type;
    
    if ($building == "")
    {
      header("location: class.php?class_id=".$classid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($classid == "")
      {
        $data[building]=quote_check($building);
        $data[level]=quote_check($level);
        $data[code]=quote_check($code);
        $class_id = $dbcon->insert("class",$data);

        header("location: classlist.php?classid=".$classid."&success='".urlencode($code)."' added.");
        exit();
      }
      else
      {
        $data[building]=quote_check($building);
        $data[level]=quote_check($level);
        $data[code]=quote_check($code);
        $dbcon->update("class",$data,"idclass = ".quote_smart($classid));

        header("location: classlist.php?classid=".$classid."&success='".urlencode($code)."' updated.");
        exit();
      }


    }
?>
