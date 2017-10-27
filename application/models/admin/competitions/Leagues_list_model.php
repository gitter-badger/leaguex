<?php

class Leagues_list_model extends CI_Model{
       
    public function add_league(){ 
        $data = array(           
            'competition_name' => $this->input->post('leaguename'),
            'competition_type' => '0',
            );
        $this->db->set('competition_registration_date', 'NOW()', FALSE);
        $this->db->insert('lex_competitions',$data); 
        $id_competition = $this->db->insert_id();
        $teams = $this->input->post('leagueteams');
        foreach($teams as $team){
        $data2 = array(           
            'ct_competition_id' => $id_competition,
            'ct_competition_team_id' => $team, 
        );
        $this->db->insert('lex_competitions_teams',$data2);                       
        }
        $this->db->select('competition_id, competition_logo, competition_name, count(ct_competition_id)as counteams, competition_registration_date');
        $this->db->from('lex_competitions');
        $this->db->join('lex_competitions_teams', 'competition_id = ct_competition_id');
        $this->db->group_by('competition_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    function makefixture($fixture_id){
        
        //Make a fixtures (fmxls mod script) - start        
        $this->db->select('ct_competition_team_id');
        $this->db->from('lex_competitions_teams');
        $this->db->join('lex_competitions', 'competition_id = ct_competition_id');
        $this->db->where('competition_id', $fixture_id);
        $query = $this->db->get();
        
        $teams = array();
        foreach($query->result() as $row){
            $teams[] = $row->ct_competition_team_id;
        }
        $totalteams = count($teams);
        
        $this->db->set('competition_fixture', '1');
        $this->db->where('competition_id', $fixture_id);
        $this->db->update('lex_competitions');
        
        if($totalteams % 2 == 1){
            $teams[] = 0;
            $totalteams++;
        }        
        $totalmatchday = $totalteams - 1;
        for($i = 0; $i < $totalteams / 2; $i++){
            $home[$i] = $teams[$i];
            $away[$i] = $teams[$totalteams - 1 - $i];
        }
        for($i = 0; $i < $totalmatchday * 2; $i++){
            $data = array(
                'matchday_name' => $i + 1,
                'matchday_competition_id' => $fixture_id,
            );
            $this->db->insert('lex_matchday', $data);
            $matchday_id = $this->db->insert_id();
            
                if(($i % 2) == 0){
                    for($j = 0; $j < $totalteams /2; $j++){
                        $data2 = array(
                            'match_matchday_id' => $matchday_id,
                            'match_team1_id' => $away[$j],
                            'match_team2_id' => $home[$j],
                            'match_competition_id' => $fixture_id
                        );
                        $this->db->insert('lex_matches', $data2); 
                    }
                } else {
                    for($j = 0; $j < $totalteams /2; $j++){
                    $data3 = array(
                        'match_matchday_id' => $matchday_id,
                        'match_team1_id' => $home[$j],
                        'match_team2_id' => $away[$j],
                        'match_competition_id' => $fixture_id
                    );    
                    $this->db->insert('lex_matches', $data3);        
                    }
                }
            $tmp = $home[0];
            array_unshift($away, $home[1]);
            $rpt = array_pop($away);
            array_shift($home);
            array_push($home, $rpt);
            $home[0] = $tmp ;
        }
        $insert = $this->db->affected_rows() > 0;
        if($insert){
            return true;
        } else {
            return false;
        }
        // End
    }
    
    function deleteleague($delete_id){
        $this->db->trans_start();
        $this->db->where('competition_id', $delete_id);
        $this->db->delete('lex_competitions');
        $this->db->where('ct_competition_id', $delete_id);
        $this->db->delete('lex_competitions_teams');
        $this->db->where('matchday_competition_id', $delete_id);
        $this->db->delete('lex_matchday');
        $this->db->where('match_competition_id', $delete_id);
        $this->db->delete('lex_matches');
        $this->db->where('scorer_competition_id', $delete_id);
        $this->db->delete('lex_matchscorer');
        $this->db->where('event_competition_id', $delete_id);
        $this->db->delete('lex_matchevents');
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function optionteams(){
        
        $this->db->select('team_name, team_id');
        $this->db->from('lex_teams'); 
        $this->db->order_by("team_name", "asc");
        $show_teams = $this->db->get();        
        return $show_teams->result_array();
    }    
}

