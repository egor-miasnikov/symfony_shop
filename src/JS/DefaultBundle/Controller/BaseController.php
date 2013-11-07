<?php

namespace JS\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JS\DefaultBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BaseController extends Controller
{
    protected function getRepository($entityName, $entity_manager = null)
    {
        if (!$entity_manager)
        {
            $em = $this->getDoctrine()->getManagerForClass($entityName);
        }
        else
        {
            $em = $this->getDoctrine()->getManager($entity_manager);
        }
        return $em->getRepository($entityName);
    }

    protected function getEntityManager($entity_manager = "default")
    {
        return $this->getDoctrine()->getManager($entity_manager);
    }

    protected function isEntityNew($entity, $entity_manager = "default")
    {
        return $this->getEntityManager($entity_manager)->getUnitOfWork()->getEntityState($entity) == \Doctrine\ORM\UnitOfWork::STATE_NEW;
    }

    public function setFlash($name, $message)
    {
        $this->get('session')->getFlashBag()->add($name, $message);
    }

    public function forwardSecure($message = null)
    {
        if (!$message)
            $message = $this->get('translator')->trans('access_denied');
        throw new AccessDeniedException($message);
    }

    public function forwardSecureIf($cond, $message = null)
    {
        if ($cond)
            $this->forwardSecure($message);
    }

    public function forwardSecureUnless($cond, $message = null)
    {
        if (!$cond)
            $this->forwardSecure($message);
    }

    public function forward404($message = null)
    {
        if (!$message)
            $message = $this->get('translator')->trans('not_found');
        throw $this->createNotFoundException($message);
    }

    public function forward404If($cond, $message = null)
    {
        if ($cond)
            $this->forward404($message);
    }

    public function forward404Unless($cond, $message = null)
    {
        if (!$cond)
            $this->forward404($message);
    }

    public function redirect($url, $status = 302)
    {
        return parent::redirect($url, $status);
    }

    /**
     * url generation + redirect
     * 
     * @param type $route
     * @param type $parameters
     * @return type 
     */
    public function redirectToRoute($route, $parameters = array(), $absolute = true)
    {
        return $this->redirect($this->generateUrl($route, $parameters, $absolute));
    }

    public function getContainer()
    {
        return $this->container;
    }

}
