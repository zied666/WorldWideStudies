<?php

namespace Back\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Back\ReferentielBundle\Form\MediaType;

class AboutAsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title1')
            ->add('text1')
            ->add('title2')
            ->add('text2')
            ->add('title3')
            ->add('text3')
            ->add('image1',new MediaType())
            ->add('image2',new MediaType())
            ->add('image3',new MediaType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\GeneralBundle\Entity\AboutAs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_generalbundle_aboutas';
    }
}
