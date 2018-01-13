<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
   
   function __construct()
	{
            parent::__construct();            
            $this->load->model('chat/message_model', 'message');   
            $this->load->model('chat/lastmsg_model', 'last');           
	}    
    
    public function messages(){         
        $per_page = 10;
        $user = $this->session->userdata('userid');
        $buddy = $this->input->post('user');
        $limit  = $this->input->post('limit') ? $this->input->post('limit') : $per_page ;

        $messages = array_reverse($this->message->conversation($user, $buddy, $limit));
        $total = $this->message->thread_len($user, $buddy);
        
        $thread = array();
            foreach ($messages as $message){
                $query = $this->db->get_where('lex_users', array('user_id' => $message->from)); 
                $owner = $query->row();      			
                $chat = array(
                        'msg' => $message->id,
                        'sender' => $message->from, 
                        'recipient' => $message->to,
                        'avatar' => $owner->user_avatar,
                        'body' => $message->message,
                        'time' => time_convert($message->time),                        
                        'type' => $message->from == $user ? '' : 'buddy',
                        'name' => $message->from == $user ? 'You' : ($owner->user_name)
                );
                array_push($thread, $chat);
            }

            $query = $this->db->get_where('lex_users',array('user_id' => $buddy));
            $chatbuddy = $query->row();                
            $contact = array(
                'name' => $chatbuddy->user_name,
                'avatar' => $chatbuddy->user_avatar,
                'id' => $chatbuddy->user_id,
                'permissions' => $chatbuddy->user_permissions,
                'limit'=>$limit + $per_page,
                'more' => $total  <= $limit ? false : true, 
                'scroll'=> $limit > $per_page  ?  false : true,
                'remaining'=> $total - $limit
            );

            $response = array(
                'success' => true,
                'errors'  => '',
                'message' => '',
                'buddy'   => $contact,
                'thread'  => $thread
            );            
            header('Content-Type: application/json');
            echo json_encode( $response );
    }

    public function save_message(){        
        $logged_user = $this->session->userdata('userid');
        $buddy = $this->input->post('user');
        $message = $this->input->post('message');
        if($message != '' && $buddy != ''){
            $msg_id = $this->message->insert_message(array(
                'from' => $logged_user,
                'to' => $buddy,
                'message' => $message,
                'message' => $message
            ));

            $msg = $this->message->get_message($msg_id);
            $query = $this->db->get_where('lex_users',array('user_id' => $msg['from'])); 
            $owner = $query->row();     
            $chat = array(
            'msg' => $msg['id'],
            'sender' => $msg['from'], 
            'recipient' => $msg['to'],
            'avatar' => $owner->user_avatar,
            'body' => $msg['message'],
            'time' => time_convert($msg['time']),
            'type' => $msg['from'] == $logged_user ? 'media-left' : '',
            'name' => $msg['from'] == $logged_user ? 'You' : $owner->user_name
            );
            
            $response = array(
                'success' => true,
                'message' => $chat 	  
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Empty fields exists'
            );
        }
        header('Content-Type: application/json');
        echo json_encode( $response );
    }

    public function updates(){                  
        $new_exists = false;
        $user_id = $this->session->userdata('userid');            
        $query = $this->db->get_where('lex_last_seen',array('user_id' => $user_id));
        $last_seen = $query->row();      
        $last_seen  = empty($last_seen) ? 0 : $last_seen->message_id;
        $exists = $this->message->latest_message($user_id, $last_seen);
            //echo $exists;
        if($exists){
            $new_exists = true;
        }
            
        if($new_exists){
            $new_messages = $this->message->unread($user_id);               
            $thread = array();
            $senders = array();
            foreach ($new_messages as $message) {
                if(!isset($senders[$message->from])){
                    $senders[$message->from]['count'] = 1; 
                }else{
                    $senders[$message->from]['count'] += 1; 
                }
                $query = $this->db->get_where('lex_users', array('user_id' => $message->from));
                $owner = $query->row();  
                $chat = array(
                    'msg' => $message->id,
                    'sender' => $message->from, 
                    'recipient' => $message->to,
                    'avatar' => $owner->user_avatar,
                    'body' => $message->message,
                    'time' => time_convert($message->time),
                    'type' => $message->from == $user_id ? 'media-left' : '',
                    'name' => $message->from == $user_id ? 'You' : ($owner->user_name)                    
                );
                array_push($thread, $chat);
            }          

            $groups = array();
            foreach ($senders as $key=>$sender){
                $sender = array('user'=> $key, 'count'=>$sender['count']);
                array_push($groups, $sender);
            }
            $totalmsg = count($new_messages);
            $this->last->update_lastSeen($user_id);

            $response = array(
                'success' => true,
                'messages' => $thread,
                'senders' => $groups,
                'totalmsg' => $totalmsg
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } 
    }
    
    public function mark_read(){
        $this->message->mark_read();
    }        
}