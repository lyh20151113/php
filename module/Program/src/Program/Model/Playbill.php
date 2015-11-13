<?php

namespace Program\Model;

class Playbill
{
    public $id;
    public $channelId;  // join table = channel
    public $broadcastDate;  
    public $createrId;  
    public $createTime;   
    public $lastEditorId;  
    public $lastEditTime;  
    public $auditorId;
    public $auditTime;
    public $auditResult;
    public $programCount;   //不是数据库内字段
    public $channelName;  //join table = channel
    public $isDel;
 
    
    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->channelId     = (!empty($data['channelId'])) ? $data['channelId'] : null;
        $this->broadcastDate = (!empty($data['broadcastDate'])) ? $data['broadcastDate'] : null;
        $this->createrId  = (!empty($data['createrId'])) ? $data['createrId'] : null;
        $this->createTime  = (!empty($data['createTime'])) ? $data['createTime'] : null;
        $this->lastEditorId  = (!empty($data['lastEditorId'])) ? $data['lastEditorId'] : null;
        $this->lastEditTime  = (!empty($data['lastEditTime'])) ? $data['lastEditTime'] : null;
        $this->auditorId  = (!empty($data['auditorId'])) ? $data['auditorId'] : null;
        $this->auditTime  = (!empty($data['auditTime'])) ? $data['auditTime'] : null;
        $this->auditResult  = (!empty($data['auditResult'])) ? $data['auditResult'] : null;
        $this->programCount  = (!empty($data['programCount'])) ? $data['programCount'] : null;
        $this->channelName  = (!empty($data['channelName'])) ? $data['channelName'] : null;
        $this->isDel  = (!empty($data['isDel'])) ? (bool)$data['isDel'] : false;
        
    }
    

  
} 