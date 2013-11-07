<?php

namespace JS\AdminBundle\Controller;

use JS\AdminBundle\Controller\AdminBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Order controller.
 *
 * @Route("/order")
 */
class OrderController extends AdminBaseController
{

    protected $entityClass = 'JS\DefaultBundle\Entity\Order';

    /**
     * @Route("/{page}", defaults={"page"=0}, requirements={"page"="\d+"},  name="admin_order_index")
     * @Template()
     */
    public function indexAction()
    {
        $all = $this->getRepository("JSDefaultBundle:Order")->findLastOrders();

        return array('all' => $all);
    }

    /**
     * @Route("/delete/{pk}", requirements={"pk"="\d+"},  name="admin_order_delete")
     */
    public function deleteAction()
    {
        return parent::deleteAction();
    }
}
