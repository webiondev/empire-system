<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");




 $dbcon->connect();

    $scriptMsg = "Request Sent";
    $recruitid = $_POST["id"];
    $date=$_POST["date"];
    $description=$_POST["description"];
    
    $employer_id=$dbcon->exec("select * from employer where user_id = ".quote_smart($_COOKIE["user_id"]));

   

    if ($date==""){



        header("location: hire.php?recruit_id=".$recruitid."&error=An error occur while processing. Date required.");
        exit();
    }

    else{
        
       

        $data[employer_id]=quote_check($employer_id);
        //$data[recruit_id]=quote_check($recruitid);
        $data[description]=quote_check($description);
        $data[date_time]=quote_check($date);
        

        $idemployer_notification=$dbcon->insert("employer_notification", $data);

        //var_dump($data);

        //send mail to staff

        header("location: requestlist.php?recruitid=".$recruitid."&success=Request Hire Sent.");
        exit();

            
       }

       

    
?>

