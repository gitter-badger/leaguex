<?php

/*** Competitions Helper Global ***/

/* Change link fixture icon */

function check_fixture_link($competition_fixture = ""){
    return ($competition_fixture == 0) ? '#' : 'edit_league/leagueid/';
}

/* Change class fixture icon */

function check_fixture_class($competition_fixture = ""){
    return ($competition_fixture == 0) ? 'make-fx' : 'success-fx';
}

/* Change fixture icon */

function check_fixture_icon($competition_fixture = ""){
    return ($competition_fixture == 0) ? 'event_avalaible' : 'mode_edit';
}

/* Change status icon */

function check_fixture_status($competition_status = ""){
    return ($competition_status == 0) ? 'text-red' : 'text-green';
}

