<?php

class Signin_model extends CI_Model {
    
    
    public function login($email,$password){
        $sha_password = sha1($password);
        $this->db->where('user_email',$email);
        $this->db->where('user_password',$sha_password);         
        $query = $this->db->get('lex_users');
        if($query->num_rows()==1){
            foreach($query->result() as $row){
                $data = array(
                    'username' => $row->user_name,
                    'userid' =>  $row->user_id,
                    'avatar' => $row->user_avatar,
                    'permissions' => $row->user_permissions,
                    'birthday' => $row->user_birthday,
                    'logged_in' => TRUE
                );
            }
            $this->session->set_userdata($data);
            $is_banned = $this->session->userdata('permissions');
            return $data;
        }else{
            return FALSE;
        }
    }
    
    public function birthday_note($data) {
         $this->db->insert('lex_notification',$data);  
    }

    public function isLoggedIn(){
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $is_logged_in = $this->session->userdata('logged_in');        
        if(!isset($is_logged_in) || $is_logged_in !==TRUE){
            redirect('home');
            exit;
        }
    }
}