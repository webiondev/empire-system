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
    
    //get employer_id  and get company name
    
    
    if($type=="dismiss"){
        $data_h[date_left]=quote_check($date_left);
        $data_h[status]="dismiss";
    
        var_dump($data_h);

        $dbcon->update("employment_history",$data_h );
        
        //mail to  employee 

        //mail to staff if firing
      }

    else {

      //mail message to employee



    }
    
   //header("location: recruitrequestlist.php?success=New Employee Hired.");
   exit();

            
   

       

    
?>