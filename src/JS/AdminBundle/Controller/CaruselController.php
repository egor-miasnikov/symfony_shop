<?php

namespace JS\AdminBundle\Controller;

use JS\AdminBundle\Controller\AdminBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Carusel controller.
 *
 * @Route("/carusel")
 */
class CaruselController extends AdminBaseController
{

    protected $entityClass = 'JS\DefaultBundle\Entity\Carusel';

    /**
     * @Route("/{page}", defaults={"page"=0}, requirements={"page"="\d+"},  name="admin_carusel_index")
     * @Template()
     */
    public function indexAction()
    {
        return parent::indexAction();
    }

    /**
     * @Route("/delete/{pk}", requirements={"pk"="\d+"},  name="admin_carusel_delete")
     */
    public function deleteAction()
    {
        return parent::deleteAction();
    }

    /**
     * @Route("/create", name="admin_carusel_create")
     * @Template("JSAdminBundle:Default:create.html.twig")
     */
    public function createAction()
    {
        return parent::createAction();
    }

    /**
     * @Route("/edit/{pk}", requirements={"pk"="\d+"}, name="admin_carusel_edit")
     * @Template()
     */
    public function editAction()
    {
        return parent::editAction();
    }

}
