<?php
function time_convert($datetime, $full = false) {
    $today = time();    
    $createdday= strtotime($datetime); 
    $datediff = abs($today - $createdday);  
    $difftext="";  
    $years = floor($datediff / (365*60*60*24));  
    $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
    $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
    $hours= floor($datediff/3600);  
    $minutes= floor($datediff/60);  
    $seconds= floor($datediff);  
    //year checker  
    if($difftext=="")  
    {  
      if($years>1){  
       $difftext=$years. " " .lang('years_ago');
      }elseif($years==1){  
       $difftext=$years. " " .lang('year_ago');
      }      
    }  
    //month checker  
    if($difftext=="")  
    {  
       if($months>1){  
       $difftext=$months. " " .lang('months_ago');
       }elseif($months==1){  
       $difftext=$months. " " .lang('month_ago');
       }
    }  
    //month checker  
    if($difftext=="")  
    {  
       if($days>1){  
       $difftext=$days. " " .lang('days_ago');
       }elseif($days==1){  
       $difftext=$days. " " .lang('day_ago');  
       }
    }  
    //hour checker  
    if($difftext=="")  
    {  
       if($hours>1){  
       $difftext=$hours. " " .lang('hours_ago');
       }elseif($hours==1){  
       $difftext=$hours. " " .lang('hour_ago');
       }
    }  
    //minutes checker  
    if($difftext=="")  
    {  
       if($minutes>1){  
       $difftext=$minutes. " " .lang('minutes_ago');  
       }elseif($minutes==1){  
       $difftext=$minutes. " " .lang('minute_ago');  
       }
    }  
    //seconds checker  
    if($difftext=="")  
    {  
       if($seconds>1){  
       $difftext=$seconds. " " .lang('seconds_ago'); 
       }elseif($seconds==1){  
       $difftext=$seconds. " " .lang('second_ago');   
       }
    }  
    return $difftext;  
}        
