<?php
    /*
    ** Title Function v1.0
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
    ** Home Redirect Function v1.0
    ** [ This Function Accept Paramaters ]
    ** $errorMsg = Echo The Error Message
    ** $seconds = Seconds Before Redirecting
    */

    function redirectHome ($errorMsg, $seconds) {
        echo "<div class='alert alert-danger'>$errorMsg</div>";
        echo "<div class='alert alert-danger'>You will Be Redirected To homePage After $seconds Seconds.</div>";
        header("refresh: $seconds; url=index.php");
        exit();
    }

    /*
    ** Check Items Funnction v1.0
    ** Function to Check Item In Database [ Function Accept Parameter ]
    ** $select = The Item To Select [ Example: user, item, category ]
    ** $from = The Table To Select From [ Example: users, items, categories ]
    ** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
    */

    function checkItem($select, $from, $value) {

        global $con;
        
        $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

    $statment->execute(array($value));

    $count = $statment->rowCount();
    
    return $count;

}

 