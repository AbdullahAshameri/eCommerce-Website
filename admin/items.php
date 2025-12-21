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


        $stmt = $con->prepare("  SELECT 
                                    items.*, 
                                    categories.Name AS Category_name,
                                    users.Username    
                                FROM 
                                    items
                                INNER JOIN 
                                    categories 
                                ON 
                                    categories.ID = items.Cat_ID
                                INNER JOIN 
                                users 
                                ON 
                                users.UserID = items.Member_id");

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
                        <td>Category</td>
                        <td>Username</td>
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
                        echo "<td>" . $item['Category_name'] . "</td>";
                        echo "<td>" . $item['Username'] . "</td>";
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

        // Check if Get Request item Is Numeric & Get The Integer Value Of It

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        //Select All Data Depend In This ID
        $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
        // Execute
        $stmt->execute(array($itemid));
        // Fetch The Data
        $item = $stmt->fetch();

        // The Row Count
        $count = $stmt->rowCount();

        // If There is Such Id Show The Form
        if ($stmt->rowCount() > 0) { ?>

            <h1 class="text-center">Edite Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
                    <!-- Starat Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Name Of The Item" value="<?php echo $item['Name'] ?>" />
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Starat Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" placeholder="Description Of The Item" value="<?php echo $item['Description'] ?>" />
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Starat Price Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" class="form-control" placeholder="Price Of The Item" value="<?php echo $item['Price'] ?>" />
                        </div>
                    </div>
                    <!-- End Price Field -->
                    <!-- Starat Country Made Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="country" class="form-control" placeholder="Country Of Made" value="<?php echo $item['Country_Made'] ?>" />
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
                                <option value="1" <?php if ($item['Status'] == 1 ) { echo 'selected'; } ?>>New</option>
                                <option value="2" <?php if ($item['Status'] == 2 ) { echo 'selected'; } ?>>Link New</Link></option>
                                <option value="3" <?php if ($item['Status'] == 3 ) { echo 'selected'; } ?>>Used</option>
                                <option value="4" <?php if ($item['Status'] == 4 ) { echo 'selected'; } ?>>Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->
                    <!-- Starat Members Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="" name="member" id="">
                                <?php
                                $stmt = $con->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo "<option value='" . $user['UserID'] . "'";
                                    if ($item['Member_id'] == $user['UserID'] ) { echo 'selected'; } 
                                    echo">" . $user['Username'] . "</option>";
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
                                <?php
                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach ($cats as $cat) {

                                    echo "<option value='" . $cat['ID'] . "'";
                                    if ($item['Cat_ID'] == $cat['ID'] ) { echo 'selected'; }
                                    echo ">" . $cat['Name'] . "</option>";
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
            // If There's No Such ID Show Error Message
        } else {

            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger"> There is No Such ID </div>';

            redirectHome($theMsg);

            echo "<</div>";
        }
    } elseif ($do == 'Update') {

        echo "<h1 class='text-center'>Update Item</h1>";
        echo "<div class='container'>";

        // $pass = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get The Variable From The Form
            $id             = $_POST['itemid'];
            $name           = $_POST['name'];
            $desc           = $_POST['description'];
            $price          = $_POST['price'];
            $country        = $_POST['country'];
            $status         = $_POST['status'];
            $cat            = $_POST['category'];
            $member         = $_POST['member'];

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

                // Update The Database Whith This info
                $stmt = $con->prepare("UPDATE 
                                            items 
                                        SET 
                                            Name = ?, 
                                            Description = ?, 
                                            Price = ?, 
                                            Country_Made = ?, 
                                            Status = ?, 
                                            Cat_ID  = ?, 
                                            Member_id  = ? 
                                        WHERE 
                                            item_ID = ?");
                $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));

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
        
    } elseif ($do == 'Delete') {
    } elseif ($do == 'Approve') {
    }

    include $tpl . 'footer.php';
} else {

    header('Location: index.php');

    exit();
}

ob_end_flush(); //  Relase The Output
