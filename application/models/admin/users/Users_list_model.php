<?php

class Users_list_model extends CI_Model{
    
    public function add_user(){
        $birthday = $this->input->post('birthday');        
        $data = array(           
            'user_name' => $this->input->post('username'),            
            'user_email' => $this->input->post('email'),
            'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday))),
            'user_password'=>sha1($this->input->post('password')));
        $this->db->set('user_registration_date', 'NOW()', FALSE);
        $this->db->insert('lex_users',$data);            
        $id_user = $this->db->insert_id();            
        $this->db->set('pi_user_id',$id_user, FALSE);        
        $this->db->insert('lex_personal_info');
        $this->db->set('la_user_id',$id_user, FALSE);
        $this->db->set('time','NOW()', FALSE);
        $this->db->insert('lex_last_activity');                
        $this->db->select('*');
        $this->db->from('lex_users');
        $this->db->join('lex_last_activity', 'la_user_id = user_id');
        $this->db->where('user_id', $id_user);
        $query = $this->db->get();
        return $query->result();
        
    }
    
    function edit_user($userid, $data){
        $this->db->where('user_id', $userid);
        $this->db->update('lex_users', $data);
    }
    
    function select_user($userid){
        $this->db->select('user_id, user_name, user_email, user_password, user_permissions, user_birthday, user_registration_date');
        $this->db->from('lex_users'); 
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function deleteuser($delete_id){
        $this->db->trans_start();
        $this->db->where('user_id', $delete_id);
        $this->db->delete('lex_users');
        $this->db->where('manager_user_id', $delete_id);
        $this->db->delete('lex_managers');
        $this->db->where('object_id', $delete_id);
        $this->db->delete('lex_notification');
        $this->db->where('user_id', $delete_id);
        $this->db->delete('lex_notification');
        $this->db->where('user_id', $delete_id);
        $this->db->delete('lex_last_notification');
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }    
}  

