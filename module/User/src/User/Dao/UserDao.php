<?php
namespace User\Dao;

use Base\Dao\BaseDao;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class UserDao extends BaseDao
{

    
    public function loginVerify($user)
    {
        $user = $this->em->getRepository('User\Entity\User')->findOneBy(array(
            'username' => $user->getUsername(),
            'password' => $user->getPassword()
        ));
        if ($user == null) {
            return false;
        } else {
            return $user;
        }
    }
    
  
    
    public function fetchUserPaginator()
    {
      
        $query = $this->em->createQuery('SELECT a FROM User\Entity\User a Join a.role b where b.roleKey <> \'superAdmin\'');
        $paginator = new Paginator(new DoctrinePaginator(new ORMPaginator($query,$fetchJoinCollection = true)));
        return $paginator;
    }
    
}