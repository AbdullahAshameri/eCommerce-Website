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

        echo 'Welcome To Items Page';
    } elseif ($do == 'Add') { ?>

        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- Starat Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Item" />
                    </div>
                </div>
                <!-- End Name Field -->
                <!-- Starat Description Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="Description" class="form-control" required="required" placeholder="Description Of The Item" />
                    </div>
                </div>
                <!-- End Description Field -->
                <!-- Starat Price Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="Price" class="form-control" required="required" placeholder="Price Of The Item" />
                    </div>
                </div>
                <!-- End Price Field -->
                <!-- Starat Country Made Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="Country_Made" class="form-control" required="required" placeholder="Country Of Made" />
                    </div>
                </div>
                <!-- End Country Made Field -->
                <!-- Starat Image Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="Country_Made" class="form-control" required="required" placeholder="Image Of The Item" />
                    </div>
                </div>
                <!-- End Image Field -->
                <!-- Starat Status Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name="Status" id="">
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
