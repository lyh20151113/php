<?php
namespace User\Dao;

use Base\Dao\BaseDao;


class UserRoleDao extends BaseDao
{

    public function getRoleNotIsSuperAdmin()
    {
        $dql = 'SELECT a FROM User\Entity\UserRole a where a.roleKey <> \'superAdmin\'';
        return $this->doQuery($dql);
    }
  
    
}