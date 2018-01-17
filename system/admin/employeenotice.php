<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");



  

  $nav = "hire";
  //$subnav = "hire_m";

  $dbcon->connect();


  	$employeeid = $_GET["employeeid"];
    $date_joined=$_GET["date_joined"];
    $idemployment_history=$_GET["idemployment_history"];

  

    if (empty ($employeeid)){

      header("location: listmyemployee.php?&error=An error occur while processing. Choose an employee first.");
      exit();

  }

     $employee = $dbcon->exec("select user_id from employee where idemployee = ".quote_smart($employeeid));


    $strAction = "Notify Employee";

    if ($employee > 0)
    {
      $strAction = "Notify";
      $row=$dbcon->data_seek(0);
      //$subnav = "listmanpower";
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
                            <form class="form-horizontal" action="employeenoticeaction.php" method="post">
                              <div class="new-input">
                                 <input type="hidden" name="id" value="<?php echo $employeeid; ?>">
                                 <input type="hidden" name="datej" value="<?php echo $date_joined; ?>">
                                 <input type="hidden" name="id_e_h" value="<?php echo $idemployment_history; ?>">
                                  
                              
                                <?php
                                  $info=$dbcon2->exec("select name, email from user where iduser = ".quote_smart($row[user_id]));
                                  if ($info>0)
                                     $info=$dbcon2->data_seek(0);

                                    ?>
                                 
                                <input type="hidden" name="email" value="<?php echo  $info[email]?>">
                                <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10"><input name="name" type="text" class="form-control" value="<?php echo $info[name]?>" readonly></div>
                                </div>

                               
                                
                                <div class="form-group"><label class="col-sm-2 control-label">Message to Employee</label>
                                    <div class="col-sm-10"><input name="message" type="text" class="form-control"></div>
                                </div>
                                
                                 <div class="form-group" id="opt"><label class="col-sm-2 control-label">Type</label>
                                 <div class="col-sm-10">
                                  <select class="form-control" id="type" name="type" required>
                                   <option>message</option>
                                   <option>dismiss</option>
                                 </select>
                               </div>
                             </div>
                           </div>
                                

                              <!--   <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10"><input name="status" type="text" class="form-control" readonly></div>
                                </div> -->

                            
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="listmyemployee.php">Cancel</a>
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
