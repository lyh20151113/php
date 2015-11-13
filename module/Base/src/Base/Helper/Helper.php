<?php
namespace Base\Helper;

use Doctrine\ORM\PersistentCollection;

class Helper
{
    /**
     * 将doctrine查询结果对象转为数组 
     * 对于PersistentCollection类型的数据不转，如果需要，使用extractCollectionByGetMethod对PersistentCollection类型转为数组
     * @param  $object  doctrine查询结果对象
     * @return $data 数组
     */
    static function extractByGetMethod($object)
    {
        if ($object instanceof PersistentCollection) {
            return null;
        }
        $methods = get_class_methods($object);
        
        $data = array();
        foreach ($methods as $method) {
           
            if (strpos($method, 'get') === 0) {
                $fieldName = lcfirst(substr($method, 3));
                
                $value = $object->$method();
                $data[$fieldName] = gettype($value) == 'object' ? self::extractByGetMethod($value) : $value;
            }
        }
        
        return $data;
    }
    /**
     * 将PersistentCollection对象转为数组
     * @param  $object  PersistentCollection对象
     * @return $data 数组
     */
    static function extractCollectionByGetMethod($object)
    {
        if ($object instanceof PersistentCollection) {
            $result = [];
            foreach ($object as $entity) {
                array_push($result, self::extractByGetMethod($entity));
            }
            return $result;
        }
        return null;
    }
    
    static function getDateArray($date){
         
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