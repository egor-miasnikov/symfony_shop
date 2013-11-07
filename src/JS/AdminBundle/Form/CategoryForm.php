<?php

namespace JS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class CategoryForm extends BaseForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,array('label' => "Имя"));
        $builder->add('description',null,array('label' => "Описание"));
        $builder->add('usdPrice',null,array('label' => "Цена в долларах"));
        $builder->add('byrPrice',null,array('label' => "Цена в белорусских рублях"));
        $builder->add('rubPrice',null,array('label' => "Цена в российских рублях"));
        $builder->add('isNotebook',null,array(
            'label' => "Есть отделение для ноутбука",
            'required' => false
        ));
        $builder->add('notebookSize',null,array(
            'label' => "Размер отделения для ноутбука",
            'required' => false
        ));
        $builder->add('size',null,array('label' => "Размер"));
        $builder->add('material',null,array('label' => "Материал"));
        $builder->add('weight',null,array('label' => "Вес"));
        $builder->add('capacity',null,array('label' => "Вместимость"));
    }

    public function getName()
    {
        return 'js_admin_category';
    }

}
