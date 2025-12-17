<?php

/*
    ==========================================
    == Items Page
    ==========================================
*/

ob_start();

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {


        $stmt = $con->prepare("SELECT * FROM items");

        // Execute The Statment
        $stmt->execute();

        // Assign To Variable
        $items = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['item_ID'] . "</td>";
                        echo "<td>" . $item['Name'] . "</td>";
                        echo "<td>" . $item['Description'] . "</td>";
                        echo "<td>" . $item['Price'] . "</td>";
                        echo "<td>" . $item['Add_Date'] . "</td>";
                        echo "<td>
                                <a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                <a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm'><i class='fa  fa-close'></i>Delete</a>";

                        // if ($item['RegStatus'] == 0) {

                        //     echo " <a href='items.php?do=Activate&userid=" . $item['item_ID'] . "' class='btn btn-info'><i class='fa  fa-close'></i>Activate</a>";
                        // }

                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New Item</a>
        </div>

    <?php

    } elseif ($do == 'Add') { ?>

        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- Starat Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Name Of The Item" />
                    </div>
                </div>
                <!-- End Name Field -->
                <!-- Starat Description Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Description Of The Item" />
                    </div>
                </div>
                <!-- End Description Field -->
                <!-- Starat Price Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="Price Of The Item" />
                    </div>
                </div>
                <!-- End Price Field -->
                <!-- Starat Country Made Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" class="form-control" placeholder="Country Of Made" />
                    </div>
                </div>
                <!-- End Country Made Field -->
                <!-- Starat Image Field -->
                <!-- <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="Image" class="form-control" required="required" placeholder="Image Of The Item" />
                    </div>
                </div> -->
                <!-- End Image Field -->
                <!-- Starat Status Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="status" id="">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Link New</Link>
                            </option>
                            <option value="3">Used</option>
                            <option value="4">Old</option>
                        </select>
                    </div>
                </div>
                <!-- End Status Field -->
                <!-- Starat Members Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="member" id="">
                            <option value="0">...</option>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {

                                echo "<option value='" . $user['UserID'] . " '>" . $user['Username'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End Members Field -->
                <!-- Starat Category Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="category" id="">
                            <option value="0">...</option>
                            <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories");
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach ($cats as $cat) {

                                echo "<option value='" . $cat['ID'] . " '>" . $cat['Name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End Category Field -->
                <!-- Starat Submit Field -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>

<?php

    } elseif ($do == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";
            // Get The Variable From The Form
            $name           = $_POST['name'];
            $desc           = $_POST['description'];
            $price          = $_POST['price'];
            $country        = $_POST['country'];
            // $image          = $_POST['image'];
            $status         = $_POST['status'];
            $member         = $_POST['member'];
            $cat            = $_POST['category'];

            // Validate The Form
            $formErrors = array();
            if (empty($name)) {

                $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
            }

            if (empty($desc)) {

                $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
            }
            if (empty($price)) {

                $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
            }

            if (empty($country)) {

                $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
            }

            if ($status == 0) {

                $formErrors[] = 'You Must Choose The <strong>Status</strong>';
            }
            if ($member == 0) {

                $formErrors[] = 'You Must Choose The <strong>Member</strong>';
            }
            if ($cat == 0) {

                $formErrors[] = 'You Must Choose The <strong>Category</strong>';
            }

            // Loop Into Error Array And Echo It
            foreach ($formErrors as $errors) {
                echo '<div class="alert alert-danger">' . $errors . '</div> <br>';
            }

            // Update The Database Whith This info Update Operation
            if (empty($formErrors)) {
                // If No Errors well insert the data
                // Insert User Info In Database
                $stmt = $con->prepare("INSERT INTO 
                                        items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_id)
                                    VALUES
                                        (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)"); // Any User Inserted By Admain RegStatus Tack 1 
                $stmt->execute(array(
                    'zname'       => $name,
                    'zdesc'       => $desc,
                    'zprice'      => $price,
                    'zcountry'    => $country,
                    'zstatus'     => $status,
                    'zcat'        => $cat,
                    'zmember'     => $member,

                ));

                // Echo Seccess Message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Iserted </div>';

                redirectHome($theMsg, 'back');
            }
        } else {

            echo "<div class='container'>";

            $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directrly</div>';
            redirectHome($theMsg);

            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit') {
    } elseif ($do == 'Update') {
    } elseif ($do == 'Delete') {
    } elseif ($do == 'Approve') {
    }

    include $tpl . 'footer.php';
} else {

    header('Location: index.php');

    exit();
}

ob_end_flush(); //  Relase The Output
