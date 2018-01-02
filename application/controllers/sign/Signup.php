<?php

class Signup extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('sign/signup_model');
         $this->load->model('header_model'); 
    }
    
     public function index(){
        $data['title']= read_sitetitle();      
        echo add_css(array('plugins/formvalidation/formValidation.min.css')); 
        echo addfooter_js(array('js/sections/site/userManagement.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js'));
        if($this->session->userdata('username')){
            redirect('home','refresh');
        }else{
        $this->load->view('sign/signup_view', $data);
        }       
     }
     
    public function check_username(){
        $isAvailable = true;
        $username = $this->input->post('username');
        $this->db->where('user_name', $username);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
    }
    
    public function check_email(){
        $isAvailable = true;
        $email = $this->input->post('email');
        $this->db->where('user_email', $email);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
    }
    
    public function save_user(){
        if($this->signup_model->save_user()){
        }else{
            echo 'failed';
        }          
    }  
}

