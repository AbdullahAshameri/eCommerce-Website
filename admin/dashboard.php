<?php

ob_start(); // Output Buffering Start

session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = "Dashboard";

    include 'init.php';

    // Start Dashboard page
    $numUsers = 6;
    $latestUsers = getLatest("*", "users", "UserID", "GroupID",$numUsers);

    $numItems = 6; // Number of The Latest Item
    $latestItems = getLatest("*", 'items', 'item_ID', $numItems); // Latest Item Array

    $numComments = 4;
    $comments = getLatest("*", 'comments', 'c_id', $numComments); // Latest Item Array

?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span>
                                <a href="members.php"><?php echo countItems('UserID', 'users')  ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Pending Members
                            <span><a href="members.php?do=Manage&page=Pending">
                                    <?php echo checkItem("RegStatus", "users", 0) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-item">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                            <a href="items.php"><span><?php echo countItems('item_id', 'items') ?></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-coments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Coments
                            <span>
                                <a href="comments.php"><?php echo countItems('c_id', 'comments')?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container">
            <div class="row">
                <!-- Start Latest Users -->
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users">
                            </i> Latest <?php echo $numUsers ?> Registerd Users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>

                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                if(!empty($latestUsers)){
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
                                } else {
                                    echo 'There\'S No Record To Show';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Latest Users -->
                <!-- Start Latest Items -->
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>

                            </span>
                        </div>

                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                if(!empty($latestItems)) {
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
                                } else {
                                    echo 'There\'s No Record To Show';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Latest Items -->
            </div>
            <!-- Start Latest Comments -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments-o">
                            </i> Latest <?php echo $numComments; ?> Comments
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>

                            </span>
                        </div>
                        <div class="panel-body">
                            <?php
                                $stmt = $con->prepare("SELECT
                                                            comments.*, users.Username AS Member
                                                        FROM
                                                            comments
                                                        INNER JOIN
                                                            users
                                                        ON
                                                            users.UserID = comments.user_id
                                                        ORDER BY 
                                                            c_id DESC
                                                        LIMIT $numComments");
                                $stmt->execute();
                                $comments = $stmt->fetchAll();

                                if (!empty($comments)) {
                                    foreach ($comments as $comment) {
                                        echo '<div class="comment-box">';
                                            echo '<span class="member-n">'; 
                                                echo '<a 
                                                        href="members.php?do=Edit&userid=' . $comment["user_id"] .'">'; 
                                                    echo htmlspecialchars($comment['Member']);
                                                echo '</a>';
                                            echo '</span>';
                                            echo '<p class="member-c">' . htmlspecialchars($comment['comment']) . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo 'There\'s No Record To Show';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest Comments -->
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
