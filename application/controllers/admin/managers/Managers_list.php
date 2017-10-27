<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managers_list extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/managers/managers_list_model'); 
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
        $data['title'] = $this->lang->line('admin_title_managerslist');        
        $data['users'] = $this->managers_list_model->optionusers();       
        echo add_css(array('plugins/datatables-bootstrap/dataTables.bootstrap.min.css','plugins/datatables-responsive/responsive.bootstrap.min.css','plugins/datatables-tabletools/dataTables.tableTools.min.css','plugins/formvalidation/formValidation.min.css')); 
        echo addfooter_js(array('plugins/bootbox/bootbox.js','plugins/datatables/jquery.dataTables.min.js','plugins/datatables-bootstrap/dataTables.bootstrap.min.js','plugins/datatables-responsive/dataTables.responsive.min.js','plugins/moment/moment.min.js','plugins/moment/datetime-moment.js','js/sections/admin/dataTables.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js','plugins/jquery-number/jquery-number.min.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/managers/managers_list_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');
            
    }
    
    public function showmanagers(){
        $this->datatables->select('manager_id,user_name,team_name,manager_wallet,manager_registration_date')
             ->from('lex_managers')
             ->join('lex_users', 'user_id = manager_user_id')
             ->join('lex_teams', 'team_id = manager_team_id', 'left')
             ->add_column('action', '<a href="edit_manager/managerid/$1" class="animsition-link table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">
                <i class="material-icons">mode_edit</i>
                </a>
                <a href="#" id="$1" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">
                <i class="material-icons">delete</i>
                </a>', 'manager_id');
        echo $this->datatables->generate();
    } 
    
    public function add_manager(){
        $new_managers = $this->managers_list_model->add_manager();
        foreach ($new_managers as $new_manager){
            $addManager = array(
                'managerid' => $new_manager->manager_id,
                'username' => $new_manager->user_name,
                'teamname' => $new_manager->team_name,
                'wallet' => $new_manager->manager_wallet,
                'regdate' => $new_manager->manager_registration_date,
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'addmanager' => $addManager
        ); 
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function deletemanager(){
        $delete_id = $this->input->post('id');
        if($this->managers_list_model->deletemanager($delete_id)){        
        } else {
            echo 'failed';
        }               
    }
    
    function loadusers(){
        $show_users = $this->managers_list_model->optionusers();
        $usersList = array();
        foreach ($show_users as $show_user){
            $row = array();
            $row['userid'] = $show_user['user_id'];
            $row['username'] = $show_user['user_name'];
            $usersList[] = $row; 
        }
        $response = array(
                'success' => true,
                'errors'  => '',                
                'userslist' => $usersList                
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }    
    
    function loadteams(){
        $show_teams = $this->managers_list_model->optionteams();
        $teamsList = array();
        foreach ($show_teams as $show_team){
            $row = array();
            $row['teamid'] = $show_team['team_id'];
            $row['teamname'] = $show_team['team_name'];
            $teamsList[] = $row; 
        }
        $response = array(
                'success' => true,
                'errors'  => '',                
                'teamslist' => $teamsList                
            );            
            header('Content-Type: application/json');
            echo json_encode($response);
    }    
    
}
