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

                            echo " <a href='members.php?do=Approve&comid=" 
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

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //Select All Data Depend In This ID
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        // Execute
        $stmt->execute(array($userid));
        // Fetch The Data
        $row = $stmt->fetch();

        // The Row Count
        $count = $stmt->rowCount();

        // If There is Such Id Show The Form
        if ($stmt->rowCount() > 0) { ?>
            <h1 class="text-center">Edit Member</h1>
            <div class="container">

                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">

                    <!-- Starat Username Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username'] ?>" required="required" />
                        </div>
                    </div>
                    <!-- End Username Field -->
                    <!-- Starat Password Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
                            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
                        </div>
                    </div>
                    <!-- End Password Field -->
                    <!-- Starat Email Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required" />
                        </div>
                    </div>
                    <!-- End Email Field -->
                    <!-- Starat Full Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
                        </div>
                    </div>
                    <!-- End Full Name Field -->
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

        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class='container'>";

        // $pass = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get The Variable From The Form
            $id     = $_POST['userid'];
            $user   = $_POST['username'];
            $email  = $_POST['email'];
            $name   = $_POST['full'];

            // Password Trick
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

            // Validate The Form
            $formErrors = array();
            if (strlen($user) < 4) {

                $formErrors[] = 'Username Cant Be Less Than <strong>4 Char</strong>';
            }

            if (strlen($user) > 20) {

                $formErrors[] = 'Username Cant Be More Than <strong>20 Char</strong>';
            }

            if (empty($user)) {

                $formErrors[] = 'Username cant Be <strong>Empty</strong>';
            }

            if (empty($name)) {

                $formErrors[] = 'Full Name Cant be <strong>Empty</strong>';
            }

            if (empty($email)) {

                $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
            }

            // Loop Into Error Array And Echo It
            foreach ($formErrors as $errors) {
                echo '<div class="alert alert-danger">' . $errors . '</div> <br>';
            }

            // Update The Database Whith This info Update Operation
            if (empty($formErrors)) {

                // Update The Database Whith This info
                $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName= ?, Password = ? WHERE UserID = ?");
                $stmt->execute(array($user, $email, $name, $pass, $id));

                // Echo Seccess Message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';

                redirectHome($theMsg, 'back', 3);
            }
        } else {
            echo "<div class='continer'>";

            $theMsg = '<div class="alert alert-danger">Sorry You Cant <strong>Browse</strong> This Page Directry';
            redirectHome($theMsg, 'back');

            echo "</div>";
        }

        echo "</div>";
    } elseif ($do == 'Delete') { // Delete Member Page

        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class='container'>";

        // Check if Get Request userid Is Numeric & Get The Integer Value Of It

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //Select All Data Depend In This ID

        $check = checkItem('userid', 'users', $userid);

        // If There is Such Id Show The Form
        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

            $stmt->bindParam(":zuser", $userid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Rrcord Deleted </div>';
            redirectHome($theMsg);
        } else {

            $theMsg = '<div class="alert alert-danger"This ID is Not Exist</div>';
            redirectHome($theMsg);
        }

        echo '</div>';
    } elseif ($do == 'Activate') {

        echo "<h1 class='text-center'>Activate Member</h1>";
        echo "<div class='container'>";

        // Check if Get Request userid Is Numeric & Get The Integer Value Of It

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //Select All Data Depend In This ID

        $check = checkItem('userid', 'users', $userid);

        // If There is Such Id Show The Form
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

            $stmt->execute(array($userid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Rrcord Updated </div>';
            redirectHome($theMsg);
        } else {

            $theMsg = '<div class="alert alert-danger"This ID is Not Exist</div>';
            redirectHome($theMsg);
        }

        echo '</div>';
    }

    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
