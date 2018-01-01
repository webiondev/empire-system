<?php
  include_once("inc/cDbcon.php");
  include_once("inc/functions.php");
  include_once("inc/security.php");

    $dbcon->connect();

    $user = $dbcon->exec("select * from tbluser WHERE id = ".quote_smart($_COOKIE["user_id"]));

    $strAction = "Update Profile";

    if ($user > 0)
    {
      $row=$dbcon->data_seek(0);
    }
    else
    {
      header("location: logout.php");
      exit();
    }
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_NAME; ?></title>

    <?php include "inc/header.php"; ?>

</head>

<body>
    <div id="wrapper">

    <?php include "inc/nav.php"; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <?php include "inc/topnav.php"; ?>
        </div>
        <div class="wrapper wrapper-content">
              <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $strAction; ?></h5>
                        </div>
                        <div class="ibox-content">

                            <form class="form-horizontal" action="updateprofileaction.php" method="post">

                                <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-10 control-info"><?php echo $row[username];?></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">New Password</label>
                                    <div class="col-sm-10"><input name="password" type="password" class="form-control"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">Confirm New Password</label>
                                    <div class="col-sm-10"><input name="confirmpassword" type="password" class="form-control"></div>
                                </div>


                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        </div>

          <?php include "inc/footer.php"; ?>

        </div>
    </div>

  <?php include "inc/script.php"; ?>

</body>
</html>
