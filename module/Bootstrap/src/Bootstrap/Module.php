<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 上午9:08
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace Bootstrap;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface,
                        ConfigProviderInterface
{
    public function getConfig()
    {
        return array(
            'Bootstrap' => array(
                'dateTime' => array(
                    'dateFormat' => 'Y-m-d H:i:s',
                    'datetimepicker' => true,
                    'datetimepickerAssertPath' => '/vendor/datetimepicker',
                    'datetimepickerOption' => array(
                        'format' => "yyyy-mm-dd hh:ii:ss",
                        'autoclose' => true,
                        'todayBtn' => true,
                    )
                )
            ),
            'view_helpers' => array(
                'invokables' => array(
                    'formPassword' => 'Bootstrap\Form\View\Helper\FormPassword',
                    'formDateTime' => 'Bootstrap\Form\View\Helper\FormDateTime',
                    'form' => 'Bootstrap\Form\View\Helper\Form',
                    'formRow' => 'Bootstrap\Form\View\Helper\FormRow',
                    'formElementErrors' => 'Bootstrap\Form\View\Helper\FormElementErrors',
                )
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
    }

}
