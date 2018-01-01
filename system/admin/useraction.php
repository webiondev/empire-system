<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

  $dbcon->connect();
 
   $type = array("Admin", "Staff", "Lecturer", "Trainer", "Employer", "Employee", "Recruit", "Student");

   switch ($_POST["type"]) {
       
           case "Admin":

                $scriptMsg = "New".$_POST["type"]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $_POST["type"];
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

                    // if ($user_id>0){

                        header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' added.");
                        exit();
                    //}
                    //else{
                        // header("location: userlist.php?userid=".$user_id."&error=An error occur while processing. Please check if record exists for"." ".($name));
                         exit();

                    //}


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
                   
                   
                    
                    $res=$dbcon->update("user",$data,"iduser = ".quote_smart($userid));
                    var_dump($res);
                   
                //     if($res==1){
                    header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' updated.");
                //     exit();
                // }
                //     else{
                //      header("location: userlist.php?userid=".$userid."&error=An error occur while processing. Please check if record exists for"." ".($name));
                //     exit();   
                // }
            }
        }

            
                break;

           case "Staff":
                $scriptMsg = "New".$_POST["type"]. "Added";
                $userid = $_POST["id"];
                $name = $_POST["username"];
                $image = $_POST["image"];
                $email = $_POST["email"];
                $type = $_POST["type"];
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

                    //staff 
                    $user_id = $dbcon->insert("user",$data);
                    $data_s[user_id]=quote_check($user_id);
                   
                    $data_s[position]=quote_check($position);
                    $data_s[role]=quote_check($role);
                    $data_s[date_joined]=quote_check($datej);
                    $data_s[date_left]=quote_check($datel);

                    $staff_id= $dbcon->insert("staff", $data_s);

                  

                   // if ($user_id>0 && $staff_id>0){

                        header("location: userlist.php?userid=".$user_id."&success='".urlencode($name)."' added.");
                        exit();
                    //}
                    // else{
                    //     header("location: userlist.php?userid=".$user_id."&error=An error occur while processing. Please check if record exists for".($name));
                    //     exit();

                    // }

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
                   

                     //staff 
                   
                    $data_s[position]=quote_check($position);
                    $data_s[role]=quote_check($role);
                    $data_s[date_joined]=quote_check($datej);
                    $data_s[date_left]=quote_check($datel);
                   

                    $res=$dbcon->update("user",$data,"iduser = ".quote_smart($userid));
                    $res2=$dbcon->update("staff",$data_s,"user_id = ".quote_smart($userid));

                   
                  

                //     if($res==1 || $res2==1){
                     header("location: userlist.php?userid=".$userid."&success='".urlencode($name)."' updated.");
                //     exit();
                // }
                //     else{
                //      header("location: userlist.php?userid=".$userid."&error=An error occur while processing. Please check if record exists for"." ".($name));
                //     exit();   
                // }


                  }


                }
                    break;

             case "Lecturer":
                echo $_POST["type"];
                break;

             case "Trainer":
                echo $_POST["type"];
                break;
             case "Employer":
                echo $_POST["type"];
                break;
             case "Employee":
                echo $_POST["type"];
                break;
             case "Recruit":
                echo $_POST["type"];
                break;
             case "Student":
                echo $_POST["type"];
                break;


            default:
                   # code...
                   break;
}//end switch
?>
