
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $logon_row[name]; ?> <b class="caret"></b></strong>
                         </span> </span> </a>
                    <ul class="dropdown-menu m-t-xs">
                        <li><a href="updateprofile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    Active Group Portal
                </div>
            </li>

<!--
            <li class="<?php if ($nav == 'dashboard') { echo 'active'; } ?>">
                <a href="dashboard.php"><i class="fa fa-cube"></i> <span class="nav-label">Dashboard</span>  </a>
            </li>

-->     
            <div class="hr-line-dashed"></div>
                
                <h4 class="display-1" style="text-align: center;">Core Admin Job</h4>

            <div class="hr-line-dashed"></div>
               <li class="<?php if ($nav == 'user') { echo 'active'; } ?>">
                <a href="userlist.php"><i class="fa fa-cube"></i> <span class="nav-label">User</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'adduser') { echo 'active'; } ?>"><a href="user.php">Add User</a></li>
                    <li class="<?php if ($subnav == 'userlist') { echo 'active'; } ?>"><a href="userlist.php">List All</a></li>
                </ul>
            </li>

            <li class="<?php if ($nav == 'course') { echo 'active'; } ?>">
                <a href="courselist.php"><i class="fa fa-book"></i> <span class="nav-label">Course</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'addcourse') { echo 'active'; } ?>"><a href="course.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listcourse') { echo 'active'; } ?>"><a href="courselist.php">List All</a></li>
                </ul>
            </li>

             <li class="<?php if ($nav == 'class') { echo 'active'; } ?>">
                <a href="classlist.php"><i class="fa fa-book"></i> <span class="nav-label">Class</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'addclass') { echo 'active'; } ?>"><a href="class.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listclass') { echo 'active'; } ?>"><a href="classlist.php">List All</a></li>
                </ul>
            </li>

              <li class="<?php if ($nav == 'training') { echo 'active'; } ?>">
                <a href="traininglist.php"><i class="fa fa-book"></i> <span class="nav-label">Training</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'addtraining') { echo 'active'; } ?>"><a href="training.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listtraining') { echo 'active'; } ?>"><a href="traininglist.php">List All</a></li>
                </ul>
            </li>

            <li class="<?php if ($nav == 'interview') { echo 'active'; } ?>">
                <a href="interviewlist.php"><i class="fa fa-book"></i> <span class="nav-label">Interview</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'addinterview') { echo 'active'; } ?>"><a href="interview.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listinterview') { echo 'active'; } ?>"><a href="interviewlist.php">List All</a></li>
                </ul>
            </li>

             <li class="<?php if ($nav == 'attendance') { echo 'active'; } ?>">
                <a href="attendancelist.php"><i class="fa fa-book"></i> <span class="nav-label">Attendance</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                 <!--    <li class="<?php if ($subnav == 'addinterview') { echo 'active'; } ?>"><a href="interview.php">Add New</a></li>
                  -->   <li class="<?php if ($subnav == 'listattendance') { echo 'active'; } ?>"><a href="attendancelist.php">List All</a></li>
                </ul>
            </li>

            <li class="<?php if ($nav == 'leave') { echo 'active'; } ?>">
                <a href="leavelist.php"><i class="fa fa-book"></i> <span class="nav-label">Leave</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                 <!--    <li class="<?php if ($subnav == 'addinterview') { echo 'active'; } ?>"><a href="interview.php">Add New</a></li>
                  -->   <li class="<?php if ($subnav == 'listleave') { echo 'active'; } ?>"><a href="leavelist.php">List All</a></li>
                </ul>
            </li>

              <li class="<?php if ($nav == 'enquiry') { echo 'active'; } ?>">
                <a href="enquirylist.php"><i class="fa fa-book"></i> <span class="nav-label">Enquiry</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                     <li class="<?php if ($subnav == 'addenquiry') { echo 'active'; } ?>"><a href="enquiry.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listenquiry') { echo 'active'; } ?>"><a href="enquirylist.php">List All</a></li>
                </ul>
            </li>

            <li class="<?php if ($nav == 'message') { echo 'active'; } ?>">
                <a href="messagelist.php"><i class="fa fa-book"></i> <span class="nav-label">Message</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <li class="<?php if ($subnav == 'message') { echo 'active'; } ?>"><a href="messagelist.php">List Message</a></li>
                
                </ul>
            </li>



            <li class="<?php if ($nav == 'notification') { echo 'active'; } ?>">
                <a href="notificationlist.php"><i class="fa fa-book"></i> <span class="nav-label">Notification</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <li class="<?php if ($subnav == 'notification') { echo 'active'; } ?>"><a href="notificationlist.php">List Notification</a></li>
                 
                </ul>
            </li>

             <li class="<?php if ($nav == 'Feedback') { echo 'active'; } ?>">
                <a href="feedbacklist.php"><i class="fa fa-book"></i> <span class="nav-label">Feedback</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <li class="<?php if ($subnav == 'feedback') { echo 'active'; } ?>"><a href="feedbacklist.php">List Feedback</a></li>
                 
                </ul>
            </li>

             <li class="<?php if ($nav == 'report') { echo 'active'; } ?>">
                <a href="reportlist.php"><i class="fa fa-book"></i> <span class="nav-label">Report</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <li class="<?php if ($subnav == 'report') { echo 'active'; } ?>"><a href="Reportlist.php">List Report</a></li>
                 
                </ul>
            </li>


            <div class="hr-line-dashed"></div>
            <h4 class="display-1" style="text-align: center;">Non-Admin Job (All Users)</h4>

            <div class="hr-line-dashed"></div>

             <li class="<?php if ($nav == 'attendance') { echo 'active'; } ?>">
                <a href="attendance.php"><i class="fa fa-book"></i> <span class="nav-label">Attendance</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                 <!--    <li class="<?php if ($subnav == 'addinterview') { echo 'active'; } ?>"><a href="interview.php">Add New</a></li>
                  -->   <li class="<?php if ($subnav == 'addattendance') { echo 'active'; } ?>"><a href="attendance.php">Give Attendance</a></li>
                </ul>
            </li>

            <li class="<?php if ($nav == 'leave') { echo 'active'; } ?>">
                <a href="leavelist.php"><i class="fa fa-book"></i> <span class="nav-label">Leave</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <li class="<?php if ($subnav == 'leave') { echo 'active'; } ?>"><a href="askleave.php">Ask Leave</a></li>
                 <li class="<?php if ($subnav == 'statusleave') { echo 'active'; } ?>"><a href="leavestatus.php">Check Status</a></li>
                </ul>
            </li>



            <div class="hr-line-dashed"></div>
            <h4 class="display-1" style="text-align: center;">Employer Job</h4>

            <div class="hr-line-dashed"></div>

            <li class="<?php if ($nav == 'hire') { echo 'active'; } ?>">
                <a href="manpowerlist.php"><i class="fa fa-book"></i> <span class="nav-label">Hire</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <!-- <li class="<?php if ($subnav == 'hire_m') { echo 'active'; } ?>"><a href="hire.php">Hire</a></li> -->
                 <li class="<?php if ($subnav == 'listmanpower') { echo 'active'; } ?>"><a href="manpowerlist.php">List Manpower</a></li>
                 <li class="<?php if ($subnav == 'listrequest') { echo 'active'; } ?>"><a href="requestlist.php">Your Request</a></li>
                 <li class="<?php if ($subnav == 'listrecruitrequest') { echo 'active'; } ?>"><a href="recruitrequestlist.php">Recruit Request</a></li>
                
                 <li class="<?php if ($subnav == 'listmyemployee') { echo 'active'; } ?>"><a href="listmyemployee.php">List My Employee</a></li>
                </ul>
            </li>

            <div class="hr-line-dashed"></div>
            <h4 class="display-1" style="text-align: center;">Recruit Job</h4>

            <div class="hr-line-dashed"></div>

            <li class="<?php if ($nav == 'recruit') { echo 'active'; } ?>">
                <a href="employerlist.php"><i class="fa fa-book"></i> <span class="nav-label">Search Employer</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                 <!-- <li class="<?php if ($subnav == 'hire_m') { echo 'active'; } ?>"><a href="hire.php">Hire</a></li> -->
                 <li class="<?php if ($subnav == 'listemployer') { echo 'active'; } ?>"><a href="employerlist.php">List Employer</a></li>
                <li class="<?php if ($subnav == 'listmyrequests') { echo 'active'; } ?>"><a href="myrequestlist.php">My Job Request</a></li>
                </ul>
            </li>

             <div class="hr-line-dashed"></div>
            <h4 class="display-1" style="text-align: center;">Employee Job</h4>

            <div class="hr-line-dashed"></div>

            <li class="<?php if ($nav == 'employee') { echo 'active'; } ?>">
                <a href="myemployerlist.php"><i class="fa fa-book"></i> <span class="nav-label">Employment</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                
                
                 <li class="<?php if ($subnav == 'listmyemployer') { echo 'active'; } ?>"><a href="myemployerlist.php">List Employer</a></li>
                <!-- <li class="<?php if ($subnav == 'listmyrequests') { echo 'active'; } ?>"><a href="myrequestlist.php">My Job Request</a></li>
 -->                </ul>
            </li>



           <!--  <li class="<?php if ($nav == 'testimonial') { echo 'active'; } ?>">
                <a href="testimoniallist.php"><i class="fa fa-certificate"></i> <span class="nav-label">Testimonial</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'addcourse') { echo 'active'; } ?>"><a href="testimonial.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listcourse') { echo 'active'; } ?>"><a href="testimoniallist.php">List All</a></li>
                </ul>
            </li> -->

           
        </ul>

    </div>
</nav>