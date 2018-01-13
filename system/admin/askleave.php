<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");




  $nav = "askleave";
  //$subnav = "addtraining";

  // $dbcon->connect();

  // 	$leaveid = $_GET["leave_id"];

  //   $leave = $dbcon->exec("select * from leave_ where idleave = ".quote_smart($leaveid));

  //   $strAction = "Handle Leave Request";

  //   if ($leave > 0)
  //   {
  //     $strAction = "Ask Leave";
  //     $row=$dbcon->data_seek(0);
  //     $subnav = "Leavelist";
  //   }

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
                            <form class="form-horizontal" action="leaveaction.php" method="post">
                                 <!-- <input type="hidden" name="id" value="<?php echo $_COOKIE["user_id"];?>"> -->
                             
                              
                                <?php
                                  $name=$dbcon2->exec("select name from user where iduser = ".quote_smart($_COOKIE["user_id"]));
                                  if ($name>0)
                                     $name=$dbcon2->data_seek(0);

                                    ?>
                                 <input type="hidden" name="userid" value="<?php echo $_COOKIE["user_id"]; ?>">   
                                <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10"><input name="name" type="text" class="form-control" value="<?php echo $name[name]?>" readonly></div>
                                </div>
                                
                                <div class="form-group"><label class="col-sm-2 control-label">Start</label>
                                    <div class="col-sm-10"><input name="start" type="date" class="form-control" ></div>
                                </div>
                                
                                
                                <div class="form-group"><label class="col-sm-2 control-label">End</label>
                                    <div class="col-sm-10"><input name="end" type="date" class="form-control"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Reason</label>
                                    <div class="col-sm-10"><input name="reason" type="text" class="form-control"></div>
                                </div>

                              <!--   <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10"><input name="status" type="text" class="form-control" readonly></div>
                                </div> -->

                            
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="leavelist.php">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
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
      $(document).ready(function(){


           $('.summernote').summernote({
                height: 400,
                toolbar: [
                  ['cleaner',['cleaner']],
                  ["style", ["style"]],
                  ["font", ["bold", "underline", "clear"]],
                  ["fontname", ["fontname"]],
                  ["color", ["color"]],
                  ["para", ["ul", "ol", "paragraph"]],
                  ["table", ["table", "hr"]],
                  ["insert", ["link", "picture", "video"]],
                  ["view", ["fullscreen", "codeview", "help"]]
                ],
                  cleaner:{
                        notTime: 2400, // Time to display Notifications.
                        action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                        newline: '<br>', // Summernote's default is to use '<p><br></p>'
                        notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                        icon: 'clean',
                        keepHtml: true, // Remove all Html formats
                        keepClasses: false, // Remove Classes
                        badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                        badAttributes: ['style', 'start'] // Remove attributes from remaining tags
                  },
                callbacks : {
                    onImageUpload: function(image) {
                        uploadImage(image[0]);
                    }
                }
              });

            function uploadImage(image) {
                var data = image;

                $.ajax ({
                    data: data,
                    type: "POST",
                    url: "<?php echo ATTACHE_DOMAIN; ?>/upload?file="+image.name+"&hmac=<?php echo hash_hmac('sha1', $uuid.$expiration, ATTACHE_SECRET); ?>&uuid=<?php echo $uuid; ?>&expiration=<?php echo $expiration; ?>",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        var imageurl = "<?php echo ATTACHE_DOMAIN; ?>/view/"+data.path;
                        var filename = imageurl.replace(/^.*[\\\/]/, '');
                        imageurl = imageurl.replace(filename, "remote/"+filename);

                        $('.summernote').summernote("insertImage", imageurl);
                        },
                        error: function(data) {
                            console.log(data);
                            }
                    });

            }


          $(".quick-select").click(function() {
             $("#category").val($(this).attr("info"));
          });
          $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green',
          });

      });
  </script>
</body>
</html>
