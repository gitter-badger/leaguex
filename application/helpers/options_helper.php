<?php defined('BASEPATH') OR exit('No direct script access allowed');        
    
function options(){
    $ci=& get_instance();
    $ci->load->database(); 
    $ci->db->from('lex_settings');
    $query = $ci->db->get();
    $option = $query->row(); 
    return $option;
}
