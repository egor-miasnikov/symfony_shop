<?php

namespace JS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JS\AdminBundle\Form\BaseForm;

class ProductFilterForm extends BaseForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', 'entity', array(
            'class' => 'JSDefaultBundle:Category',
            'property' => 'name',
            'empty_value' => 'Выберите категорию',
            'required' => false
        ))
            ->add('article', 'entity', array(
                'class' => 'JSDefaultBundle:Article',
                'property' => 'name',
                'empty_value' => 'Выберите артикул',
                'required' => false
            ))
            ->add('filter', 'submit')
            ->add('reset', 'submit');

    }

    public function getName()
    {
        return 'js_admin_category_filter';
    }

}
