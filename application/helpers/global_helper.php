<?php defined('BASEPATH') OR exit('No direct script access allowed');      

// Global Functions 

// Compare and truncate string (view)
function compare_text($val1, $val2){
    $compare = substr_compare($val1,$val2, 0, 3, TRUE);
    $val3 = substr($val1, -3, 2);
    if($compare == 0){
        $compareName = $val1[0].$val3;
    } else {
        $compareName = substr($val1, 0,3);
    }
    return $compareName;
}
