<?php

namespace JS\AdminBundle\Controller;

use JS\AdminBundle\Controller\AdminBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Feedback controller.
 *
 * @Route("/feedback")
 */
class FeedbackController extends AdminBaseController
{

    protected $entityClass = 'JS\DefaultBundle\Entity\Feedback';

    /**
     * @Route("/{page}", defaults={"page"=0}, requirements={"page"="\d+"},  name="admin_feedback_index")
     * @Template()
     */
    public function indexAction()
    {
        $all = $this->getRepository("JSDefaultBundle:Feedback")->findLastFeedbacks();

        return array('all' => $all);
    }
}
