<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-15 下午8:41
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */
namespace Bootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElementErrors as ZfFormElementErrors;

class FormElementErrors extends ZfFormElementErrors
{

    protected $wrap = '<span class="help-block">%s</span>';

    protected $messageCloseString = '</i>';

    protected $messageOpenFormat = '<i>';

    protected $messageSeparatorString = '</i><i>';

    public function __invoke(ElementInterface $element = null, array $attributes = array())
    {
        $errorHtml = parent::__invoke($element, $attributes);
        if ($errorHtml) {
            return sprintf($this->wrap, parent::__invoke($element, $attributes));
        }
        
        return null;
    }
}