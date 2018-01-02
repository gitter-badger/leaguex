<?php

class Signin extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sign/signin_model'); 
        $this->load->model('header_model'); 
    }
    
    public function index(){
        $data['title']= read_sitetitle();
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/site/userManagement.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        if($this->session->userdata('username')){
            redirect('home','refresh');
        } 
        $this->load->view('sign/signin_view', $data);         
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('sign/signin','refresh');
        exit;
    }
    
    public function login(){        
        $email = $this->input->post('email');
        $password = $this->input->post('password');      
        $data = $this->signin_model->login($email,$password);  
        $permissions = $data['permissions'];
        $userid = $data['userid'];
        $checkbirthday = date("m-d", strtotime($data['birthday']));
        $currentdate = date('Y-m-d');
        $checkcurdate = date("m-d", strtotime($currentdate));        
        $query = $this->db->select('user_id, time')->where('user_id', $userid)->where('type', 2)->where('STR_TO_DATE(time, "%Y-%m-%d")=', $currentdate)->get('lex_notification');
        
        if(($query->num_rows() == 0) && ($checkbirthday == $checkcurdate)){
            $data = array(
                'user_id' => $userid,
                'object_id' =>  0,
                'url_id' => 0,
                'type' => 2
                );
            $this->signin_model->birthday_note($data);             
        }
        
        if($permissions == 4){              
            $result['ban'] = 'ban'; 
           $this->session->sess_destroy();
        }
        else if(!$data){
            $result['error'] = 'error';     
        }
        else{
            $result['success'] = 'success';
        }
        header('Content-Type: application/json');            
        echo json_encode($result);       
    }        
}
