<?php

namespace Dh\Form;
use Zend\Form\Form;
class UserForm extends Form
{
   public function __construct($name = null)
   {
       // we want to ignore the name passed
       parent::__construct('user');
       $this->add(array(
           'name' => 'id',
           'type' => 'Hidden',
       ));
       $this->add(array(
           'name' => 'username',
           'type' => 'Text',
           'options' => array(
               'label' => '用户名',
           ),
       ));
       $this->add(array(
           'name' => 'password',
           'type' => 'Text',
           'options' => array(
               'label' => '密码',
           ),
       ));
       $this->add(array(
           'name' => 'submit',
           'type' => 'Submit',
           'attributes' => array(
               'value' => 'Go',
               'id' => 'submitbutton',
           ),
       ));
   }
}