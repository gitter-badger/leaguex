<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Edit_league extends CI_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model');
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/competitions/edit_league_model');         
    }
    
    public function leagueid(){   
        if((!$this->session->userdata('username')) OR ($this->session->userdata('permissions') != 1)){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $data['option']= options();
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID); 
        $data['title'] = $this->lang->line('admin_title_editleague');
        $id = $this->uri->segment(5);
        $data['league'] = $this->edit_league_model->leagueid($id);
        $data['getmatchplayed'] = $this->edit_league_model->matchplayed($id); 
        $data['getmatchnotplayed'] = $this->edit_league_model->matchnotplayed($id); 
        echo add_css(array('plugins/bootstrap-editable/bootstrap-editable.css','plugins/formvalidation/formValidation.min.css','plugins/datatables-bootstrap/dataTables.bootstrap.min.css','plugins/datatables-responsive/responsive.bootstrap.min.css','plugins/datatables-tabletools/dataTables.tableTools.min.css'));
        echo addfooter_js(array('plugins/bootbox/bootbox.js','plugins/bootstrap-editable/bootstrap-editable.min.js','plugins/datatables/jquery.dataTables.min.js','plugins/datatables-bootstrap/dataTables.bootstrap.min.js','plugins/datatables-responsive/dataTables.responsive.min.js','js/sections/admin/dataTables.js','js/sections/admin/formValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/competitions/edit_league_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');
    }
      
    public function showfixture(){
        $id = $this->input->post('id');   
        $this->datatables->select('a.match_id, a.match_status, a.match_team1_id, a.match_team2_id, b1.team_id, b2.team_id, b1.team_name as team1, b2.team_name as team2, b1.team_logo as logo1, b2.team_logo as logo2, a.match_score1, a.match_score2, c.matchday_name, d.competition_name, d.competition_logo')
        ->from('lex_competitions as d')
        ->join('lex_matchday as c', 'd.competition_id = c.matchday_competition_id')
        ->join('lex_matches as a', 'a.match_matchday_id = c.matchday_id')
        ->join('lex_teams as b1', 'a.match_team1_id = b1.team_id')
        ->join('lex_teams as b2', 'a.match_team2_id = b2.team_id')
        ->where('d.competition_id', $id) 
        ->add_column('score', '<a href="javascript:editMatch($3)"><strong>$1 - $2</strong></a>','match_score1, match_score2, match_id');
         echo $this->datatables->generate();
    }
    
    public function select_match(){              
        $matchid = $this->input->post('matchid');  
        $data_match = $this->edit_league_model->select_match($matchid);
        foreach ($data_match as $match){
            $dataMatch = array(
                'matchdayid' => $match->matchday_id,
                'matchid' => $match->match_id,
                'competitionid' => $match->competition_id,
                'team1' => $match->team1,
                'team2' => $match->team2,
                'logo1' => $match->logo1,
                'logo2' => $match->logo2,
                'team1id' => $match->match_team1_id,
                'team2id' => $match->match_team2_id,
                'score1' => $match->match_score1 == null ? '0' : $match->match_score1,
                'score2' => $match->match_score2 == null ? '0' : $match->match_score2,
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'datamatch' => $dataMatch
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function select_scorers(){              
        $matchid = $this->input->post('match_id');
        $data_scorers = $this->edit_league_model->select_scorers($matchid);
        $sc = array();
        foreach($data_scorers as $scorers){
            $dataScorers = array(
                'playerid' => $scorers->playerid,
                'teamid' => $scorers->teamid,
                'playerid' => $scorers->playerid,
                'playername' => $scorers->playername,
                'timescore' => $scorers->timescore,
                'owngoal' => $scorers->owngoal== 0 ? $this->lang->line('addresult_option_goal') : $this->lang->line('addresult_option_own_goal'),
                'owngoalid' => $scorers->owngoal
            );
            array_push($sc, $dataScorers);
        }
        $response = array(
            'success' => true,
            'errors'  => '',                
            'datascorers' => $sc,
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function select_events(){              
        $matchid = $this->input->post('match_id');
        $data_events = $this->edit_league_model->select_events($matchid);
        $sr = array();
        foreach($data_events as $events){
            $dataEvents = array(
                'playerid' => $events->playerid,
                'teamid' => $events->teamid,
                'playerid' => $events->playerid,
                'playername' => $events->playername,
                'timevent' => $events->timevent,
                'eventid' => $events->event_type_id,
                'eventdesc' => $events->eventdesc
            );
            array_push($sr, $dataEvents);
        }
        $response = array(
            'success' => true,
            'errors'  => '',                
            'dataevents' => $sr,
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function loadplayers(){
        $modmatchid = $this->input->post('match_id');
        $show_players = $this->edit_league_model->optionplayers($modmatchid);
        $playersList = array();
        foreach($show_players as $show_player){
            $row['teamname'] = $show_player->team_name; 
            $playersList[$row['teamname']][]= $show_player;
        }
        $response = array(
            'success' => true,
            'errors'  => '',                
            'playerslist' => $playersList                
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function loadevents(){
        $show_events = $this->edit_league_model->optionevents(); 
        $eventsList = array();
        foreach($show_events as $show_event){
            $row = array();
            $row['eventid'] = $show_event['event_id'];
            $row['eventdesc'] = $show_event['event_desc'];
            $eventsList[] = $row; 
        }
        $response = array(
                'success' => true,
                'errors'  => '',                
                'eventslist' => $eventsList                
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }
    
    public function updateResult(){
        $matchid = $this->input->post('matchid');
        $ematchid = $this->input->post('vmatchid');
        $competitionid = $this->input->post('competitionid');
        $matchdayid = $this->input->post('matchdayid');
        $playerid = $this->input->post('playername');
        $evplayerid = $this->input->post('eventplayername');
        $teamid = $this->input->post('teamidval');
        $evteamid = $this->input->post('evteamidval');
        $score1 = $this->input->post('home-score');
        $score2 = $this->input->post('away-score');
        $playergoalcount = $this->input->post('goalscore'); 
        $playergoaltime = $this->input->post('time'); 
        $evtime = $this->input->post('timevent'); 
        $evtype = $this->input->post('eventype');
        $owngoal = $this->input->post('owngoal');
        if($playerid[0]){
        foreach($playerid as $i=>$val){
            $data[] = array(           
                'scorer_player_id' => $playerid[$i],          
                'scorer_match_id' => $ematchid,
                'scorer_count' => $playergoalcount[$i],
                'scorer_time' => $playergoaltime[$i],
                'scorer_team_id' => $teamid[$i],   
                'scorer_owngoal' => $owngoal[$i],
                'scorer_competition_id' => $competitionid,
                'scorer_matchday_id' => $matchdayid
            );
        }
        }else{$data='';}
        if($evplayerid[0]){    
        foreach($evplayerid as $i=>$val){
            $data2[] = array(
                'event_type_id' => $evtype[$i],
                'event_player_id' => $evplayerid[$i],
                'event_match_id' => $ematchid,
                'event_time' => $evtime[$i],
                'event_team_id' => $evteamid[$i], 
                'event_competition_id' => $competitionid,
                'event_matchday_id' => $matchdayid
            );
        }
        }else{$data2='';}
        
        $this->edit_league_model->updatescore($matchid, $score1, $score2, $data, $data2, $playerid, $evplayerid);
        
        
        
    }       
        
    public function upload_handler(){
        if (!empty($_FILES['userfile']['name'])) { 
        $this->db->select('logo_size_maxwidth, logo_size_maxheight, logo_size_minwidth, logo_size_minheight');
        $query = $this->db->get('lex_settings');
        foreach ($query->result() as $row){
            $maxWidth = $row->logo_size_maxwidth;
            $maxHeight = $row->logo_size_maxheight;
            $minWidth = $row->logo_size_minwidth;
            $minHeight = $row->logo_size_minheight;
        }        
        $json = array();           
        list($width, $height) = getimagesize($_FILES['userfile']['tmp_name']);           
        $max_width = $maxWidth;  
        $max_height = $maxHeight;
        $min_width = $minWidth;
        $min_height = $minHeight;
        $dimension_error='';     
        if($width > $max_width ){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_width'),$max_width);  
          }  
          if($height > $max_height ){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_height'),$max_height);  
          }  
          if($width > $max_width && $height > $max_height){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_width_height'),$max_width,$max_height);  
          }
          if($width < $min_width ){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_width'),$min_width);  
          }  
          if($height < $min_height ){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_height'),$min_height);  
          }  
          if($width < $min_width && $height < $min_height){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_width_height'),$min_width,$min_height);  
          }              
          if($dimension_error != ''){  
              $json['error'] = $dimension_error;  
          }  
      } else {  
        $json['error'] = 'Upload Failed';  
    }  

        if (!$json) {
            $idleague = $this->input->post('key');
            $filename = ($_FILES['userfile']['name']);            
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $imgname = sha1($filename).'.'.$extension;
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], './assets/img/competitions_logo/'.$imgname)){
                $this->edit_league_model->update_logo($idleague,$imgname);  
                $json['photo_file'] = $imgname;               
            } 
            $json['success'] = 'Successfuly uploaded';  
        }
            header('Content-Type: application/json');
            echo json_encode($json);
   }
    
    public function update_league(){              
        $id = $this->input->post('pk');  
        $leaguename = $this->input->post('value');
        if($this->edit_league_model->update_league($id, $leaguename)){        
            } else {
            echo 'failed';
            }
        }
        
    public function update_status(){              
        $id = $this->input->post('id');  
        $activeleague = $this->input->post('activeleague');
        if($this->edit_league_model->update_status($id, $activeleague)){        
            } else {
            echo 'failed';
            }
        }   
}
