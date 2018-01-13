<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

 $dbcon->connect();

    $scriptMsg = "Enquiry Added";
    $enquiryid = $_POST["id"];
    $name=$_POST["name"];
    $date_time = $_POST["date_time"];
    $description=$_POST["description"];
    $email=$_POST["email"];
    
   


    

    if ($date_time=="" || $description=="" || $name==""){

        header("location: enquiry.php?enquiryid=".$enquiryid."&error=An error occur while processing. Name, Date/Time and Description required.");
        exit();
    }

    else{
        
        if(empty($enquiryid)){
        
            $data[enquirer]=quote_check($name);
            $data[date_time]=quote_check($date_time);
            $data[description]=quote_check($description);
             $data[email]=quote_check($email);
            
            $enquiryid=$dbcon->insert("enquiry", $data);

           
            header("location: enquirylist.php?enquiryid=".$enquiryid."&success=New Enquiry Added.");
            exit();
       
       }


       else{


            $data[enquirer]=quote_check($name);
            $data[date_time]=quote_check($date_time);
            $data[description]=quote_check($description);
            $data[email]=quote_check($email);

            $dbcon->update("enquiry", $data,"idenquiry = ".quote_smart($enquiryid));

           header("location: enquirylist.php?enquiryid=".$enquiry_id."&success=Enquiry Updated.");
           exit();


          }
            
       }

       

    
?>