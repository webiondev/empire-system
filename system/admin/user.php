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
                           

           $branchlist = $dbcon2->exec("select idbranch, name from branch");
                  $branch=array();

                  for($i=0;$i<$branchlist;$i++){
                      $branchrow=$dbcon2->data_seek($i);
                      array_push($branch,$branchrow);
                    }

                             


        $interviewlist = $dbcon->exec("select idinterview, date_time from interview");

                          $interview_val=array();
                          $course_val=array();
       
                            for($k=0;$k<$interviewlist;$k++){
                              $interviewrow=$dbcon->data_seek($k);
                                      
                              array_push($interview_val,$interviewrow);
                                          } 

        $courselist = $dbcon->exec("select idcourse, name from course");

       
                            for($k=0;$k<$courselist;$k++){
                              $courserow=$dbcon->data_seek($k);
                                      
                              array_push($course_val,$courserow);                

                            }

                                      
                          

        $staff= $dbcon->exec("select * from staff where user_id=".quote_smart($userid));

                              if($staff>0){
                              $staffrow=$dbcon->data_seek(0);   

                              }
        $staff_b=$dbcon->exec("select name from branch where idbranch=".quote_smart($staffrow[branch_id]));    

                               if($staff_b>0){
                                  $staff_b=$dbcon->data_seek(0);   
                                  }                
        $lect= $dbcon->exec("select * from lecturer where user_id=".quote_smart($userid));

                              if($lect>0){
                              $lectrow=$dbcon->data_seek(0);   


                              
                              }
     $trainer= $dbcon->exec("select * from trainer where user_id=".quote_smart($userid));

                              if($trainer>0){
                              $trainerrow=$dbcon->data_seek(0);   

                              
                              }
        $employer= $dbcon->exec("select * from employer where user_id=".quote_smart($userid));

                              if($employer>0){
                              $employerrow=$dbcon->data_seek(0);   

                              
                              }
        $employee= $dbcon->exec("select * from employee where user_id=".quote_smart($userid));

                              if($employee>0){
                              $employeerow=$dbcon->data_seek(0);   

                              
                              }
        $recruit= $dbcon->exec("select * from recruit where user_id=".quote_smart($userid));

                              if($recruit>0){
                                $recruitrow=$dbcon->data_seek(0);   


                              
                              }
               $recruit_iv= $dbcon->exec("select idinterview, date_time from interview where idinterview=".quote_smart($recruitrow[interview_id])); 


              if($recruit_iv>0)
                     $recruit_iv=$dbcon->data_seek(0); 


            $student= $dbcon->exec("select * from student where user_id=".quote_smart($userid));

                              if($student>0){
                                $studentrow=$dbcon->data_seek(0);   
                              
                              }

                   

              $studentcourse= $dbcon->exec("select idcourse, name from course where idcourse=".quote_smart($studentrow[course_id])); 
              if($studentcourse>0)
                     $studentcourserow=$dbcon->data_seek(0); 

            
                              

    ?>     

                          

                            <div class="form-group" id="opt"><label class="col-sm-2 control-label">Type</label>
                                 <div class="col-sm-10">
                                  <select class="form-control" id="type" name="type" required>
                                   
                                   <?php 
                                      if(empty($row[type])) 
                                        
                                        {
                                        
                                          echo '<option selected disabled>'.$row[type]="Select New".'</option>

                                            <option>Admin</option>
                                            <option>Staff</option>
                                            <option>Lecturer</option>
                                            <option>Trainer</option>
                                            <option>Employer</option>
                                            <option>Employee</option>
                                            <option>Recruit</option>
                                            <option>Student</option>

                                            ';

                                     
                                    }


                                      else {
                                         
                                          switch ($row[type]) {
                                            case 'Admin':
                                              echo '<option>Admin</option>';
                                              echo '<option>Admin-Edit</option>';
                                              break;
                                             case 'Staff':
                                              echo '<option>Staff</option>';
                                               echo '<option>Staff-Edit</option>';
                                              break;
                                             case 'Lecturer':
                                              echo '<option>Lecturer</option>';
                                              echo '<option>Lecturer-Edit</option>';
                                              break;
                                             case 'Trainer':
                                              echo '<option>Trainer</option>';
                                              echo '<option>Trainer-Edit</option>';
                                              break;
                                             case 'Employer':
                                              echo '<option>Employer</option>';
                                              echo '<option>Employer-Edit</option>';
                                              break;
                                             case 'Employee':
                                              echo '<option>Employee</option>';
                                               echo '<option>Employee-Edit</option>';
                                              break;
                                             case 'Recruit':
                                              echo '<option>Recruit</option>';
                                              echo '<option>Recruit-Edit</option>';
                                              break;
                                             case 'Student':
                                              echo '<option>Student</option>';
                                              echo '<option>Student-Edit</option>';
                                              break;
                                            
                                            default:
                                              
                                              break;
                                          }
                                       
                                        }

                                      ?>


                                     

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
      if( $(this).val() == 'Staff' || $(this).val() == 'Staff-Edit'){
        
       $('.new-field').remove();



        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control" value="<?php echo $staffrow[position]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Role</label><div class="col-sm-10"><input name="role" type="text" class="form-control" value="<?php echo $staffrow[role]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" class="has" value="<?php echo $staffrow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $staffrow[date_left]; ?>"></div></div><div class="form-group" id="opt"><label class="col-sm-2 control-label">Branch</label><div class="col-sm-10"><select class="form-control" id="branch" name="branch"> <option selected disabled><?php echo $staff_b[name]." "; ?>[current]</option><?php foreach ($branch as $key => $value) {?><option value="<?php echo "$key"+1; ?>"><?php echo "$value[name]"; ?></option><?php } ?></select></div></div> </div>');
    }
    else if( $(this).val() == 'Lecturer' || $(this).val() == 'Lecturer-Edit'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $lectrow[phone]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" value="<?php echo $lectrow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $lectrow[date_left]; ?>"></div></div> </div> ');
    }

       else if( $(this).val() == 'Trainer' || $(this).val() == 'Trainer-Edit'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $trainerrow[phone]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" value="<?php echo $trainerrow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $trainerrow[date_left]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Expertise</label><div class="col-sm-10"><input name="expertise" type="text" class="form-control" value="<?php echo $trainerrow[expertise]; ?>"></div></div></div>');
    }
       else if( $(this).val() == 'Employer' || $(this).val() == 'Employer-Edit'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Company</label><div class="col-sm-10"><input name="company" type="text" class="form-control" value="<?php echo $employerrow[company]; ?>"></div></div><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $employerrow[phone]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" value="<?php echo $employerrow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $employerrow[date_left]; ?>"></div></div>  <div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control" value="<?php echo $employerrow[position]; ?>"></div></div></div>');
    } 
     else if( $(this).val() == 'Employee' || $(this).val() == 'Employee-Edit'){
         $('.new-field').remove();
         $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Company</label><div class="col-sm-10"><input name="company" type="text" class="form-control" value="<?php echo $employeerow[company]; ?>"></div></div><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $employeerow[phone]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Joined</label><div class="col-sm-10"><input name="datej" type="date" class="form-control" value="<?php echo $employeerow[date_joined]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $employeerow[date_left]; ?>"></div></div>  <div class="form-group"><label class="col-sm-2 control-label">Position</label><div class="col-sm-10"><input name="position" type="text" class="form-control" value="<?php echo $employeerow[position]; ?>"></div></div></div>');
    }

    else if( $(this).val() == 'Recruit' || $(this).val() == 'Recruit-Edit'){

         $('.new-field').remove();
                    

          $('.new-input').append(' <div class="new-field"> <div class="form-group" id="opt"><label class="col-sm-2 control-label">Date</label><div class="col-sm-10"><select class="form-control" id="date" name="date"><option value="<?php echo $recruit_iv[idinterview]." ";?>" ><?php echo $recruit_iv[date_time]." "; ?>[Current]</option><?php foreach($interview_val as $key=>$val) {?><option value="<?php echo $val[idinterview]; ?>"><?php echo $val[date_time]; ?></option><?php } ?></select></div></div><div class="form-group"><label class="col-sm-2 control-label">Applied For</label><div class="col-sm-10"><input name="applied" type="text" class="form-control" value="<?php echo $recruitrow[applied_for]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">CV</label><div class="col-sm-10"><input accept="application/pdf" class="enable-attache" data-geometry="150x150#" data-value="[<?php echo htmlentities($recruitrow[file]); ?>]" data-uploadurl="<?php echo ATTACHE_DOMAIN; ?>/upload" data-downloadurl="<?php echo ATTACHE_DOMAIN; ?>/view" data-uuid="<?php echo $uuid; ?>" data-expiration="<?php echo $expiration; ?>" data-hmac="<?php echo hash_hmac('sha1', $uuid.$expiration, ATTACHE_SECRET); ?>" type="file" name="cv" id="cv" /></div></div><div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control" value="<?php echo $recruitrow[phone]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Applied</label><div class="col-sm-10"><input name="datea" type="date" class="form-control" value="<?php echo $recruitrow[date_applied]; ?>"></div></div> </div>');

       }

    else if( $(this).val() == 'Student' || $(this).val() == 'Student-Edit'){
         $('.new-field').remove();
        $('.new-input').append('<div class="new-field"><div class="form-group"><label class="col-sm-2 control-label">Semester</label><div class="col-sm-10"><select class="form-control" id="semester" name="semester"><option value="<?php echo $studentrow[semester]." "?>"><?php echo $studentrow[semester]." "?>[Current]</option><option>1</option><option>2</option></select></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Registered</label><div class="col-sm-10"><input name="dater" type="date" class="form-control" value="<?php echo $studentrow[date_registered]; ?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Date Left</label><div class="col-sm-10"><input name="datel" type="date" class="form-control" value="<?php echo $studentrow[date_left];?>"></div></div> <div class="form-group"><label class="col-sm-2 control-label">Phone</label><div class="col-sm-10"><input name="phone" type="text" class="form-control"></div></div><div class="form-group" id="opt"><label class="col-sm-2 control-label">Course Enrolled (if any)</label><div class="col-sm-10"><select class="form-control" id="course" name="course"><option value="<?php echo $studentcourserow[idcourse]." "; ?>"><?php echo $studentcourserow[name]." "; ?>[Current]</option><?php foreach($course_val as $key=>$val) {?><option value="<?php echo $val[idcourse]; ?>"><?php echo $val[name]; ?></option><?php } ?></select></div></div></div>');
    }

    else{
        $('.new-field').remove();
    }


});


  </script>
</body>
</html>
