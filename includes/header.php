<?php
include('includes/config.php');
?>
<style>
    .avatar>img {
        height: 100% !important;
    }

    #require {
        color: red;
    }
</style>
<div class="header">
    <style>
        .modal-backdrop {
            z-index: 2 !important;
        }
    </style>
    <!-- Logo -->
    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="assets/img/logo.png" width="40" height="40" alt="">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>Dreamguy's Technologies</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->

        <!-- /Search -->



        <!-- Notifications -->
        <!-- /Notifications -->

        <!-- Message Notifications -->

        <!-- /Message Notifications -->

        <?php
        $sql = "SELECT * from users";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        $cnt = 1;
        ?>

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img src="./profiles/<?php echo htmlentities($result->Picture); ?>" alt="User Picture">
                    <span class="status online"></span></span>
                <span><?php echo htmlentities(ucfirst($_SESSION['FirstName'] . " " . $_SESSION['LastName'])); ?></span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="settings.php">Settings</a>
                <?php

                if ($_SESSION['userlogin'] == 2) {

                ?>
                    <a class="dropdown-item  desprojectbutton" href="#" data-id="" data-toggle="modal" data-target="#logoutt"> Log out</a>
                <?php
                } else {

                    echo '<a class="dropdown-item" href="logout.php">Logout</a> ';
                } ?>

            </div>
        </li>
    </ul>
    <!-- /Header Menu -->
    <div id="logoutt" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Description for your work </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="logoutform" action="logout.php">
                        <div class="form-group">
                            <label>Project Work on <span class="text-danger">*</span></label>
                            <select class="form-control" require name="project" id="project">
                                <option value="">Select Project</option>
                                <?php
                                $sql = "SELECT * FROM projects";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                        <option class="" value="<?php echo $row->id ?>"><?php echo $row->ProjectName ?></option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                            <p id="require"></p>

                        </div>
                        <script>
                            document.getElementById("logoutform").addEventListener("submit", function(event) {
                                var projectSelect = document.getElementById("project");
                                if (projectSelect.value === "") {
                                    var require = document.getElementById("require");
                                    require.innerHTML = `Project Work on is require `;
                                    event.preventDefault();

                                }
                            });
                        </script>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea rows="6" columns="6" name="description" id="form-control reason"></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" name="logoutandsave">Log out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="settings.php">Settings</a>
            <a class="dropdown-item" href="login.php">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<script>
    var modal = document.querySelector('.modal-backdrop');
    var desprojectbutton = document.querySelector('.desprojectbutton');
    desprojectbutton.addEventListener('click', function() {

        modal.classList.remove(...modal.classList);
    })
</script>