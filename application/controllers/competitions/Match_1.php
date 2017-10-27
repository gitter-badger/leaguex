<?php

class Match extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('header_model'); 
        $this->load->model('competitions/match_model'); 
        $this->load->model('users/get_user_data_model');         
    } 
    
    public function matchid(){  
        if(!$this->session->userdata('username')){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID);
        $matchid = $this->uri->segment(4);
        $data['match'] = $this->match_model->getmatch($matchid);
        foreach($data['match'] as $scorer){
            $hometeam = $scorer->match_team1_id; 
            $awayteam = $scorer->match_team2_id; 
            $matchname = $scorer->competition_name; 
        }
        $data['title'] = $matchname;
        $data['page'] = 'matchid';
        $data['backlink'] = 'competitions/leagues';
        $data['getscorer'] = $this->match_model->getscorer($matchid);
        $data['homevent'] = $this->match_model->gethomevent($matchid, $hometeam);
        $data['counthomescorer'] = count($data['getscorer']);
        $data['awayevent'] = $this->match_model->getawayevent($matchid, $awayteam);
        $data['countawayscorer'] = count($data['awayscorer']);
        $data['comments'] = $this->match_model->getcomments($matchid); 
        echo add_css(array('plugins/jquery-asSpinner/asSpinner.min.css','plugins/bootstrap-lightbox/lightbox.min.css','plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('plugins/jquery-asSpinner/jquery-asSpinner.min.js','plugins/bootstrap-select/bootstrap-select.min.js','plugins/bootstrap-lightbox/lightbox.min.js','plugins/textarea-autosize/autosize.min.js','plugins/bootbox/bootbox.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','js/sections/site/matchplay.js'));
        $this->load->view('header_view',$data);
        $this->load->view('sidebar_left_view');
        sidebar_chat();
        $this->load->view('notification_right_view');
        $this->load->view('competitions/match_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertComments(){
        $userid = $this->input->post('user_id');        
        $matchid = $this->input->post('match_id');
        $imageid = $this->input->post('comments_images');
        $content = $this->input->post('comment_content');
        $data = array(           
            'comment_match_id' => $matchid,                       
            'comment_user_id' => $userid,
            'comment_content' => $content
        );
        $comment_id = $this->match_model->insert_comments($data, $imageid);
        $comment = $this->match_model->show_comment($comment_id);
        $contentPost = htmlentities($comment['content']);
        $showcomment = array(
            'useravatar' => $comment['useravatar'],
            'username' => $comment['username'], 
            'content' => auto_link($contentPost),
            'time' => time_convert($comment['time']),
            'userimage' => $comment['userimage'],
            'commentid' => $comment['commentid'],
            'hidebox' => $comment['userimage'] == null ? 'hide' : '',
            );
        $response = array(
                'success' => true,
                'errors'  => '',                
                'showcomment' => $showcomment
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }
    
    public function upload_handler(){
        if(!empty($_FILES['userfile']['name'])){ 
            $filename = ($_FILES['userfile']['name']);            
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $imgname = sha1($filename).'.'.$extension;
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], './assets/img/users_images/'.$imgname)){
                $json['photo_file'] = $imgname;               
                $json['success'] = 'Successfuly uploaded';     
            }else{  
                $json['error'] = 'Upload Failed';  
            }
            header('Content-Type: application/json');
            echo json_encode($json );
        }
    }
    
    public function deleteComment(){
        $comment_id = $this->input->post('comment_id');
        if($this->match_model->deletecomment($comment_id)){        
        } else {
            echo 'failed';
        }    
    }
    
    public function loadplayers(){
        $modmatchid = $this->input->post('match_id');
        $show_players = $this->match_model->optionplayers($modmatchid);
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
        $show_events = $this->match_model->optionevents(); 
        $eventsList = array();
        foreach($show_events as $show_event){
            $row = array();
            $row['eventid'] = $show_event['event_id'];
            $row['eventdesc'] = $show_event['event_desc'];
            $row['eventicon'] = $show_event['event_icon'];
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
    
    public function addResult(){
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
        if($playerid[0] != 0){
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
        if($evplayerid[0] != 0){    
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
        $score = $this->match_model->updatescore($matchid, $score1, $score2, $data, $data2, $playerid, $evplayerid);
        $datamatch = $this->match_model->getmatch($matchid);
        foreach($datamatch as $scorer){
            $hometeam = $scorer->match_team1_id; 
            $awayteam = $scorer->match_team2_id; 
        }
        $homescorer = $this->match_model->gethomescorer($matchid);
        $awayscorer = $this->match_model->getawayscorer($matchid, $awayteam);
        $homevent = $this->match_model->gethomevent($matchid, $hometeam);
        $awayevent = $this->match_model->getawayevent($matchid, $awayteam);
        $hsr = array();
        $asr = array();
        $hev = array();
        $aev = array();
        foreach($score as $val){
            $showscore = array(
                'homescore' => $val->match_score1,
                'awayscore' => $val->match_score2, 
            );
        }
        foreach($homescorer as $hscore){
            $showhomescorer = array(
                'homeplayer' => $hscore->homeplayer,
                'infoscore' => $hscore->timescore,
                'playerimage' => $hscore->playerimage,
                'urlimage' => $hscore->url_image,
                'urlstats' => $hscore->urlstats
            );
            array_push($hsr, $showhomescorer);
        }
        foreach($awayscorer as $ascore){
            $showawayscorer = array(
                'awayplayer' => $ascore->awayplayer,
                'infoscore' => $ascore->timescore,
                'playerimage' => $hscore->playerimage,
                'urlimage' => $hscore->url_image,
                'urlstats' => $hscore->urlstats
            );
            array_push($asr, $showawayscorer);
        }
        foreach($homevent as $hevent){
            $showhomevent = array(
                'homeplayer' => $hevent->homeplayer,
                'infoscore' => $hevent->timevent,
                'unievicon' => $hevent->unievicon,
                'uniclass' => $hevent->uniclass    
            );
            array_push($hev, $showhomevent);
        }
        foreach($awayevent as $aevent){
            $showawayevent = array(
                'awayplayer' => $aevent->awayplayer,
                'infoscore' => $aevent->timevent,
                'unievicon' => $aevent->unievicon,
                'uniclass' => $aevent->uniclass    
            );
            array_push($aev, $showawayevent);
        }
          
        $response = array(
            'success' => true,
            'errors'  => '',                
            'showscore' => $showscore,
            'showhomescorer' => $hsr,
            'showawayscorer' => $asr,
            'showhomevent' => $hev,
            'showawayevent' => $aev,
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }       
}