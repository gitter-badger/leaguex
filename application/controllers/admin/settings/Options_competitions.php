<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Options_competitions extends CI_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model');
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model'); 
        $this->load->model('admin/settings/options_model');  
    }
    
    public function index()            
    {   
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
        $data['title'] = $this->lang->line('admin_title_optioncompetitions');         
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/admin/optionsValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/settings/options_competitions_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
     public function update_competitions_options(){
        $levmin = $this->input->post('levMin');
        $levmax = $this->input->post('levMax');
        $maxplayers = $this->input->post('maxPlayers');
        $levels_min_list = implode(",", array_filter($levmin, 'strlen'));
        $levels_max_list = implode(",", array_filter($levmax, 'strlen'));
        $level_max_players = implode(",", array_filter($maxplayers, 'strlen'));
        $data = array(            
            'players_levels' => $this->input->post('playersLevels') ,
            'level_min' => $levels_min_list,
            'level_max' => $levels_max_list,
            'level_max_players' => $level_max_players
        );       
        if($this->options_model->update_competitions($data)){        
            } else {
            echo 'failed';
            }
        }
}
