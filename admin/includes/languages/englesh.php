<?php

    function lang($phrase) {

        static $lang = array(

             // Homepage
            'MESSAGE' => 'Wellcom',
            'ADMIN' => 'Administrato'

            // Setings
        );
        
        return $lang[$phrase];
    }

    /*
    $lang = array(

        'Osama' => 'Zero'
         
    );
    echo $lang['Osama'];
    */
