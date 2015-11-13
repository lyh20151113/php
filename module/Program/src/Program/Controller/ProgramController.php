<?php
namespace Program\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Program\Entity\Program;
use Base\Helper\Helper;
use Base\Json\Json;

class ProgramController extends AbstractActionController
{

    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');
        // $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate(13, "1444838400");
        // $programs = $programDao->getProgramByPlaybillId(28);
        // $channel = $systemDao->get('CHANNEL_NAME',"CH08");
        
        $program = new Program();
        $hydrator = new DoctrineObject($objectManager, 'Program\Entity\Program');
        $t = $hydrator->hydrate([
            'playbill' => [
                'id' => 28
            ],
            'isDel' => 0
        ], $program);
        var_dump($t);
        exit();
    }

    public function testAction()
    {
        
//         $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//         $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
//         $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
//         $programs = $programDao->getProgramByPlaybillId(37);
        
       
// //         $hydrator = new DoctrineObject($objectManager, 'Program\Entity\Program');
  
// //         $arr = $hydrator->extract($programs[0]);
//         $arr = [];
//         foreach ($programs as $program) {
           
//             array_push($arr, Helper::extractByGetMethod($program));
//         }
     
//         return new JsonModel([
//             'programs' => $arr,
//             'number' => "123"
//         ]);
           
      
        $redis = $this->getServiceLocator()->get('redis');
        $redis->setItem('name','lvyihan');
        echo $redis->getItem('name');
        exit;
        $json = new Json();
        $json->setStatus('success');
        $json->setArray(['ds'=>'123','sx'=>'134']);
        var_dump(Helper::extractByGetMethod($json));
        exit;
    }
    
    
  
}