<?php
namespace Program\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Program\Form\File;
use Program\Entity\Program;
use Zend\EventManager\EventManagerInterface;
use Program\Service\ProgramService;
use Program\Entity\Playbill;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Base\Helper\Helper;

include_once (__DIR__ . '/../../../../../vendor/PHPExcel/PHPExcel.php');

class IndexController extends AbstractActionController
{
    
    protected $programService;

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        $this->init();
    }

    public function init()
    {
        $this->programService = new ProgramService();
       
        
    }

    public function indexAction()
    {
        
        $date = $this->params()->fromRoute('date');
        if ($date == null) {
            $date = date("Y-m-d", time()); // 2015-9-23
        }
        $dateArray = Helper::getDateArray($date);
        
        $view = new ViewModel([
            'dateArray' => $dateArray
        ]);
        $view->setTemplate('program\index\index');
       
    
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');
        // 得到频道信息
        $channels = $systemDao->getAll("CHANNEL_NAME");
        $playbills = [];
        // 得到date当天的每个频道的节目单信息
     
        foreach ($channels as $channel) {
            
            $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channel->getId(), strtotime($date));
            
            if (! $playbill) {
                $playbill = new Playbill();
                $playbill->setChannel($systemDao->getById($channel->getId()));
            }
            else{
                $playbill->setProgramCount(sizeof($programDao->getProgramByPlaybillId($playbill->getId())));
            }
            $playbills[$channel->getId()] = $playbill;
        }
      
        $playbillView = new ViewModel([
            'date' => $date,
            'playbills' => $playbills
        ]);
        $playbillView->setTemplate('program\index\child\playbill');
        $view->addChild($playbillView, 'childView');
      
        return $view;
    }

    public function testAction()
    {
        $arr = [
            "你好",
            [
                "type" => "test"
            ]
        ];
        
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function delectAction()
    {
        $date = $this->params()->fromRoute('date');
        if ($date == null) {
            $date = date("Y-m-d", time()); // 2015-9-23
        }
        $dateArray = Helper::getDateArray($date);
        
        $view = new ViewModel([
            'dateArray' => $dateArray
        ]);
        $view->setTemplate('program\index\index');
        $channelId = $this->params()->fromRoute('cId');
        if ($channelId == null) {
            echo "参数错误";
            exit();
        }
   
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
 

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $con = $em->getConnection();
        try {
            $con->beginTransaction();
            $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
            
            if (! $playbill) {
                echo "该节目单不存在";
                exit();
            }
            
            $playbillDao->deletePlaybill($playbill);
            $programs = $programDao->getProgramByPlaybillId($playbill->getId());
            foreach ($programs as $program) {
                
                $programDao->deleteProgram($program);
            }
            $con->commit();
        } catch (\PDOException $e) {
            
            $con->rollback();
            exit($e->getMessage());
        }
        
        echo "已删除";
        exit();
    }

    public function lookAction()
    {
        $date = $this->params()->fromRoute('date');
        if ($date == null) {
            $date = date("Y-m-d", time()); // 2015-9-23
        }
        $dateArray = Helper::getDateArray($date);
        
        $view = new ViewModel([
            'dateArray' => $dateArray
        ]);
        $view->setTemplate('program\index\index');
        $channelId = $this->params()->fromRoute('cId');
        if ($channelId == null) {
            echo "参数错误";
            exit();
        }
    
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');
        $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
        $programs = [];
        if (! $playbill) {
            $playbill = new Playbill();
            $channel = $systemDao->getById($channelId);
            $playbill->setChannel($channel);
        }
        else{
            $playbill->setProgramCount(sizeof($programDao->getProgramByPlaybillId($playbill->getId())));
            $programs = $programDao->getProgramByPlaybillId($playbill->getId());
        }
        $programView = new ViewModel([
            'date' => $date,
            'playbill' => $playbill
        ]);
        $subrun = $this->params()->fromRoute('subrun');
        if ($subrun == null) {
            foreach ($programs as $program){
                $program->TypeChangeToShow();
            }
            $programView->setVariable('programs', $programs);
            $programView->setTemplate('program\index\child\programLook');
            $view->addChild($programView, 'childView');
        }
        
        return $view;
    }

    public function addAction()
    {
        $date = $this->params()->fromRoute('date');
        if ($date == null) {
            $date = date("Y-m-d", time()); // 2015-9-23
        }
        $dateArray = Helper::getDateArray($date);
        
        $view = new ViewModel([
            'dateArray' => $dateArray
        ]);
        $view->setTemplate('program\index\index');
        $form = new File();
        
        $channelId = $this->params()->fromRoute('cId');
        if ($channelId == null) {
            echo "参数错误";
            exit();
        }
    
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');
        
        $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
        
        $programs = [];
        if (! $playbill) {
            $playbill = new Playbill();
            $channel = $systemDao->getById($channelId);
            $playbill->setChannel($channel);
        }
        else{
            $playbill->setProgramCount(sizeof($programDao->getProgramByPlaybillId($playbill->getId())));
            $programs = $programDao->getProgramByPlaybillId($playbill->getId());
        }
        
        $programTypes = $systemDao->getAll("PROGRAM_TYPE");
        
        $programNames = $systemDao->getChildByParentId($channelId);
      
        $programView = new ViewModel([
            'form' => $form,
            'date' => $date,
            'playbill' => $playbill,
            'programTypes' => $programTypes,
            'programNames' => $programNames
        ]);
        $subrun = $this->params()->fromRoute('subrun');
        if ($subrun == null) {
            foreach ($programs as $program){
                $program->TypeChangeToShow();
            }
            $programView->setVariable('programs', $programs);
            $programView->setTemplate('program\index\child\programAdd');
            $view->addChild($programView, 'childView');
        }
        if ($subrun == "upload") {
            $programs = $this->fileIn();
            $programView->setVariable('programs', $programs);
            $programView->setVariable('subrun', 'upload');
            $programView->setTemplate('program\index\child\programAdd');
            $view->addChild($programView, 'childView');
        }
        if ($subrun == "save") {
            $data = $this->getRequest()->getPost('data');
            $this->save($date, $channelId, $data);
            echo "保存成功";
            exit();
        }
        
        return $view;
    }

    public function editAction()
    {
        $date = $this->params()->fromRoute('date');
        if ($date == null) {
            $date = date("Y-m-d", time()); // 2015-9-23
        }
        $dateArray = Helper::getDateArray($date);
        
        $view = new ViewModel([
            'dateArray' => $dateArray
        ]);
        $view->setTemplate('program\index\index');
        $form = new File();
        
        $channelId = $this->params()->fromRoute('cId');
        if ($channelId == null) {
            echo "参数错误";
            exit();
        }
      
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');
        $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
        $programs = [];
        if (! $playbill) {
            $playbill = new Playbill();
            $channel = $systemDao->getById($channelId);
            $playbill->setChannel($channel);
        }
        else{
            $playbill->setProgramCount(sizeof($programDao->getProgramByPlaybillId($playbill->getId())));
            $programs = $programDao->getProgramByPlaybillId($playbill->getId());
        }
        $programTypes = $systemDao->getAll("PROGRAM_TYPE");
        $programNames = $systemDao->getChildByParentId($channelId);
        $programView = new ViewModel([
            'form' => $form,
            'date' => $date,
            'playbill' => $playbill,
            'programTypes' => $programTypes,
            'programNames' => $programNames
        ]);
        $subrun = $this->params()->fromRoute('subrun');
        if ($subrun == null) {
            foreach ($programs as $program){
                $program->TypeChangeToShow();
            }
            $programView->setVariable('programs', $programs);
            $programView->setTemplate('program\index\child\programEdit');
            $view->addChild($programView, 'childView');
        }
        // if($subrun == "upload"){
        // $programs = $this->fileIn();
        // $programView->setVariable('programs', $programs);
        // $programView->setTemplate('program\index\child\program');
        // return $programView;
        // }
        if ($subrun == "save") {
            $data = $this->getRequest()->getPost('data');
            $this->save($date, $channelId, $data);
            echo "保存成功";
            exit();
        }
        
        return $view;
    }

    public function save($date, $channelId, $data)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $programs = [];
        $hydrator = new DoctrineObject($em,'Program\Entity\Program');
        for ($i = 0; $i < sizeof($data); $i ++) {
            $program = new Program();
         //   $program->exchangeArray($data[$i]);
            $program= $hydrator->hydrate($data[$i],$program);
            $programs[$i] = $program;
        }
   
        $programDao = $this->getServiceLocator()->get('Program\Dao\ProgramDao');
        $playbillDao = $this->getServiceLocator()->get('Program\Dao\PlaybillDao');
        $systemDao = $this->getServiceLocator()->get('Program\Dao\SystemDao');

        $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
      
  //      $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $con = $em->getConnection();
        try {
        
            $con->beginTransaction();
        
            if (! $playbill) {
                $playbill = new Playbill();
                $playbill->setChannel($systemDao->getById($channelId));
                $playbill->setBroadcastDate(strtotime($date));
              
                $playbillDao->savePlaybill($playbill);
          
                $playbill = $playbillDao->getPlaybillByChannelIdAndBroadcastDate($channelId, strtotime($date));
                
            } 

            for($i=0;$i<sizeof($programs);$i++){
                
                $programs[$i]->setPlaybill($playbill);
                $programs[$i]->TypeChangeToData();
                $programDao->saveProgram($programs[$i]);
          
            }
          
            $con->commit();
        } catch (\Exception $e) {
            
            $con->rollback();
            exit($e->getMessage());
        }
    }

    public function fileIn()
    {
        $file = $this->getRequest()
            ->getFiles()
            ->toArray();
        $form = new File();
        $form->setData($file);
        if ($form->isValid()) {
            $form->getInputFilter()->getValues();
            // 导入成功
            $savePath = __DIR__ . '/../../../upload';
            $fileName = $this->getRequest()->getFiles('file')['name'];
            
            $excelData = $this->excelToArrary($savePath . '/' . $fileName);
            
            $programs = array();
            for ($i = 0; $i < sizeof($excelData); $i ++) {
                $program = new Program();
                $program->setName($excelData[$i]['name']);
                $program->setBroadcastTime($excelData[$i]['broadcastTime']);
                $program->setEndTime($excelData[$i]['endTime']);
                $programs[$i] = $program;
            }
            // var_dump($programs);
            // var_dump($excelData);
            return $programs;
        } else {
            echo "导入失败";
            exit();
        }
        // var_dump($this->getRequest()->getFiles());
        
        return;
    }

    public function excelToArrary($filename, $encode = 'utf-8')
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 2; $row <= $highestRow; $row ++) {
            for ($col = 0; $col < $highestColumnIndex; $col ++) {
                $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
                $value = $cell->getValue();
                
                if ($cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_NUMERIC) {
                    
                    $formatcode = \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME6;
                    
                    $value = \PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
                }
                if ($col == 0) {
                    $excelData[$row - 2]['name'] = (string) $value;
                }
                if ($col == 1) {
                    $excelData[$row - 2]['broadcastTime'] = (string) $value;
                    if ($row == $highestRow) {
                        $excelData[$row - 2]['endTime'] = "5:00:00";
                    } else {
                        $temp = $objWorksheet->getCellByColumnAndRow($col, $row + 1)->getValue();
                        $formatcode = \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME6;
                        $endTime = \PHPExcel_Style_NumberFormat::toFormattedString($temp, $formatcode);
                        $excelData[$row - 2]['endTime'] = (string) $endTime;
                    }
                }
            }
        }
        return $excelData;
    }
}