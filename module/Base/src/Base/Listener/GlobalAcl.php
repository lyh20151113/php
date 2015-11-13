<?php


namespace Base\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface, Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\RouteMatch;
/**
 * 权限控制事件
 * @author lyh
 *
 */
class GlobalAcl implements ListenerAggregateInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait,ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        //priority=-101，在checkAuth之后执行
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [
            $this,
            'globalAcl'
        ], - 101);
    }

    public function globalAcl(EventInterface $event)
    {
        $request = $event->getRequest();
        
        $match = $event->getRouteMatch();
        if (! $match instanceof RouteMatch) {
            return;
        }
        $route = $match->getMatchedRouteName();
        //需要进行权限控制的后台模块数组
        $behindRoute = [
            'Program',
            'User'
        ];
        if (in_array($route, $behindRoute)) {
            $controller = $match->getParam('controller');
            $action = $match->getParam('action');
            
            if (in_array($controller, [
                'DH\Controller\Index',
                'User\Controller\User'
            ])) {
                return;
            }
            
            $DHUser = json_decode($_COOKIE['DH_user']);
            $response = $event->getResponse();
            //如果身份为超级管理员='superAdmin',具有所有权限
            if ($DHUser->roleKey == 'superAdmin') {
                return;
            }
            
            try {
                //获得检查权限的对象
                $acl = $this->serviceLocator->get('User\Service\Acl');
                
                if (! $acl->isAllowed($DHUser->uid, $controller, $action)) {
                    exit('所在用户组未得到资源子权限许可:<br>' . $controller . '::' . $action);
                }
                return;
            } catch (\Exception $e) {
                exit('用户未登记以下资源权限:<br>' . $DHUser->roleName . '::' . $controller . '::' . $action);
            }
        }
    }
}