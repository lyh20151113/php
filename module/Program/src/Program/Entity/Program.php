<?php
namespace Program\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Program 
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $broadcastTime;

    /**
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="typeId", referencedColumnName="id")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Playbill")
     * @ORM\JoinColumn(name="playbillId", referencedColumnName="id")
     */
    protected $playbill;

    /**
     * @ORM\Column(type="integer")
     */
    protected $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="broadcastTypeId", referencedColumnName="id")
     */
    protected $broadcastType;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isReplay = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDel = false;

    /**
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="programSysId", referencedColumnName="id")
     */
    protected $programSys;

    /**
     * @ORM\Column(type="string")
     */
    protected $initName;

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
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return the $broadcastTime
     */
    public function getBroadcastTime()
    {
        return $this->broadcastTime;
    }

    /**
     *
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return the $playbill
     */
    public function getPlaybill()
    {
        return $this->playbill;
    }

    /**
     *
     * @return the $endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     *
     * @return the $broadcastType
     */
    public function getBroadcastType()
    {
        return $this->broadcastType;
    }

    /**
     *
     * @return the $isReplay
     */
    public function getIsReplay()
    {
        return $this->isReplay;
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
     * @return the $programSys
     */
    public function getProgramSys()
    {
        return $this->programSys;
    }

    /**
     *
     * @return the $initName
     */
    public function getInitName()
    {
        return $this->initName;
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
     * @param field_type $name            
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @param field_type $broadcastTime            
     */
    public function setBroadcastTime($broadcastTime)
    {
        $this->broadcastTime = $broadcastTime;
    }

    /**
     *
     * @param field_type $type            
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @param field_type $playbill            
     */
    public function setPlaybill($playbill)
    {
        $this->playbill = $playbill;
    }

    /**
     *
     * @param field_type $endTime            
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     *
     * @param field_type $broadcastType            
     */
    public function setBroadcastType($broadcastType)
    {
        $this->broadcastType = $broadcastType;
    }

    /**
     *
     * @param field_type $isReplay            
     */
    public function setIsReplay($isReplay)
    {
        $this->isReplay = $isReplay;
    }

    /**
     *
     * @param field_type $isDel            
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;
    }

    /**
     *
     * @param field_type $programSys            
     */
    public function setProgramSys($programSys)
    {
        $this->programSys = $programSys;
    }

    /**
     *
     * @param field_type $initName            
     */
    public function setInitName($initName)
    {
        $this->initName = $initName;
    }

    public function TypeChangeToShow()
    {
        if ($this->broadcastTime != null) {
            $this->broadcastTime = date("G:i:s", $this->broadcastTime);
        }
        if ($this->endTime != null) {
            $this->endTime = date("G:i:s", $this->endTime);
        }
    }

    public function TypeChangeToData()
    {
        if ($this->broadcastTime != null) {
            $this->broadcastTime = strtotime($this->broadcastTime);
        }
        if ($this->endTime != null) {
            $this->endTime = strtotime($this->endTime);
        }
        if ($this->isDel != null) {
            $this->isDel = $this->isDel == "true" ? true : false;
        }
        if ($this->isReplay != null) {
            $this->isReplay = $this->isReplay == "true" ? true : false;
        }
    }


    
//     public function doctrineEntitytoArray(ObjectManager $objectManager)
//     {
//         $hydrator = new DoctrineObject($objectManager, 'Program\Entity\Program');
        
//         $result = '';
//         $result = $hydrator->extract($this);
        
//         $result['type'] = $this->type->doctrineEntitytoArray($objectManager);
        
//         $result['broadcastType'] = gettype($this->broadcastType) == 'object' ? $this->broadcastType->doctrineEntitytoArray($objectManager) : $this->broadcastType;
//         $result['programSys'] = gettype($this->programSys) == 'object' ? $this->programSys->doctrineEntitytoArray($objectManager) : $this->programSys;
//         $result['playbill'] = gettype($this->playbill) == 'object' ? $this->playbill->doctrineEntitytoArray($objectManager) : $this->playbill;
//         return $result;
//     }
}