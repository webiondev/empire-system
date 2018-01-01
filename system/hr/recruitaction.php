<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


  $dbcon->connect();



    $scriptMsg = "Recruit Added";
    $recruitid = $_POST["id"];
    $interview = $_POST["interview"];
    $userid = $_POST["userid"];
    $applied = $_POST["applied"];
    $date = $_POST["date"];
    $employeeid = $_POST["employeeid"];
    $courseid = $_POST["courseid"];
    $image=$_POST["image"];
   
    
    if ($applied == "")
    {
      header("location: recruit.php?recruitid=".$recruitid."&error=An error occur while processing. Please try again. 'Applied For' field required");
      exit();
    }
    else
    {

      if ($recruitid == "")
      {

        $data[interview_id]=quote_check($interview);
        $data[user_id]=quote_check($userid);
        $data[file]=quote_check($image);
        $data[applied_for]=quote_check($applied);
        $data[date_applied]=quote_check($date);
        $data[employee_id]=quote_check($employeeid);
        $data[course_id]=quote_check($courseid);

       
      
        $recruit_id =$dbcon->insert("recruit", $data);

        var_dump($recruitid);
       
        
        // if ($recruit_id>0){

        //     header("location: recruitlist.php?recruitid=".$recruit_id."&success='".urlencode($recruit_id)."' added.");
        //     exit();
        // }
        // else{
        //     header("location: recruitlist.php?recruitid=".$recruit_id."&error=An error occur while processing. Please check if employee/course/interview exists.");
        //     exit();

        // }

      }
      else
      {

     $data[interview_id]=quote_check($interview);
        $data[user_id]=quote_check($userid);
        $data[file]=quote_check($image);
        $data[applied_for]=quote_check($applied);
        $data[date_applied]=quote_check($date);
        $data[employee_id]=quote_check($employeeid);
        $data[course_id]=quote_check($courseid);
       

        $res=$dbcon->update("recruit",$data,"idrecruit = ".quote_smart($recruitid));

        if(res==1){
        header("location: recruitlist.php?recruitid=".$recruitid."&success='".urlencode($recruitid)."' updated.");
        exit();
    }
        else{
         header("location: recruitlist.php?recruitid=".$recruitid."&error=An error occur while processing. Please check if employee/course/interview exists.");
        exit();   
    }

      }


    }
?>
