<?php
session_start();
if (isset($_SESSION['Username'])) {

    // echo "Wellcom " . $_SESSION['Username'];
    include 'init.php';
    echo 'Wellcome';
    include $tpl . 'footer.php';
} else {

    header('Location: index.php'); // Redirect to login Page

    exit();
}
