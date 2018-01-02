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
        }else{
            return FALSE;
        }
        $this->db->select('a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, a.match_matchday, c.competition_name, c.competition_logo');
        $this->db->from('lex_matches as a');
        $this->db->join('lex_competitions as c', 'c.competition_id = a.match_competition_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('c.competition_id', $competition_id);
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
        $this->db->select('(SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, a.match_matchday, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d');
        $this->db->join('lex_matches as a', 'a.match_competition_id = d.competition_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id');
        $this->db->where('d.competition_id', $id);
        $query = $this->db->get();        
        return $query->result();
    }
    
    function getteams($id, $teamid, $userid){
        $sql = 'SELECT * FROM (SELECT (SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, d.competition_id as cid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, a.match_matchday as matchdayname, d.competition_name, d.competition_logo
                FROM lex_competitions as d
                INNER JOIN lex_matches as a ON a.match_competition_id = d.competition_id
                INNER JOIN lex_teams as b1 ON a.match_team1_id = b1.team_id
                INNER JOIN lex_teams as b2 ON a.match_team2_id = b2.team_id
                WHERE b1.team_id = ('.$teamid.')
                UNION ALL
                SELECT (SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, d.competition_id as cid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1, a.match_score2, a.match_matchday as matchdayname, d.competition_name, d.competition_logo
                FROM lex_competitions as d
                INNER JOIN lex_matches as a ON a.match_competition_id = d.competition_id
                INNER JOIN lex_teams as b1 ON a.match_team1_id = b1.team_id
                INNER JOIN lex_teams as b2 ON a.match_team2_id = b2.team_id
                WHERE b2.team_id = ('.$teamid.')) as A
                WHERE cid = ('.$id.')
                ORDER BY matchdayname ASC'; 
                $query = $this->db->query($sql);        
                return $query->result();
    }
    
    function getallteams($id, $userid){
        $this->db->select('(SELECT manager_team_id FROM lex_managers WHERE manager_user_id = ('.$userid.')) as managerid, a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id as teamid1, b2.team_id as teamid2, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1 as score1, a.match_score2 as score2, a.match_matchday as matchdayname, d.competition_name, d.competition_logo');
        $this->db->from('lex_competitions as d');
        $this->db->join('lex_matches as a', 'a.match_competition_id = d.competition_id');
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
    
    function getlastable(){
        $this->db->select('competition_id, competition_name');
        $this->db->from('lex_competitions');
        $this->db->order_by('competition_id','DESC');
        $this->db->where('competition_status', '1');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $competition_id = $query->row("competition_id");
        }else{
            return FALSE;
        }
                        
        $sql = 'SELECT @rowno:= @rowno+1 as position, total.*
                from (SELECT 
                (SELECT competition_name FROM lex_competitions WHERE competition_id = ('.$competition_id.'))as competitioname, (SELECT competition_logo FROM lex_competitions WHERE competition_id = ('.$competition_id.'))as competitionlogo, match_matchday, team_logo as logo, team_name AS team, IFNULL(Sum(P),0) AS P,IFNULL(Sum(W),0) AS W,IFNULL(Sum(D),0) AS D,IFNULL(Sum(L),0) AS L, 
                IFNULL(SUM(F),0) as F,IFNULL(SUM(A),0) AS A,IFNULL(SUM(GD),0) AS GD,IFNULL(SUM(Pts),0) AS Pts
                FROM ( 
                SELECT  
                  match_team1_id team, match_matchday, 
                  IF(match_status = 1,0,1) P,  
                  IF(match_score1 > match_score2,1,0) W, 
                  IF(match_score1 = match_score2,1,0) D, 
                  IF(match_score1 < match_score2,1,0) L, 
                  match_score1 F, 
                  match_score2 A, 
                  match_score1-match_score2 GD, 
                  CASE WHEN match_score1 > match_score2 THEN 3 WHEN match_score1 = match_score2 THEN 1 ELSE 0 END PTS 
                FROM lex_matches 
                WHERE match_competition_id = ('.$competition_id.')
                UNION ALL 
                SELECT  
                  match_team2_id, match_matchday,
                  IF(match_status = 1,0,1), 
                  IF(match_score1 < match_score2,1,0), 
                  IF(match_score1 = match_score2,1,0), 
                  IF(match_score1 > match_score2,1,0), 
                  match_score2, 
                  match_score1, 
                  match_score2-match_score1 GD, 
                  CASE WHEN match_score1 < match_score2 THEN 3 WHEN match_score1 = match_score2 THEN 1 ELSE 0 END 
                FROM lex_matches
                WHERE match_competition_id = ('.$competition_id.')
                )as tot
                JOIN lex_teams c ON tot.team=c.team_id  
                CROSS JOIN (SELECT @rowno := 0) r
                GROUP BY team
                ORDER BY  SUM(Pts) DESC,SUM(GD) DESC, SUM(F) DESC)total
                ORDER BY Pts DESC,GD DESC, F DESC';
                $query2 = $this->db->query($sql);        
                return $query2->result();
    }
    
    function gettable($competitionid){
         $sql = 'SELECT @rowno:= @rowno+1 as position, total.*
                from (SELECT   
                (SELECT competition_name FROM lex_competitions WHERE competition_id = ('.$competitionid.'))as competitioname, (SELECT competition_logo FROM lex_competitions WHERE competition_id = ('.$competitionid.'))as competitionlogo, match_matchday, team_logo as logo, team_name AS team, IFNULL(Sum(P),0) AS P,IFNULL(Sum(W),0) AS W,IFNULL(Sum(D),0) AS D,IFNULL(Sum(L),0) AS L, 
                IFNULL(SUM(F),0) as F,IFNULL(SUM(A),0) AS A,IFNULL(SUM(GD),0) AS GD,IFNULL(SUM(Pts),0) AS Pts
                FROM ( 
                SELECT  
                  match_team1_id team, match_matchday,  
                  IF(match_status = 1,0,1) P,  
                  IF(match_score1 > match_score2,1,0) W, 
                  IF(match_score1 = match_score2,1,0) D, 
                  IF(match_score1 < match_score2,1,0) L,
                  match_score1 F, 
                  match_score2 A, 
                  match_score1-match_score2 GD, 
                  CASE WHEN match_score1 > match_score2 THEN 3 WHEN match_score1 = match_score2 THEN 1 ELSE 0 END PTS 
                FROM lex_matches 
                WHERE match_competition_id = ('.$competitionid.') 
                UNION ALL 
                SELECT  
                  match_team2_id, match_matchday,
                  IF(match_status = 1,0,1),    
                  IF(match_score1 < match_score2,1,0), 
                  IF(match_score1 = match_score2,1,0), 
                  IF(match_score1 > match_score2,1,0),
                  match_score2, 
                  match_score1, 
                  match_score2-match_score1 GD, 
                  CASE WHEN match_score1 < match_score2 THEN 3 WHEN match_score1 = match_score2 THEN 1 ELSE 0 END
                FROM lex_matches
                WHERE match_competition_id = ('.$competitionid.') 
                )as tot
                JOIN lex_teams c ON tot.team=c.team_id  
                CROSS JOIN (SELECT @rowno := 0) r
                GROUP BY team
                ORDER BY SUM(Pts) DESC,SUM(GD) DESC, SUM(F) DESC)total
                ORDER BY Pts DESC,GD DESC, F DESC';
                $query = $this->db->query($sql);        
                return $query->result();
    }
}