<?php

namespace JS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class CaruselForm extends BaseForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'data_class' => null,
            'required' => false,
            'label' => "Фаил картинки"
        ));
        $builder->add('image','hidden',array('label' => "Путь до картинки"));
        $builder->add('name',null,array('label' => "Имя"));
        $builder->add('url',null,array('label' => "Ссылка"));

    }

    public function getName()
    {
        return 'js_admin_carusel';
    }

}
