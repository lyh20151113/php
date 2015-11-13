<?php

namespace Base\Dao;

/**
 * 所有Dao要继承该类获得数据库操作的基本信息和方法
 * @author lyh
 *
 */
class BaseDao {

   
    /**
     * 
     * @var Doctrine\ORM\EntityManager
     */
    protected  $em;
    
    /**
     * 
     * 所操作的实体类名
     */
    protected $className;
    
    
    /**
     * @return the $em
     */
    public function getEm()
    {
        return $this->em;
    }

 /**
     * @param field_type $em
     */
    public function setEm($em)
    {
        $this->em = $em;
        return $this;
    }
 /**
     * @return the $className
     */
    public function getClassName()
    {
        return $this->className;
    }

 /**
     * @param field_type $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * 查询该实体类的所有数据
     */
    public function fetchAll()
    {
        return $this->em->getRepository($this->className)->findAll();
    }
    /**
     * 根据Id查询该实体类的数据
     * @param  $id
     */
    public function getById($id)
    {
        return $this->em->getRepository($this->className)->find($id);
    }
    /**
     * 根据条件查询，获得第一条数据
     * @param  $array
     */
    public function findOneBy($array)
    {
        return $this->em->getRepository($this->className)->findOneBy($array);
    }
    /**
     * 根据条件查询，获得数据
     * @param  $array
     */
    public function findBy($array)
    {
        return $this->em->getRepository($this->className)->findBy($array);
    }
    /**
     * 保存实体
     * @param  $entity
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        return $this->em->flush();
    }
    /**
     * 删除实体
     * @param  $entity
     */
    public function delect($entity)
    {
        
        $this->em->remove($entity);
        $this->em->flush();
    }
    /**
     * 更新实体
     * @param  $entity
     */
    public function update($entity)
    {
        $this->em->flush($entity);
    }
    /**
     * 做dql查询操作
     * @param  $dql
     */
    public function doQuery($dql)
    {
        $query = $this->em->createQuery($dql);
       
        return $query->getResult();
    }
}
