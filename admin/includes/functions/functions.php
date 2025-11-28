<?php
    /*
    ** Title Function That Echo The Page Title In Case The Page
    ** Has The Variable $pageTitle And Echo Defult Title For Othe Pages
    */
    function getTitle() {

        global $pageTitle;

        if(isset($pageTitle)) {

            echo $pageTitle;

        }else{

            echo 'Defaulte';

        }
    }

    /* 
    ** Home Redirect Function [ This Function Accept Paramaters ]
    ** $errorMsg = Echo The Error Message
    ** $seconds = Seconds Before Redirecting
    */

    function redirectHome ($errorMsg, $seconds) {
        echo "<div class='alert alert-danger'>$errorMsg</div>";
        echo "<div class='alert alert-danger'>You will Be Redirected To homePage After $seconds Seconds.</div>";
        header("refresh: $seconds; url=index.php");
        exit();
    }