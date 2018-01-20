<?php

class Match_model extends CI_Model{
    
    function getmanager($userID){
        $this->db->select('manager_team_id');
        $this->db->from('lex_managers');
        $this->db->where('manager_user_id', $userID);
        $query = $this->db->get();        
        return $query->result();    
    } 
    
    function getmatch($matchid){
        $this->db->select('a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1, a.match_score2, a.match_matchday, c.competition_id, c.competition_name, c.competition_logo, e1.user_name as user1, e2.user_name as user2, e1.user_id as userid1, e2.user_id as userid2');
        $this->db->from('lex_matches as a');
        $this->db->join('lex_competitions as c', 'c.competition_id = a.match_competition_id');
        $this->db->join('lex_teams as b1', 'a.match_team1_id = b1.team_id', 'left');
        $this->db->join('lex_teams as b2', 'a.match_team2_id = b2.team_id', 'left');
        $this->db->join('lex_managers as d1', 'b1.team_id = d1.manager_team_id', 'left');
        $this->db->join('lex_managers as d2', 'b2.team_id = d2.manager_team_id', 'left');
        $this->db->join('lex_users as e1', 'd1.manager_user_id = e1.user_id', 'left');
        $this->db->join('lex_users as e2', 'd2.manager_user_id = e2.user_id', 'left');
        $this->db->where('match_id', $matchid);
        $this->db->group_by('match_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function getscorers($matchid){
        $owngoal = $this->lang->line('match_own_goal');
        $this->db->select("url_image, url_stats, scorer_count, player_team_id as teamid, player_name as playername, id as playerid, player_id as playerimage, GROUP_CONCAT(CONCAT(scorer_time, '''', IF(scorer_owngoal = 1, '', ' $owngoal')) ORDER BY scorer_time ASC SEPARATOR ', ') as timescore");
        $this->db->from('lex_matchscorer, lex_settings'); 
        $this->db->join('lex_players', 'scorer_player_id = id');
        $this->db->where('scorer_match_id', $matchid);
        $this->db->group_by('playerid');
        $this->db->order_by('timescore', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function getevents($matchid){
        $this->db->select("url_image, url_stats, player_team_id as teamid, player_name as playername, id as playerid, player_id as playerimage, event_icon as evicon, CONCAT(event_time, '''') as timevent");
        $this->db->from('lex_matchevents, lex_settings'); 
        $this->db->join('lex_players', 'event_player_id = id');
        $this->db->join('lex_events_type as ev', 'event_type_id = ev.event_id');
        $this->db->where('event_match_id', $matchid);
        $this->db->group_by('playerid');
        $this->db->order_by('timevent', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function getcomments($matchid, $limit){
        $this->db->select('comment_id, comment_match_id, comment_user_id, time, comment_content, user_name, user_id, user_avatar, comment_image_id');
        $this->db->from('lex_comments'); 
        $this->db->join('lex_users', 'user_id = comment_user_id');
        $this->db->join('lex_comments_images', 'match_comment_id = comment_id', 'left');
        $this->db->where('comment_match_id', $matchid);
        $this->db->order_by('comment_id','DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function count_comments($matchid){
        $this->db->where('comment_match_id', $matchid);
        $comments = $this->db->count_all_results('lex_comments');
        return $comments;
    }
    function insert_comments($data, $imageid){ 
        $this->db->trans_start();
        $this->db->insert('lex_comments',$data);
        $comment_id = $this->db->insert_id();
        if($imageid){
        $this->db->set('match_comment_id', $comment_id, FALSE); 
        $this->db->set('comment_image_id', $imageid); 
        $this->db->insert('lex_comments_images');
        }
        $this->db->trans_complete();
        return $comment_id;        
    }
    
    function show_comment($comment_id){
        $this->db->select('comment_id, time, comment_content, user_name, user_avatar, comment_image_id, comment_image_id');
        $this->db->from('lex_comments'); 
        $this->db->join('lex_users', 'user_id = comment_user_id');
        $this->db->join('lex_comments_images', 'match_comment_id = comment_id', 'left');
        $this->db->where('comment_id', $comment_id);
        $query = $this->db->get();
        if($query->num_rows()==1){
            foreach($query->result() as $row){
                $comment = array(
                    'time' => $row->time,
                    'content' => $row->comment_content, 
                    'username' => $row->user_name,
                    'useravatar' => $row->user_avatar,
                    'userimage' => $row->comment_image_id,
                    'commentid' => $row->comment_id,
                );
            }
        }
        return $comment;
    }
        
    function deletecomment($comment_id){
        $this->db->trans_start();
        $this->db->where('comment_id', $comment_id);
        $this->db->delete('lex_comments'); 
        $this->db->where('match_comment_id', $comment_id);
        $this->db->delete('lex_comments_images');    
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
                return FALSE;
            } else {
                return TRUE;
        }
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
        if($playerid[0] != 0){
        $this->db->insert_batch('lex_matchscorer', $data);
        }        
        if($evplayerid[0] != 0){
        $this->db->insert_batch('lex_matchevents', $data2);
        }
        $this->db->select('match_score1, match_score2');
        $this->db->from('lex_matches'); 
        $this->db->where('match_id', $matchid);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getable($competitionid){
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
                ORDER BY  SUM(Pts) DESC,SUM(GD) DESC, SUM(F) DESC)total
                ORDER BY Pts DESC,GD DESC, F DESC';
                $query = $this->db->query($sql);        
                return $query->result();        
    }
}
