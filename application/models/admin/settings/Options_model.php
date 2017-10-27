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
        
    function update_competitions($data){
        $this->db->trans_start();       
        $this->db->update('lex_settings', $data);          
        $this->db->trans_complete();       
        if ($this->db->trans_status() === FALSE){           
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
    

