<?php
class Get_user_data_model extends CI_Model {
    
    public function get_user_img($userID){        
        $this->db->where('user_id',$userID);       
        $query = $this->db->get('lex_users');
        if($query->num_rows()==1){
            $row = $query->row();
        return $row->user_avatar;       
        }else{
            return FALSE;
        }
    } 
}