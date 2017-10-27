<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Dynamically add Javascript files to header page
if(!function_exists('addfooter_js')){
    function addfooter_js($file='')
    {
        $str = '';
        $ci = &get_instance();
        $footer_js  = $ci->config->item('footer_js');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $footer_js[] = $item;
            }
            $ci->config->set_item('footer_js',$footer_js);
        }else{
            $str = $file;
            $footer_js[] = $str;
            $ci->config->set_item('footer_js',$footer_js);
        }
    }
}

if(!function_exists('put_footer')){
    function put_footer()
    {
        $str = '';
        $ci = &get_instance();
        $footer_js  = $ci->config->item('footer_js');

        foreach($footer_js AS $item){
            $str .= '<script type="text/javascript" src="'.base_url().'assets/'.$item.'"></script>'."\n";
        }

        return $str;
    }
}

