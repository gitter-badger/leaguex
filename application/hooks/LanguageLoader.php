<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        $ci->load->database();
        $ci->db->select('language');
        $query = $ci->db->get('lex_settings');
            foreach ($query->result() as $row){
                $setlang = $row->language;                
            }
        
        if ($setlang == 0){
            $language = 'italian';
        } else {
            $language = 'english';
        }    
        $ci->lang->load('message',$language);        
    }
}

