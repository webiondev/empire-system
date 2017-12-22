<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Course Added";
    $courseid = $_POST["id"];
    $category = $_POST["category"];
    $title = $_POST["title"];
    $image = $_POST["image"];
    $description = $_POST["description"];
    $course_code = $_POST["course_code"];
    $month = $_POST["month"];

    if ($title == "")
    {
      header("location: course.php?courseid=".$courseid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($courseid == "")
      {
        $data[category]=quote_check($category);
        $data[title]=quote_check($title);
        $data[image]=quote_check($image);
        $data[description]=quote_check($description);
        $data[month]=quote_check($month);
        $data[course_code]=quote_check($course_code);
        $data[date_created]=time();
        $courseid = $dbcon->insert("tblcourse",$data);

        header("location: courselist.php?courseid=".$courseid."&success='".urlencode($title)."' added.");
        exit();
      }
      else
      {
        $data[category]=quote_check($category);
        $data[title]=quote_check($title);
        $data[image]=quote_check($image);
        $data[description]=quote_check($description);
        $data[month]=quote_check($month);
        $data[course_code]=quote_check($course_code);
        $dbcon->update("tblcourse",$data,"id = ".quote_smart($courseid));

        header("location: course.php?courseid=".$courseid."&success='".urlencode($title)."' updated.");
        exit();
      }


    }
?>



