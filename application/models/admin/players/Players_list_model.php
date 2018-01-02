<?php

class Players_list_model extends CI_Model{
    
    function getplayers(){
        $this->db->select('id, player_name, player_age, player_position, player_overall, id, player_id, team_name, url_stats, url_image');
        $this->db->from('lex_players, lex_settings');        
        $this->db->join('lex_teams', 'team_id = player_team_id', 'left');
        $query = $this->db->get();        
        return $query->result_array();
    }    
    
}

