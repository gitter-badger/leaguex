<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Options_competitions extends CI_Controller {    
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
        $data['title'] = $this->lang->line('admin_title_optioncompetitions');         
        $data['getevents']= $this->options_model->get_events();
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('js/sections/admin/optionsValidation.js','plugins/bootbox/bootbox.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js'));
        $this->load->view('header_view',$data);
        $this->load->view('admin/sidebar_left_view');
        $this->load->view('admin/settings/options_competitions_view',$data);
        sidebar_chat();
        $this->load->view('footer_view');           
    }
    
     public function update_events_options(){
        $eventname = $this->input->post('eventName');
        $eventimage = $this->input->post('eventImage');
        foreach($eventname as $i=>$val){
            $data[] = array(            
                'event_desc' => $eventname[$i],                       
                'event_icon' => $eventimage[$i]  
            );       
        }
        if($this->options_model->update_events($data)){} else {
            echo 'failed';
        }
    }
    
    public function upload_handler(){
        if (!empty($_FILES['userfile']['name'])){ 
            $json = array();           
            list($width, $height) = getimagesize($_FILES['userfile']['tmp_name']);           
            $max_width = '50';  
            $max_height = '50';
            $min_width = '20';
            $min_height = '20';
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
        }else{  
            $json['error'] = 'Upload Failed';  
        }  
        if(!$json){
            $filename = ($_FILES['userfile']['name']);            
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], './assets/img/icons/'.$filename)){
                $json['photo_file'] = $filename;               
            } 
            $json['success'] = 'Successfuly uploaded';  
        }
        header('Content-Type: application/json');
        echo json_encode( $json );
    }
}
