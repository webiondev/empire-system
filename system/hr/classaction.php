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
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $country = $_POST["country"];

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
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);

        if($class_id>0){
          
          header("location: classlist.php?classid=".$class_id."&success='".urlencode($code)."' added.");
          exit();

      }
      else{

         header("location: classlist.php?classid=".$class_id."&error=An error occur while processing. Please check if record exists.");
          exit();

      }
      }
      else
      {
        $data[building]=quote_check($building);
        $data[level]=quote_check($level);
        $data[code]=quote_check($code);
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);
        $res=$dbcon->update("class",$data,"idclass = ".quote_smart($classid));

        if($res==1){
        header("location: classlist.php?classid=".$classid."&success='".urlencode($code)."' updated.");
        exit();
      }
      else{
        header("location: classlist.php?classid=".$classid."&error=An error occur while processing. Please check if record exists.");
          exit();

      }
      }


    }
?>
