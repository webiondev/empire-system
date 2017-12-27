<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Training Added";
    $trainingid = $_POST["id"];
    $name = $_POST["trainingname"];
    $type = $_POST["type"];
    $description=$_POST["description"];
    $trainerid=$_POST["trainerid"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $country = $_POST["country"];

    
    
    if ($name == "")
    {
      header("location: training.php?trainingid=".$trainingid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($trainingid == "")
      {
        $data[name]=quote_check($name);
        $data[type]=quote_check($type);
        //$data[image]=quote_check($image);
        $data[description]=quote_check($description);
        $data[trainer_id]=quote_check($trainerid);
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);

        $training_id = $dbcon->insert("training",$data);

        if($training_d>0){
          header("location: traininglist.php?trainingid=".$training_id."&success='".urlencode($name)."' added.");
          exit();
        }

        else{
           header("location: traininglist.php?trainerid=".$training_id."&error=An error occur while processing. Please check if record exists.");
          exit();

        }
      }
      else
      {

        $data[name]=quote_check($name);
        $data[type]=quote_check($type);
        //$data[image]=quote_check($image);
        $data[description]=quote_check($description);
        $data[trainer_id]=quote_check($trainerid);
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);
       

        $res=$dbcon->update("training",$data,"idtraining = ".quote_smart($trainingid));

       if($res==1){
          header("location: traininglist.php?trainingid=".$trainingid."&success='".urlencode($name)."' updated.");
          exit();
        }

        else{
           header("location: traininglist.php?trainerid=".$trainingid."&error=An error occur while processing. Please check if record exists.");
          exit();

        }
      }


    }
?>
