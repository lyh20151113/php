<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity
 *  @ORM\Table(name="user_role")
 *  */
class UserRole {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $roleName;
    
    
    /** @ORM\Column(type="string") */
    protected $roleKey;
    
    /**
     * @ORM\OneToMany(targetEntity="AclGroup", mappedBy="role")
     * @var action[]
     **/
    protected $aclActions = null;
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $roleName
     */
    public function getRoleName()
    {
        return $this->roleName;
    }



 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $roleName
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }
 /**
     * @return the $roleKey
     */
    public function getRoleKey()
    {
        return $this->roleKey;
    }

 /**
     * @param field_type $roleKey
     */
    public function setRoleKey($roleKey)
    {
        $this->roleKey = $roleKey;
    }
 /**
     * @return the $aclActions
     */
    public function getAclActions()
    {
        return $this->aclActions;
    }

 /**
     * @param multitype:\User\Entity\group  $aclActions
     */
    public function setAclActions($aclActions)
    {
        $this->aclActions = $aclActions;
    }





    

    
    

    

    
}