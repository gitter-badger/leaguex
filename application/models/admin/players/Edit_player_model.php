<?php

class Edit_player_model extends CI_Model{
    
    function playerid($data){
        $this->db->select('*');
        $this->db->from('lex_players');       
        $this->db->where('id', $data);
        $this->db->join('lex_teams', 'team_id = player_team_id', 'left');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function teamid(){  
        $this->db->select('team_id, team_name');
        $this->db->from('lex_teams');        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    function positionid(){ 
        $this->db->distinct();
        $this->db->select('player_position');
        $this->db->from('lex_players'); 
        $this->db->order_by('player_position', 'asc');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }  
    
    function update_player($id,$data){
        $this->db->trans_start();      
        $this->db->where('id', $id);
        $this->db->update('lex_players', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }     
}  
