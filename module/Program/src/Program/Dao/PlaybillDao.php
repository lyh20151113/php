<?php
namespace Program\Dao;

use Base\Dao\BaseDao;
use Program\Entity\Playbill;


class PlaybillDao extends BaseDao
{
    public function getPlaybill($id)
    {
        return $this->getById($id);
    }
    
    public function savePlaybill(Playbill $playbill)
    {
        
        $id = (int) $playbill->getId();
        if ($id == 0) {
            $this->save($playbill);
        } else {
            if ($this->getPlaybill($id)) {
                $this->update($playbill);
            } else {
                throw new \Exception('Program id does not exist');
            }
        }
      
    }
    
    public function getPlaybillByChannelIdAndBroadcastDate($channelId, $broadcastDate)
    {
        $dql = 'SELECT a FROM Program\Entity\Playbill a JOIN a.channel b where b.id='.$channelId.' and a.isDel=false and a.broadcastDate='.$broadcastDate;
        $playbill = $this->doQuery($dql);
     
        if ($playbill == null) {
            return false;
        } else {

            return end($playbill);
        }
       
    }
    
    public function deletePlaybill(Playbill $playbill)
    {
        $playbill->setIsDel(true);
        $this->savePlaybill($playbill);
    }
}