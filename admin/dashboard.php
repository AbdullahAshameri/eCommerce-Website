<?php
session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = "Dashboard";

    include 'init.php';

    // Start Dashboard page
?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members
                        <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?do=Manage&page=Pending">50</a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-item">
                        Total Items
                        <span>60</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-coments">
                        Total Coments
                        <span>70</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users">
                            </i>Latest Registerd Users
                        </div>
                        <div class="panel-body">
                            test
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i>Latest Items
                        </div>

                        <div class="panel-body">
                            test
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    // End Dashboard Page

    // print_r($_SESSION['ID']);

    include $tpl . 'footer.php';
} else {

    header('Location: index.php'); // Redirect to login Page

    exit();
}
