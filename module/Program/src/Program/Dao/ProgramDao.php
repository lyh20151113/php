<?php
namespace Program\Dao;

use Base\Dao\BaseDao;
use Program\Entity\Program;


class ProgramDao extends BaseDao
{

    public function getProgram($id)
    {
         return $this->getById($id);
    }
    
    public function saveProgram(Program $program)
    {
        
        $id = (int) $program->getId();
        if ($id == 0) {
            $this->save($program);
        } else {
            if ($this->getProgram($id)) {
                $this->update($program);
            } else {
                throw new \Exception('Program id does not exist');
            }
        }
      
    }
    
    public function getProgramByPlaybillId($playbillId)
    {
        $dql = 'SELECT a FROM Program\Entity\Program a JOIN a.playbill b where a.isDel=false and b.id='.$playbillId;
        return $this->doQuery($dql);    
    }
    
    public function countProgramByPlaybillId($playbillId)
    {
        $dql = 'SELECT a FROM Program\Entity\Program a JOIN a.playbill b where a.isDel=false and b.id='.$playbillId;
        $program = $this->doQuery($dql);

        return count($program);
    }
    
    public function deleteProgram(Program $program)
    {
        $program->setIsDel(true);
        $this->saveProgram($program);
    }
}