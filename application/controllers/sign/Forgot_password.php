<?php

class Forgot_password extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('sign/forgot_password_model');
        $this->load->model('header_model'); 
    }
    
    public function index() {
        if($this->session->userdata('username')){
            redirect('home','refresh');
        }
        else
        {
        $data['title']= read_sitetitle();     
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/site/userManagement.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('sign/forgot_password_view',$data);          
        }
    } 
    
    public function doforget() {        
        $email = $this->input->post('email');
        $check = $this->forgot_password_model->dbforget($email);
        foreach ($check as $row){
            $username = $row->user_name;
        }
        if($check){
            $user = $check[0];           
            $this->resetpassword($user,$username);                        
            return true;
            }else{
            echo "failed";
            return false;
            }   
    }
    
    private function resetpassword($user, $username) {
        $query = $this->db->query("SELECT smtp_email, smtp_name FROM lex_settings;");
        foreach ($query->result() as $smtp){
            $email = $smtp->smtp_email;
            $name = $smtp->smtp_name;            
    }
        date_default_timezone_set('GMT');
        $this->load->helper('string');
        $password= random_string('alnum',8);
        $this->db->where('user_id', $user->user_id);
        $this->db->update('lex_users',array('user_password'=>sha1($password)));
        $this->load->library('email');
        $this->email->from($email, $name);
        $this->email->to($user->user_email); 	
        $this->email->subject($this->lang->line('rpsw_object_mailreset'));
        $this->email->message(sprintf($this->lang->line('rpsw_text_mailreset').':'. $password,$username));	
        $this->email->send();
    } 
    
}

