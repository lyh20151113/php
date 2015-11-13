<?php
namespace Program\Dao;

use Base\Dao\BaseDao;


class SystemDao extends BaseDao
{

   
    public function getChildByParentId($id)
    {
         
        return $this->findBy(['parentId' => $id]);
    }
    public function getAll($parentKey)
    {
    //    $dql ="SELECT b.id FROM Program\Entity\System b where b.key='".$parentKey."'";
      
        $dql = "SELECT a FROM Program\Entity\System a where a.parentId=(SELECT b.id FROM Program\Entity\System b where b.key='".$parentKey."')";
        return $this->doQuery($dql);
         
     
    }
    public function get($parentKey,$key)
    {
        $dql = "SELECT a FROM Program\Entity\System a where a.key='".$key."' and a.parentId=(SELECT b.id FROM Program\Entity\System b where b.key='".$parentKey."')";
        $result = $this->doQuery($dql);
        return end($result);
        
    }
}