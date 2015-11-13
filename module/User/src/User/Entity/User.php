<?php
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $fullName;
    
    /** @ORM\Column(type="string") */
    protected $username;
    
    
    /** @ORM\Column(type="string") */
    protected $password;
    
    /** @ORM\ManyToOne(targetEntity="UserRole") 
     *  @ORM\JoinColumn(name="roleId", referencedColumnName="id")
     * */
    protected $role;
    
    /** @ORM\Column(type="string") */
    protected $email;
    
    
    
 /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

 /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

 /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $fullName
     */
    public function getFullName()
    {
        return $this->fullName;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param field_type $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }
 /**
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

 /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

 /**
     * @param field_type $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

 /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
 /**
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

 /**
     * @param field_type $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }





    

    
}