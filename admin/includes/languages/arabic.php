<?php

function lang($phrase) {

    static $lang = array(
        'MESSAGE' => 'Wellcom In Arabic',
        'ADMIN' => 'Administrato In Arabic'
    );

    return $lang[$phrase];
}