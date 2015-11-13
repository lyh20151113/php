<?php

namespace Program\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Filter\File\RenameUpload;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\Validator\File\MimeType;
class File extends Form implements InputFilterProviderInterface
{
    public function __construct() {
        parent::__construct();
        
        $this->add([
            'type' => 'file',
            'name' => 'file',
            'attributes' => [
                'style' => 'display:none',
                'id' => 'file'
            ],
            'options' => [
                'label' => '上传手工文件'
            ]
        ],[
            'priority' => 98
        ]);
   
    }
    
    public function getInputFilterSpecification() {
         
        //文件上传后保存到临时目录的filter
        $renameUpload = new RenameUpload(array(
            "target"	=> __DIR__.'/../../../upload',
         //   "randomize" => true,
            "overwrite" => true,
            "use_upload_name" => true,
        ));
        //验证文件扩展名
        $extention = new Extension('xls');
        //验证文件大小
        $size = new Size(array('min'=>'1kB', 'max'=>'600MB'));
        //验证文件MIME类型
        $mime = new MimeType(array('application/vnd.ms-excel','enableHeaderCheck' => true));
        return [
            'file' => [
                'required' => true,
                'filters'  => [
                    $renameUpload,
                ],
                'validators' => [
                    $extention,
                    $size,
                    $mime,
                ],
            ]
        ];
    }
}