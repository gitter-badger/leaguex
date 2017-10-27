<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Edit_player extends CI_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model');
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/players/edit_player_model');         
    }   
	
    public function playerid()            
    {   
        if((!$this->session->userdata('username')) OR ($this->session->userdata('permissions') != 1)){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID); 
        $id = $this->uri->segment(5);
        $data['player'] = $this->edit_player_model->playerid($id);       
        $data['teams'] = $this->edit_player_model->teamid();
        $data['positions'] = $this->edit_player_model->positionid();
        $data['title'] = $this->lang->line('admin_title_editplayer');         
        echo add_css(array('plugins/bootstrap-select/bootstrap-select.min.css','plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('plugins/bootstrap-select/bootstrap-select.min.js','js/sections/admin/formValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/players/edit_player_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_player(){              
        $id = $this->input->post('id');         
        $data = array(            
            'player_team_id' => $this->input->post('team'),                       
            'player_position' => $this->input->post('position'),
            'player_age' => $this->input->post('age'),
            'player_overall' => $this->input->post('overall'),  
        );         
        if($this->edit_player_model->update_player($id, $data)){        
        }else{
            echo 'failed';
        }
    }   
}



