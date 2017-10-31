<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leagues_list extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('header_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('users/get_user_data_model');
        $this->load->model('admin/competitions/leagues_list_model'); 
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
        $data['title'] = $this->lang->line('admin_title_leagueslist');     
        echo add_css(array('plugins/datatables-bootstrap/dataTables.bootstrap.min.css','plugins/datatables-responsive/responsive.bootstrap.min.css','plugins/datatables-tabletools/dataTables.tableTools.min.css','plugins/formvalidation/formValidation.min.css')); 
        echo addfooter_js(array('plugins/bootbox/bootbox.js','plugins/datatables/jquery.dataTables.min.js','plugins/datatables-bootstrap/dataTables.bootstrap.min.js','plugins/datatables-responsive/dataTables.responsive.min.js','plugins/moment/moment.min.js','plugins/moment/datetime-moment.js','js/sections/admin/dataTables.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js')); 
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/competitions/leagues_list_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');
    }
    
    public function showleagues(){
        
        $this->datatables->select('competition_id, competition_logo, competition_name, count(ct_competition_id)as counteams, competition_registration_date, competition_fixture, competition_status')
            ->from('lex_competitions')
            ->join('lex_competitions_teams', 'competition_id = ct_competition_id')
            ->group_by('competition_id')
            ->add_column('leagueinfo', '<img src="../../assets/img/competitions_logo/$1">
                <span class="img-cell">$2</span>','competition_logo, competition_name')
            ->add_column('action', '<a id="$1" href="$2$1" class="table-icon btn btn-fab btn-fab-custom $3 no-shadow no-color-bg fixture">
                <i class="material-icons $4"></i>
                <i class="fa fa-circle-o-notch fa-spin loadpic"></i>
                </a>
                <a href="#" id="$1" class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg delete">
                <i class="material-icons">delete</i>
                </a>
                <span class="table-icon btn btn-fab btn-fab-custom no-shadow no-color-bg">
                <i class="material-icons $5">fiber_manual_record</i>
                </span>', 'competition_id, check_fixture_link(competition_fixture), check_fixture_class(competition_fixture), check_fixture_icon(competition_fixture), check_fixture_status(competition_status)'); 
        
        echo $this->datatables->generate();
    }
    
    function loadteams(){
        
        $show_teams = $this->leagues_list_model->optionteams();
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
    
    public function add_league(){        
        $new_leagues = $this->leagues_list_model->add_league();
        foreach ($new_leagues as $new_league){
            $addLeague = array(
                'leagueid' => $new_league->competition_id,
                'leaguelogo' => $new_league->competition_logo,
                'leaguename' => $new_league->competition_name,
                'counteams' => $new_league->counteams,               
                'regdate' => $new_league->competition_registration_date,
            );
        }
        $response = array(
            'success' => true,
            'errors' => '',
            'addleague' => $addLeague
        ); 
        header('Content-Type: application/json');
        echo json_encode($response);        
    }
    
    function makefixture(){
        
        $fixture_id = $this->input->post('id');
        if($this->leagues_list_model->makefixture($fixture_id)){        
        } else {
            echo 'failed';
        }               
    }
    
    function deleteleague(){
        $delete_id = $this->input->post('id');
        if($this->leagues_list_model->deleteleague($delete_id)){        
        } else {
            echo 'failed';
        }               
    }
}
