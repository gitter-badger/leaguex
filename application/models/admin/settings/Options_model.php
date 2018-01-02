<?php

class Options_model extends CI_Model{
    
    function update_media($data){
        $this->db->trans_start();             
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function update_general($data){
        $this->db->trans_start();       
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
        
    function update_players($data){
        $this->db->trans_start();       
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
        
    function update_email($data){
        $this->db->trans_start();       
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
        
    function update_levels($data){
        $this->db->trans_start();       
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function get_events(){
        $this->db->select('*');
        $this->db->from('lex_events_type');        
        $query = $this->db->get();        
        return $query->result();
    }
    
    function update_events($data){
        $this->db->trans_start();       
        $this->db->truncate('lex_events_type'); 
        $this->db->insert_batch('lex_events_type', $data);
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
}