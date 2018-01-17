<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


 $dbcon->connect();

    $scriptMsg = "Recruit Hired";
    $recruit_iduser = $_POST["id"];
    $employer_iduser=$_POST["userid"];
    $position=$_POST["position"];
    $date_joined=$_POST["date"];

    
    //get employer_id  and get company name
    $employer = $dbcon->exec("select idemployer, company from employer where user_id = ".quote_smart($employer_iduser));

     if ($employer > 0)
    {
      $strAction = "Hire";
      $row=$dbcon->data_seek(0);
       }

    $data[user_id]=quote_check($recruit_iduser);
    
    $idemployee=$dbcon->insert("employee", $data);

    $data_h[status]="Active";
    $data_h[company]=quote_check($row[company]);
    $data_h[position]=quote_check($position);
    $data_h[employer_id]=quote_check($row[idemployer]);
    $data_h[employee_id]=quote_check($idemployee);

    $data_h[date_joined]=quote_check($date_joined);

    // var_dump($data);
    // echo '<br/>';
    // var_dump($data_h);

   $idemployment_history=$dbcon->insert("employment_history",$data_h );
   $data_m[message]="You have been hired. Join date:".quote_check("$date_joined");
   $data_m[date_time]=date('Y-m-d H:i:s');
   $data_m[user_idfrom]=quote_check($_COOKIE["user_id"]);
   $data_m[user_idfor]=quote_check($recruit_iduser);

   //message to recruit
   $dbcon->insert("message", $data_m);
   

   header("location: recruitrequestlist.php?success=Offer sent to recruit.");
   exit();

            
   

       

    
?>