<?php

namespace Back\SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExtraType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name')
                ->add('price')
                ->add('startDate', 'date', array(
                    'widget'  =>'single_text',
                    'format'  =>'yyyy-MM-dd',
                    'required'=>false
                ))
                ->add('endDate', 'date', array(
                    'widget'  =>'single_text',
                    'format'  =>'yyyy-MM-dd',
                    'required'=>false
                ))
                ->add('perWeek', 'choice', array(
                    'choices' =>array(
                        '1'=>'Per week (course)',
                        '2'=>'Per week (accommodation) ' 
                    ),
                    'expanded'=>true,
                    'multiple'=>false,
                    'required'=>false
                ))
                ->add('obligatory', 'checkbox', array(
                    'label'   =>'Obligatory',
                    'required'=>false
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Back\SchoolBundle\Entity\Extra'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_schoolbundle_extra';
    }

}
