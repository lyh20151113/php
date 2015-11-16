<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="dhtv_user_phone")
 *  */
class UserPhone {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;



    /**
     * @ORM\ManyToOne(targetEntity="WeiXinUnion")
     * @ORM\JoinColumn(name="unId", referencedColumnName="id")
     */
    protected $union;
    
  
    /** @ORM\Column(type="string") */
    protected $phone;
 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $union
     */
    public function getUnion()
    {
        return $this->union;
    }

 /**
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $union
     */
    public function setUnion($union)
    {
        $this->union = $union;
    }

 /**
     * @param field_type $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    
 
    
}