<?php

namespace Back\ReferentielBundle\Form ;

use Symfony\Component\Form\AbstractType ;
use Symfony\Component\Form\FormBuilderInterface ;
use Symfony\Component\OptionsResolver\OptionsResolverInterface ;

class CityType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
        $builder
                ->add('libelle')
                ->add('longitude')
                ->add('latitude')
                ->add('country')
                ->add('image' , new MediaType())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array (
            'data_class' => 'Back\ReferentielBundle\Entity\City'
        )) ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_referentielbundle_city' ;
    }

}
