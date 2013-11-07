<?php

namespace JS\AdminBundle\Controller;

use JS\DefaultBundle\Controller\BaseController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class AdminBaseController extends BaseController
{

    protected $filterFormClass = null;
    protected $entityClass = null;

    protected function getFilterFormClass()
    {
        return $this->filterFormClass;
    }

    protected function getEntityClass()
    {
        if ($this->entityClass)
        {
            return $this->entityClass;
        }
        throw new \Exception('Please define entityClass in controller');
    }

    public function indexAction()
    {
        $all = $this->getRepository('JSDefaultBundle:'.$this->getShortClassName())->findAll();
        return array(
            'all' => $all,
            'routePrefix' => $this->getRoutePrefix(),
            'entityName' => $this->getShortClassName(),
        );
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $this->forward404Unless($pk = $request->get('pk'));
        $em = $this->getEntityManager();
        $this->forward404Unless($entity = $em->find($this->getEntityClass(), $pk));

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Успешно удалено!');
        return $this->redirectToRoute($this->getRoutePrefix() . 'index');
    }

    public function createAction()
    {
        $request = $this->getRequest();
        $className = $this->getEntityClass();
        $entity = new $className();
        $em = $this->getEntityManager();
        $formClass = $this->getCreateFormClass();

        $form = $this->createForm(new $formClass($this->container), $entity);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                if(isset($form['file']))
                {
                    $dir = 'image/'.strtolower($this->getShortClassName());
                    $imageName = rand(1, 99999);

                    $existImage = $this->getRepository("JSDefaultBundle:".$this->getShortClassName())->findOneByImage($dir.'/'.$imageName);
                    while($existImage){
                        $imageName = rand(1, 99999);
                        $existImage = $this->getRepository("JSDefaultBundle:".$this->getShortClassName())->findOneByImage($dir.'/'.$imageName);
                    }


                    $form['file']->getData()->move($dir, $imageName);
                    $entity->setImage($dir.'/'.$imageName);
                }
                $em->persist($entity);
                $em->flush();

                $this->postCreateCallback($entity);

                $this->get('session')->getFlashBag()->add('notice', 'Добавлено!');

                /*
                 * determine promary key
                 */
                $meta = $em->getClassMetadata(get_class($entity));
                $identifier = $meta->getSingleIdentifierFieldName();

                $pk = call_user_func(array($entity, 'get' . ucfirst($identifier)));
                return $this->redirectToRoute($this->getRoutePrefix() . 'index', array('pk' => $pk));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'routePrefix' => $this->getRoutePrefix(),
            'entityName' => $this->getShortClassName(),
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $this->forward404Unless($pk = $request->get('pk'));
        $em = $this->getEntityManager();
        $this->forward404Unless($entity = $em->find($this->getEntityClass(), $pk));

        $formClass = "\JS\AdminBundle\Form\\" . $this->getShortClassName() . "Form";
        $form = $this->createForm(new $formClass($this->container), $entity);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                if(isset($form['file']))
                {
                   $file = $form['file']->getData();
                   if(isset($file))
                   {
                       $dir = 'image/'.strtolower($this->getShortClassName());
                       $imageName = rand(1, 99999);
                       $existImage = $this->getRepository("JSDefaultBundle:".$this->getShortClassName())->findOneByImage($dir.'/'.$imageName);
                       while($existImage){
                           $imageName = rand(1, 99999);
                           $existImage = $this->getRepository("JSDefaultBundle:".$this->getShortClassName())->findOneByImage($dir.'/'.$imageName);
                       }
                       $form['file']->getData()->move($dir, $imageName);
                       $entity->setImage($dir.'/'.$imageName);
                   }
                }
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Сохранено');
                return $this->redirectToRoute($this->getRoutePrefix() . 'edit', array('pk' => $pk));
            }
            else
            {
                $this->get('session')->getFlashBag()->add('error', 'Ошибка в сохранении');
            }
        }

        return array(
            'errors' => $form->isBound() ? $this->getErrorMessages($form) : array(),
            'entity' => $entity,
            'pk' => $pk,
            'form' => $form->createView(),
            'routePrefix' => $this->getRoutePrefix(),
            'entityName' => $this->getShortClassName(),
        );
    }

    protected function getShortClassName()
    {
        if ($this->getFilterFormClass())
        {
            return $this->getFilterFormClass();
        }
        else
        {
            return preg_replace("|^.*?([^\\\]+)$|", "$1", $this->getEntityClass());
        }
    }

    protected function getRoutePrefix()
    {
        return 'admin_' . strtolower($this->getShortClassName()) . '_';
    }

    protected function getCreateFormClass()
    {
        return "\JS\AdminBundle\Form\\" . $this->getShortClassName() . "Form";
    }

    public function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        if ($form->hasChildren())
        {
            foreach ($form->getChildren() as $child)
            {
                if (!$child->isValid())
                {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        }
        else
        {
            foreach ($form->getErrors() as $key => $error)
            {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }
}
