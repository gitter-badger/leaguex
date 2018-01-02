<?php

class Edit_settings_model extends CI_Model{  
        
    function userid($data){
        $this->db->select('*');
        $this->db->from('lex_users');
        $this->db->join('lex_personal_info', 'pi_user_id = user_id');
        $this->db->join('lex_managers', 'manager_user_id = user_id', 'left');
        $this->db->join('lex_teams', 'team_id = manager_team_id', 'left');
        $this->db->where('user_id', $data);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    } 
    
    function select_user_account($userid){
        $this->db->select('user_id, user_email, user_password, user_birthday, user_city');
        $this->db->from('lex_users'); 
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
     function select_user_info($userid){
        $this->db->select('pi_user_id, skype_tag, xbox_tag, psn_tag, favorite_club, aboutme');
        $this->db->from('lex_personal_info'); 
        $this->db->where('pi_user_id', $userid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function update_avatar($iduser,$imgname){
        $this->db->trans_start();
        $this->db->where('user_id', $iduser);
        $this->db->set('user_avatar',$imgname);
        $this->db->update('lex_users');                 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
     
    function update_account($userid, $data){
        $this->db->where('user_id', $userid);
        $this->db->update('lex_users', $data);
    }
    
    function update_info($userid, $data){
        $this->db->where('pi_user_id', $userid);
        $this->db->update('lex_personal_info', $data);
    }
    
}


