<?php

namespace JS\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class OrderForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('customerName',null,array('label' => "Имя"));
        $builder->add('customerEmail', 'email', array('label' => "Адрес электронной почты"));
        $builder->add('customerTelephone',null,array('label' => "Телефон"));
        $builder->add('customerCountry',null,array('label' => "Страна"));
        $builder->add('customerCity',null,array('label' => "Город"));
        $builder->add('customerAddress',null,array('label' => "Адрес"));
        $builder->add('buy','submit');

    }

    public function getName()
    {
        return 'js_default_order';
    }

}
