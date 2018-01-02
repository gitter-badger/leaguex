<?php

class Header_model extends CI_Model{
    
    function count_unread_msg($iduserunread){
        $countchat = $this->db->where('to', $iduserunread)                           
                          ->where('is_read', '0')
                          ->count_all_results('lex_chat');
		return $countchat;
    }
    
    function count_unread_ntf($iduserunread){
        $countnotify = $this->db->where('user_id', $iduserunread)                           
                          ->where('is_read', '0')
                          ->count_all_results('lex_notification');
		return $countnotify;
    } 
    
    function count_ntf($iduser){
        $countntf = $this->db->where('user_id', $iduser)                         
                          ->count_all_results('lex_notification');
		return $countntf;
    }
    
    function check_transition(){
        $this->db->select('transition')->from('lex_settings');
        return $this->db->get()->row('transition');		
    }
    
    function get_sitetitle(){
        $this->db->select('site_title')->from('lex_settings');
        return $this->db->get()->row('site_title');		
    }  
}  
