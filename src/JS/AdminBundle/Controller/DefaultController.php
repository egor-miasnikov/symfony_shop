<?php

namespace JS\AdminBundle\Controller;

use JS\DefaultBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends BaseController
{

    /**
     * @Route("/", name="admin_home")
     * @Template()
     */
    public function homeAction()
    {
        $limit = 10;
        $orders = $this->getRepository("JSDefaultBundle:Order")->findLastOrders($limit);
        $feedbacks = $this->getRepository("JSDefaultBundle:Feedback")->findLastFeedbacks($limit);
        return array(
            'orders' =>$orders,
            'feedbacks' => $feedbacks
        );
    }

    /**
     * COMPONENT
     * 
     * @Route("/menu/{route}", name="admin_menu")
     * @Template()
     */
    public function menuAction($route = '')
    {
        $active = $route;

        /*
         * for all routes:
         * 
         * admin_user_index  
         * admin_user_edit
         * admin_user_create
         * 
         * active -> "admin_user"
         */
        preg_match('/(admin_[^_]+)_?/', $route, $matches);
        return array('active' => $matches[1]);
    }
}
