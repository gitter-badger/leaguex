<?php

class Message_model extends CI_Model{
	
	public function conversation($user, $chatbuddy, $limit = 10){
        $this->db->where('from', $user);
        $this->db->where('to', $chatbuddy);
        $this->db->or_where('from', $chatbuddy);
        $this->db->where('to', $user);
        $this->db->order_by('id', 'desc');
        $messages = $this->db->get('lex_chat', $limit);

        $this->db->where('to', $user)->where('from',$chatbuddy)->update('lex_chat', array('is_read'=>'1'));
        return $messages->result();
	}
        
        public function insert_message($msg_id){            
        $this->db->insert('lex_chat',$msg_id);         
        return $this->db->insert_id();        
        }
        
        public function get_message($msg_id){
        $this->db->where('id',$msg_id);  
        $query = $this->db->get('lex_chat');
        if($query->num_rows()==1){
            foreach($query->result() as $row){
                $msg = array(
                    'id' => $row->id, 
                    'from' => $row->from,
                    'to' => $row->to,
                    'message' => $row->message,
                    'time' => $row->time
                );
            }
        }
        return $msg;
        }
        
	public function thread_len($user, $chatbuddy){
        $this->db->where('from', $user);
        $this->db->where('to', $chatbuddy);
        $this->db->or_where('from', $chatbuddy);
        $this->db->where('to', $user);
        $this->db->order_by('id', 'desc');
        $messages = $this->db->count_all_results('lex_chat');
        return $messages;
	}

	public function latest_message($user, $last_seen){
		$message = $this->db->where('to', $user)
			  ->where('id  > ', $last_seen)
			  ->order_by('time', 'desc')
			  ->get('lex_chat', 1);

		if($message->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function new_messages($user, $last_seen){
		$messages  =  $this->db->where('to', $user)
                              ->where('id  > ', $last_seen)
                              ->order_by('time', 'asc')
                              ->get('lex_chat');

		return $messages->result();
	}

	public function unread($user){
		$messages  =  $this->db->where('to', $user)
                              ->where('is_read', '0')
                              ->order_by('time', 'asc')
                              ->get('lex_chat');

		return $messages->result();                
	}
	public function mark_read(){
		$id = $this->input->post('id');
		$this->db->where('id', $id)->update('lex_chat', array('is_read'=>'1'));
	}

	public function unread_per_user($id, $from){
		$count  =  $this->db->where('to', $id)
                           ->where('from', $from)
                           ->where('is_read', '0')
                           ->count_all_results('lex_chat');
		return $count;
	}
        
}