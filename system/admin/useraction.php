<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();
 
  if ($_POST[type]==""){

     header("location: user.php?userid=".$userid."&error=An error occur while processing. Type Needed.");
      exit();
    }

   $type= (explode("-",$_POST[type]));

   //check if date is null
   if (empty ($_POST["datej"]))
     $_POST["datej"]='0000-00-00';// $flag_j=true;

   if (empty ($_POST["datel"]))
     $_POST["datel"]='0000-00-00';// $flag_l=true;

   if (empty ($_POST["date"]))
     $_POST["datea"]='0000-00-00 00:00:00';// $flag_l=true;

   if (empty ($_POST["datea"]))
     $_POST["datea"]='0000-00-00';// $flag_l=true;
  
 
   switch ($type[0]) {
       
           case "Admin":

                $scriptMsg = 'New'." ".$type[0]." ".'Added';
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }
                else
                {

                  if ($userid == "")
                  {
                    //user
                    $data[name]=quote_check($name);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                    $data[email]=quote_check($email);
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);

                    $user_id = $dbcon->insert("user",$data);

                 

                        header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                        exit();
                    


                    }

                  else   
                  {
                    //user
                    $data[name]=quote_check($name);
                     $data[email]=quote_check($email);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                   
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);
                   
                   
                    
                    $dbcon->update("user",$data,"iduser = ".quote_smart($userid));
                    
                    header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' updated.");
                
              
            }
        }

            
                break;

           case "Staff":
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $position= $_POST["position"];
                $role=$_POST["role"];
                $datej=$_POST["datej"];
                $datel=$_POST["datel"];
                $branch=$_POST["branch"];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];

                $branch = $dbcon->exec("select idbranch from branch where name = ".quote_smart($branch));

                

                if($branch>0){
                  $row=$dbcon->data_seek(0);
                   $data_s[branch_id]=quote_check($row[idbranch]);
                }

                else
                     $data_s[branch_id]="-1";

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }
                else
                {

                  if ($userid == "")
                  {
                    //user
                    $data[name]=quote_check($name);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                    $data[email]=quote_check($email);
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);
                    $user_id = $dbcon->insert("user",$data);

                    //staff 
                    
                    $data_s[user_id]=quote_check($user_id);  
                    $data_s[position]=quote_check($position);
                    $data_s[role]=quote_check($role);
                    
                    $data_s[date_joined]=quote_check($datej);
                    $data_s[date_left]=quote_check($datel);
                    $staff_id= $dbcon->insert("staff", $data_s);

                  

                 
                        header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                        exit();
                    

                  }
                  else
                  {
                    //user
                    $data[name]=quote_check($name);
                    $data[email]=quote_check($email);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                   
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);
                    $dbcon->update("user",$data,"iduser = ".quote_smart($userid));
                   

                     //staff 
                   
                    $data_s[position]=quote_check($position);
                    $data_s[role]=quote_check($role);
                    
                    $data_s[date_joined]=quote_check($datej);
                    $data_s[date_left]=quote_check($datel);
                    $dbcon->update("staff",$data_s,"user_id = ".quote_smart($userid));

                 

               
                     header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' updated.");
               


                  }


                }
                    break;

             case "Lecturer":
                
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];
                $datej = $_POST["datej"];
                $datel = $_POST["datel"];
                $phone= $_POST["phone"];


                 if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }

                else{
                  if($userid==""){

                     //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $user_id = $dbcon->insert("user",$data);

                     //lecturer
                     
                     $data_l[phone]=quote_check($phone);
                     $data_l[date_joined]=quote_check($datej);
                     $data_l[date_left]=quote_check($datel);
                     $data_l[user_id]=quote_check($user_id);

                     $lect_id=$dbcon->insert("lecturer",$data_l);

                      header("location: userlist.php?userid=".$user_id."&success='".urlencode($scriptMsg));
                          exit();

                     
                  }

                  else {


                       //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $dbcon->update("user",$data,"iduser = ".quote_smart($userid));

                     //lecturer
                    
                     $data_l[phone]=quote_check($phone);
                     $data_l[date_joined]=quote_check($datej);
                     $data_l[date_left]=quote_check($datel);
                     

                     //update
                     $dbcon->update("lecturer",$data_l,"user_id = ".quote_smart($userid));
                      
                      
                   

                      header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' updated.");
                        exit();


                  }
              }

                break;

             case "Trainer":
                
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];
                $datej = $_POST["datej"];
                $datel = $_POST["datel"];
                $phone= $_POST["phone"];
                $expertise=$_POST["expertise"];

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }

                else{
                  if($userid==""){

                     //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $user_id = $dbcon->insert("user",$data);

                     //lecturer
                     
                     $data_t[phone]=quote_check($phone);
                     $data_t[date_joined]=quote_check($datej);
                     $data_t[date_left]=quote_check($datel);
                     $data_t[user_id]=quote_check($user_id);
                     $data_t[expertise]=quote_check($expertise);

                     $trainer_id=$dbcon->insert("trainer",$data_t);

                      header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                          exit();

                     
                  }

                  else {


                       //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $dbcon->update("user",$data,"iduser = ".quote_smart($userid));

                     //Trainer
                    
                     $data_t[phone]=quote_check($phone);
                     $data_t[date_joined]=quote_check($datej);
                     $data_t[date_left]=quote_check($datel);
                     $data_t[expertise]=quote_check($expertise);
                     
                     //update
                     $dbcon->update("trainer",$data_t,"user_id = ".quote_smart($userid));
                      
                   

                      header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' updated.");
                        exit();


                  }
              }

                break;
             case "Employer":
                
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];
                $datej = $_POST["datej"];
                $datel = $_POST["datel"];
                $phone= $_POST["phone"];
                $company=$_POST["company"];
                $position=$_POST["position"];
                $phone=$_POST["phone"];

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }

                else{
                  if($userid==""){

                     //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $user_id = $dbcon->insert("user",$data);

                     //employer
                     
                     $data_e[company]=quote_check($company);
                     $data_e[position]=quote_check($position);
                     $data_e[phone]=quote_check($phone);
                     
                     $data_e[date_joined]=quote_check($datej);
                     $data_e[date_left]=quote_check($datel);
                     $data_e[user_id]=quote_check($user_id);
                    
                     $employer_id=$dbcon->insert("employer",$data_e);

                      header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                          exit();

                     
                  }

                  else {


                       //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $dbcon->update("user",$data,"iduser = ".quote_smart($userid));

                     //Trainer
                    
                     $data_e[company]=quote_check($company);
                     $data_e[position]=quote_check($position);
                     $data_e[phone]=quote_check($phone);
                     $data_e[date_joined]=quote_check($datej);
                     $data_e[date_left]=quote_check($datel);
                     
                     
                     //update
                     $dbcon->update("employer",$data_e,"user_id = ".quote_smart($userid));
                      
                     

                      header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' updated.");
                        exit();


                  }
              }
                break;
             case "Employee":
                
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];
                $datej = $_POST["datej"];
                $datel = $_POST["datel"];
                $phone= $_POST["phone"];
                $company=$_POST["company"];
                $position=$_POST["position"];
                $phone=$_POST["phone"];

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }

                else{
                  if($userid==""){

                     //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $user_id = $dbcon->insert("user",$data);

                     //employee
                     
                     $data_ee[company]=quote_check($company);
                     $data_ee[position]=quote_check($position);
                     $data_ee[phone]=quote_check($phone);
                     
                     $data_ee[date_joined]=quote_check($datej);
                     $data_ee[date_left]=quote_check($datel);
                     $data_ee[user_id]=quote_check($user_id);
                    
                     $employee_id=$dbcon->insert("employee",$data_ee);

                      header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                          exit();

                     
                  }

                  else {


                       //user
                     $data[name]=quote_check($name);
                     //$data[image]=quote_check($image);
                     $data[email]=quote_check($email);
                     $data[type]=quote_check($type);
                     $data[postcode]=quote_check($postcode);
                     $data[city]=quote_check($city);
                     $data[street]=quote_check($street);
                     $data[country]=quote_check($country);
                     $dbcon->update("user",$data,"iduser = ".quote_smart($userid));

                     //employee

                     $data_ee[company]=quote_check($company);
                     $data_ee[position]=quote_check($position);
                     $data_ee[phone]=quote_check($phone);
                     
                     $data_ee[date_joined]=quote_check($datej);
                     $data_ee[date_left]=quote_check($datel);
                     
                     
                     //update
                     $dbcon->update("employee",$data_ee,"user_id = ".quote_smart($userid));
                      
                     

                      header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' updated.");
                        exit();


                  }
              }
                break;
             case "Recruit":
                
                $scriptMsg = "New".$type[0]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $type[0];
                $interviewid=$_POST["idinterview"];
                $courseid=$_POST["idcourse"];
                $applied=$_POST["applied"];
                $phone=$_POST["phone"];
                $file=$_POST["cv"];  
               
                $datea=$_POST["datea"];
                $postcode = $_POST["postcode"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $country = $_POST["country"];


                
             
             

                if ($email == "")
                {
                  header("location: user.php?userid=".$userid."&error=An error occur while processing. Email Needed.");
                  exit();
                }
                else
                {

                  if ($userid == "")
                  {
                    //user
                    $data[name]=quote_check($name);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                    $data[email]=quote_check($email);
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);
                    $user_id = $dbcon->insert("user",$data);

                    //Recruit
                    
                    
                    $data_r[interview_id]=quote_check($interviewid);
                    $data_r[user_id]=quote_check($user_id);  
                    $data_r[applied_for]=quote_check($applied);
                    //$data[file]=quote_check($cv);
                    $data_r[phone]=quote_check($phone);
                    
                    $data_r[date_applied]=quote_check($datea);
                   
                   
                    $data_r[course_id]=quote_check($courseid);

                    $recruit_id= $dbcon->insert("recruit", $data_r);

                  

                 
                        header("location: userlist.php?userid=".$user_id."&success=".urlencode($scriptMsg));
                        exit();
                    

                  }
                  else
                  {
                    //user
                    $data[name]=quote_check($name);
                    $data[email]=quote_check($email);
                    $data[type]=quote_check($type);
                    //$data[image]=quote_check($image);
                   
                    $data[postcode]=quote_check($postcode);
                    $data[city]=quote_check($city);
                    $data[street]=quote_check($street);
                    $data[country]=quote_check($country);
                    $dbcon->update("user",$data,"iduser = ".quote_smart($userid));
                   

                     //Recruit
                   
                     
                    $data_r[interview_id]=quote_check($interviewid);
                    
                    $data_r[applied_for]=quote_check($applied);
                    //$data[file]=quote_check($cv);
                    $data_r[phone]=quote_check($phone);
                    
                    $data_r[date_applied]=quote_check($datea);
                   
                    $data_r[course_id]=quote_check($courseid);

                    $dbcon->update("recruit",$data_r,"user_id = ".quote_smart($userid));

                    
                  

              
                     //header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' updated.");
               


                  }


                }
                break;
             case "Student":
                echo $type[0];
                break;


            default:
                   # code...
                   break;
}//end switch
?>
