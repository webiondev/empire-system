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



        header("location: hire.php?recruitid=".$recruitid."&error=An error occur while processing. Date required.");
        exit();
    }

    else{
        
       

        $data[employer_id]=quote_check($employer_id);
        //$data[recruit_id]=quote_check($recruitid);
        $data[description]=quote_check($description);
        $data[date_time]=quote_check($date);
        //$data[recruit_id]=quote_check($recruitid);

        $idemployer_notification=$dbcon->insert("employer_notification", $data);

       $data_m[message]=quote_check($description);
       $data_m[date_time]=date('Y-m-d H:i:s');
       $data_m[user_idfrom]=quote_check($_COOKIE["user_id"]);
       $data_m[user_idfor]=quote_check("1");//admin

       $dbcon->insert("message", $data_m);

        

        header("location: requestlist.php?recruitid=".$recruitid."&success=Request Hire Sent.");
        exit();

            
       }

       

    
?>

