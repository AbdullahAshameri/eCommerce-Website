<?php

include 'connect.php';
// Routes
$tpl = 'includes/templates/'; // Template Directory
$lang = 'includes/languages/'; // Lang Directory
$func = 'includes/functions/'; // Functions Directory
$css = 'layout/css/'; // Css Directory
$js = 'layout/js/'; // Js Directory

// Include The Importants Files
include $func . 'functions.php';
include $lang . 'englesh.php';
include $tpl . 'header.php';

// Incloud Navbare On All PAges Expect The One With $noNavbar Virable
if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
}
