<?php

namespace User\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
class Acl implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function isAllowed($userId,$controller,$action)
    {
        $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
        $user = $userDao->getById($userId);
        $aclActions = [];
        if(null!==$user->getRole()){
             $aclActions = $user->getRole()->getAclActions()->getValues();
        }

 
        $controllers = [];
        for ($i = 0; $i < sizeof($aclActions); $i ++) {
             
               if ($controller == $aclActions[$i]->getAction()->getResource()->getResource()){
                    $actionInDataBase = $aclActions[$i]->getAction()->getAction();
             
                    if($action == $actionInDataBase || $actionInDataBase == "all" ){
                        return true;
                    }
               }
        }
        return false;
    }
}
