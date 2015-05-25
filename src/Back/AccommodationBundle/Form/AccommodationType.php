<?php

namespace Back\AccommodationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Back\ReferentielBundle\Form\MediaType;

class AccommodationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('firstPayment')
            ->add('avgPrice')
            ->add('typeAccommodation')
            ->add('currency')
            ->add('image',new MediaType())
            ->add('city')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\AccommodationBundle\Entity\Accommodation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_accommodationbundle_accommodation';
    }
}
