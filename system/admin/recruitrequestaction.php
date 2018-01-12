<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

 $dbcon->connect();

    $scriptMsg = "Request Sent";
    $recruitid = $_GET["recruit_iduser"];
     $employerid = $_GET["employer_iduser"];
    

        
      
            $data[recruit_iduser]=quote_check($recruitid);
             $data[employer_iduser]=quote_check($employerid);
            $data[date]=date('Y-m-d');
            
            
           
            $request_id=$dbcon->insert("recruitrequest", $data);

            //send email to employer to notify him of new request

            header("location:employerlist.php?requestid=".$request_id."&success=Request Sent.");
            exit();
       
   

       

    
?>