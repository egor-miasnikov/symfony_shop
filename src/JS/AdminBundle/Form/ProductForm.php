<?php

namespace JS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class ProductForm extends BaseForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'data_class' => null,
            'required' => false,
            'label' => "Выберите файл"

        ));
        $builder->add('image','hidden',array('label' => "Путь к изображению"));
//        $builder->add('name',null,array('label' => "Имя"));
        $builder->add('article', 'entity', array(
            'class' => 'JSDefaultBundle:Article',
            'property' => 'name',
            'label' => "Артикул"
        ));
        $builder->add('category', 'entity', array(
            'class' => 'JSDefaultBundle:Category',
            'property' => 'name',
            'label' => "Категория"
        ));
        $builder->add('isMain',null,array(
            'label' => "Главный товар в категории?",
            'required' => false
        ));
        $builder->add('isHidden',null,array(
            'label' => "Скрыть",
            'required' => false
        ));

    }

    public function getName()
    {
        return 'js_admin_carusel';
    }

}
