<?php

class Edit_manager_model extends CI_Model{
    
    function managerid($data){
        $this->db->select('*');
        $this->db->from('lex_managers');        
        $this->db->where('manager_id', $data);
        $this->db->join('lex_teams', 'team_id = manager_team_id', 'left');
        $this->db->join('lex_users', 'user_id = manager_user_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function teamid($showteams){  
        $this->db->select('team_id, team_name');
        $this->db->from('lex_teams');
        $this->db->where('team_id NOT IN (SELECT manager_team_id FROM lex_managers where manager_team_id NOT IN ('.$showteams.'))');
        $query2 = $this->db->get();
        $result2 = $query2->result();        
        return $result2;
    }
    
    function update_manager($id,$data,$data2){        
        $this->db->trans_start();
        $this->db->select('manager_team_id');
        $this->db->from('lex_managers');
        $this->db->where('manager_id', $id);       
        $res = $this->db->get()->row()->manager_team_id;
        $this->db->where('manager_id', $id);
        $this->db->update('lex_managers', $data); 
        $this->db->select('manager_team_id');
        $this->db->from('lex_managers');
        $this->db->where('manager_id', $id);       
        $res2 = $this->db->get()->row()->manager_team_id;
        $this->db->trans_complete();
        if($res !== $res2){
            $this->db->insert('lex_notification',$data2);
        }
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }     
}  
