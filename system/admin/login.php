<?php
  include_once("inc/cDbcon.php");
  include_once("inc/functions.php");

  if ($_COOKIE['username'] && $_COOKIE['user_id']) 

    { header("location: index.php");
     exit();

      }
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_NAME; ?></title>
   

    <script>
    function onSubmit(token) {
        document.getElementById("i-recaptcha").submit();
    }
    </script> 

    <?php include "inc/header.php"; ?>
    
<script src="http://www.google.com/recaptcha/api.js" async defer></script>    
</head>

<body class="black-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>

            <form id='i-recaptcha' class="m-t" role="form" action="loginaction.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Email/Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                 
                <button  class="g-recaptcha btn btn-primary block full-width m-b" data-sitekey="6LeCUTwUAAAAAEGmo73c-w5baRUBglXxVMtDfPxA
                    " data-callback="onSubmit" data-badge="inline">Login
                </button>
            </form>


        </div>
    </div>
  
  <?php include "inc/script.php"; ?>

</body>


</html>
