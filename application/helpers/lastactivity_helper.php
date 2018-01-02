<?php defined('BASEPATH') OR exit('No direct script access allowed');        
    
function last_activity(){
    $ci=& get_instance();
    $ci->load->database(); 
    $logged = $ci->session->userdata('logged_in');
    
    if($logged){
        $date = date('Y-m-d H:i:s');
        $uid = $ci->session->userdata('userid');                 
           
        $ci->db->set('time', $date);
        $ci->db->where('la_user_id', $uid);
        $ci->db->update('lex_last_activity');        
    }
}


