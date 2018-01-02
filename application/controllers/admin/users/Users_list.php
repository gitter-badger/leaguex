<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_list extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/users/users_list_model'); 
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
        $data['title'] = $this->lang->line('admin_title_userslist');
        echo add_css(array('plugins/datatables-bootstrap/dataTables.bootstrap.min.css','plugins/datatables-responsive/responsive.bootstrap.min.css','plugins/datatables-tabletools/dataTables.tableTools.min.css','plugins/formvalidation/formValidation.min.css')); 
        echo addfooter_js(array('plugins/bootbox/bootbox.js','plugins/datatables/jquery.dataTables.min.js','plugins/datatables-bootstrap/dataTables.bootstrap.min.js','plugins/datatables-responsive/dataTables.responsive.min.js','plugins/moment/moment.min.js','plugins/moment/datetime-moment.js','js/sections/admin/dataTables.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/users/users_list_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');
            
    }
    
    public function showusers(){
        $this->datatables->select('user_id,user_name,user_permissions,user_email,user_registration_date,time')
             ->from('lex_users')
             ->join('lex_last_activity', 'la_user_id = user_id')
             ->add_column('action', '<a href="javascript:editUser($1)" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">
                <i class="material-icons">mode_edit</i>
                </a>
                <a href="#" id="$1" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">
                <i class="material-icons">delete</i>
                </a>', 'user_id');
        echo $this->datatables->generate();
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
    
     public function echeck_username(){ 
        $usid = $this->input->post('userid');
        $isAvailable = true;        
        $username = $this->input->post('username');
        $this->db->where('user_name', $username);
        $this->db->where('user_id !=' ,$usid);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
    }
        
    public function echeck_email(){
        $isAvailable = true;    
        $usid = $this->input->post('userid');
        $email = $this->input->post('email');
        $this->db->where('user_email', $email);
        $this->db->where('user_id !=' ,$usid);
        $query = $this->db->get('lex_users');
        if($query->num_rows() > 0){$isAvailable = false;}
        echo json_encode(array('valid' => $isAvailable));
        }
    
    public function add_user(){
        $new_users = $this->users_list_model->add_user();
        foreach ($new_users as $new_user){
            $addUser = array(
                'userid' => $new_user->user_id,
                'username' => $new_user->user_name,
                'permission' => $new_user->user_permissions,
                'usermail' => $new_user->user_email,
                'regdate' => $new_user->user_registration_date,
                'activity' => $new_user->time
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'adduser' => $addUser
        ); 
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function edit_user(){
        $userid = $this->input->post('userid');
        $birthday = $this->input->post('birthday'); 
        $newpassword = sha1($this->input->post('newpassword'));
        $password = $this->input->post('password');
        if($this->input->post('newpassword') == ''){
            $data = array(            
                'user_name' => $this->input->post('username'),                       
                'user_email' => $this->input->post('email'),
                'user_permissions' => $this->input->post('permission'),
                'user_password' => $password,
                'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday))) 
            ); 
        }else{
            $data = array(            
                'user_name' => $this->input->post('username'),                       
                'user_email' => $this->input->post('email'),
                'user_permissions' => $this->input->post('permission'),
                'user_password' => $newpassword,
                'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday))) 
            );     
        }
        $this->users_list_model->edit_user($userid, $data);
        $get_users = $this->users_list_model->select_user($userid);
        foreach ($get_users as $get_user){
            $editUser = array(
                'userid' => $get_user->user_id,
                'username' => $get_user->user_name,
                'useremail' => $get_user->user_email,
                'permission' => $get_user->user_permissions,
                'regdate' => $get_user->user_registration_date,
                'username' => $get_user->user_name
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'edituser' => $editUser
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function select_user(){              
        $userid = $this->input->post('userid');  
        $data_users = $this->users_list_model->select_user($userid);
        foreach ($data_users as $data_user){
            $dataUser = array(
                'userid' => $data_user->user_id,
                'username' => $data_user->user_name,
                'useremail' => $data_user->user_email,
                'userpassword' => $data_user->user_password,
                'userbirthday' => $data_user->user_birthday,
                'userpermission' => $data_user->user_permissions     
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'datauser' => $dataUser
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function deleteuser(){
        $delete_id = $this->input->post('id');
        if($this->users_list_model->deleteuser($delete_id)){        
        } else {
            echo 'failed';
        }               
    }
}

