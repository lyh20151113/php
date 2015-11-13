<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use User\Entity\User;


class UserBase extends Form
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setHydrator(new ClassMethods())->setObject(new User());
        $this->add(array(
        
            'name'=>'id',
        
            'type'=>'Hidden'
        
        ));
        $this->add([
           'type' => 'text',
           'name' => 'username',
           'options' => [
               'label' => '用户名'
           ],
           'attributes' => [
               'id' => 'username',
               'placeholder' => '用户名',
               'required' => 'required',
               'maxLength' => '6',
               'pattern' => '[0-9a-zA-Z]{0,6}'
           ]
        ],[
            'priority' => 99
        ]
            );
        
        $this->add([
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => '密码'
            ],
           'attributes' => [
               'id' => 'password',
               'placeholder' => '密码',
               'required' => 'required',
               'maxLength' => '11',
           ]
        ],[
            'priority' => 98
        ]);
        
        $this->add([
            'type' => 'email',
            'name' => 'email',
            'options' => [
                'label' => 'email'
            ],
           'attributes' => [
               'required' => 'required',
               'id' => 'email',
               'placeholder' => '邮箱',
           ]
        ],[
            'priority' => 96
        ]);
    }
}