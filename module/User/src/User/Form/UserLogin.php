<?php
namespace User\Form;



class UserLogin extends UserBase
{

    public function __construct()
    {
        parent::__construct();
        
        $this->remove('email');
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => '登录'
            ]
        ]);
    }

//     public function getInputFilterSpecification()
//     {
//         return [
//             'username' => [
//                 'required' => true,
//                 'filters' => [
//                     [
//                         'name' => 'StripTags'
//                     ],
//                     [
//                         'name' => 'StringTrim'
//                     ]
//                 ],
//                 'validators' => [
//                     [
//                         'name' => 'StringLength',
//                         'options' => [
//                             'encoding' => 'UTF-8',
//                             'min' => 1,
//                             'max' => 20
//                         ]
//                     ]
//                 ]
//             ]
//         ];
//     }
}