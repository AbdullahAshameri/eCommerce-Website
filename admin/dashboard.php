<?php
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitle = "Dashboard";
    // echo "Wellcom " . $_SESSION['Username'];
    include 'init.php';

    echo 'Welcom';
    print_r($_SESSION['ID']);

    include $tpl . 'footer.php';
} else {

    header('Location: index.php'); // Redirect to login Page

    exit();
}
