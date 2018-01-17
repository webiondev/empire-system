<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


 $dbcon->connect();

    $scriptMsg = "Employee Notified";
    $employeeid = $_POST["id"];
    $idemployment_history=$_POST["id_e_h"];
    $message=$_POST["message"];
    $date_left=$_POST["date"];
    $type=$_POST["type"];
    $email=$_POST["email"];
    
    //get employer_id user_id 
   
    $userid= $dbcon->exec("select user_id from employee where idemployee=".quote_check($employeeid));
    if($userid>0)
      $userid=$dbcon->data_seek(0); 
    
    if($type=="dismiss"){
        $data_h[date_left]=quote_check($date_left);
        $data_h[status]="dismiss";
    

        $dbcon->update("employment_history",$data_h );
        
       $data_m[message]=quote_check($message);
       $data_m[date_time]=date('Y-m-d H:i:s');
       $data_m[user_idfrom]=quote_check($_COOKIE["user_id"]);
       $data_m[user_idfor]=quote_check($userid[user_id]);

       $dbcon->insert("message", $data_m);


      }

    else {

      $data_m[message]=quote_check($message);
       $data_m[date_time]=date('Y-m-d H:i:s');
       $data_m[user_idfrom]=quote_check($_COOKIE["user_id"]);
       $data_m[user_idfor]=quote_check($userid[user_id]);

       $dbcon->insert("message", $data_m);
      



    }
    
   header("location: recruitrequestlist.php?success=New Employee Hired.");
   exit();

            
   

       

    
?>