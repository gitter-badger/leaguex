<?php

class Forgot_password_model extends CI_Model{
    
    
    public function dbforget($email){                  
        $this->db->where('user_email',$email);       
        $query = $this->db->get('lex_users');
        if($query->num_rows()>0){
            return $query->result();                       
            }else{
            return FALSE;
        }   
    }
}


