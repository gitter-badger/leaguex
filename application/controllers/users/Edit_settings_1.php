<?php

class Edit_settings extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('header_model'); 
        $this->load->model('users/edit_settings_model'); 
        $this->load->model('users/get_user_data_model');         
    }   
    
    public function userid(){               
        if(!$this->session->userdata('username')){
            redirect('sign/signin','refresh');
        }
        last_activity();
        $data['unreadmsg'] = totalmsg_chat();  
        $data['unreadntf'] = total_unread_notifications();
        $data['countntf'] = total_notifications();
        $data['transition'] = read_transition();
        $userID = $this->session->userdata('userid');
        $data['userPic'] = $this->get_user_data_model->get_user_img($userID);
        $id = $this->uri->segment(4);
        $data['user'] = $this->edit_settings_model->userid($id);                
        $data['title'] = $this->lang->line('site_title_settings');
        echo add_css(array('plugins/formvalidation/formValidation.min.css'));
        echo addfooter_js(array('plugins/bootbox/bootbox.js','plugins/moment/moment.min.js','js/sections/site/userManagement.js','plugins/formvalidation/formValidation.min.js','plugins/formvalidation/framework/bootstrap.min.js','plugins/formvalidation/languages/it_IT.js','plugins/jquery-mask/jquery.mask.min.js'));
        $this->load->view('header_view',$data);
        $this->load->view('sidebar_left_view');
        sidebar_chat();
        $this->load->view('users/edit_settings_view',$data);
        $this->load->view('footer_view');
            
    }
    
    public function update_account(){           
    $id = $this->input->post('id');        
    $birthday = $this->input->post('birthday'); 
    $data = array(            
        'aboutme' => $this->input->post('aboutme'),                       
        'city' => $this->input->post('city'),             
        'favorite_club' => $this->input->post('favoriteclub')
    ); 
    $data2 = array(
        'user_email' => $this->input->post('email'),
        'user_birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $birthday)))            
    );

    if($this->edit_settings_model->update_info($id,$data,$data2)){        
        } else {
        echo 'failed';
        }
    }
        
    public function update_password(){              
    $id = $this->input->post('idpsw');
    $password = sha1($this->input->post('password'));
    if($this->edit_settings_model->update_password($id,$password)){        
        } else {
        echo 'failed';
        }
    }
        
    public function select_user(){              
        $userid = $this->input->post('userid');  
        $data_users = $this->edit_settings_model->select_user($userid);
        foreach ($data_users as $data_user){
            $dataUser = array(
                'userid' => $data_user->user_id,
                'useremail' => $data_user->user_email,
                'userpassword' => $data_user->user_password,
                'userbirthday' => $data_user->user_birthday    
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
        
    public function check_email(){
    $isAvailable = true;    
    $id = $this->session->userdata['userid']; 
    $email = $this->input->post('email');
    $this->db->where('user_email', $email);
    $this->db->where('user_id !=' ,$id);
    $query = $this->db->get('lex_users');
    if($query->num_rows() > 0){$isAvailable = false;}
    echo json_encode(array('valid' => $isAvailable));
    }
        
    public function upload_handler(){
        if (!empty($_FILES['userfile']['name'])) { 
        $this->db->select('avatar_size_maxwidth, avatar_size_maxheight, avatar_size_minwidth, avatar_size_minheight');
        $query = $this->db->get('lex_settings');
        foreach ($query->result() as $row){
            $maxWidth = $row->avatar_size_maxwidth;
            $maxHeight = $row->avatar_size_maxheight;
            $minWidth = $row->avatar_size_minwidth;
            $minHeight = $row->avatar_size_minheight;
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
            $iduser = $this->input->post('key');
        $filename = ($_FILES['userfile']['name']);            
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $imgname = sha1($filename).'.'.$extension;
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], './assets/img/avatars/'.$imgname)){
            $this->edit_settings_model->update_avatar($iduser,$imgname);  
            $json['photo_file'] = $imgname;               
        } 
         $json['success'] = 'Successfuly uploaded';  
        }
        //add the header here
                header('Content-Type: application/json');
                echo json_encode( $json );

    }        
}
