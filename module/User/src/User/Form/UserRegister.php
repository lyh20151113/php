<?php

namespace User\Form;

class UserRegister extends UserBase
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
            'type' => 'password',
            'name' => 'passwordConfirm',
            'options' => [
                'label' => 'password confirm'
            ],
           'attributes' => [
               'id' => 'passwordConfirm',
               'placeholder' => '重复密码',
               'required' => 'required',
               'maxLength' => '11',
           ]
        ],[
            'priority' => 97
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => '注册'
            ]
        ]);
    }
}