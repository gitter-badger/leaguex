<?php

class Managers_list_model extends CI_Model{
    
    function optionusers(){
        $this->db->select('user_name, user_id');
        $this->db->from('lex_users');
        $this->db->where('user_permissions != 4');
        $this->db->where('user_id NOT IN (SELECT manager_user_id FROM lex_managers)');
        $this->db->order_by("user_name", "asc");
        $show_users = $this->db->get();       
        return $show_users->result_array();
    }
    
    function optionteams(){
        $this->db->select('team_name, team_id');
        $this->db->from('lex_teams'); 
        $this->db->where('team_id NOT IN (SELECT manager_team_id FROM lex_managers)');
        $this->db->order_by("team_name", "asc");
        $show_teams = $this->db->get();        
        return $show_teams->result_array();
    }
    
    public function add_manager(){          
        $data = array(           
            'manager_user_id' => $this->input->post('username'),
            'manager_team_id' => $this->input->post('teamname'),
            'manager_wallet' => str_replace($this->lang->line('mask_page'), "", $this->input->post('managerwallet'))    
            );
        $data2 = array(           
            'user_id' => $this->input->post('username'),
            'object_id' => $this->input->post('teamname'), 
            'type' => '1'   
            );       
        $this->db->insert('lex_notification',$data2); 
        $this->db->set('manager_registration_date', 'NOW()', FALSE);
        $this->db->insert('lex_managers',$data);
        $id_manager = $this->db->insert_id();  
        $this->db->select('*');
        $this->db->from('lex_managers');
        $this->db->join('lex_users', 'user_id = manager_user_id');
        $this->db->join('lex_teams', 'team_id = manager_team_id'); 
        $this->db->where('manager_id', $id_manager);
        $query = $this->db->get();
        return $query->result();
    }
    
    function deletemanager($delete_id){
        $this->db->trans_start();
        $this->db->where('manager_id', $delete_id);
        $this->db->delete('lex_managers');        
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
}