<?php

namespace Back\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Back\ReferentielBundle\Form\MediaType;
class HomePageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('title1')
            ->add('description1')
            ->add('title2')
            ->add('description2')
            ->add('title3')
            ->add('description3')
            ->add('title4')
            ->add('description4')
            ->add('logo',new MediaType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Back\GeneralBundle\Entity\HomePage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_generalbundle_homepage';
    }
}
