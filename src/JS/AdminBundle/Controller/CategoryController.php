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
 * @Route("/category")
 */
class CategoryController extends AdminBaseController
{

    protected $entityClass = 'JS\DefaultBundle\Entity\Category';

    /**
     * @Route("/{page}", defaults={"page"=0}, requirements={"page"="\d+"},  name="admin_category_index")
     * @Template()
     */
    public function indexAction()
    {
        $all = $this->getRepository('JSDefaultBundle:Category')->findAllOrderedByName();
        $parent = parent::indexAction();
        $parent['all'] = $all;
        return $parent;
    }

    /**
     * @Route("/delete/{pk}", requirements={"pk"="\d+"},  name="admin_category_delete")
     */
    public function deleteAction()
    {
        return parent::deleteAction();
    }

    /**
     * @Route("/create", name="admin_category_create")
     * @Template("JSAdminBundle:Default:create.html.twig")
     */
    public function createAction()
    {
        return parent::createAction();
    }

    /**
     * @Route("/edit/{pk}", requirements={"pk"="\d+"}, name="admin_category_edit")
     * @Template("JSAdminBundle:Default:edit.html.twig")
     */
    public function editAction()
    {
        return parent::editAction();
    }

}
