<?php

namespace User\Form;

class UserEdit extends UserBase
{
    public function __construct()
    {
        parent::__construct();
        
        $this->add([
            'type' => 'text',
            'name' => 'fullName',
            'options' => [
                'label' => '姓名'
            ],
            'attributes' => [
                'id' => 'fullName',
                'placeholder' => '姓名',
                'required' => 'required',
                'maxLength' => '4',
            ]
        ],[
            'priority' => 100
        ]);
        $this->add([
            'type' => 'text',
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
            'type' => 'text',
            'name' => 'username',
            'options' => [
                'label' => '用户名'
            ],
            'attributes' => [
                'readOnly' => 'readOnly'
            ]
        ],[
            'priority' => 99
        ]
        );
        
        
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => '保存'
            ]
        ]);
    }
}