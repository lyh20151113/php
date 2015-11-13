<?php

namespace Program\Model;

class Program
{
    public $id;
    public $name;
    public $broadcastTime;  //播出时间
    public $duration;  //时长
    public $isReplay;   //是否为重播
    public $typeId;    //join table = system
    public $playbillId;  //所属节目单的id  //join table = playbill
    public $channelName;  
    public $endTime;
    public $isDel;
    public $broadcastTypeId;  //join table  = system
    public $typeName;
    public $broadcastTypeName;
    public $programSysId;
    public $programSysName;
    public $initName;
    
    public function exchangeArray($data)
    {
      
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name     = (!empty($data['name'])) ? $data['name'] : null;
        $this->broadcastTime = (!empty($data['broadcastTime'])) ? $data['broadcastTime'] : null;
        $this->duration  = (!empty($data['duration'])) ? $data['duration'] : null;
        $this->isReplay  = (!empty($data['isReplay'])) ? (bool)$data['isReplay'] : false;
        $this->typeId  = (!empty($data['typeId'])) ? $data['typeId'] : 4;
        $this->playbillId  = (!empty($data['playbillId'])) ? $data['playbillId'] : null;
        $this->channelName  = (!empty($data['channelName'])) ? $data['channelName'] : null;
        $this->endTime = (!empty($data['endTime'])) ? $data['endTime'] : null;
        $this->isDel  = (!empty($data['isDel'])) ? (bool)$data['isDel'] : false;
        $this->typeName =  (!empty($data['typeName'])) ? $data['typeName'] : null;
        $this->broadcastTypeName =  (!empty($data['broadcastTypeName'])) ? $data['broadcastTypeName'] : null;
        $this->broadcastTypeId  = (!empty($data['broadcastTypeId'])) ? $data['broadcastTypeId'] : null;
        $this->programSysId = (!empty($data['programSysId'])) ? $data['programSysId'] : null;
        $this->programSysName = (!empty($data['programSysName'])) ? $data['programSysName'] : null;
        $this->initName = (!empty($data['initName'])) ? $data['initName'] : null;
    }
    
  
    public static function typeChange($type){
        
        if($type == 1){
            return '导视';
        }
        if($type == 2){
            return '新闻';
        }
        if($type == 3){
            return '栏目';
        }
        if($type == 4){
            return '广告';
        }
        if($type == 5){
            return '其他';
        }
    }
} 