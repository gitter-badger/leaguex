<?php

class Leagues_model extends CI_Model{
    function getmanager($userID){
        $this->db->select('manager_team_id');
        $this->db->from('lex_managers');
        $this->db->where('manager_user_id', $userID);
        $query = $this->db->get();        
        return $query->result();    
    } 
            
    function getlastleague(){
        $this->db->select('competition_id, competition_name');
        $this->db->from('lex_competitions');
        $this->db->order_by('competition_id','DESC');
        $this->db->where('competition_status', '1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $competition_id = $query->row("competition_id");
           
        } else {
            return FALSE;
        }
        
        $this->db->select('a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, c.matchday_name, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d');
        $this->db->join('lex_matchday as c', 'd.competition_id = c.matchday_competition_id');
        $this->db->join('lex_matches as a', 'a.match_matchday_id = c.matchday_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('d.competition_id', $competition_id);
        $query2 = $this->db->get();        
        return $query2->result();
    }
    
    function getlastteams(){
        $this->db->select('competition_id, competition_name');
        $this->db->from('lex_competitions');
        $this->db->where('competition_status', '1');
        $this->db->limit(1);
        $this->db->order_by('competition_id','DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $competition_id = $query->row("competition_id");
        } else {
            return FALSE;
        }
        
        $this->db->select('team_name, team_id, competition_id');
        $this->db->from('lex_competitions');
        $this->db->join('lex_competitions_teams', 'competition_id = ct_competition_id');
        $this->db->join('lex_teams', 'ct_competition_team_id = team_id');
        $this->db->where('competition_id', $competition_id);
        $this->db->group_by('team_id');
        $query2 = $this->db->get();        
        return $query2->result();
    }
    
    function getleague($id, $userid){
        $this->db->select('(SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, c.matchday_name, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d');
        $this->db->join('lex_matchday as c', 'd.competition_id = c.matchday_competition_id');
        $this->db->join('lex_matches as a', 'a.match_matchday_id = c.matchday_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('d.competition_id', $id);
        $query = $this->db->get();        
        return $query->result();
    }
    
    function getteams($id, $teamid, $userid){
        $sql = 'SELECT * FROM (SELECT (SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, d.competition_id as cid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, c.matchday_name as matchdayname, d.competition_name, d.competition_logo
                from lex_competitions as d
                INNER JOIN lex_matchday as c ON d.competition_id = c.matchday_competition_id
                INNER JOIN lex_matches as a ON a.match_matchday_id = c.matchday_id
                INNER JOIN lex_teams as b1 ON a.match_team1_id = b1.team_id
                INNER JOIN lex_teams as b2 ON a.match_team2_id = b2.team_id
                where b1.team_id = ('.$teamid.')
                UNION ALL
                SELECT (SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, d.competition_id as cid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1, a.match_score2, c.matchday_name as matchdayname, d.competition_name, d.competition_logo
                from lex_competitions as d
                INNER JOIN lex_matchday as c ON d.competition_id = c.matchday_competition_id
                INNER JOIN lex_matches as a ON a.match_matchday_id = c.matchday_id
                INNER JOIN lex_teams as b1 ON a.match_team1_id = b1.team_id
                INNER JOIN lex_teams as b2 ON a.match_team2_id = b2.team_id
                where b2.team_id = ('.$teamid.')) as A
                where cid = ('.$id.')
                order by matchdayname ASC'; 
                  
                $query = $this->db->query($sql);        
                return $query->result();
    }
    
    function getallteams($id, $userid){
        $this->db->select('(SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, c.matchday_name as matchdayname, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d');
        $this->db->join('lex_matchday as c', 'd.competition_id = c.matchday_competition_id');
        $this->db->join('lex_matches as a', 'a.match_matchday_id = c.matchday_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('d.competition_id', $id);         
        $query = $this->db->get();        
        return $query->result();
    }
            
    function optionleagues(){
        $this->db->select('competition_name, competition_id');
        $this->db->from('lex_competitions');
        $this->db->where('competition_status', '1');
        $this->db->order_by('competition_id', 'DESC');
        $show_leagues = $this->db->get();        
        return $show_leagues->result_array();
    }
    
    function optionteams($id){
        $this->db->select('team_name, team_id, competition_id');
        $this->db->from('lex_competitions');
        $this->db->join('lex_competitions_teams', 'competition_id = ct_competition_id');
        $this->db->join('lex_teams', 'ct_competition_team_id = team_id');
        $this->db->where('competition_id', $id);
        $this->db->where('competition_status', '1');
        $this->db->group_by('team_id');
        $show_teams = $this->db->get();        
        return $show_teams->result_array();
    }     
}
