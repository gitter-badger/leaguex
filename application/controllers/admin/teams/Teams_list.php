<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams_list extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/teams/teams_list_model'); 
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
        $data['title'] = $this->lang->line('admin_title_teamslist');        
        echo add_css(array('plugins/datatables-bootstrap/dataTables.bootstrap.min.css','plugins/datatables-responsive/responsive.bootstrap.min.css','plugins/datatables-tabletools/dataTables.tableTools.min.css','plugins/formvalidation/formValidation.min.css')); 
        echo addfooter_js(array('plugins/bootstrap-rating/bootstrap-rating.min.js','plugins/bootbox/bootbox.js','plugins/datatables/jquery.dataTables.min.js','plugins/datatables-bootstrap/dataTables.bootstrap.min.js','plugins/datatables-responsive/dataTables.responsive.min.js','plugins/moment/moment.min.js','plugins/moment/datetime-moment.js','js/sections/admin/dataTables.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/teams/teams_list_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');
            
    }
    
    public function showteams(){
        $this->datatables->select('team_id,team_logo,team_name,team_level,manager_wallet,team_registration_date, user_name')
             ->from('lex_teams')
             ->join('lex_managers', 'manager_team_id = team_id', 'left')
             ->join('lex_users', 'user_id = manager_user_id', 'left')
             ->add_column('teaminfo', '<img src="../../assets/img/teams_logo/$1">
                <span class="img-cell">$2</span>
                <span class="icon-cell"><input type="hidden" class="form-control rating" id="inputLevel" name="teamlevel" data-filled="fa fa-star" data-empty="fa fa-star-o" data-readonly value="$3"></span>',
                'team_logo, team_name, team_level')   
             ->add_column('action', '<a href="javascript:editTeam($1)" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">
                <i class="material-icons">mode_edit</i>
                </a>
                <a href="#" id="$1" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">
                <i class="material-icons">delete</i>
                </a>', 'team_id');
        echo $this->datatables->generate();
    } 
    
    public function add_team(){
        $new_teams = $this->teams_list_model->add_team();
        foreach ($new_teams as $new_team){
            $addTeam = array(
                'teamid' => $new_team->team_id,
                'teamlogo' => $new_team->team_logo,
                'teamname' => $new_team->team_name,
                'teamlevel' => $new_team->team_level,
                'regdate' => $new_team->team_registration_date,
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'addteam' => $addTeam
        ); 
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function edit_team(){
        $teamid = $this->input->post('teamid');
        $data = array(            
            'team_name' => $this->input->post('teamname'),                       
            'team_level' => $this->input->post('teamlevel'), 
            'team_logo' => $this->input->post('img-ghost'),           
        );       
        $this->teams_list_model->edit_team($teamid, $data);
        $get_teams = $this->teams_list_model->select_team($teamid);
        foreach ($get_teams as $get_team){
            $ediTeam = array(
                'teamid' => $get_team->team_id,
                'teamlogo' => $get_team->team_logo,
                'teamname' => $get_team->team_name,
                'teamlevel' => $get_team->team_level,
                'regdate' => $get_team->team_registration_date,
                'username' => $get_team->user_name
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'editeam' => $ediTeam
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function select_team(){              
        $teamid = $this->input->post('teamid');  
        $data_teams = $this->teams_list_model->select_team($teamid);
        foreach ($data_teams as $data_team){
            $dataTeam = array(
                'teamlogo' => $data_team->team_logo,
                'teamid' => $data_team->team_id,
                'teamname' => $data_team->team_name,
                'teamlevel' => $data_team->team_level
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'datateam' => $dataTeam
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function delete_team(){
        $delete_id = $this->input->post('id');
        if($this->teams_list_model->delete_team($delete_id)){        
        } else {
            echo 'failed';
        }               
    }
    
    public function upload_handler(){
        if (!empty($_FILES['userfile']['name'])) { 
        $this->db->select('logo_size_maxwidth, logo_size_maxheight, logo_size_minwidth, logo_size_minheight');
        $query = $this->db->get('lex_settings');
        foreach ($query->result() as $row){
            $maxWidth = $row->logo_size_maxwidth;
            $maxHeight = $row->logo_size_maxheight;
            $minWidth = $row->logo_size_minwidth;
            $minHeight = $row->logo_size_minheight;
        }        
        $json = array();           
        list($width, $height) = getimagesize($_FILES['userfile']['tmp_name']);           
        $max_width = $maxWidth;  
        $max_height = $maxHeight;
        $min_width = $minWidth;
        $min_height = $minHeight;
        $dimension_error='';     
        if($width > $max_width ){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_width'),$max_width);  
          }  
          if($height > $max_height ){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_height'),$max_height);  
          }  
          if($width > $max_width && $height > $max_height){  
              $dimension_error = sprintf($this->lang->line('alert_image_max_width_height'),$max_width,$max_height);  
          }
          if($width < $min_width ){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_width'),$min_width);  
          }  
          if($height < $min_height ){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_height'),$min_height);  
          }  
          if($width < $min_width && $height < $min_height){  
              $dimension_error = sprintf($this->lang->line('alert_image_min_width_height'),$min_width,$min_height);  
          }              
          if($dimension_error != ''){  
              $json['error'] = $dimension_error;  
          }  
      } else {  
        $json['error'] = 'Upload Failed';  
    }  

        if (!$json) {
        $filename = ($_FILES['userfile']['name']);            
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $imgname = sha1($filename).'.'.$extension;
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], './assets/img/teams_logo/'.$imgname)){
            $json['photo_file'] = $imgname;               
        } 
         $json['success'] = 'Successfuly uploaded';  
        }
        //add the header here
                header('Content-Type: application/json');
                echo json_encode( $json );

    }        
    
}
