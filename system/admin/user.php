<?php

include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


  $nav = "user";
  $subnav = "adduser";

  $dbcon->connect();
  $dbcon2->connect();

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
                              <div class="new-input">
                                <input type="hidden" name="id" value="<?php echo $row[iduser];?>">
                                <div class="form-group"><label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                      <input accept="image/jpeg,image/gif,image/png" class="enable-attache" data-geometry="150x150#" data-value="[<?php echo htmlentities($row[image]); ?>]" data-uploadurl="<?php echo ATTACHE_DOMAIN; ?>/upload" data-downloadurl="<?php echo ATTACHE_DOMAIN; ?>/view" data-uuid="<?php echo $uuid; ?>" data-expiration="<?php echo $expiration; ?>" data-hmac="<?php echo hash_hmac('sha1', $uuid.$expiration, ATTACHE_SECRET); ?>" type="file" name="image" id="image" />
                                    </div>
                                </div>
                               
                              
                                <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10"><input name="username" type="text" class="form-control" value="<?php echo $row[name]; ?>"></div>
                                </div>
                                
                                <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10"><input name="email" type="text" class="form-control" value="<?php echo $row[email]; ?>"></div>
                                </div>
                                
                               <?php 

                                $branchlist = $dbcon2->exec("select name from branch");



                                                    for($i=0;$i<$branchlist;$i++){
                                                      $branchrow=$dbcon2->data_seek($i);


                               ?>

                               <?php

                                $interviewlist = $dbcon->exec("select date_time from interview");

                                                    for($i=0;$i<$interviewlist;$i++){
                                                      $interviewrow=$dbcon->data_seek($i);
                                          
                                                     

                            ?> 

                              <?php 
                                $staff= $dbcon->exec("select * from staff where user_id=".quote_smart($userid));

                                                      if($staff>0){
                                                      $staffrow=$dbcon->data_seek($i);   


                                                      
                                                      }
                            ?>
                           
                            <div class="form-group" id="opt"><label class="col-sm-2 control-label">Type</label>
                                 <div class="col-sm-10">
                                  <select class="form-control" id="type" name="type">
                                   
                                    <option>[<?php 
                                      if(empty($row[type])) 
                                        
                                        {$row[type]="Select New";}
                                      else 
                                          $info="select to edit";
                                        echo $row[type]; 
                                        

                                      ?>] <?php echo $info?></option>


                                      <option>Admin</option>
                                      <option>Staff</option>
                                      <option>Lecturer</option>
                                      <option>Trainer</option>
                                      <option>Employer</option>
                                      <option>Employee</option>
                                      <option>Recruit</option>
                                      <option>Student</option>
                                   

                                  </select>
                                  
                                  
                                </div>

                              </div>

                            </div>


                                 <div class="form-group"><label class="col-sm-2 control-label">Postcode</label>
                                    <div class="col-sm-10"><input name="postcode" type="text" class="form-control" value="<?php echo $row[postcode]; ?>"></div>
                                </div>

                                 <div class="form-group"><label class="col-sm-2 control-label">City</label>
                                    <div class="col-sm-10"><input name="city" type="text" class="form-control" value="<?php echo $row[city]; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Street</label>
                                    <div class="col-sm-10"><input name="street" type="text" class="form-control" value="<?php echo $row[street]; ?>"></div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-10"><input name="country" type="text" class="form-control" value="<?php echo $row[country]; ?>"></div>
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


      $('#type').change(function(){

        if( $(this).val() == 'Admin'){
       $('.new-field').remove();
       
    }
      if( $(this).val() == 'Staff'){
       $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control" value="<?php echo $staffrow[position]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Role</label><div class="col-sm-10"><input name="role" type="text" class="form-control" value="<?php echo $staffrow[role]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" value="<?php echo $staffrow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $staffrow[date_left]; ?>"></div></div><div class="form-group" id="opt"><label class="col-sm-2 control-label">Branch</label><div class="col-sm-10"><select class="form-control" id="branch" name="branch"><option selected disable>Choose Branch</option><option><?php echo $branchrow[name]; ?></option></select></div></div><?php } ?> </div>');
    }
    else if( $(this).val() == 'Lecturer'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control"></div></div> </div> ');
    }

       else if( $(this).val() == 'Trainer'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Expertise</label><div class="col-sm-10"><input name="expertise" type="text" class="form-control"></div></div></div>');
    }
       else if( $(this).val() == 'Employer'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Company</label><div class="col-sm-10"><input name="company" type="text" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control"></div></div>  <div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control"></div></div></div>');
    } 
     else if( $(this).val() == 'Employee'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Company</label><div class="col-sm-10"><input name="company" type="text" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control"></div></div>  <div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control"></div></div></div>');
    }

    else if( $(this).val() == 'Recruit'){
         $('.new-field').remove();

          $('.new-input').append(' <div class="new-field"><div class="form-group" id="opt"><label class="col-sm-2 control-label">Date</label><div class="col-sm-10"><select class="form-control" id="date" name="date"><option selected disable>Choose Date</option><option><?php echo $interviewrow[date_time]; ?></option></select></div></div><?php } ?></div>');

       }

    else if( $(this).val() == 'Student'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Semester</label><div class="col-sm-10"><select class="form-control" id="semester" name="semester"><option selected disable>Choose Semester</option><option>1</option><option>2</option></select></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="expertise" type="text" class="form-control"></div></div></div>');
    }

    else{
        $('.new-field').remove();
    }
});


  </script>
</body>
</html>
