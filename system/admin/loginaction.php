<?php
  include_once ("inc/postCaptcha.php"); // since this is a function only. I will put inside functions.
  include_once("inc/cDbcon.php");
  include_once("inc/functions.php");

session_start();

$dbcon->connect();


//$res=post_captcha($_POST['g-recaptcha-response']); // Here you get to check captcha response
$res['success']=true;

//error params
$error_1="?error=Invalid username/password";
$error_2="&error=Invalid username/password";

if (!$res['success']) {
  // if captcha is not setup correctly, it means people try to cheat. So just redirect them back to home.
  $refererURL = '/';
    //var_dump ($res);

} else {
  //so if successful then run the username and password check.

  $refererURL =$_SERVER["HTTP_REFERER"];
  //$refererURL ="http://localhost/index.php";

  $currentip = get_real_ip();

  if (isset($_POST['username']) && isset($_POST['password']))
  {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user=$dbcon->exec("select * from user where email = ".quote_smart($username) );
    
    if ($user > 0) {
      $row=$dbcon->data_seek(0);
  
      if ($row[password] == crypt($password,$row[password]))
      {
        setcookie ("username", $row[email], 0, "/");
        setcookie ("user_id", $row[iduser], 0, "/");
        setcookie ("logon", "true", 0, "/");
        setcookie ("key", md5($row[iduser].$row[email]."empire"), 0, "/");
        $refererURL="index.php";
       
      }
      else
      {
        $pos = strrpos($refererURL, "?");

        if ($pos === false)
        {
          $refererURL = $refererURL.$error_1;
        }
        else
        {
          $refererURL = $refererURL.$error_2;
        }
      }
    }
    else
    {
      $pos = strrpos($refererURL, "?");

      if ($pos === false)
      {
        $refererURL = $refererURL.$error_1;
      }
      else
      {
        $refererURL = $refererURL.$error_2;
      }
    }

  }
  else
  {
    $refererURL = $refererURL.$error_1;
  }
}


header("Location: ".$refererURL);
exit();

?>