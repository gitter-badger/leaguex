<?php

/*** Competitions Helper Global ***/

/*** FIXTURES ADMIN PAGE ***/

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

/*** EDIT LEAGUE ADMIN PAGE ***/

/* Change edit match icon */

function check_match_score($match_score1 = "", $match_score1, $match_score2, $match_id){
    return ($match_score1 == null) ? '<a href="javascript:editMatch('.$match_id.')" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg"><i class="material-icons">edit_mode</i></a>' : '<a href="javascript:editMatch('.$match_id.')"><strong>'.$match_score1.' - '.$match_score2.'</strong></a>';
}
