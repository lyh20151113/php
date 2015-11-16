<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="dhtv_weixin_msg_base")
 *  */
class WeiXinMsgBase {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $toUserName;
    
    /** @ORM\Column(type="string") */
    protected $fromUserName;
    

    /** @ORM\Column(type="integer") */
    protected $createTime;
    
    /** @ORM\Column(type="string") */
    protected $msgType;
    
    /** @ORM\Column(type="integer") */
    protected $updateTime;
    
    /**
     * @ORM\OneToMany(targetEntity="WeiXinMsgImage", mappedBy="msg")
     * @var image[]
     **/
    protected $images = null;
    
    /**
     * @ORM\OneToMany(targetEntity="WeiXinMsgText", mappedBy="msg")
     * @var text[]
     **/
    protected $texts = null;
    
    
 /**
     * @return the $images
     */
    public function getImages()
    {
        return $this->images;
    }

 /**
     * @return the $texts
     */
    public function getTexts()
    {
        return $this->texts;
    }

 /**
     * @param multitype:\DH\Entity\image  $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

 /**
     * @param multitype:\DH\Entity\text  $texts
     */
    public function setTexts($texts)
    {
        $this->texts = $texts;
    }

 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $toUserName
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

 /**
     * @return the $fromUserName
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

 /**
     * @return the $createTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

 /**
     * @return the $msgType
     */
    public function getMsgType()
    {
        return $this->msgType;
    }

 /**
     * @return the $updateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $toUserName
     */
    public function setToUserName($toUserName)
    {
        $this->toUserName = $toUserName;
    }

 /**
     * @param field_type $fromUserName
     */
    public function setFromUserName($fromUserName)
    {
        $this->fromUserName = $fromUserName;
    }

 /**
     * @param field_type $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

 /**
     * @param field_type $msgType
     */
    public function setMsgType($msgType)
    {
        $this->msgType = $msgType;
    }

 /**
     * @param field_type $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }

 
    
}