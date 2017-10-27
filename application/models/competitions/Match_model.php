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
    function getcomments($matchid){
        $this->db->select('comment_id, comment_match_id, comment_user_id, time, comment_content, user_name, user_id, user_avatar, comment_image_id');
        $this->db->from('lex_comments'); 
        $this->db->join('lex_users', 'user_id = comment_user_id');
        $this->db->join('lex_comments_images', 'match_comment_id = comment_id', 'left');
        $this->db->where('comment_match_id', $matchid);
        $this->db->order_by('comment_id','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
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
}
