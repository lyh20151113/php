<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="acl_action")
 *  */
class AclAction {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $action;
    
    /** @ORM\ManyToOne(targetEntity="AclResource")
     *  @ORM\JoinColumn(name="resourceId", referencedColumnName="id")
     * */
    protected $resource;
 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
 /**
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }

 /**
     * @return the $resource
     */
    public function getResource()
    {
        return $this->resource;
    }

 /**
     * @param field_type $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

 /**
     * @param field_type $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }


 




    

    
    

    

    
}