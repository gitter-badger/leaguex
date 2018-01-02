<?php

class Notes_model extends CI_Model{
    
    function getunreadnotifications($userid, $limit = 10){
        $this->db->where('user_id', $userid);
        $this->db->where('is_read', '0');        
        $this->db->order_by('id', 'desc');
        $unreadnotifications = $this->db->get('lex_notification', $limit);       
        return $unreadnotifications->result();
    }
    
    function getreadnotifications($userid, $limit = 10){
        $this->db->where('user_id', $userid); 
        $this->db->where('is_read', '1');      
        $this->db->order_by('id', 'desc');
        $readnotifications = $this->db->get('lex_notification', $limit);       
        return $readnotifications->result();
    }
    
    public function getallnotifications($user, $limit = 10){
        $this->db->where('user_id', $user);  
        $this->db->order_by('id', 'desc');
        $notifications = $this->db->get('lex_notification', $limit);       
        return $notifications->result();
    }
        
    public function ntf_len($user){
        $this->db->where('user_id', $user);        
        $this->db->order_by('id', 'desc');
        $notifications = $this->db->count_all_results('lex_notification');
        return $notifications;
	}    
    
    public function ntf_len_unread($user){
        $this->db->where('user_id', $user);  
        $this->db->where('is_read', '0');        
        $this->db->order_by('id', 'desc');
        $notifications = $this->db->count_all_results('lex_notification');
        return $notifications;
	}    
        
    public function latest_notification($user_id, $last_notification){
        $note = $this->db->where('user_id', $user_id)
	         	  ->where('id  > ', $last_notification)
			  ->order_by('time', 'desc')
			  ->get('lex_notification', 1);

		if($note->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
        
    public function unread($user){
	$notes  =  $this->db->where('user_id', $user)
                           ->where('is_read', '0')
                           ->order_by('time', 'asc')
                           ->get('lex_notification');

		return $notes->result();                
	}    
        
    public function mark_read($id){		
	$this->db->where('id', $id)->update('lex_notification', array('is_read'=>'1'));
	}  
        
    public function mark_all_read($user_id){		
	$this->db->where('user_id', $user_id)->update('lex_notification', array('is_read'=>'1'));
	}       
    
    public function mark_unread($id){		
	$this->db->where('id', $id)->update('lex_notification', array('is_read'=>'0'));
	}
        
    public function mark_all_unread($user_id){		
	$this->db->where('user_id', $user_id)->update('lex_notification', array('is_read'=>'0'));
	}      
}

