<?php defined('BASEPATH') OR exit('No direct script access allowed');        
    
function totalmsg_chat(){
    $ci=& get_instance();
    $iduserunread = $ci->session->userdata('userid');
    $countchat = $ci->header_model->count_unread_msg($iduserunread);
    return $countchat;                
}

function total_unread_notifications(){
    $ci=& get_instance();
    $iduserunread = $ci->session->userdata('userid');
    $countnotify = $ci->header_model->count_unread_ntf($iduserunread);
    return $countnotify;                
}

function total_notifications(){
    $ci=& get_instance();
    $iduser = $ci->session->userdata('userid');
    $countntf = $ci->header_model->count_ntf($iduser);
    return $countntf;                
}

function read_transition(){
    $ci=& get_instance();    
    $transition = $ci->header_model->check_transition();
    return $transition;                
}

function read_sitetitle(){
    $ci=& get_instance();    
    $sitetitle = $ci->header_model->get_sitetitle();
    return $sitetitle;                
}


