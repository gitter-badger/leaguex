<?php

class Lastntf_model extends CI_Model{	

	public function update_lastSeen($user_id=0)
	{
		$last_ntf = $this->db->where('user_id', $user_id)->order_by('time', 'desc')->get('lex_notification', 1)->row();
		$ntf = !empty($last_ntf) ? $last_ntf->id : 0;

		$query = $this->db->get_where('lex_last_notification',array('user_id' => $user_id));
                $record = $query->row();   
		$details = array('user_id' => $user_id,'notification_id' => $ntf);
		if(empty($record))
		{
                    $this->db->insert('lex_last_notification',$details); 		
		}else{
                    $this->db->where('id', $record->id);
                    $this->db->update('lex_last_notification', $details);
		}
	}
}

