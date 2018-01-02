<?php defined('BASEPATH') OR exit('No direct script access allowed');        
    
function sidebar_chat(){
    $ci=& get_instance();
    $idchat = $ci->session->userdata('userid');
        $data['cur_user'] = $ci->sidebar_right_model->get_user($idchat);
        $contacts = $ci->sidebar_right_model->showusers();
        
        foreach ($contacts as $key=>$contact) {
		$unread = $ci->message->unread_per_user($idchat, $contact->user_id); 
		$contacts[$key]->unread =  $unread > 0 ? $unread : null ; 
		}
		$data['users'] = $contacts;
                $ci->load->view('sidebar_right_view',$data);
}
