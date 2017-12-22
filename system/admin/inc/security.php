<?php

if ($_COOKIE['username'] && $_COOKIE['user_id'])
{
    $logon_UserID = $_COOKIE["user_id"];
    $logon_Username = $_COOKIE["username"];
    $logon_Key = $_COOKIE["key"];

    

  if (md5($logon_UserID.$logon_Username."empire") != $logon_Key) {
    setcookie ("username", "", time() - 3600, "/");
    setcookie ("user_id", "", time() - 3600, "/");
    setcookie ("logon", "", time() - 3600, "/");
    include ("./login.php");
    die();
  }

  if ($logon_Role == 'agent') {
    $logonUser = $dbcon2->exec("SELECT * FROM tblagent WHERE id = ".quote_smart($logon_UserID));
  }
  else
  {
    $logonUser = $dbcon2->exec("SELECT * FROM user WHERE iduser = ".quote_smart($logon_UserID));
  }

  if ($logonUser > 0)
  {
    $logon_row = $dbcon2->data_seek(0);
  }
  else
  {
    setcookie ("username", "", time() - 3600);
    setcookie ("user_id", "", time() - 3600);
    include ("./login.php");
    die();
  }

}
else
{

  setcookie ("username", "", time() - 3600);
  setcookie ("user_id", "", time() - 3600);
  include ("./login.php");
  die();
}

?>