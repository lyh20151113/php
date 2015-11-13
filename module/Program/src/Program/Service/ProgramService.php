<?php

namespace Program\Service;

class ProgramService
{
    public function getDateArray($date){
       
     
        $weekarray=array("周日","周一","周二","周三","周四","周五","周六");
        $dateArray = Array();
        $dateArray = [
            ['day'=>$weekarray[date("w",strtotime("-3 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("-3 days",strtotime($date)))],
            ['day'=>$weekarray[date("w",strtotime("-2 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("-2 days",strtotime($date)))],
            ['day'=>$weekarray[date("w",strtotime("-1 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("-1 days",strtotime($date)))],
            ['day'=>$weekarray[date("w",strtotime($date))],'date' => date("Y-m-d",strtotime($date))],
            ['day'=>$weekarray[date("w",strtotime("+1 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("+1 days",strtotime($date)))],
            ['day'=>$weekarray[date("w",strtotime("+2 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("+2 days",strtotime($date)))],
            ['day'=>$weekarray[date("w",strtotime("+3 days",strtotime($date)))],'date' => date("Y-m-d",strtotime("+3 days",strtotime($date)))],
        ];
      
        return $dateArray;
    }
    
   
}