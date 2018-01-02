<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Edit_user extends CI_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/users/edit_user_model');         
    }   
	
    public function userid()            
    {   
        if((!$this->session->userdata('username')) OR ($this->session->userdata('permissions') != 1)){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID); 
        $id = $this->uri->segment(5);
        $data['user'] = $this->edit_user_model->userid($id);   
        $data['title'] = $this->lang->line('admin_title_edituser'); 
        $this->session->set_userdata('checkuser',$id);
        echo add_css(array('plugins/bootstrap-select/bootstrap-select.min.css','plugins/formvalidation/formValidation.min.css','plugins/ladda-bootstrap/ladda.min.css'));
        echo addfooter_js(array('plugins/bootstrap-select/bootstrap-select.min.js','plugins/bootbox/bootbox.js','plugins/ladda-bootstrap/spin.min.js','plugins/ladda-bootstrap/ladda.min.js','js/sections/admin/usersValidation.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/users/edit_user_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
    public function update_user_data(){              
        $id = $this->input->post('id');        
        $birthday = $this->input->post('birthday'); 
        $data = array(            
            'aboutme' => $this->input->post('aboutme'),                       
            'city' => $this->input->post('city'),             
            'favorite_club' => $this->input->post('favoriteclub')
        ); 
        $data2 = array(
            'user_email' => $this->input->post('email'),
            'user_permissions' => $this->input->post('permissions'), 
            'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday))),
            'user_ban' => $this->input->post('ban'), 
        );
        
        if($this->edit_user_model->update_info($id,$data,$data2)){        
            } else {
            echo 'failed';
            }
        }
        
    public function update_password(){              
        $id = $this->input->post('idpsw');
        $password = sha1($this->input->post('password'));
        if($this->edit_user_model->update_password($id,$password)){        
            } else {
            echo 'failed';
            }
        }       
        
    public function check_username(){ 
        $usid = $this->session->userdata('checkuser');
        $isAvailable = true;        
        $username = $this->input->post('username');
        $this->db->where('user_name', $username);
        $this->db->where('user_id !=' ,$usid);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
    }
        
        public function check_email(){
        $isAvailable = true;    
        $usid = $this->session->userdata('checkuser');
        $email = $this->input->post('email');
        $this->db->where('user_email', $email);
        $this->db->where('user_id !=' ,$usid);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
        }
    
}



