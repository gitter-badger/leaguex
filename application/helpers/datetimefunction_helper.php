<?php
function time_convert($datetime) {
    $time_ago = strtotime($datetime);  
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return lang('just_now');  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return lang('minute_ago');  
     }  
     else  
           {  
       return $minutes." ".lang('minutes_ago');  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return lang('hour_ago');  
     }  
           else  
           {  
       return $hours." ".lang('hours_ago');  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return lang('yesterday');  
     }  
           else  
           {  
       return $days." ".lang('days_ago');  
     }  
   }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
     if($weeks==1)  
           {  
       return lang('week_ago');  
     }  
           else  
           {  
       return $weeks." ".lang('weeks_ago');  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return lang('month_ago');  
     }  
           else  
           {  
       return $months." ".lang('months_ago');  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return lang('year_ago');  
     }  
           else  
           {  
       return $years." ".lang('years_ago');  
     }  
   } 
}        
