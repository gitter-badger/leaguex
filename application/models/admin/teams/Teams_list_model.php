<?php

class Teams_list_model extends CI_Model{
        
    function add_team(){          
        $data = array(           
            'team_name' => $this->input->post('teamname'),
            'team_level' => $this->input->post('teamlevel')
            );
        $this->db->set('team_registration_date', 'NOW()', FALSE);
        $this->db->insert('lex_teams',$data);
        $id_team = $this->db->insert_id();  
        $this->db->select('*');
        $this->db->from('lex_teams');        
        $this->db->where('team_id', $id_team);
        $query = $this->db->get();
        return $query->result();
    }
    function edit_team($teamid, $data){
        $this->db->where('team_id', $teamid);
        $this->db->update('lex_teams', $data);
    }
    
    function select_team($teamid){
        $this->db->select('team_id,team_logo,team_name,team_level,manager_wallet,team_registration_date, user_name');
        $this->db->from('lex_teams'); 
        $this->db->join('lex_managers', 'manager_team_id = team_id', 'left');
        $this->db->join('lex_users', 'user_id = manager_user_id', 'left');
        $this->db->where('team_id', $teamid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function delete_team($delete_id){
        $this->db->trans_start();
        $this->db->where('team_id', $delete_id);
        $this->db->delete('lex_teams');
        $this->db->set('manager_team_id', '0');
        $this->db->where('manager_team_id', $delete_id);
        $this->db->update('lex_managers');
        $this->db->where('object_id', $delete_id)->where('type', '1');               
        $this->db->delete('lex_notification');   
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
}