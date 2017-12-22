<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "image Added";

    $bannerid=$_POST["id"];
    $title=$_POST["title"];
    $image = $_POST["image"];
    $link= $_POST["link"];
    

   
  


    if ($title=="")
    {
       header("location: slider.php?bannerid=".$bannerid."&error=An error occur while processing. Please try again.");
      exit();
    }

     else {
      
      if ($bannerid == "")
      {
       

        $data[title]=quote_check($title);
        $data[image]=quote_check($image);
        $data[url_path]=quote_check($link);
        $data[date_created]=time();
        $bannerid = $dbcon->insert("tblbanner",$data);

        
        header("location: sliderlist.php?bannerid=".$bannerid."&success='".urlencode($title)."' added.");
        exit();
      }
      else
      {
        
        $data[title]=quote_check($title);
        $data[image]=quote_check($image);
        $data[url_path]=quote_check($link);
        $dbcon->update("tblbanner",$data,"id = ".quote_smart($bannerid));

        header("location: slider?bannerid=".$bannerid."&success='".urlencode($title)."' updated.");
        exit();
        exit();
      }

    }

      
?>



