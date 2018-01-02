<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Options_media extends CI_Controller {    
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
        $data['title'] = $this->lang->line('admin_title_optionsmedia');         
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/admin/optionsValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/settings/options_media_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_media_options(){                      
        $data = array(            
            'avatar_size_maxwidth' => $this->input->post('avatarMaxWidth'),                       
            'avatar_size_maxheight' => $this->input->post('avatarMaxHeight'),
            'avatar_size_minwidth' => $this->input->post('avatarMinWidth'),                       
            'avatar_size_minheight' => $this->input->post('avatarMinHeight'),
            'logo_size_maxwidth' => $this->input->post('logoMaxWidth'),                       
            'logo_size_maxheight' => $this->input->post('logoMaxHeight'),
            'logo_size_minwidth' => $this->input->post('logoMinWidth'),                       
            'logo_size_minheight' => $this->input->post('logoMinHeight'),    
        );       
        if($this->options_model->update_media($data)){        
            } else {
            echo 'failed';
            }
        }
}

