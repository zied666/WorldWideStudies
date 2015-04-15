<?php

namespace Back\SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Back\ReferentielBundle\Form\MediaType;

class SchoolLocationType extends AbstractType
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
            ->add('reviews')
            ->add('note')
            ->add('stars')
            ->add('image', new MediaType())
            ->add('city')
            ->add('school')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\SchoolBundle\Entity\SchoolLocation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_schoolbundle_schoollocation';
    }
}
