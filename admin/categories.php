<?php

/*
    ==========================================
    == Category Page
    ==========================================
    */

ob_start();

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
    } elseif ($do == 'Add') { ?>

        <h1 class="text-center">Add New Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- Starat Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
                    </div>
                </div>
                <!-- End Name Field -->
                <!-- Starat Description Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6 password-box">
                        <input type="text" name="description" class="form-control" placeholder="Describe The Category" />
                    </div>
                </div>
                <!-- End Description Field -->
                <!-- Starat Ordering Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="ordering" class="form-control" placeholder="Number To Array The Categories" />
                    </div>
                </div>
                <!-- End Ordering Field -->
                <!-- Starat Visibility Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                            <label for="vis-yes">Yeas</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Visibility Field -->
                <!-- Starat Commenting Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked />
                            <label for="com-yes">Yeas</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Commenting Field -->
                <!-- Starat Ads Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="ads-yes">Yeas</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Ads Field -->
                <!-- Starat Submit Field -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>

<?php

    } elseif ($do == 'Insert') {

        // Insert Member Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";
            // Get The Variable From The Form
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $order      = $_POST['ordering'];
            $visible    = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads        = $_POST['ads'];

            // Check If User Exist in Database
            $check = checkItem("Name", "categories", $name);

            if ($check == 1) {

                $theMsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';

                redirectHome($theMsg, 'back');
            } else {

                // Insert Category Info In Database
                $stmt = $con->prepare("
                    INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
                VALUES(:zname, :zdesc, :zorder, :zvis, :zcom, :zads)
            ");

                $stmt->execute([
                    'zname'  => $name,
                    'zdesc'  => $desc,
                    'zorder' => $order,
                    'zvis'   => $visible,
                    'zcom'   => $comment,
                    'zads'   => $ads
                ]);



                // Echo Seccess Message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Iserted </div>';

                redirectHome($theMsg, 'back');
            }
        } else {

            echo "<div class='container'>";

            $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directrly</div>';
            redirectHome($theMsg, 'back', 3);

            echo "</div>";
        }
    } elseif ($do == 'Edit') {
    } elseif ($do == 'Update') {
    } elseif ($do == 'Delete') {
    }

    include $tpl . 'footer.php';
} else {

    header('Location: index.php');

    exit();
}

ob_end_flush(); //  Relase The Output
