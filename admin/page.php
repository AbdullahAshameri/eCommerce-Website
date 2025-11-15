<?php
/*

    Categories => [ Manage | Edit | Update | Add | Insert | Delete | Stats ]

*/
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    // if(isset($_GET['do']) ) {

    //         $do = $_GET['do'];
    // } else {
        
    //     $do = 'Manage';

    // }

    // If The Page Is Mine Page
    if($do == 'Manage') {
        echo 'Welcom You Are In Manage Category Page<br>';
        echo '<a href="page.php?do=Add">Add New Category+</a>';
    } elseif ($do == 'Add') {
        echo 'Welcom You are in Add Category Page<br>';
        echo '<a href="page.php?do=Insert">Insert Category +</a>';
    }elseif ($do == 'Insert') {
        echo 'Welcom You are in Insert Category Page';
    }else{
        echo 'Error \' No Page Whith This Name';
    }