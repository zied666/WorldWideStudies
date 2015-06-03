<?php

namespace Back\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFrontFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array( 'required'=>false ));
        $builder->add('lastName', 'text', array( 'required'=>false ));
        $builder->add('phone', 'text', array( 'required'=>false ));
        $builder->add('address', 'text', array( 'required'=>false ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'front_user_registration';
    }

}
