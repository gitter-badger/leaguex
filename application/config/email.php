<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$ci=& get_instance();
$ci->load->database(); 
$query = $ci->db->query("SELECT smtp_host, smtp_user, smtp_pass, smtp_port FROM lex_settings;");
foreach ($query->result() as $smtp){
    $host = $smtp->smtp_host;
    $user = $smtp->smtp_user;
    $pass = $smtp->smtp_pass;
    $port = $smtp->smtp_port;
}
        
$config['protocol'] = 'smtp';
$config['smtp_host']= $host;
$config['smtp_user']= $user;
$config['smtp_pass']= $pass;
$config['smtp_port']= $port;
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
/* End of file config.php */
/* Location: ./application/config/config.php */ 