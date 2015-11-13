<?php
namespace Program\Model;

use Zend\Db\TableGateway\TableGateway;
use Program\Model\Program;
use Zend\Db\Sql\Select;

class ProgramTable
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

    public function getProgram($id)
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

    public function saveProgram(Program $program)
    {
        // var_dump($program->broadcastTime);
        
        // var_dump(date("Y-m-d",time()));
        // exit;
        $data = array(
            'name' => $program->name,
            'broadcastTime' => strtotime($program->broadcastTime), // date("G:i:s",strtotime($program->broadcastTime))
            'endTime' => strtotime($program->endTime), // date("G:i:s",strtotime($program->duration))
            'isReplay' => $program->isReplay,
            'typeId' => $program->typeId,
            'playbillId' => $program->playbillId,
            'isDel' => $program->isDel,
            'broadcastTypeId' => $program->broadcastTypeId,
            'programSysId' => $program->programSysId,
            'initName' => $program->initName
        );
        
        $id = (int) $program->id;
        if ($id == 0) {
            
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProgram($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new \Exception('Program id does not exist');
            }
        }
    }

    public function getProgramByPlaybillId($playbillId)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use($playbillId) {
            $select->join('system', 'system.id = program.typeId', [
                'typeName' => 'value',
                'typeId' => 'id'
            ], Select::JOIN_LEFT)
                ->join([
                'system2' => 'system'
            ], 'system2.id = program.broadcastTypeId', [
                'broadcastTypeName' => 'value',
                'broadcastTypeId' => 'id'
            ]
            , Select::JOIN_LEFT) 
                 ->join([
                'system3' => 'system'
            ], 'system3.id = program.programSysId', [
                'programSysName' => 'value',
                'programSysId' => 'id'
            ]
            , Select::JOIN_LEFT)
                ->where([
                'playbillId' => $playbillId,
                'isDel' => false
            ])
                ->order('broadcastTime');
        });
        $result = [];
        foreach ($rowset as $row) {
            $row->broadcastTime = date("G:i:s", $row->broadcastTime);
            $row->endTime = date("G:i:s", $row->endTime);
            array_push($result, $row);
        }
        
        return $result;
    }

    public function countProgramByPlaybillId($playbillId)
    {
        $rowset = $this->tableGateway->select(array(
            'playbillId' => $playbillId
        ));
        
        return $rowset->count();
    }

    public function deleteProgram($program)
    {
        $program->isDel = true;
        $this->saveProgram($program);
    }
}