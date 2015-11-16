<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Dh\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Model\User;

class IndexController extends AbstractActionController
{

   

    public function indexAction()
    {
        $this->layout()->setVariable('tag', 'index');
    }

}
