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
    ** Home Redirect Function v2.0
    ** [ This Function Accept Paramaters ]
    ** $theMsg = Echo The Message [ Error | Success | Warrning ]
    ** $url = The Link You Want To Redirect
    ** $seconds = Seconds Before Redirecting
    */

    function redirectHome ($theMsg, $url = null, $seconds = 3) {
        $link = 'Homepage';
        if ($url === null ) {

            $url = 'index.php';
            $link = 'Homepage';
        } else {

            // $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''?  $_SERVER['HTTP_REFERER'] : 'index.php';
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

                $url = $_SERVER['HTTP_REFERER'];

                $link = 'Previous Page';

            }else {

                $url = 'index.php';

                $link = 'Homepage';
            }
            
        }

        echo $theMsg;
        echo "<div class='alert alert-info'>You will Be Redirected To $link After $seconds Seconds.</div>";
        header("refresh: $seconds; url=$url");
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

 