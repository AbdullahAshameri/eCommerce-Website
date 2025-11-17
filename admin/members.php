<?php

/*

** Manage Members Page
** You Can Add | Edit | Delete Members Frome Here

*/

session_start();

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { // Get Manage Page 

        // Select All Users Except Admin
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");

        // Execute The Statment
        $stmt->execute();

        // Assign To Variable
        $rows = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Member</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . "</td>";
                        echo "<td>
                                <a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'>Edit</a>
                                <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>
        </div>

    <?php } elseif ($do == 'Add') {  // Add Member Page 
    ?>

        <h1 class="text-center">Add New Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- Starat Username Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop" />
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Starat Password Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6 password-box">
                        <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex" />
                        <i class="show-pass fa fa-eye"></i>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Starat Email Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Starat Full Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required="required" placeholder="Full Name Apper In Your Page" />
                    </div>
                </div>
                <!-- End Full Name Field -->
                <!-- Starat Submit Field -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>

        <?php
    } elseif ($do == 'Insert') {

        // Insert Member Page

        // $pass = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";
            // Get The Variable From The Form
            $user   = $_POST['username'];
            $pass   = sha1($_POST['password']);
            $email  = $_POST['email'];
            $name   = $_POST['full'];

            $hashPass = sha1($_POST['password']);

            // Validate The Form
            $formErrors = array();
            if (strlen($user) < 4) {

                $formErrors[] = 'Username Cant Be Less Than <strong>4 Char</strong>';
            }

            if (strlen($user) > 20) {

                $formErrors[] = 'Username Cant Be <strong>More Than 20 Char</strong>';
            }
            if (strlen($pass) < 20) {

                $formErrors[] = 'Password Cant Be More Than <strong>20 Char</strong>';
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

                // Insert User Inf In Database

                $stmt = $con->prepare("INSERT INTO 
                                        users(Username, Password, Email, FullName)
                                    VALUES
                                        (:zuser, :zpass, :zemail, :zname)");
                $stmt->execute(array(
                    'zuser'    => $user,
                    'zpass'    => $hashPass,
                    'zemail'   => $email,
                    'zname'    => $name,

                ));

                // Echo Seccess Message
                echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Iserted </div>';
            }
        } else {
            echo '<div class="alert alert-danger">Sorry You Cant <strong>Browse</strong> This Page Directry';
        }
        echo "</div>";
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
            echo 'There is No Such ID';
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
                echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';
            }
        } else {
            echo '<div class="alert alert-danger">Sorry You Cant <strong>Browse</strong> This Page Directry';
        }
        echo "</div>";
    } elseif ($do == 'Delete') { // Delete Member Page

        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class='container'>";

            // Check if Get Request userid Is Numeric & Get The Integer Value Of It

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            //Select All Data Depend In This ID
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

            // Execute
            $stmt->execute(array($userid));

            // The Row Count
            $count = $stmt->rowCount();

            // If There is Such Id Show The Form
            if ($stmt->rowCount() > 0) {

                $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

                $stmt->bindParam(":zuser", $userid);

                $stmt->execute();

                echo "<div class='alert alert-success'>" . $stmt->rowCount() .'Rrcord Deleted </div>';

            } else {
                echo 'This ID is Not Exist';
            }
            
        echo '</div>';
    }

    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
