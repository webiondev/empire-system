<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();

    $scriptMsg = "Course Added";
    $courseid = $_POST["id"];
   
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
       
        $data[name]=quote_check($title);
        $data[description]=quote_check($description);
        $data[year]=quote_check($year);
        $data[code]=quote_check($coursecode);
        $course_id = $dbcon->insert("course",$data);

       
       if($course_id>0){
        header("location: courselist.php?courseid=".$course_id."&success='".urlencode($title)."' added.");
        exit();
      }

      else{

        header("location: courselist.php?courseid=".$course_id."&error=An error occur while processing. Please check if record exists.");
        exit();


      }
      }
      else
      {
        
        $data[name]=quote_check($title);
        $data[description]=quote_check($description);
        $data[year]=quote_check($year);
        $data[code]=quote_check($coursecode);
        $res=$dbcon->update("course",$data,"idcourse = ".quote_smart($courseid));

        if($res==1){
        header("location: course.php?courseid=".$courseid."&success='".urlencode($title)."' updated.");
        exit();

      }

        else{
            header("location: courselist.php?courseid=".$courseid."&error=An error occur while processing. Please check if record exists.");
        exit();

        }
      }


    }
?>



