<?php

namespace JS\DefaultBundle\Controller;

use JS\DefaultBundle\Entity\Category;
use JS\DefaultBundle\Entity\Feedback;
use JS\DefaultBundle\Entity\Order;
use JS\DefaultBundle\Form\OrderForm;
use JS\DefaultBundle\Form\FeedbackForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Cookie;
use JS\DefaultBundle\Controller\BaseController;
use JS\DefaultBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class DefaultController extends BaseController
{
    /**
     * @Route("/", name="default_home")
     * @Template
     */
    public function indexAction()
    {
        $carusels = $this->getRepository("JSDefaultBundle:Carusel")->findAll();
        return array(
            'carusels' => $carusels
        );
    }

    /**
     * @Route("/catalog", name="default_catalog")
     * @Template
     */
    public function catalogAction()
    {
        $categories = $this->getRepository("JSDefaultBundle:Category")->findAllOrderedByNameWithoutHidden();
        return array('categories'=>$categories);
    }

    /**
     * @Template
     */
    public function topMenuAction()
    {
        $session = $this->get("session");
        return array();
    }

    /**
     * @Template
     */
    public function leftMenuAction()
    {
        $categories = $this->getRepository("JSDefaultBundle:Category")->findAllOrderedByNameWithoutHidden();
        return array(
            'categories' =>$categories
        );
    }

    /**
     *  @Route("/catalog/{slug}", name="default_view_product")
     * @Template
     */
    public function productViewAction(Category $category)
    {
        return array(
            'category' => $category
        );
    }

    /**
     * add by ajax
     * @Route("/add", name="default_add_cart")
     *
     */
    public function addCartAction()
    {
        $request = $this->getRequest();
        $id = $request->get('id');
        $session = $this->get("session");
        if(!$productIds = $session->get('js_product'))
        {
            $productIds = array();
        }

        array_push($productIds, $id);
        $session->set('js_product', $productIds);
        $count = count($session->get('js_product'));


        return new Response($count);
    }

    /**
     * add by ajax
     * @Route("/remove/{id}", name="default_remove_from_cart")
     *
     */
    public function removeProductFromCartAction($id)
    {
        $session = $this->get("session");
        $productIds = $session->get('js_product');
        foreach ($productIds as $key => $value)
        {
            if ($value == $id) {
                unset($productIds[$key]);
                break;
            }
        }
        $session->set('js_product', $productIds);
        $session->getFlashBag()->add('notice', 'Товар удален из корзины');
        return $this->redirectToRoute("default_view_cart");
    }

    /**
     *
     * @Route("/cart", name="default_view_cart")
     * @Template
     */
    public function cartViewAction()
    {
        $session = $this->get("session");
        $request = $this->getRequest();
        $productIds = $session->get('js_product');
        $productArray = array();
        if($productIds)
        {
            foreach ($productIds as $productId)
            {
                $product = $this->getRepository('JSDefaultBundle:Product')->findOneById($productId);
                $productArray[] = $product;
            }
            $order = new Order();
            $form = $this->createForm(new OrderForm(), $order);
            if ($request->getMethod() == 'POST')
            {
                $form->handleRequest($request);
                if ($form->isValid())
                {
                    $products = array();
                    foreach ($productArray as $p)
                    {
                        $products[] = $p;
                        $order->addProduct($p);
                    }
                    $em =  $this->getEntityManager();
                    $em->persist($order);
                    $em->flush();
                    $messageToUser = \Swift_Message::newInstance()
                        ->setSubject('Новый заказ')
                        ->setFrom('info@jansport.by')
                        ->setTo($order->getCustomerEmail())
                        ->setContentType("text/html")
                        ->setBody(
                            $this->renderView(
                                'JSDefaultBundle:Default:emailToUser.html.twig',
                                array(
                                    'name' => $order->getCustomerName(),
                                    'products' => $products
                                )
                            ));


                    $productArray = null;
                    $session->clear();
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Новый заказ')
                        ->setFrom('no-reply@jansport.by')
                        ->setTo('info@jansport.by')
                        ->setContentType("text/html")
                        ->setBody(
                            $this->renderView(
                                'JSDefaultBundle:Default:emailToManager.html.twig',
                                array(
                                    'order' => $order,
                                    'products' => $products,
                                )
                            ));
                    $this->get('mailer')->send($message);
                    $this->get('mailer')->send($messageToUser);
                    $session->getFlashBag()->add('notice', 'Ваш заказ принят, в ближайшее время с вам свяжется наш специалист');
                    return $this->redirectToRoute('default_catalog');
                }
            }
            return array(
                'productIds' => true,
                'productArray' => $productArray,
                'form' => $form->createView()
            );
        }


        return array(
            'productIds' => $productIds,
        );
    }

    /**
     * @Route("/delivery", name="default_delivery")
     * @return array
     * @Template
     */
    public function deliveryAction()
    {
        return array();
    }

    /**
     * @Route("/sale_places", name="default_sale_places")
     * @return array
     * @Template
     */
    public function salePlacesAction()
    {
        return array();
    }

    /**
     * @Route("/about", name="default_about")
     * @return array
     * @Template
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/warranty", name="default_warranty")
     * @return array
     * @Template
     */
    public function warrantyAction()
    {
        return array();
    }

    /**
     * @Route("/history", name="default_history")
     * @return array
     * @Template
     */
    public function historyAction()
    {
        return array();
    }

    /**
     * @Route("/feedback", name="default_feedback")
     * @return array
     * @Template
     */
    public function feedbackAction()
    {
        $request = $this->getRequest();
        $session = $this->get("session");
        $feedback = new Feedback();
        $em = $this->getEntityManager();
        $form = $this->createForm(new FeedbackForm(), $feedback);
        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {

                $em->persist($feedback);
                $em->flush();
                $feedbackMessage = \Swift_Message::newInstance()
                ->setSubject('Новый сообщение')
                ->setFrom('no-reply@jansport.by')
                ->setTo('info@jansport.by')
                ->setBody(
                    $this->renderView(
                        'JSDefaultBundle:Default:emailFeedback.txt.twig',
                        array(
                            'name' => $feedback->getName(),
                            'email' => $feedback->getEmail(),
                            'date' => $feedback->getCreatedAt(),
                            'text' => $feedback->getText()
                        )
                    ));
                $this->get('mailer')->send($feedbackMessage);
                $session->getFlashBag()->add('notice', 'Сообщение отправлено');
                return $this->redirectToRoute('default_feedback');
            }
        }
        return array(
            'form' => $form->createView()
        );
    }

}
