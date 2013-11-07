<?php

namespace JS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use JS\DefaultBundle\Controller\BaseController;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    /**
     * @return array
     * @Template
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
        );
    }

//    public function checkLoginAction()
//    {
////        /* @var $request Request */
////        $request = $this->container->get('request');
////
////        $pass = sha1($request->get('_password'));
////        $username = $request->get('_username');
////
////        $user = $this->getRepository("JSUserBundle:User")->findOneBy(array('username'=>$username, 'password'=> $pass));
////
//////        var_dump($user->getId());exit;
////        $token = new UsernamePasswordToken($user, null, 'main', array('ROLE_ADMIN'));
////
////        if ($this->container->isScopeActive('request'))
////        {
////            $this->container->get('security.authentication.manager')->onAuthentication($this->container->get('request'), $token);
////        }
////
////        $this->container->get('security.context')->setToken($token);
////
////        $response = new Response();
////        if (isset($result['user']))
////        {
////            $this->container->get('afa.cache.manager')->setCookie($response, $result['user']);
////        }
////
////        $response->setContent(json_encode($result));
////        return $response;
//    }
}
