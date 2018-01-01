<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Testimonial Added";
    $testimonialid = $_POST["id"];
    $course_id = $_POST["course_id"];
    $person_name = $_POST["person_name"];
    $image = $_POST["image"];
    $content = $_POST["content"];

    if ($person_name == "")
    {
      header("location: testimonial.php?testimonialid=".$testimonialid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($testimonialid == "")
      {
        $data[course_id]=quote_check($course_id);
        $data[person_name]=quote_check($person_name);
        $data[image]=quote_check($image);
        $data[content]=quote_check($content);
        $data[date_created]=time();
        $testimonialid = $dbcon->insert("tbltestimonial",$data);

        header("location: testimoniallist.php?testimonialid=".$testimonialid."&success='".urlencode($person_name)."' added.");
        exit();
      }
      else
      {
        $data[course_id]=quote_check($course_id);
        $data[person_name]=quote_check($person_name);
        $data[image]=quote_check($image);
        $data[content]=quote_check($content);
        $dbcon->update("tbltestimonial",$data,"id = ".quote_smart($testimonialid));

        header("location: testimonial.php?testimonialid=".$testimonialid."&success='".urlencode($person_name)."' updated.");
        exit();
      }


    }
?>



