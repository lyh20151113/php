<?php
namespace Base\Json;

/**
 * 用来与前台交互的Json类
 * @author lyh
 *
 */
class Json
{
    /**
     * 状态['success','fail']
     * @var String
     */
    protected $status = 'fail';
    /**
     * 提示信息
     * @var S
     */
    protected $msg;
    /**
     * 数组用来传递数据
     * @var array
     */
    protected $array =  array();
 /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

 /**
     * @return the $msg
     */
    public function getMsg()
    {
        return $this->msg;
    }

 /**
     * @return the $array
     */
    public function getArray()
    {
        return $this->array;
    }

 /**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

 /**
     * @param field_type $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

 /**
     * @param multitype: $array
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    
    
}