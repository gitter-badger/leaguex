<?php

class User_team extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('header_model'); 
        $this->load->model('teams/user_team_model'); 
        $this->load->model('users/get_user_data_model');         
    }
    
    public function userid(){               
        if(!$this->session->userdata('username')){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->uri->segment(4);
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID);                      
        $data['userteam'] = $this->user_team_model->showuserteam($userID);
        foreach($data['userteam'] as $geteam){
            $teamname = $geteam->team_name;
            $teamid = $geteam->team_id; 
        }
        $data['countplayed'] = $this->user_team_model->showstatsteam($teamid);
        $data['title'] = $teamname;
        $data['userplayer'] = $this->user_team_model->showuserplayer($userID);
        $data['countplayers'] = count($data['userplayer']);
        echo addfooter_js(array('plugins/bootstrap-rating/bootstrap-rating.min.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('sidebar_left_view');
        sidebar_chat();
        $this->load->view('teams/user_team_view',$data);
        $this->load->view('footer_view');       
            
    }
}
