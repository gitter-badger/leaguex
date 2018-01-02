<?php

class Leagues extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('header_model'); 
        $this->load->model('competitions/leagues_model'); 
        $this->load->model('users/get_user_data_model');         
    }
    
    public function index(){               
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
        $data['title'] = $this->lang->line('site_title_leagues');
        $data['getlastleague'] = $this->leagues_model->getlastleague();
        $data['getlastteams'] = $this->leagues_model->getlastteams();
        $data['getmanagers'] = $this->leagues_model->getmanager($userID);
        $data['getlastable'] = $this->leagues_model->getlastable();
        echo add_css(array('plugins/bootstrap-select/bootstrap-select.min.css')); 
        echo addfooter_js(array('plugins/bootstrap-select/bootstrap-select.min.js','js/sections/site/competitions.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('sidebar_left_view');
        sidebar_chat();
        $this->load->view('competitions/leagues_view',$data);
        $this->load->view('footer_view');             
    }
    
    public function filterLeagues(){
        $id = $this->input->post('id');
        $userid = $this->session->userdata('userid');
        $getLeague = $this->leagues_model->getleague($id, $userid);
        $this->output->set_output(json_encode($getLeague));        
    }
    
    public function filterTeams(){
        $teamid = $this->input->post('teamid');
        $id = $this->input->post('id');
        $userid = $this->session->userdata('userid');
        if($teamid){
            $getTeams = $this->leagues_model->getteams($id, $teamid, $userid);
        } else {
            $getTeams = $this->leagues_model->getallteams($id, $userid);    
        }
        $this->output->set_output(json_encode($getTeams));
    }

    public function filterTable(){
         $competitionid = $this->input->post('id');
         $getTable = $this->leagues_model->gettable($competitionid);
         $this->output->set_output(json_encode($getTable)); 
    }
    
    public function loadleagues(){
        
        $show_leagues = $this->leagues_model->optionleagues();
        $leaguesList = array();
        foreach ($show_leagues as $show_league){
            $row = array();
            $row['leagueid'] = $show_league['competition_id'];
            $row['leaguename'] = $show_league['competition_name'];
            $leaguesList[] = $row; 
        }
        $response = array(
                'success' => true,
                'errors'  => '',                
                'leagueslist' => $leaguesList                
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }
    
    public function loadteams(){
        $id = $this->input->post('id');
        $show_teams = $this->leagues_model->optionteams($id);
        $teamsList = array();
        foreach ($show_teams as $show_team){
            $row = array();
            $row['teamid'] = $show_team['team_id'];
            $row['teamname'] = $show_team['team_name'];
            $teamsList[] = $row; 
        }
        $response = array(
                'success' => true,
                'errors'  => '',                
                'teamslist' => $teamsList                
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }
}
