<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="acl_group")
 *  */
class AclGroup {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\ManyToOne(targetEntity="UserRole",inversedBy="aclActions")
     *  @ORM\JoinColumn(name="roleId", referencedColumnName="id")
     * */
    protected $role;
    
    /** @ORM\ManyToOne(targetEntity="AclAction")
     *  @ORM\JoinColumn(name="actionId", referencedColumnName="id")
     * */
    protected $action;
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
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

 /**
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }

 /**
     * @param field_type $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

 /**
     * @param field_type $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


 




    

    
    

    

    
}