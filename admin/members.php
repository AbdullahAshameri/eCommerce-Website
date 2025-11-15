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

        $user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //Select All Data Depend In This ID
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        // Execute
        $stmt->execute(array($user));
        // Fetch The Data
        $row = $stmt->fetch();

        // The Row Count
        $count = $stmt->rowCount();

        // If There is Such Id Show The Form
        if ($stmt->rowCount() > 0) { ?>
            <h1 class="text-center">Edit Member</h1>
            <div class="container">

                <form class="form-horizontal">
                    <!-- Starat Username Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username'] ?>" />
                        </div>
                    </div>
                    <!-- End Username Field -->
                    <!-- Starat Password Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="password" name="password" class="form-control" autocomplete="new-password" />
                        </div>
                    </div>
                    <!-- End Password Field -->
                    <!-- Starat Email Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" />
                        </div>
                    </div>
                    <!-- End Email Field -->
                    <!-- Starat Full Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-5">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" />
                        </div>
                    </div>
                    <!-- End Full Name Field -->
                    <!-- Starat Submit Field -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="Save" class="btn btn-primary btn-lg" />
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
    }
    // echo 'welcom In Edit Page' . $_GET['userid'];

    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
