<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


  $nav = "message";
  $subnav = "addmessage";

  $dbcon->connect();

  	$messageid = $_GET["messageid"];

    $message = $dbcon->exec("select * from message where idmessage = ".quote_smart($messageid));

    $strAction = "Send Message";

    if ($message > 0)
    {
      $strAction = "Send Message";
      $row=$dbcon->data_seek(0);
      //$subnav = "classlist";
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
                            <form class="form-horizontal" action="messageaction.php" method="post">
                                
                                  
                                  <div class="form-group"><label class="col-sm-2 control-label">Replying to</label>
                                    <div class="col-sm-10"><input name="message_p" type="text" class="form-control" value="<?php echo $row[message]; ?>" readonly></div>
                                </div>
                     
                              
                              
                                <div class="form-group"><label class="col-sm-2 control-label">Message</label>
                                    <div class="col-sm-10"><textarea name="message_n" rows=4 cols=50 class="form-control"></textarea></div>
                                </div>


                                <?php
                                  $userlist=$dbcon->exec("select * from user");
                                  $userinfo=array();
                                  for ($i=0;$i<$userlist;$i++){

                                    $user=$dbcon->data_seek($i);


                                    array_push($userinfo,$user);



                                  }

                                ?>


                                 <!-- <input type="hidden" name="id" value="<?php echo $user[iduser];?>"> -->

                                <div class="form-group" id="opt"><label class="col-sm-2 control-label">Send to</label>
                                     <div class="col-sm-10">
                                     <select class="form-control" id="recieverid" name="recieverid" required>
                                      <option selected disabled> Select User</option>
                                       <?php foreach($userinfo as $key=>$val) {?><option value="<?php echo $val[iduser]; ?>"><?php echo $val[name]; ?></option><?php } ?>
                                     </select>

                                  </div>

                                </div>

                       
                               
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="messagelist.php">Cancel</a>
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
