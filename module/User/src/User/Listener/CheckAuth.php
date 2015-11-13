<?php
namespace User\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\RouteMatch;

/**
 * 用户登录验证
 * @author lyh
 *
 */
class CheckAuth implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $event)
    {
        $this->listeners[] = $event->attach(MvcEvent::EVENT_ROUTE, [
            $this,
            'checkAuth'
        ], - 100);
    }

    public function CheckAuth(EventInterface $event)
    {
        $route = $event->getRouteMatch();
        if (! $route instanceof RouteMatch) {
            return;
        }
        $response = $event->getResponse();
        $routeName = $route->getMatchedRouteName();
        $actionName = $route->getParams()['action'];
        //需要进行用户登录验证的后台模块
        $behindRoute = [
            'DH',
            'User',
            'Program'
        ];
        if (! isset($_COOKIE['DH_user'])) {
            
            if ((in_array($routeName, $behindRoute)) && ($actionName != 'login'&&$actionName!='register'&&$actionName!='refreshcaptcha')) {
                $url = $event->getRouter()->assemble([
                    'controller' => 'user',
                    'action' => 'login'
                ], [
                    'name' => 'User'
                ]);
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                $event->stopPropagation();
                return $response;
            }
        }
        else{
            if ((in_array($routeName, $behindRoute)) && ($actionName == 'login'||$actionName=='register')) {
                
                $url = $event->getRouter()->assemble([
                    'controller' => 'index',
                    'action' => 'index'
                ], [
                    'name' => 'DH'
                ]);
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                $event->stopPropagation();
                return $response;
            }
        }
    }
}