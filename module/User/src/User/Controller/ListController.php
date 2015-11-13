<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserAdd;
use User\Form\UserEdit;
use Zend\View\Model\ViewModel;
use Base\Helper\Helper;
use Base\Json\Json;




class ListController extends AbstractActionController
{

    public function indexAction()
    {
        $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
        $userPaginator = $userDao->fetchUserPaginator();
 
        $request = $this->getRequest();
        $page = $request->getQuery('page', 1);
        $userPaginator->setCurrentPageNumber($page);
        $userPaginator->setDefaultItemCountPerPage(5);
    
        return [
            'userPaginator' => $userPaginator
        ];
    }
    
    public function delectUserAction()
    {  
        $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
        $request = $this->getRequest();
        $userId = (int)$request->getQuery('userId');
        if($userId){
        
            $user = $userDao->getById($userId);
            $json = new Json();
            try {
                $userDao->delect($user);
            } catch (\Exception $e) {
                $json->setStatus('fail');
                $json->setMsg($e->getMessage());
                exit(json_encode(Helper::extractByGetMethod($json)));
            }
            $json->setStatus('success');
            $json->setMsg('删除成功');
            exit(json_encode(Helper::extractByGetMethod($json)));
        }
        else{
            $json->setStatus('fail');
            $json->setMsg('删除失败');
            exit(json_encode(Helper::extractByGetMethod($json)));
        }
    }
    public function addUserAction()
    {
       
        $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
        $userRoleDao = $this->getServiceLocator()->get('User\Dao\UserRoleDao');
        $form = new UserAdd();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
               
                $role = $userRoleDao->getById((int)$request->getPost('roleId'));
              
                $user->setRole($role);
                if($userDao->findOneBy(['username'=>$user->getUsername()])){
                    exit("用户名已存在");
                }
                try {
                    $userDao->save($user);
                } catch (\Exception $e) {
                    exit("保存失败".$e->getMessage());
                }
                 
                exit("保存成功");
    
            }
        }
       
       $userRoleList = $userRoleDao->getRoleNotIsSuperAdmin();
       $view = new ViewModel( [
            'form' => $form,
            'userRoleList' => $userRoleList
        ]);
        
        
        $layout=$this->layout();
        $layout->setTemplate('layout\JsLayout');
        return $view;
    }
    
    public function editUserAction()
    {
        $form = new UserEdit();
        $request = $this->getRequest();
        $userId = (int)$request->getQuery('userId');
        $userRoleDao = $this->getServiceLocator()->get('User\Dao\UserRoleDao');
        $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
        if($userId){
            
            $user = $userDao->getById($userId);
    
            $form->setData(Helper::extractByGetMethod($user));
           
        }
        
        else if ($request->isPost()) {
          
            $array = $request->getPost();
        
            $userId = (int)$array->id;
             
            $user = $userDao->getById($userId);
            if (isset($array->password)){$user->setPassword($array->password);}
            if (isset($array->fullName)){$user->setFullName($array->fullName);}
            if (isset($array->email)){$user->setEmail($array->email);}
            if (isset($array->roleId)){
                $role = $userRoleDao->getById($array->roleId);
                
                $user->setRole($role);}
            $form->setData(Helper::extractByGetMethod($user));
            if ($form->isValid()) {             
             
               
                try {
                    $userDao->save($user);
                } catch (\Exception $e) {
                    exit("保存失败");
                }
                 
                exit("保存成功");
    
            }
        }
        else {
            exit("参数错误");
        }
       
        $userRoleList = $userRoleDao->getRoleNotIsSuperAdmin();
        $view = new ViewModel( [
            'form' => $form,
            'user' => $user,
            'userRoleList' => $userRoleList
        ]);
        
        $layout=$this->layout();
        $layout->setTemplate('layout\JsLayout');
        return $view;
    }
}