<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Options_general extends CI_Controller {    
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
        $data['title'] = $this->lang->line('admin_title_optionsgeneral');   
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID);
        echo add_css(array('plugins/bootstrap-select/bootstrap-select.min.css','plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('plugins/bootstrap-select/bootstrap-select.min.js','js/sections/admin/optionsValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/settings/options_general_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_general_options(){
        $data = array(            
            'language' => $this->input->post('language'),
            'site_name' => $this->input->post('sitename'),
            'site_title' => $this->input->post('sitetitle'),
            'transition' => $this->input->post('transition'),
            'table_details' => $this->input->post('details-visibile') 
        );
        
        if($this->options_model->update_general($data)){        
            } else {
            echo 'failed';
            }
        }
}

