<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="dhtv_weixin_msg_text")
 *  */
class WeiXinMsgText {
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $picUrl;
    
    /** @ORM\Column(type="string") */
    protected $mediaId;
    

    /**
     * @ORM\ManyToOne(targetEntity="WeiXinMsgBase",inversedBy="texts")
     * @ORM\JoinColumn(name="MsgId", referencedColumnName="id")
     */
    protected $msg;
 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $picUrl
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

 /**
     * @return the $mediaId
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

 /**
     * @return the $msg
     */
    public function getMsg()
    {
        return $this->msg;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $picUrl
     */
    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
    }

 /**
     * @param field_type $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

 /**
     * @param field_type $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }


    
    
}