<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="dhtv_weixin_fans")
 *  */
class WeiXinFans {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $openId;
    
    /**
     * @ORM\ManyToOne(targetEntity="WeiXinUnion")
     * @ORM\JoinColumn(name="unId", referencedColumnName="id")
     */
    protected $union;
    
    /** @ORM\Column(type="integer",nullable=true) */
    protected $subscribe;
    
    /** @ORM\Column(type="integer") */
    protected $subscribeTime;
    
    /** @ORM\Column(type="string") */
    protected $remark;
    
    /** @ORM\Column(type="integer") */
    protected $groupId;
    
    /** @ORM\Column(type="integer") */
    protected $createTime;
 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $openId
     */
    public function getOpenId()
    {
        return $this->openId;
    }

 /**
     * @return the $union
     */
    public function getUnion()
    {
        return $this->union;
    }

 /**
     * @return the $subscribe
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

 /**
     * @return the $subscribeTime
     */
    public function getSubscribeTime()
    {
        return $this->subscribeTime;
    }

 /**
     * @return the $remark
     */
    public function getRemark()
    {
        return $this->remark;
    }

 /**
     * @return the $groupId
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

 /**
     * @return the $createTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $openId
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;
    }

 /**
     * @param field_type $union
     */
    public function setUnion($union)
    {
        $this->union = $union;
    }

 /**
     * @param field_type $subscribe
     */
    public function setSubscribe($subscribe)
    {
        $this->subscribe = $subscribe;
    }

 /**
     * @param field_type $subscribeTime
     */
    public function setSubscribeTime($subscribeTime)
    {
        $this->subscribeTime = $subscribeTime;
    }

 /**
     * @param field_type $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

 /**
     * @param field_type $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

 /**
     * @param field_type $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

 
    
}