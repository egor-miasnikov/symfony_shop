<?php

namespace JS\AdminBundle\Controller;

use JS\AdminBundle\Controller\AdminBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JS\AdminBundle\Form\ProductFilterForm;

/**
 * Carusel controller.
 *
 * @Route("/product")
 */
class ProductController extends AdminBaseController
{

    protected $entityClass = 'JS\DefaultBundle\Entity\Product';

    /**
     * @Route("/{page}", defaults={"page"=0}, requirements={"page"="\d+"},  name="admin_product_index")
     * @Template()
     */
    public function indexAction()
    {
        $items = array();
        $request = $this->getRequest();
        $form = $this->createForm(new ProductFilterForm());

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $data = $form->getData();
               if($form->get('reset')->isClicked())
               {
                   $items = array();
               }
               else
               {
                   if($data['category'] && $data['article'])
                   {
                       $items = $this->getRepository('JSDefaultBundle:Product')->findBy(array('category' => $data['category'], 'article' => $data['article'] ));
                   }
                   elseif($data['category'] && !$data['article'])
                   {
                       $items = $this->getRepository('JSDefaultBundle:Product')->findBy(array('category' => $data['category']));
                   }
                   elseif(!$data['category'] && $data['article'])
                   {
                       $items = $this->getRepository('JSDefaultBundle:Product')->findBy(array('article' => $data['article'] ));
                   }
               }
            }
        }

        if(!$items)
        {
            $items = $this->getRepository('JSDefaultBundle:'.$this->getShortClassName())->findAll();
        }
        return array(
            'all' => $items,
            'form' => $form->createView(),
            'routePrefix' => $this->getRoutePrefix(),
            'entityName' => $this->getShortClassName(),
        );
    }

    /**
     * @Route("/delete/{pk}", requirements={"pk"="\d+"},  name="admin_product_delete")
     */
    public function deleteAction()
    {
        return parent::deleteAction();
    }

    /**
     * @Route("/create", name="admin_product_create")
     * @Template("JSAdminBundle:Default:create.html.twig")
     */
    public function createAction()
    {
        return parent::createAction();
    }

    /**
     * @Route("/edit/{pk}", requirements={"pk"="\d+"}, name="admin_product_edit")
     * @Template("JSAdminBundle:Default:edit.html.twig")
     */
    public function editAction()
    {
        return parent::editAction();
    }

}
