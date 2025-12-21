<?php

ob_start(); // Output Buffering Start

session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = "Dashboard";

    include 'init.php';

    // Start Dashboard page
    $numUsers = 6;
    $latestUsers = getLatest("*", "users", "UserID", $numUsers);

    $numItems = 6; // Number of The Latest Item
    $latestItems = getLatest("*", 'items', 'item_ID', $numItems); // Latest Item Array


?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members
                        <a href="members.php"><span><?php echo countItems('UserID', 'users') ?></span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?do=Manage&page=Pending">
                                <?php echo checkItem("RegStatus", "users", 0) ?>
                            </a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-item">
                        Total Items
                        <a href="items.php"><span><?php echo countItems('item_id', 'items') ?></span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-coments">
                        Total Coments
                        <span>0</span>
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
                            </i>Latest <?php echo $numUsers ?>Registerd Users
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                foreach ($latestUsers as $user) {

                                    echo '<li>';
                                    echo $user['Username'];
                                    echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                    echo '<span class="btn btn-success pull-right">';
                                    echo '<i class="fa fa-edit"></i>Edit';
                                        if ($user['RegStatus'] == 0) {
                                            echo " <a 
                                                href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
                                                class='btn btn-info pull-right activate'>
                                                <i class='fa  fa-check'></i>Activate</a>";
                                        }
                                    echo '</span>';
                                    echo '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i>Latest Items
                        </div>

                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                foreach ($latestItems as $item) {
                                    echo '<li>';
                                        echo $item['Name'];
                                        echo '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] . '">';
                                            echo '<span class="btn btn-success pull-right">';
                                                echo '<i class="fa fa-edit"></i>Edit';
                                                    if ($item['Approve'] == 0) {
                                                        echo " <a 
                                                            href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' 
                                                            class='btn btn-info pull-right activate'>
                                                            <i class='fa  fa-check'></i> Approve</a>";
                                                    }
                                                echo '</span>';
                                            echo '</a>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
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
ob_end_flush(); // Send output + end buffering
