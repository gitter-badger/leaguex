<?php

class User_team_model extends CI_Model{
    function showuserteam($userID){
        $this->db->select('team_logo, team_name, team_level, team_registration_date, user_name, manager_wallet');
        $this->db->from('lex_teams');
        $this->db->join('lex_managers', 'manager_team_id = team_id');       
        $this->db->join('lex_users', 'user_id = manager_user_id');
        $this->db->where('user_id', $userID);
        $query = $this->db->get();        
        return $query->result();
    }
    
    function showuserplayer($userID){
        $this->db->select('url_image, url_stats, players_levels, level_min, level_max, level_max_players, player_link_tm, player_id, player_name, player_overall, player_age, player_position');
        $this->db->from('lex_teams, lex_settings');
        $this->db->join('lex_managers', 'manager_team_id = team_id');
        $this->db->join('lex_players', 'player_team_id = team_id', 'left');
        $this->db->join('lex_users', 'user_id = manager_user_id');
        $this->db->where('user_id', $userID);
        $query = $this->db->get();        
        return $query->result();
    }    
}

