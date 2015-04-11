<?php

namespace Back\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{

    

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'acme_user_registration';
    }

}
