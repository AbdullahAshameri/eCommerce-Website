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

    if ($do == 'Manage') {
        // Get Manage Page
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
                        <div class="col-sm-10 col-md-5">
                            <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username'] ?>" required="required" />
                        </div>
                    </div>
                    <!-- End Username Field -->
                    <!-- Starat Password Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
                            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                        </div>
                    </div>
                    <!-- End Password Field -->
                    <!-- Starat Email Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required" />
                        </div>
                    </div>
                    <!-- End Email Field -->
                    <!-- Starat Full Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-5">
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

                $formErrors[] = '<div class="alert alert-danger">Username Cant Be Less Than <strong>4 Char</strong></div>';
            }

            if (strlen($user) > 20) {

                $formErrors[] = '<div class="alert alert-danger">Username Cant Be More Than <strong>20 Char</strong></dive>';
            }

            if (empty($user)) {

                $formErrors[] = '<div class="alert alert-dander">Username cant Be <strong>Empty</strong></div>';
            }

            if (empty($name)) {

                $formErrors[] = '<div class="alert alert-danger">Full Name Cant be <strong>Empty</strong></div>';
            }

            if (empty($email)) {

                $formErrors[] = '<div class="alert alert-danger">Email Cant Be <strong>Empty</strong></div>';
            }

            // Loop Into Error Array And Echo It
            foreach ($formErrors as $errors) {
                echo $errors . '<br>';
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
    }

    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
