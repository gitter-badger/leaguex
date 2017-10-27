<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Edit_manager extends CI_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model');
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/managers/edit_manager_model');         
    }   
	
    public function managerid()            
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
        $data['manager'] = $this->edit_manager_model->managerid($id);
        $teams = $this->edit_manager_model->managerid($id);
        foreach ($teams as $team){
            $showteams = $team->manager_team_id;                     
        }
        $data['teams'] = $this->edit_manager_model->teamid($showteams);  
        $data['title'] = $this->lang->line('admin_title_editmanager');         
        echo add_css(array('plugins/bootstrap-select/bootstrap-select.min.css','plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('plugins/bootstrap-select/bootstrap-select.min.js','js/sections/admin/formValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/managers/edit_manager_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_manager(){              
        $id = $this->input->post('id');         
        $data = array(            
            'manager_team_id' => $this->input->post('teamname'),                       
            'manager_wallet' => str_replace($this->lang->line('mask_page'), "", $this->input->post('managerwallet')),                         
        );
         $data2 = array(           
            'user_id' => $this->input->post('user_id'),
            'object_id' => $this->input->post('teamname'), 
            'type' => '1'   
         );    
        if($this->edit_manager_model->update_manager($id,$data,$data2)){        
        }else{
            echo 'failed';
        }
    }   
}



