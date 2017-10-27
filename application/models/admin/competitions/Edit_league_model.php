<?php

class Edit_league_model extends CI_Model{
    function leagueid($id){
        $this->db->select('competition_id, competition_name, competition_logo, competition_registration_date, COUNT(DISTINCT matchday_id)as countmatchday, COUNT(DISTINCT match_id)as countmatches, competition_status');
        $this->db->from('lex_competitions'); 
        $this->db->join('lex_matchday', 'matchday_competition_id = competition_id');
        $this->db->join('lex_matches', 'match_competition_id = competition_id');
        $this->db->where('competition_id', $id);
        $this->db->where('match_team1_id !=', 0);
        $this->db->where('match_team2_id !=', 0);
        $this->db->group_by('competition_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function matchplayed($id){
        $this->db->select('COUNT(match_id)as matchplayed');
        $this->db->from('lex_matches');
        $this->db->where('match_competition_id', $id);
        $this->db->where('match_status', '1');
        $this->db->where('match_team1_id !=', 0);
        $this->db->where('match_team2_id !=', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function matchnotplayed($id){
        $this->db->select('COUNT(match_id)as matchnotplayed');
        $this->db->from('lex_matches');
        $this->db->where('match_competition_id', $id);
        $this->db->where('match_status', '0');
        $this->db->where('match_team1_id !=', 0);
        $this->db->where('match_team2_id !=', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function select_match($matchid){
        $this->db->select('a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1, a.match_score2, c.matchday_id, c.matchday_name, d.competition_id, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d'); 
        $this->db->join('lex_matchday as c', 'd.competition_id = c.matchday_competition_id');
        $this->db->join('lex_matches as a', 'a.match_matchday_id = c.matchday_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('match_id', $matchid);
        $this->db->group_by('match_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function select_scorers($matchid){
        $this->db->select('player_name as playername, id as playerid, player_team_id as teamid, scorer_time as timescore, scorer_owngoal as owngoal');
        $this->db->from('lex_matchscorer');
        $this->db->join('lex_players', 'id = scorer_player_id');
        $this->db->where('scorer_match_id', $matchid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function select_events($matchid){
        $this->db->select('player_name as playername, id as playerid, player_team_id as teamid, event_time as timevent, event_type_id, event_desc as eventdesc');
        $this->db->from('lex_matchevents');
        $this->db->join('lex_players', 'id = event_player_id');
        $this->db->join('lex_events_type as t', 't.event_id = event_type_id');
        $this->db->where('event_match_id', $matchid);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function optionplayers($modmatchid){
        $sql='SELECT player_name, id, player_team_id, team_name FROM lex_players, lex_teams, lex_matches
              WHERE player_team_id = team_id AND match_team1_id = team_id AND match_id = '.$modmatchid.'
              UNION
              SELECT player_name, id, player_team_id as pteam, team_name FROM lex_players, lex_teams, lex_matches
              WHERE player_team_id = team_id AND match_team2_id = team_id AND match_id = '.$modmatchid.'
              ORDER BY player_team_id ASC';
        $query = $this->db->query($sql);        
        return $query->result();
    }
    
    function optionevents(){
        $this->db->select('event_id, event_desc');
        $this->db->from('lex_events_type');
        $show_events = $this->db->get();  
        return $show_events->result_array();
    }
    
    function updatescore($matchid, $score1, $score2, $data, $data2, $playerid, $evplayerid){
        $this->db->set('match_score1', $score1);
        $this->db->set('match_score2', $score2);
        $this->db->set('match_status', '1');
        $this->db->where('match_id', $matchid);       
        $this->db->update('lex_matches');
        if($playerid[0]){
            $this ->db-> where('scorer_match_id', $matchid);        
            $this->db->delete('lex_matchscorer');    
            $this->db->insert_batch('lex_matchscorer', $data);
        }else{
            $this ->db-> where('scorer_match_id', $matchid);        
            $this->db->delete('lex_matchscorer');        
        }        
        if($evplayerid[0]){
            $this ->db-> where('event_match_id', $matchid);    
            $this->db->delete('lex_matchevents');        
            $this->db->insert_batch('lex_matchevents', $data2);
        }else{
            $this ->db-> where('event_match_id', $matchid);    
            $this->db->delete('lex_matchevents');            
        }      
        $this->db->select('match_score1, match_score2');
        $this->db->from('lex_matches'); 
        $this->db->where('match_id', $matchid);
        $query = $this->db->get();
        return $query->result();
    }
        
    function update_logo($idleague,$imgname){
        $this->db->trans_start();
        $this->db->where('competition_id', $idleague);
        $this->db->set('competition_logo',$imgname);
        $this->db->update('lex_competitions');                 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function update_league($id, $leaguename){
        $this->db->trans_start();      
        $this->db->set('competition_name', $leaguename);
        $this->db->where('competition_id', $id);
        $this->db->update('lex_competitions');          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function update_status($id, $activeleague){
        $this->db->trans_start();      
        $this->db->set('competition_status', $activeleague);
        $this->db->where('competition_id', $id);
        $this->db->update('lex_competitions');          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }   
}
