<?php

namespace Program\Model;

class System
{
    public $id;
    public $value;  // ['CH01' => "新闻综合",'CH02' => "经济科教",'CH03' => "都市生活" ,'CH04' => "公共频道",'CH05' => "瓯江先锋"]
    public $key;  
    public $parentId;  
  
 
    
    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->value     = (!empty($data['value'])) ? $data['value'] : null;
        $this->key = (!empty($data['key'])) ? $data['key'] : null;
        $this->parentId  = (!empty($data['parentId'])) ? $data['parentId'] : null;
    
        
    }
    

  
} 