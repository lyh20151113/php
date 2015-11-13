<?php
namespace Program\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class System {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string",nullable=true) */
    protected $value;
    
    /** @ORM\Column(type="string",nullable=true) */
    protected $key;
    
    
    /** @ORM\Column(type="integer",nullable=true) */
    protected $parentId;
 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $value
     */
    public function getValue()
    {
        return $this->value;
    }

 /**
     * @return the $key
     */
    public function getKey()
    {
        return $this->key;
    }

 /**
     * @return the $parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

 /**
     * @param field_type $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

 /**
     * @param field_type $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    
    
//     public function doctrineEntitytoArray(ObjectManager $objectManager)
//     {
//         $hydrator = new DoctrineObject($objectManager, 'Program\Entity\System');
    
    
      
//         $result = $hydrator->extract($this);
//         return $result;
//     }
    
    



    

    
}