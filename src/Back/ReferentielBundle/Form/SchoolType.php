<?php

namespace Back\ReferentielBundle\Form ;

use Symfony\Component\Form\AbstractType ;
use Symfony\Component\Form\FormBuilderInterface ;
use Symfony\Component\OptionsResolver\OptionsResolverInterface ;
use Back\ReferentielBundle\Form\MediaType ;

class SchoolType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
        $builder
                ->add('name')
                ->add('description')
                ->add('image' , new MediaType())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array (
            'data_class' => 'Back\ReferentielBundle\Entity\School'
        )) ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_referentielbundle_school' ;
    }

}
