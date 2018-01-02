<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->model('sidebar_right_model'); 
        $this->load->model('chat/message_model', 'message');
        $this->load->model('header_model'); 
        $this->load->model('users/get_user_data_model');     
        $this->load->model('notifications/notes_model', 'notify');   
        $this->load->model('notifications/lastntf_model', 'last');            
    }
    
    public function index(){               
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
        $data['title'] = $this->lang->line('site_title_notifications');
        echo addfooter_js(array('plugins/moment/moment.min.js'));
        $this->load->view('header_view',$data);
        $this->load->view('sidebar_left_view');
        sidebar_chat();
        $this->load->view('notifications/notes_view');
        $this->load->view('footer_view');
    }    
     
    public function filterNotifications(){
        $per_page = 10;
        $value = $this->input->post('value');
        $userid = $this->input->post('user');
        $limit = isset($_POST['limit']) ? $this->input->post('limit') : $per_page ;
        if($value == 2){
            $getNotifications = $this->notify->getunreadnotifications($userid, $limit);
        }else if($value == 3){
            $getNotifications = $this->notify->getreadnotifications($userid, $limit);    
        }else{
            $getNotifications = $this->notify->getallnotifications($userid, $limit);    
        }
        $total = $this->notify->ntf_len($userid);  
        $notes = array();
        $message = '';
        foreach ($getNotifications as $getNotification){
            if($getNotification->type == 1){ 
                $query = $this->db->get_where('lex_teams', array('team_id' => $getNotification->object_id));
                $owner = $query->row();  
                $object = $owner->team_name;
                $message = sprintf($this->lang->line('ntf_type_1'),$owner->team_name);
                $url = base_url().'/teams/user_team';
                $bg = 'bg-blue';
                $icon = 'person';
            } elseif ($getNotification->type == 2){
                $query = $this->db->get('lex_settings');
                $result = $query->row(); 
                $message = sprintf($this->lang->line('ntf_type_2'),$result->site_name);
                $object = $result->site_name;
                $url = 'javascript:void(0)';
                $bg = 'bg-orange';
                $icon = 'cake';
            }
            $notify = array(
                'ntf' => $getNotification->id,                                                          
                'message' => $message,
                'time' => time_convert($getNotification->time),
                'object' => $object, 
                'url' => $url,
                'bg' => $bg,
                'icon' => $icon,
                'is_read' => $getNotification->is_read == 0 ? 'visibility_off' : 'done',
                'bg_read' => $getNotification->is_read == 0 ? 'unread' : 'read',
            );
            array_push($notes, $notify);
        }
        $morenote = array(
            'id' => $userid,
            'limit' => $limit + $per_page,
            'more' => $total  <= $limit ? false : true,
            'scroll'=> $limit > $per_page  ?  false : true,
            'remaining'=> $total - $limit
        );
        $response = array(
            'success' => true,
            'errors'  => '', 
            'morenote'   => $morenote,
            'ntf'  => $notes
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function notifications(){                
        $per_page = 10;
        $user = $this->input->post('user');
        $limit = isset($_POST['limit']) ? $this->input->post('limit') : $per_page;
        $notifications = $this->notify->getunreadnotifications($user, $limit);
        $total = $this->notify->ntf_len_unread($user);        
        $ntf = array();
        $message = '';
        foreach ($notifications as $notification){
            if($notification->type == 1){ 
                $query = $this->db->get_where('lex_teams', array('team_id' => $notification->object_id));
                $owner = $query->row();  
                $object = $owner->team_name;
                $message = sprintf($this->lang->line('ntf_type_1'),$owner->team_name);
                $url = base_url().'/teams/user_team';
                $bg = 'bg-blue';
                $icon = 'person';
            }elseif ($notification->type == 2){
                $query = $this->db->get('lex_settings');
                $result = $query->row(); 
                $message = sprintf($this->lang->line('ntf_type_2'),$result->site_name);
                $object = $result->site_name;
                $url = 'javascript:void(0)';
                $bg = 'bg-orange';
                $icon = 'cake';
            }
            $notify = array(
                'ntf' => $notification->id,                                                          
                'message' => $message,
                'time' => time_convert($notification->time),
                'object' => $object, 
                'url' => $url,
                'bg' => $bg,
                'icon' => $icon,
                'is_read' => $notification->is_read == 0 ? 'visibility_off' : 'done',
                'bg_read' => $notification->is_read == 0 ? 'unread' : 'read',
            );
            array_push($ntf, $notify);
        }
        $morenote = array(
            'id' => $user,
            'limit' => $limit + $per_page,
            'more' => $total  <= $limit ? false : true,
            'scroll'=> $limit > $per_page  ?  false : true,
            'remaining'=> $total - $limit
        );

        $response = array(
            'success' => true,
            'errors'  => '',                
            'morenote'   => $morenote,
            'ntf'  => $ntf
        );            
        header('Content-Type: application/json');
        echo json_encode($response);
    }
        
    public function updates(){          
        $new_exists = false;
        $user_id = $this->session->userdata('userid');
        $query = $this->db->get_where('lex_last_notification',array('user_id' => $user_id));
        $last_notification = $query->row();      
        $last_notification  = empty($last_notification) ? 0 : $last_notification->notification_id;
        $exists = $this->notify->latest_notification($user_id, $last_notification);

        if($exists){
        $new_exists = true;
        }
        if($new_exists){
            $new_notification = $this->notify->unread($user_id);  
            $shownote = array();               
            foreach ($new_notification as $note) {                            
            $notify = array(
                'ntf' => $note->id,               
            );
            array_push($shownote, $notify);
            }
            $totalntf = count($new_notification);
            $this->last->update_lastSeen($user_id);                
            $response = array(
            'success' => true,
            'notifications' => $shownote,                
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        }
    }
    
    public function mark_read(){
        $id = $this->input->post('id');
        $user_id = $this->session->userdata('userid');
        $this->notify->mark_read($id);
        $count_notification = $this->notify->unread($user_id);
        $totalntf = count($count_notification);
         $response = array(
            'success' => true,                            
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
     public function mark_all_read(){
        $user_id = $this->session->userdata('userid');
        $this->notify->mark_all_read($user_id);
        $count_notification = $this->notify->unread($user_id);
        $totalntf = count($count_notification);
         $response = array(
            'success' => true,                            
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function mark_unread(){
        $id = $this->input->post('id');
        $user_id = $this->session->userdata('userid');
        $this->notify->mark_unread($id);
        $count_notification = $this->notify->unread($user_id);
        $totalntf = count($count_notification);
         $response = array(
            'success' => true,                            
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function mark_all_unread(){
        $user_id = $this->session->userdata('userid');
        $this->notify->mark_all_unread($user_id);
        $count_notification = $this->notify->unread($user_id);
        $totalntf = count($count_notification);
         $response = array(
            'success' => true,                            
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function count_unread(){       
        $user_id = $this->session->userdata('userid');   
        $count_notification = $this->notify->unread($user_id);
        $totalntf = count($count_notification);
         $response = array(
            'success' => true,                            
            'totalntf' => $totalntf
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
    
