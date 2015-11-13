<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use User\Form\UserLogin;
use User\Form\UserRegister;
use User\Entity\User;
use User\Entity\UserRole;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\View\Model\JsonModel;

class UserController extends AbstractActionController
{

    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        
        // $user = new \Program\Entity\User();
        // $user->setFullName('Marco Pivetta');
        
        // $objectManager->persist($user);
        // $repository = $objectManager->getRepository('User\Entity\User');
        $query = $objectManager->createQuery('SELECT a FROM User\Entity\User a');
        $products = $query->getResult();
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions([
            'use_cookies' => true,
            'cookie_httponly' => true
        ]);
        $sessionManager = new SessionManager($sessionConfig, null, null);
        $sessionManager->rememberMe(2419200);
        $container = new Container('mySession', $sessionManager);
        $container->offsetSet('userinfo', $products);
        var_dump($container->offsetGet('userinfo'));
        exit();
    }

    public function testAction()
    {
        
        $container = new Container('mySession');
        
        var_dump($container->offsetGet('userinfo'));
        exit();
    }

    public function loginAction()
    {
        
        $layout = $this->layout();
        $layout->setTemplate('user\layout');
        $form = new UserLogin();
        $imgSrc = $this->createCaptcha();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                // var_dump($user);
                $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
                $user = $userDao->loginVerify($user);
                
                if (! $user) {
                    return [
                        'imgSrc' => $imgSrc,
                        'error' => '用户名或密码错误'
                    ];
                } else {
                    $DHUser = [
                        'uid' => $user->getId(),
                        'fullName' => $user->getFullName(),
                        'username' => $user->getUsername(),
                        'roleName' => null!==$user->getRole()?$user->getRole()->getRoleName():'',
                        'roleKey' => null!==$user->getRole()?$user->getRole()->getRoleKey():''
                    ];
                    setcookie('DH_user', json_encode($DHUser, JSON_UNESCAPED_UNICODE), time() + 3600 * 24 * 7, "/");
                    return $this->redirect()->toRoute('DH');
                }
            }
        }
       
        return [
            'imgSrc' => $imgSrc  
        ];
    }

    public function registerAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('user\layout');
        $form = new UserRegister();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                
                $userDao = $this->getServiceLocator()->get('User\Dao\UserDao');
                try {
                    $userDao->save($user);
                } catch (\Exception $e) {
                    exit("注册失败");
                }
             
                exit("注册成功");
                
            }
        }
        return [
            'form' => $form,
        ];
    }

    public function logoutAction()
    {
        $result = setcookie('DH_user', "", time() - 3600 * 24 * 7, "/");
        
      
        if($result){
          
            echo "注销成功";
            exit();
        }
        else{
            echo "注销失败";
            exit();
        }
    }

    public function testpersistAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $role = new UserRole();
        $role->setRoleName('游客');
        $role->setRoleKey('tourist');
        $objectManager->persist($role);
        
        $user = new User();
        $user->setRole($role);
        $user->setFullName('陈熠晓');
        $user->setUsername('cyx');
        $user->setPassword('123456');
        $objectManager->persist($user);
        $objectManager->flush();
        var_dump($user);
        exit();
    }
    
    public function refreshcaptchaAction() {
        $imgSrc = $this->createCaptcha();
        return new JsonModel([
            'imgSrc' => $imgSrc
        ]);
    }
    
    public function createCaptcha(){
        //创建验证码
        $sessionKey_Capthca = 'sesscaptcha';
        $icv = new \Zend\Captcha\Image();//zf2只支持生成*.png格式图片
        $icv->setFont('public/fonts/ARIAL.TTF');//指定字体文件，可以从windows系统文件夹"WINDOWS\Fonts"下拷贝一个“arial.ttf”文件到/public/fonts目录下
        $icv->setFontSize(14);
        $icv->setHeight(30);
        $icv->setWidth(80);
        $icv->setDotNoiseLevel(20);//添加像素点的干扰，默认值100
        $icv->setLineNoiseLevel(2);//添加像素线的干扰，默认值5
        $icv->setImgDir('public/captcha'); //特别需要注意的是，imgDir和imgUrl这2个参数，如果设置不当，很容易出现无法创建图片文件或者无法显示图片文件的问题。
        //下面对这2个参数的设置和默认值做了以下整理：
        //imgDir：默认值是public/images/captcha。
        //imgUrl：默认值是/images/capthca。
        //可见，默认值是按照网站把/public设置为web根目录来定的。
        //setImgDir：如果是以根目录符"/"开头，则认为是绝对路径，例如，setImgDir('/public/captcha/');则图片保存路径为/public/capthca/asdfas.png；
        //           如果不是以根目录符"/"开头，则以网站根目录为根，设置的值为网站根目录下的子目录，例如，setImgDir('public/captcha/');则图片保存路径为WebRoot/public/capthca/asdfas.png(WebRoot为网站web根目录)；
        //setImgUrl：如果是以根目录符"/"开头，则以网站根目录为根，例如，setImgUrl('/public/captcha/');则图片URL为http://xxxx/public/capthca/asdfas.png；
        //           如果不是以根目录符"/"开头，则以当前route为为根，例如，假设当前表单URL为http://x/test/testform，那么调用setImgUrl('public/captcha/');则图片URL为http://x/test/public/capthca/asdfas.png；
        //综上所述，正确的设置这2个参数的方法是，setImgDir的参数“不要”以“/”开头，setImgUrl的参数“要”以“/”开头。
        $icv->setImgUrl('/php/public/captcha');
        $icv->setWordlen(4);//设置字符个数，默认是8个字符
        //创建新的验证码的值
        $icv->generate();
        //验证码图片的URL
        $imgSrc = $icv->getImgUrl().$icv->getId().$icv->getSuffix();
        //验证码的字符串
        $captchaWord = $icv->getWord();
        $sessionStorage = new SessionArrayStorage();
        //验证码保存到session
        $sessionStorage->offsetSet($sessionKey_Capthca, $captchaWord);
        
        return $imgSrc;
    }
    
    
//     public function imgCaptchaValid($value){
        
//         $isValid = true;
//         $sessionKey_Capthca = 'sesscaptcha';
//         $sessionStorage = new SessionArrayStorage();
//         $captchaWord = $sessionStorage->offsetGet($sessionKey_Capthca);//获取session临时保存的验证码
//         $wd = $captchaWord;
//         if ($wd != $value){//比较输入的验证码和生成的验证码       
//             $isValid = false;
//         }
//         return $isValid;
//      }
    
}