<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span>Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="index.php">Admin Dashboard</a></li>
                    </ul>
                </li>



                <li class="menu-title">
                    <?php

                    if ($_SESSION['userlogin'] == 1) {

                    ?>
                        <span>Employees</span>

                    <?php
                    } else {

                    ?>
                        <span>Personal</span>

                    <?php


                    } ?>

                </li>
                <li class="submenu">
                    <?php

                    if ($_SESSION['userlogin'] == 1) {

                    ?>
                        <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>



                    <?php
                    } else {

                    ?>
                        <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Personal</span> <span class="menu-arrow"></span></a>



                    <?php


                    } ?>



                    <ul style="display: none;">
                        <?php

                        if ($_SESSION['userlogin'] == 1) {

                        ?>
                            <li><a href="employees.php">All Employees</a></li>

                        <?php
                        }  ?>

                        <li><a href="holidays.php">Holidays</a></li>
                        <li><a href="leaves-employee.php">Employee Leave</a></li>
                        <?php

                        if ($_SESSION['userlogin'] == 1) {

                        ?>
                            <li><a href="departments.php">Departments</a></li>

                        <?php
                        }  ?>
                        <?php

                        if ($_SESSION['userlogin'] == 1) {

                        ?>
                            <li><a href="designations.php">Designations</a></li>

                        <?php
                        }  ?>


                        <li><a href="timesheet.php">Timesheet</a></li>

                        <?php

                        if ($_SESSION['userlogin'] == 1) {

                        ?>

                            <li><a href="overtime.php">Overtime</a></li>

                        <?php
                        }

                        ?>



                    </ul>
                </li>
                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                    <li>
                        <a href="userRole.php"><i class="la la-key"></i> <span>User Role</span></a>
                    </li>

                <?php
                }

                ?>

                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                    <li>
                        <a href="clients.php"><i class="la la-users"></i> <span>Clients</span></a>
                    </li>

                <?php
                }

                ?>

                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                    <li class="submenu">
                        <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="projects.php">Projects</a></li>
                        </ul>
                    </li>

                <?php
                }  ?>

                <!-- <li>
                    <a href="leads.php"><i class="la la-user-secret"></i> <span>Leads</span></a>
                </li> -->
                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                    <li class="menu-title">
                        <span>HR</span>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a href="payroll-items.php"> Payroll Items </a></li>
                        </ul>
                    </li>



                    <li class="submenu">
                        <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="goal-tracking.php"> Goal List </a></li>
                            <li><a href="goal-type.php"> Goal Type </a></li>
                        </ul>
                    </li>


                <?php
                }  ?>

                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                    <li class="menu-title">
                        <span>Administration</span>
                    </li>

                    <li>
                        <a href="assets.php"><i class="la la-object-ungroup"></i> <span>Assets</span></a>
                    </li>

                    <!-- <li>
                        <a href="users.php"><i class="la la-user-plus"></i> <span>Users</span></a>
                    </li> -->


                <?php
                }  ?>



                <li class="menu-title">
                    <span>Pages</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="profile.php"> Employee Profile </a></li>
                    </ul>
                </li>

                <li>

                    <?php

                    if ($_SESSION['userlogin'] == 2) {

                    ?>
                        <a class=" desprojectbutton" href="#" data-id="" data-toggle="modal" data-target="#logoutt"><i class="la la-power-off"></i> <span>Logout</span></a>

                    <?php
                    } else {

                        echo ' <a href="logout.php"><i class="la la-power-off"></i> <span>Logout</span> </a> ';
                    } ?>

                    <!-- -->
                </li>

            </ul>
        </div>
    </div>
</div>