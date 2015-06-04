<?php

namespace Back\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StatusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observation')
            ->add('status')
            ->add('bookingLanguageCourse')
            ->add('bookingAccommodation')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\BookingBundle\Entity\Status'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_bookingbundle_status';
    }
}
