<?php

class Lastmsg_model extends CI_Model{	

	public function update_lastSeen($user=0)
	{
		$last_msg = $this->db->where('to', $user)->order_by('time', 'desc')->get('lex_chat', 1)->row();
		$msg = !empty($last_msg) ? $last_msg->id : 0;

		$query = $this->db->get_where('lex_last_seen',array('user_id' => $user));
                $record = $query->row();   
		$details = array('user_id' => $user,'message_id' => $msg);
		if(empty($record))
		{
                    $this->db->insert('lex_last_seen',$details); 		
		}else{
                    $this->db->where('id', $record->id);
                    $this->db->update('lex_last_seen', $details);
		}
	}
}