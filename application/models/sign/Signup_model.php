<?php

class Signup_model extends CI_Model {
    public function save_user(){
        $birthday = $this->input->post('birthday');        
        $data = array(           
            'user_name' => $this->input->post('username'),            
            'user_email' => $this->input->post('email'),
            'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday))),
            'user_password'=>sha1($this->input->post('password')));
        $this->db->trans_start();
        $this->db->set('user_registration_date', 'NOW()', FALSE);
        $this->db->insert('lex_users',$data);            
        $id_user = $this->db->insert_id();            
        $this->db->set('pi_user_id',$id_user, FALSE);        
        $this->db->insert('lex_personal_info');
        $this->db->set('la_user_id',$id_user, FALSE);
        $this->db->set('time','NOW()', FALSE);
        $this->db->insert('lex_last_activity');
        $this->db->trans_complete();  
        return TRUE;
    }      
}
