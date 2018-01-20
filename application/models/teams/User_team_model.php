<?php

class User_team_model extends CI_Model{
    function showuserteam($userID){
        $this->db->select('team_logo, team_name, team_level, team_registration_date, user_name, manager_wallet, team_id');
        $this->db->from('lex_teams');
        $this->db->join('lex_managers', 'manager_team_id = team_id');       
        $this->db->join('lex_users', 'user_id = manager_user_id');
        $this->db->where('user_id', $userID);
        $query = $this->db->get();        
        return $query->result();
    }
    
    function showstatsteam($teamid){
        $sql='SELECT SUM(P) as played, SUM(W) as win, SUM(L) as loss 
              FROM 
              (SELECT IF(match_status = 1,0,1) P, IF(match_score1 > match_score2,1,0) W, IF(match_score1 < match_score2,1,0) L  
                FROM lex_matches
                WHERE match_team1_id = '.$teamid.'
              UNION ALL
              SELECT IF(match_status = 1,0,1) P, IF(match_score2 > match_score1,1,0) W, IF(match_score2 < match_score1,1,0) L  
                FROM lex_matches
               WHERE match_team2_id = '.$teamid.') as t';
              
        $query = $this->db->query($sql);        
        return $query->row();
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

