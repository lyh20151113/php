<?php
namespace Program\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Playbill
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="channelId", referencedColumnName="id")
     */
    protected $channel;

    /**
     * @ORM\Column(type="integer")
     */
    protected $broadcastDate;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="createrId", referencedColumnName="id")
     */
    protected $creater;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $createTime;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="lastEditorId", referencedColumnName="id")
     */
    protected $lastEditor;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $lastEditTime;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="auditorId", referencedColumnName="id")
     */
    protected $auditor;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $auditTime;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $auditResult;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDel = false;

    protected $programCount;

    /**
     *
     * @return the $programCount
     */
    public function getProgramCount()
    {
        return $this->programCount;
    }

    /**
     *
     * @param field_type $programCount            
     */
    public function setProgramCount($programCount)
    {
        $this->programCount = $programCount;
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     *
     * @return the $broadcastDate
     */
    public function getBroadcastDate()
    {
        return $this->broadcastDate;
    }

    /**
     *
     * @return the $creater
     */
    public function getCreater()
    {
        return $this->creater;
    }

    /**
     *
     * @return the $createTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     *
     * @return the $lastEditor
     */
    public function getLastEditor()
    {
        return $this->lastEditor;
    }

    /**
     *
     * @return the $lastEditTime
     */
    public function getLastEditTime()
    {
        return $this->lastEditTime;
    }

    /**
     *
     * @return the $auditor
     */
    public function getAuditor()
    {
        return $this->auditor;
    }

    /**
     *
     * @return the $auditTime
     */
    public function getAuditTime()
    {
        return $this->auditTime;
    }

    /**
     *
     * @return the $auditResult
     */
    public function getAuditResult()
    {
        return $this->auditResult;
    }

    /**
     *
     * @return the $isDel
     */
    public function getIsDel()
    {
        return $this->isDel;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param field_type $channel            
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     *
     * @param field_type $broadcastDate            
     */
    public function setBroadcastDate($broadcastDate)
    {
        $this->broadcastDate = $broadcastDate;
    }

    /**
     *
     * @param field_type $creater            
     */
    public function setCreater($creater)
    {
        $this->creater = $creater;
    }

    /**
     *
     * @param field_type $createTime            
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     *
     * @param field_type $lastEditor            
     */
    public function setLastEditor($lastEditor)
    {
        $this->lastEditor = $lastEditor;
    }

    /**
     *
     * @param field_type $lastEditTime            
     */
    public function setLastEditTime($lastEditTime)
    {
        $this->lastEditTime = $lastEditTime;
    }

    /**
     *
     * @param field_type $auditor            
     */
    public function setAuditor($auditor)
    {
        $this->auditor = $auditor;
    }

    /**
     *
     * @param field_type $auditTime            
     */
    public function setAuditTime($auditTime)
    {
        $this->auditTime = $auditTime;
    }

    /**
     *
     * @param field_type $auditResult            
     */
    public function setAuditResult($auditResult)
    {
        $this->auditResult = $auditResult;
    }

    /**
     *
     * @param field_type $isDel            
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;
    }

    public function TypeChangeToShow()
    {
        if ($this->createTime != null) {
            $this->createTime = date("Y-m-d G:i:s", $this->createTime);
        }
        if ($this->auditTime != null) {
            $this->auditTime = date("Y-m-d G:i:s", $this->auditTime);
        }
        if ($this->lastEditTime != null) {
            $this->lastEditTime = date("Y-m-d G:i:s", $this->lastEditTime);
        }
        if ($this->broadcastDate != null) {
            $this->broadcastDate = date("Y-m-d", $this->broadcastDate);
        }
    }

    public function TypeChangeToData()
    {
        if ($this->createTime != null) {
            $this->createTime = strtotime($this->createTime);
        }
        if ($this->auditTime != null) {
            $this->auditTime = strtotime($this->auditTime);
        }
        if ($this->lastEditTime != null) {
            $this->lastEditTime = strtotime($this->lastEditTime);
        }
        if ($this->broadcastDate != null) {
            $this->broadcastDate = strtotime($this->broadcastDate);
        }
        if ($this->isDel != null) {
            $this->isDel = $this->isDel == "true" ? true : false;
        }
    }

//     public function doctrineEntitytoArray(ObjectManager $objectManager)
//     {
//         $hydrator = new DoctrineObject($objectManager, 'Program\Entity\Playbill');
        
//         $result = '';
//         $result = $hydrator->extract($this);
//         $result['channel'] = gettype($this->channel) == 'object' ? $this->channel->doctrineEntitytoArray($objectManager) : $this->channel;
       
//         return $result;
//     }
}