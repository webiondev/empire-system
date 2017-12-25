<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "User Added";
    $userid = $_POST["id"];
    $name = $_POST["username"];
    $image = $_POST["image"];
    $email = $_POST["email"];
    $type = $_POST["type"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $country = $_POST["country"];

    
    
    if ($email == "")
    {
      header("location: user.php?userid=".$userid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($userid == "")
      {
        $data[name]=quote_check($name);
        $data[type]=quote_check($type);
        //$data[image]=quote_check($image);
        $data[email]=quote_check($email);
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);

        $user_id = $dbcon->insert("user",$data);

        header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' added.");
        exit();
      }
      else
      {

        $data[name]=quote_check($name);
        $data[type]=quote_check($type);
        //$data[image]=quote_check($image);
        $data[email]=quote_check($email);
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);
       

        $res=$dbcon->update("user",$data,"iduser = ".quote_smart($userid));


        header("location: userlist.php?userid=".$userid."&success='".urlencode($country)."' updated.");
        exit();
      }


    }
?>
