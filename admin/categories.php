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

        $sort = 'ASC';
        $type = 'Ordering';

        $sort_array = array('ASC', 'DESC');
        $type_array = array('Ordering', 'ID');

        if (isset($_GET['type']) && in_array($_GET['type'], $type_array)) {

            $type = $_GET['type'];
        }

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

            $sort = $_GET['sort'];
        }

        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY $type $sort");

        $stmt2->execute();

        $cats = $stmt2->fetchAll(); ?>

        <h1 class="text-center">Manage Category</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage Categories
                    <div class="ordering pull-right">
                        Ordering:
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?type=<?php echo $type; ?>&sort=ASC">Asc</a> |
                        <a class="<?php if ($sort == 'DESC') {
                                        echo 'active';
                                    } ?>" href="?type=<?php echo $type; ?>&sort=DESC">Desc</a>
                    </div>

                    <div class="ordering pull-right">
                        By:
                        <a class="<?php if ($type == 'Ordering') {
                                        echo 'active';
                                    } ?>" href="?type=Ordering&sort=<?php echo $sort; ?>">Ordering</a> |
                        <a class="<?php if ($type == 'ID') {
                                        echo 'active';
                                    } ?>" href="?type=ID&sort=<?php echo $sort; ?>">ID</a> |
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($cats as $cat) {
                        echo "<div class='cat'>";
                        echo "<div class='hidden-buttons'>";
                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                        echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                        echo "</div>";
                        echo "<h3>" . $cat['Name'] . '</h3>';
                        echo "<p>";
                        if ($cat['Description'] == '') {
                            echo 'This category has no description';
                        } else {
                            echo $cat['Description'];
                        }
                        echo "</p>";
                        echo 'Ordering Is ' . $cat['Ordering'] . '<br />';
                        if ($cat['Visibility'] == 1) {
                            echo '<span class="visibility">Hidden</span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class="commenting">Comment Disabled</span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class="advertises">Ads Disabled</span>';
                        }
                        echo "</div>";
                        echo "<hr>";
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
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
        // Check if Get Request catid Is Numeric & Get The Integer Value Of It

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        //Select All Data Depend In This ID
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

        // Execute
        $stmt->execute(array($catid));

        // Fetch The Data
        $cat = $stmt->fetch();

        // The Row Count
        $count = $stmt->rowCount();

        // If There is Such Id Show The Form
        if ($count > 0) { ?>

            <h1 class="text-center">Edit Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                    <!-- Starat Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name']; ?>" />
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Starat Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6 password-box">
                            <input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?php echo $cat['Description']; ?>" />
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Starat Ordering Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="ordering" class="form-control" placeholder="Number To Array The Categories" value="<?php echo $cat['Ordering'] ?>" />
                        </div>
                    </div>
                    <!-- End Ordering Field -->
                    <!-- Starat Visibility Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0 ) {echo 'checked'; }?> />
                                <label for="vis-yes">Yeas</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1 ) {echo 'checked'; }?> />
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
                                <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) {echo 'checked'; }?> />
                                <label for="com-yes">Yeas</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" <?php if( $cat['Allow_Comment'] == 1) {echo 'checked'; }?> />
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
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) {echo 'checked'; } ?> />
                                <label for="ads-yes">Yeas</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Comment'] == 1) {echo 'checked'; }?> />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads Field -->
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
    } elseif ($do == 'Update') {

    } elseif ($do == 'Delete') {
    }

    include $tpl . 'footer.php';
} else {

    header('Location: index.php');

    exit();
}

ob_end_flush(); //  Relase The Output
