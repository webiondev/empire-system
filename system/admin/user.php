<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


  $nav = "user";
  $subnav = "adduser";

  $dbcon->connect();

  	$userid = $_GET["user_id"];

    $user = $dbcon->exec("select * from user where iduser = ".quote_smart($userid));

    $strAction = "Add User";

    if ($user > 0)
    {
      $strAction = "Update User";
      $row=$dbcon->data_seek(0);
      $subnav = "userlist";
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
                            <form class="form-horizontal" action="useraction.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row[iduser];?>">
                                <div class="form-group"><label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                      <input accept="image/jpeg,image/gif,image/png" class="enable-attache" data-geometry="150x150#" data-value="[<?php echo htmlentities($row[image]); ?>]" data-uploadurl="<?php echo ATTACHE_DOMAIN; ?>/upload" data-downloadurl="<?php echo ATTACHE_DOMAIN; ?>/view" data-uuid="<?php echo $uuid; ?>" data-expiration="<?php echo $expiration; ?>" data-hmac="<?php echo hash_hmac('sha1', $uuid.$expiration, ATTACHE_SECRET); ?>" type="file" name="image" id="image" />
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">User Name</label>
                                    <div class="col-sm-10">
                                      <div class="input-group">
                                         <div class="input-group-btn">
                                            <button type="button" class="btn btn-default
                                               dropdown-toggle" data-toggle="dropdown">
                                               -- Select Existing --
                                               <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php

                                                    $userlist = $dbcon->exec("select DISTINCT(name) from user");

                                                    for($i=0;$i<$userlist;$i++){
                                                      $userrow=$dbcon->data_seek($i);

                                                ?>
                                                  <li><a href="#" class="quick-select" info="<?php echo $userrow[name]; ?>"><?php echo $userrow[name]; ?></a></li>
                                                <?php
                                                    }
                                                ?>
                                               <li><a href="#" class="quick-select" info="">-- Create New --</a></li>
                                            </ul>
                                         </div>
                                         <input id="userid" name="username" type="text" class="form-control" value="<?php echo $row[name]; ?>">
                                      </div>
                                    </div>
                                </div>
                              
                              
                                <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10"><input name="email" type="text" class="form-control" value="<?php echo $row[email]; ?>"></div>
                                </div>
                                
                                <div class="form-group"><label class="col-sm-2 control-label">Type</label>
                                    <div class="col-sm-10"><input name="type" type="text" class="form-control" value="<?php echo $row[type]; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="userlist.php">Cancel</a>
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
