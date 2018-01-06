<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Training Added";
    $interviewid = $_POST["id"];
    $username = $_POST["username"];
    $date_time = $_POST["date_time"];
    $domain=$_POST["domain"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $country = $_POST["country"];

    
    if ($date_time == "")
    {
      header("location: interview.php?interviewid=".$interviewid."&error=An error occur while processing. Date/Time required.");
      exit();
    }
    else
    {

      if ($interviewid == "")
      {
        $data[user_id]=quote_check($_COOKIE["user_id"]);
        $data[date_time]=quote_check($date_time);
       
        $data[domain]=quote_check($domain);
       
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);

        $interview_id = $dbcon->insert("interview",$data);
          header("location: interviewlist.php?interviewid=".$interview_id."&success='".urlencode($date_time)."' added.");
          exit();

      }
      else
      {

      
       $data[date_time]=quote_check($date_time);
       
        $data[domain]=quote_check($domain);
       
        $data[postcode]=quote_check($postcode);
        $data[city]=quote_check($city);
        $data[street]=quote_check($street);
        $data[country]=quote_check($country);
       

        $dbcon->update("interview",$data,"idinterview = ".quote_smart($interviewid));

          header("location: interviewlist.php?interviewid=".$interviewid."&success='".urlencode($date_time)."' updated.");
       
        }
      }


    
?>
