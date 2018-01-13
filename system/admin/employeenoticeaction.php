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
    
    //get employer_id  and get company name
    
    
    if($type=="dismiss"){
        $data_h[date_left]=quote_check($date_left);
        $data_h[status]="dismiss";
    

        $dbcon->update("employment_history",$data_h );
        
        //mail to  employee 
        //mail("empire email","subject",$message);

        //mail to staff if firing
      }

    else {

      //mail message to employee
      //mail("rahman@d2j.com","my subject",$message);
      



    }
    
   header("location: recruitrequestlist.php?success=New Employee Hired.");
   exit();

            
   

       

    
?>