<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Course Added";
    $courseid = $_POST["id"];
    $recruitid = $_POST["recruitid"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $coursecode = $_POST["coursecode"];
    $year = $_POST["year"];

   
    if ($title == "")
    {
      header("location: course.php?courseid=".$courseid."&error=An error occur while processing. Please try again.");
      exit();
    }
    else
    {

      if ($courseid == "")
      {
        $data[recruit_id]=quote_check($recruitid);
        $data[name]=quote_check($title);
        $data[description]=quote_check($description);
        $data[year]=quote_check($year);
        $data[code]=quote_check($coursecode);
        $courseid = $dbcon->insert("course",$data);

        var_dump($courseid);
        
        //header("location: courselist.php?courseid=".$courseid."&success='".urlencode($title)."' added.");
        exit();
      }
      else
      {
        $data[recruit_id]=quote_check($recruitid);
        $data[name]=quote_check($title);
        $data[description]=quote_check($description);
        $data[year]=quote_check($year);
        $data[code]=quote_check($coursecode);
        $dbcon->update("course",$data,"idcourse = ".quote_smart($courseid));

        header("location: course.php?courseid=".$courseid."&success='".urlencode($title)."' updated.");
        exit();
      }


    }
?>



