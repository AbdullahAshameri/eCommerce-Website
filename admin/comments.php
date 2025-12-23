<?php

/*
================================================
** Manage Comments Page
** You Can Edit | Delete | Approve Comments Frome Here
================================================

*/

session_start();

$pageTitle = 'Comments';

if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { // Get Manage Page 


        // Select All Users Except Admin
        $stmt = $con->prepare("SELECT 
                                    comments.*, items.Name AS Item_Name, users.Username AS Member
                               FROM 
                                    comments
                               INNER JOIN 
                                    items
                               ON 
                                    items.item_ID = comments.item_id
                                    
                               INNER JOIN 
                                    users
                               ON
                                    users.UserID = comments.user_id");

        // Execute The Statment
        $stmt->execute();

        // Assign To Variable
        $rows = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table">
                    <tr>
                        <td>ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['c_id'] . "</td>";
                        echo "<td>" . $row['comment'] . "</td>";
                        echo "<td>" . $row['item_id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['comment_date'] . "</td>";
                        echo "<td>
                                <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa  fa-close'></i>Delete</a>";

                        if ($row['status'] == 0) {

                            echo " <a href='comments.php?do=Approve&comid=" 
                                        . $row['c_id'] . "' 
                                        class='btn btn-info activate'>
                                        <i class='fa  fa-check'></i>Approve</a>";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

    <?php

    } elseif ($do == 'Edit') { // Get Edit Page 

        // Check if Get Request userid Is Numeric & Get The Integer Value Of It

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        //Select All Data Depend In This ID
        $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
        // Execute
        $stmt->execute(array($comid));
        // Fetch The Data
        $row = $stmt->fetch();

        // The Row Count
        $count = $stmt->rowCount();

        // If There is Such Id Show The Form
        if ($stmt->rowCount() > 0) { ?>
            <h1 class="text-center">Edit Comment</h1>
            <div class="container">

                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="comid" value="<?php echo $comid; ?>">

                    <!-- Starat Comment Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea class="form-control" name="comment" id=""><?php echo $row['comment'] ?></textarea>
                        </div>
                    </div>
                    <!-- End Comment Field -->
                    <!-- Starat Submit Field -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>

            </div>

<?php
            // If There's No Such ID Show Error Message
        } else {

            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger"> There is No Such ID </div>';

            redirectHome($theMsg);

            echo "<</div>";
        }
    } elseif ($do == 'Update') { // Update page

        echo "<h1 class='text-center'>Update Comment</h1>";
        echo "<div class='container'>";

        // $pass = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get The Variable From The Form
            $comid     = $_POST['comid'];
            $comment   = $_POST['comment'];

            // Update The Database Whith This info
            $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
            $stmt->execute(array($comment, $comid));

            // Echo Seccess Message
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';

            redirectHome($theMsg, 'back', 3);

        } else {
            echo "<div class='continer'>";

            $theMsg = '<div class="alert alert-danger">Sorry You Cant <strong>Browse</strong> This Page Directry';
            redirectHome($theMsg, 'back');

            echo "</div>";
        }

        echo "</div>";
    } elseif ($do == 'Delete') { // Delete Member Page

        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class='container'>";

        // Check if Get Request userid Is Numeric & Get The Integer Value Of It

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        //Select All Data Depend In This ID

        $check = checkItem('c_id', 'comments', $comid);

        // If There is Such Id Show The Form
        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zcom");

            $stmt->bindParam(":zcom", $comid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Rrcord Deleted </div>';
            redirectHome($theMsg);
        } else {

            $theMsg = '<div class="alert alert-danger"This ID is Not Exist</div>';
            redirectHome($theMsg);
        }

        echo '</div>';
    } elseif ($do == 'Approve') {

        echo "<h1 class='text-center'>Approve Comment</h1>";
        echo "<div class='container'>";

        // Check if Get Request Comid Is Numeric & Get The Integer Value Of It

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        //Select All Data Depend In This ID

        $check = checkItem('c_id', 'comments', $comid);

        // If There is Such Id Show The Form
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

            $stmt->execute(array($comid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Rrcord Approved </div>';
            redirectHome($theMsg, 'back');
        } else {

            $theMsg = '<div class="alert alert-danger>"This ID is Not Exist</div>';
            redirectHome($theMsg);
        }

        echo '</div>';
    }

    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
