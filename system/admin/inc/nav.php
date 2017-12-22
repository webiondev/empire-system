
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
               <li class="<?php if ($nav == 'user') { echo 'active'; } ?>">
                <a href="userlist.php"><i class="fa fa-cube"></i> <span class="nav-label">User</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php if ($subnav == 'adduser') { echo 'active'; } ?>"><a href="user.php">Add New</a></li>
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
                    <li class="<?php if ($subnav == 'addcclass') { echo 'active'; } ?>"><a href="class.php">Add New</a></li>
                    <li class="<?php if ($subnav == 'listclass') { echo 'active'; } ?>"><a href="classlist.php">List All</a></li>
                </ul>
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