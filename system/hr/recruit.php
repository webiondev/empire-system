<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


  $nav = "recruit";
  $subnav = "addrecruit";

  $dbcon->connect();

  	$recruitid = $_GET["recruit_id"];

    $recruit = $dbcon->exec("select * from recruit where idrecruit = ".quote_smart($recruitid));

    $strAction = "Add Recruit";

    if ($recruit > 0)
    {
      $strAction = "Update Recruit";
      $row=$dbcon->data_seek(0);
      $subnav = "recruitlist";
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
                            <form class="form-horizontal" action="recruitaction.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row[idrecruit];?>">
                          
                                <?php

                                  $interviewlist = $dbcon->exec("select idinterview, date_time from interview");

                                $interview_val=array();
                                $course_val=array();
             
                                  for($k=0;$k<$interviewlist;$k++){
                                        $interviewrow=$dbcon->data_seek($k);
                                      
                                       array_push($interview_val,$interviewrow);
                                          } 

                                 $recruit= $dbcon->exec("select * from recruit where user_id=".quote_smart($userid));

                                if($recruit>0){
                                  $recruitrow=$dbcon->data_seek(0);   


                                            
                                            }
                             $recruit_iv= $dbcon->exec("select idinterview, date_time from interview where idinterview=".quote_smart($recruitrow[interview_id])); 


                                if($recruit_iv>0)
                                      $recruit_iv=$dbcon->data_seek(0); 
                                              ?>
                              
                             <div class="form-group" id="opt">
                               <label class="col-sm-2 control-label">Date</label>
                                <div class="col-sm-10">
                                   <select class="form-control" id="date" name="date">
                                      <option value="<?php echo $recruit_iv[idinterview]." ";?>" ><?php echo $recruit_iv[date_time]." "; ?>[Current]</option>

                                      <?php foreach($interview_val as $key=>$val) {?>
                                          <option value="<?php echo $val[idinterview]; ?>"><?php echo $val[date_time]; ?></option><?php } ?>
                                     </select>
                                   </div>
                                 </div>

                                 <div class="form-group"><label class="col-sm-2 control-label">Applied For</label>
                                  <div class="col-sm-10"><input name="applied" type="text" class="form-control" value="<?php echo $recruitrow[applied_for]; ?>">
                                 </div>
                               </div> 

                               <div class="form-group"><label class="col-sm-2 control-label">CV</label>
                                  <div class="col-sm-10"><input accept="application/pdf" class="enable-attache" data-geometry="150x150#" data-value="[<?php echo htmlentities($recruitrow[file]); ?>]" data-uploadurl="<?php echo ATTACHE_DOMAIN; ?>/upload" data-downloadurl="<?php echo ATTACHE_DOMAIN; ?>/view" data-uuid="<?php echo $uuid; ?>" data-expiration="<?php echo $expiration; ?>" data-hmac="<?php echo hash_hmac('sha1', $uuid.$expiration, ATTACHE_SECRET); ?>" type="file" name="cv" id="cv" /></div></div>

                                  <div class="form-group"><label class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $recruitrow[phone]; ?>"></div></div> 

                                    <div class="form-group"><label class="col-sm-2 control-label">Date Applied</label><div class="col-sm-10"><input name="datea" type="date" class="form-control" value="<?php echo $recruitrow[date_applied]; ?>"></div></div>
                                
                               


                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="recruitlist.php">Cancel</a>
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
