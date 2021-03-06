<?php

namespace Back\ReferentielBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaypalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account')
            ->add('testMode')
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\ReferentielBundle\Entity\Paypal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_referentielbundle_paypal';
    }
}
