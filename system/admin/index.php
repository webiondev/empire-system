<?php
  include_once("inc/cDbcon.php");
  include_once("inc/functions.php");
  include_once("inc/security.php");

  $nav = "dashboard";
  $subnav = "";

  $dbcon->connect();

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_NAME; ?></title>

    <?php include "inc/header.php"; ?>

</head>

<body class="md-skin">
    <div id="wrapper">

    <?php include "inc/nav.php"; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <?php include "inc/topnav.php"; ?>
        </div>

        <div class="wrapper wrapper-content">
          <div class="row">
            <div class="col-lg-12">
              <div class="ibox float-e-margins">
                <div class="ibox-content">
                  Welcome to Empire Portal.
                </div>
              </div>
            </div>
          </div>
        </div>


          <?php include "inc/footer.php"; ?>

        </div>
    </div>

  <?php include "inc/script.php"; ?>


</body>
</html>
