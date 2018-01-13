<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");



  

  $nav = "employee";
  $subnav = "listmyemployer";

  $dbcon->connect();


  	$userid = $_GET["userid"];
    $name=$_GET["name"];

    if (empty ($userid)){

      header("location: myemployerlist.php?&error=An error occur while processing. Choose your employer first.");
      exit();

  }

  


    // $strAction = "Notify Employee";

    // if ($employee > 0)
    // {
    //   $strAction = "Notify";
    //   $row=$dbcon->data_seek(0);
    //   //$subnav = "listmanpower";
    // }


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
              <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $strAction; ?></h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" action="myemployeraction.php" method="post">
                              <div class="new-input">
                                 <input type="hidden" name="id" value="<?php echo $userid; ?>">
                                 
                                 
                                <div class="form-group"><label class="col-sm-2 control-label">To</label>
                                    <div class="col-sm-10"><input name="name" type="text" class="form-control" value="<?php echo $name ?>" readonly></div>
                                </div>

                               
                                
                                <div class="form-group"><label class="col-sm-2 control-label">Message to Employer</label>
                                    <div class="col-sm-10"><input name="message" type="text" class="form-control"></div>
                                </div>
                                
                               
                                

                              <!--   <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10"><input name="status" type="text" class="form-control" readonly></div>
                                </div> -->

                            
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="myemployerlist.php">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Send</button>
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
  <script>
    
         $('#type').change(function(){

           
          if( $(this).val() == 'dismiss'){
            
           $('.new-field').remove();
              $('.new-input').append(' <div class="new-field"> <div class="form-group"><label class="col-sm-2 control-label">Date To Dismiss</label> <div class="col-sm-10"><input name="date" type="date" class="form-control" required></div></div></div>');
            


         }

         else if($(this).val()=='message') {

             $('.new-field').remove();

           


         }

       });
  </script>
</body>
</html>
