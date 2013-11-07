<?php

namespace JS\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class FeedbackForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,array('label' => "Имя"));
        $builder->add('email', 'email',array('label' => "Адрес электронной почты"));
        $builder->add('text',null,array('label' => "Сообщение"));
        $builder->add('send','submit');

    }

    public function getName()
    {
        return 'js_default_feedback';
    }

}
