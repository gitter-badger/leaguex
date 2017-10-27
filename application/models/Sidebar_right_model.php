<?php

class Sidebar_right_model extends CI_Model{
    
    function showusers(){
        $this->db->select('user_id,user_name,user_avatar,aboutme,time,user_permissions,user_birthday');
        $this->db->from('lex_users');
        $this->db->join('lex_last_activity', 'la_user_id = user_id');
        $this->db->join('lex_personal_info', 'pi_user_id = user_id'); 
        $this->db->order_by('user_name', 'ASC');
        $query = $this->db->get();        
        return $query->result();
    }  
    
    function get_user($idchat){
        $this->db->select('user_id');
        $this->db->where('user_id',$idchat);
        $this->db->from('lex_users');        
        $query = $this->db->get();        
        return $query->row();
    }    
    
}  
