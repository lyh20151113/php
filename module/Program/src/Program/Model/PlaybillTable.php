<?php
namespace Program\Model;

use Zend\Db\TableGateway\TableGateway;
use Program\Model\Playbill;
use Zend\Db\Sql\Select;
class PlaybillTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPlaybill($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array(
            'id' => $id
        ));
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

//     public function getChannel()
//     {
//         $sql = new \Zend\Db\Sql\Sql($this->tableGateway->getAdapter());
//         $select = $sql->select()->from('channel');
//         $selectString = $sql->getSqlStringForSqlObject($select);
//         $results = $this->tableGateway->getAdapter()->query($selectString, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        
//         return $results;
//     }
//     public function getChannelById($channelId)
//     {
//         $sql = new \Zend\Db\Sql\Sql($this->tableGateway->getAdapter());
//         $select = $sql->select()->from('channel')->where(['id' => $channelId]);
//         $selectString = $sql->getSqlStringForSqlObject($select);
//         $results = $this->tableGateway->getAdapter()->query($selectString, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
  
//         return $results->current();
//     }
    public function savePlaybill(Playbill $playbill)
    {
        $data = array(
            'channelId' => $playbill->channelId,
            'broadcastDate' => $playbill->broadcastDate, 
            'createrId' => $playbill->createrId,
            'createTime' => $playbill->createTime,
            'lastEditorId' => $playbill->lastEditorId,
            'lastEditTime' => $playbill->lastEditTime,
            'auditorId' => $playbill->auditorId,
            'auditTime' => $playbill->auditTime,
            'auditResult' => $playbill->auditResult,
            'isDel' => $playbill->isDel
        );
      
        $id = (int) $playbill->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPlaybill($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new \Exception('Program id does not exist');
            }
        }
    }



    public function getPlaybillByChannelIdAndBroadcastDate($channelId, $broadcastDate)
    {

      
        $channelId = (int) $channelId;
        $rowset = $this->tableGateway->select(function (Select $select) use($channelId, $broadcastDate) {
            $select->join('system', 'system.id = playbill.channelId', [
                'channelName' => 'value',
                'channelId' => 'id'
            ])
                ->where([
                'playbill.broadcastDate' => $broadcastDate,
                'playbill.channelId' => $channelId,
                'playbill.isDel' => false
            ]);
        });
        
        $row = $rowset->current();
        return $row;
    }

    public function deletePlaybill($playbill)
    {
        $playbill->isDel=true;
        $this->savePlaybill($playbill);
    }
}