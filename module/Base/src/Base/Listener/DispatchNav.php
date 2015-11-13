<?php

namespace Base\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\ListenerAggregateInterface;
/**
 * 设置当前导航选项对应的tag
 * @author lyh
 *
 */
class DispatchNav implements ListenerAggregateInterface
{

    protected $listeners = [];

    public function detach(EventManagerInterface $events)
    {}

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [
            $this,
            'setDispatchNav'
        ], - 99);
        }
    /**
     * 每新增一个导航选项，需要添加对应的设置
     * @param MvcEvent $e
     */
    public function setDispatchNav(MvcEvent $e)
    {
        $viewModel = $e->getViewModel();
        $matches = $e->getRouteMatch();     
        
        $matchRouteName = $matches->getMatchedRouteName();       
        $controller = $matches->getParam('controller');
        //当进入Program模块时，tag设为TV，即在导航栏中选中‘电视’
        if ($matchRouteName=='Program') {
            $viewModel->setVariable('tag', 'TV');     
        }        
        
        //当进入User模块的List控制器时，tag设为userList，即在导航栏中选中‘用户列表’
        if ($matchRouteName=='User'&& $controller=='User\Controller\List') {
            $viewModel->setVariable('tag', 'userList');
        }
       
    }
}