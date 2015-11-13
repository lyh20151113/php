<?php
namespace Program\Model;

use Zend\Db\TableGateway\TableGateway;
class SystemTable
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
    public function getById($id)
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
    public function getChildByParentId($id)
    {
       
        $results=[];
        $resultset = $this->tableGateway->select(['parentId' => $id]);
        foreach ($resultset as $result) {
            array_push($results, $result);
        }
        return $results;
    }
    public function getAll($parentKey)
    {
        $rowset = $this->tableGateway->select(['key' => $parentKey]);
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find $parentKey");
        }
        $results=[];
        $resultset = $this->tableGateway->select(['parentId' => $row->id]);
        foreach ($resultset as $result) {
            array_push($results, $result);
        }
        return $results;
    }
    public function get($parentKey,$key)
    {
        $rowset = $this->tableGateway->select(['key' => $parentKey]);
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find $parentKey");
        }
        $resultset = $this->tableGateway->select(['parentId' => $row->id,'key' => $key]);
        $result = $resultset->current();
        if(! $result){
            throw new \Exception("Could not find $parentKey to $key");
        }
        return $result;
    }
}