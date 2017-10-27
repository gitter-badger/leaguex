<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Options_email extends CI_Controller {    
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
        $data['title'] = $this->lang->line('admin_title_optionsemail');         
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/admin/optionsValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/settings/options_email_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_email_options(){                      
        $data = array(            
            'smtp_email' => $this->input->post('email'),                       
            'smtp_name' => $this->input->post('name'),
            'smtp_host' => $this->input->post('host'),                       
            'smtp_user' => $this->input->post('username'),
            'smtp_pass' => $this->input->post('password'),                       
            'smtp_port' => $this->input->post('port')  
        );       
        if($this->options_model->update_email($data)){        
            } else {
            echo 'failed';
            }
        }
        
    public function test_email_options() {
        $query = $this->db->query("SELECT smtp_email, smtp_name FROM lex_settings;");
        foreach ($query->result() as $smtp){
            $email = $smtp->smtp_email;
            $name = $smtp->smtp_name;            
    }
        $emailTest = $this->input->post('testemail');
        date_default_timezone_set('GMT');        
        $this->load->library('email');
        $this->email->from($email, $name);
        $this->email->to($emailTest); 	
        $this->email->subject($this->lang->line('admin_omail_object_test_mail'));
        $this->email->message($this->lang->line('admin_omail_text_test_mail'));	
        $this->email->send();
    } 
}
